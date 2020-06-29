<?php
require_once '../../config.php';
if ($CFG->forcelogin) {
    require_login();
}

global $USER, $DB, $COURSE;
if(isset($_GET['idgrupouser'])){
$id = $_GET['idgrupouser'];

echo $id;
echo '<br>';
$status= $_POST['status'.$id];

if($status==0){
    $actualizar = new stdClass();
    $actualizar-> id = $id;
    $actualizar-> status  = $status;

    $DB->update_record('objective_groups_users', $actualizar, $bulk=false);
}else if($status==1){
    $actualizar = new stdClass();
    $actualizar-> id = $id;
    $actualizar-> status  = $status;
    
    $DB->update_record('objective_groups_users', $actualizar, $bulk=false);

}else if($status==2){
    echo 'entramos aqui 2';

        $sql="select oe.id as idestablecimiento, gu.id, oe.idjefedirecto as jjefedirecto, gu.idgroup,gu.idusuario 
        from {objective_groups_users} gu 
        join {objective_establishment} oe on gu.idusuario=oe.userid and oe.courseid=gu.courseid 
        where gu.id=?";
        $infousers = $DB->get_records_sql($sql, array($id));
        //print_r($viewusers);
        //exit();
    
        foreach($infousers as  $val){
            echo $idesta=$val->idestablecimiento;
            echo '<br>';
            echo $idusergroup=$val->id;
            echo '<br>';
            echo $idgrupo=$val->idgroup;
            echo '<br>';
            echo $idusuariojefe=$val->idusuario;
            echo '<br>';
            echo $idjefedejefe=$val->jjefedirecto;

        }
      
    
          $record1 = new stdClass();
          $record1-> id = $idusergroup;
          $record1-> rol = 1;

          $eusuario = new stdClass();
          $eusuario -> id = $idesta;
          $eusuario -> rol= 1;
          $eusuario -> status= 1;
          print_r($record1);

          print_r($eusuario);

            try{
              $updaterol = $DB->update_record('objective_groups_users', $record1, $bulk=false);
              $updateestablecimiento = $DB->update_record('objective_establishment', $eusuario, $bulk=false);
            // print_r($lastupdateid);
    
            } catch(\Throwable $e) {
              // PHP 7 
              echo 'ERROR AL ACTUALIZAR OBJETIVO 6';
            } 

            $sqla="select oe.id as ide, gu.id as idgu, gu.idgroup as grupoid ,gu.idusuario as usuarioid
            from {objective_groups_users} gu 
            join {objective_establishment} oe on gu.idusuario=oe.userid and oe.courseid=gu.courseid 
            where gu.idgroup=? and gu.idusuario !=?";
            $infocolaboradores = $DB->get_records_sql($sqla, array($idgrupo , $idusuariojefe));

            foreach($infocolaboradores as $res){

                $idestablecimientocol=$res->ide;
                

                $record2 = new stdClass();
                $record2-> id = $idestablecimientocol;
                $record2-> idjefedirecto = $idjefedejefe;
                echo '<br>';
                print_r($record2);
      
                  try{

                    $updateestablecimientocol = $DB->update_record('objective_establishment', $record2, $bulk=false);
                  // print_r($lastupdateid);
          
                  } catch(\Throwable $e) {
                    // PHP 7 
                    echo 'ERROR AL ACTUALIZAR OBJETIVO 6';
                  } 


            }



        

   

}else if($status==3){
    echo 'entramos aqui 3';
    exit();


}else{

}
}
header("Location:".$_SERVER['HTTP_REFERER']);
?>
