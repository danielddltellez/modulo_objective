<?php
require_once '../../config.php';

if ($CFG->forcelogin) {
    require_login();
}

global $USER, $DB, $COURSE;

if(isset($_GET['idgrupo'])){
	
		
    $idgrupo = $_GET['idgrupo'];

    $DB->delete_records('objective_groups', array('id' => $idgrupo)) ;

}

if(isset($_GET['idgrupouser'])){
	
		
    $idgrupouser = $_GET['idgrupouser'];

    $DB->delete_records('objective_groups_users', array('id' => $idgrupouser));
  /*
   $sql="select a.id, a.idgroup, a.idusuario, a.rol, b.id as idestablecimiento, b.idjefedirecto
   from {objective_groups_users} a
   left join {objective_establishment} b on b.userid=a.idusuario where a.id=?";
   $result = $DB->get_records_sql($sql, array($idgrupouser));
   foreach($result as $values){

    $roluser=$values->rol;
    $idgrupo=$values->idgroup;
    $idjefesuperior=$values->idjefedirecto;
    $idestab=$values->idestablecimiento;
   // echo $roluser;

   
    if($roluser=2 || $roluser=3){

        

        //Valida usuarios a actualizar su jefe en establecimineto
        $query="select id as idcolgrupo, idusuario from {objective_groups_users} where idgroup=? and rol=?";
        $resp = $DB->get_records_sql($query, array($idgrupo, 1));
        foreach($resp as $valor){
            $idusergroup=$valor->idcolgrupo;
            $iduserobj=$valor->idusuario;
            $sqlestablecimiento="select id from {objective_establishment} where userid =?";
            $idestablecimiento  = $DB->get_records_sql($sqlestablecimiento, array($iduserobj));
            foreach($idestablecimiento as $resfinal){
                $idobj=$resfinal->id;
            }
            $record = new stdClass();
            $record-> id = $idobj;
            $record-> idjefedirecto = $idjefesuperior; 
            try{
              $updatejefesuperior = $DB->update_record('objective_establishment', $record, $bulk=false);

            } catch(\Throwable $e) {
              // PHP 7 
              echo 'Error al actualizar los objetivos';
            } 
       

            

        }

        $record2 = new stdClass();
        $record2-> id = $idestab;
        $record2-> rol = 1;


          try{

            $updateestablecimiento = $DB->update_record('objective_establishment', $record2, $bulk=false);
          // print_r($lastupdateid);
  
          } catch(\Throwable $e) {
            // PHP 7 
            echo 'ERROR AL ACTUALIZAR OBJETIVO 6';
          } 


        $DB->delete_records('objective_groups_users', array('id' => $idgrupouser));


    }else{

    }
    

   }*/


  

   // exit();

}

if(isset($_GET['idnivel'])){
	
		
    $idnivel = $_GET['idnivel'];

    $DB->delete_records('objective_nivel', array('id' => $idnivel)) ;

}




header("Location:".$_SERVER['HTTP_REFERER']);

?>


?>