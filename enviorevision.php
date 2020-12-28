<?php
require_once '../../config.php';
if ($CFG->forcelogin) {
    require_login();
}
global $USER, $DB, $COURSE;
$fecha = new DateTime();
if(!empty($_POST['racciones1']) && !empty($_POST['rmeses1'])){
    
    $record1 = new stdClass();
    $record1-> userid = $_POST['userid1'];
    $record1-> courseid = $_POST['courseid1'];
    $record1-> idobjective = $_POST['idobjetivo1'];
    $record1-> idobjectiveestablishment  = $_POST['idobjestablecido1'];
    $record1-> actionpartner = $_POST['racciones1'];
    $record1-> actionsixmonth  = $_POST['rmeses1'];
    $record1-> bosscomments = $_POST['rimplementadas1'];
    $record1-> bosssuggestions = $_POST['rimplementar1'];
    $record1-> timecreated = $fecha->getTimestamp();
    $record1-> timemodified = $fecha->getTimestamp();


    try{
    $lastinsertid1 = $DB->insert_record('objective_establishment_revise', $record1);
    //echo 'REVISION 1 INSERTADO';

    } catch(\Throwable $e) {
        // PHP 7 
    //echo 'ERROR AL INSERTAR REVISION 1';
    } 

}
if(!empty($_POST['racciones2']) && !empty($_POST['rmeses2'])){
    $record2 = new stdClass();
    $record2-> userid = $_POST['userid2'];
    $record2-> courseid = $_POST['courseid2'];
    $record2-> idobjective = $_POST['idobjetivo2'];
    $record2-> idobjectiveestablishment  = $_POST['idobjestablecido2'];
    $record2-> actionpartner = $_POST['racciones2'];
    $record2-> actionsixmonth  = $_POST['rmeses2'];
    $record2-> booscomments = $_POST['rimplementadas2'];
    $record2-> bosssuggestions = $_POST['rimplementar2'];
    $record2-> timecreated = $fecha->getTimestamp();
    $record2-> timemodified = $fecha->getTimestamp();
    try{
    $lastinsertid2 = $DB->insert_record('objective_establishment_revise', $record2);
    //echo 'REVISION 2 INSERTADO';

    } catch(\Throwable $e) {
        // PHP 7 
    //echo 'ERROR AL INSERTAR REVISION 2';
    } 
}

if(!empty($_POST['racciones3']) && !empty($_POST['rmeses3'])){
    $record3 = new stdClass();
    $record3-> userid = $_POST['userid3'];
    $record3-> courseid = $_POST['courseid3'];
    $record3-> idobjective = $_POST['idobjetivo3'];
    $record3-> idobjectiveestablishment  = $_POST['idobjestablecido3'];
    $record3-> actionpartner = $_POST['racciones3'];
    $record3-> actionsixmonth  = $_POST['rmeses3'];
    $record3-> booscomments = $_POST['rimplementadas3'];
    $record3-> bosssuggestions = $_POST['rimplementar3'];
    $record3-> timecreated = $fecha->getTimestamp();
    $record3-> timemodified = $fecha->getTimestamp();
    try{
    $lastinsertid3 = $DB->insert_record('objective_establishment_revise', $record3);
    //echo 'REVISION 3 INSERTADO';

    } catch(\Throwable $e) {
        // PHP 7 
    //echo 'ERROR AL INSERTAR REVISION 3';
    } 

}
if(!empty($_POST['racciones4']) && !empty($_POST['rmeses4'])){

    $idobj=$_POST['idobjetivo4'];
    $record4 = new stdClass();
    $record4-> userid = $_POST['userid4'];
    $record4-> courseid = $_POST['courseid4'];
    $record4-> idobjective = $idobj;
    $record4-> idobjectiveestablishment  = $_POST['idobjestablecido4'];
    $record4-> actionpartner = $_POST['racciones4'];
    $record4-> actionsixmonth  = $_POST['rmeses4'];
    $record4-> booscomments = $_POST['rimplementadas4'];
    $record4-> bosssuggestions = $_POST['rimplementar4'];
    $record4-> timecreated = $fecha->getTimestamp();
    $record4-> timemodified = $fecha->getTimestamp();
    try{
        $lastinsertid4 = $DB->insert_record('objective_establishment_revise', $record4);
        $updaterevision = new stdClass();
        $updaterevision-> id = $idobj;
        $updaterevision-> status = 5;
        try{
            $updaterev = $DB->update_record('objective_establishment', $updaterevision, $bulk=false);

            $querynotificacion="select UPPER(concat(u.firstname, ' ', u.lastname)) as 'nombre', oe.idjefedirecto as 'idjefedirecto' , (select u2.email from {user} u2 where oe.idjefedirecto = u2.id) as 'emailjefedirecto', oe.courseid as 'idcurso' ,
                (select FROM_UNIXTIME(ue.timeend, '%Y-%m-%d')
                    FROM {course} AS course  
                    JOIN {enrol} AS en ON en.courseid = course.id 
                    JOIN {user_enrolments} AS ue ON ue.enrolid = en.id
                    WHERE ue.userid = oe.idjefedirecto and course.id=oe.courseid) AS finm 
                from {objective_establishment} oe
                join {user} u on oe.userid = u.id
                where oe.id=?";
                $resultnot = $DB->get_records_sql($querynotificacion, array($idobj));
                $nombrenot="";
                foreach($resultnot  as $vals){
                    $nombrecom=$vals->nombre;
                    $idjefed=$vals->idjefedirecto;
                    $emailjefed=$vals->emailjefedirecto;
                    $fechafinal=$vals->finm;
                    $idcurso=$vals->idcurso;
                }
                $cadena = "email=$emailjefed&courseid=$idcurso";
                $cadena= base64_encode($cadena);
                $clienteSOAP = new SoapClient('http://192.168.14.30:8080/svcELearning.svc?wsdl');
                // https://www.portal3i.mx/URL/new_login.php?email=ingdanieltellez2015@gmail.com&courseid=12
                $mensaje=''.$nombrecom.' ha finalizado el registrado de su Revisión  mitad de año (Autoevaluación), ingresa a  colocar tus comentarios y  la Retroalimentación de fin de año dando clic.~https://www.portal3i.mx/openlms/tripleI.php?key='.$cadena.'~. La fecha límite para realizar esta acción es '.$fechafinal.'';
    

                    try{
                    $parametros1=array(); //parametros de la llamada
                    $parametros1['mensaje']=$mensaje;
                    $parametros1['correo']=$emailjefed;
                    $parametros1['aplicacion']='Establecimiento de Objetivos';
                    $parametros1['idAplicacion']=(int)9;
                    $parametros1['IdAmbiente']=(int)1;
                    $parametros1['IdTipoNotificacion']=(int)0;
                    $result1 = $clienteSOAP->Notificacion($parametros1);
                    $statusfinal1 = $result1->envioNotificacionUsuarioResult;
                
                    } catch(SoapFault $e){
                    //  var_dump($e);
                
                    }

    
                echo 'Guardado con éxito';
        
            } catch(\Throwable $e) {
                    // PHP 7 
               // echo 'Error al guardar';
            } 
      

    } catch(\Throwable $e) {
        // PHP 7 
        //echo 'Error al guardar';
    }

    
    
}

if($_POST['idobjestablecido5'] != NULL){
    if(!empty($_POST['racciones5']) && !empty($_POST['rmeses5'])){

        $record5 = new stdClass();
        $record5-> userid = $_POST['userid5'];
        $record5-> courseid = $_POST['courseid5'];
        $record5-> idobjective = $_POST['idobjetivo5'];
        $record5-> idobjectiveestablishment  = $_POST['idobjestablecido5'];
        $record5-> actionpartner = $_POST['racciones5'];
        $record5-> actionsixmonth  = $_POST['rmeses5'];
        $record5-> booscomments = $_POST['rimplementadas5'];
        $record5-> bosssuggestions = $_POST['rimplementar5'];
        $record5-> timecreated = $fecha->getTimestamp();
        $record5-> timemodified = $fecha->getTimestamp();
        try{
        $lastinsertid5 = $DB->insert_record('objective_establishment_revise', $record5);
    // echo 'REVISION 5 INSERTADO';
        
        } catch(\Throwable $e) {
            // PHP 7 
    //  echo 'ERROR AL INSERTAR REVISION 5';
        } 
    }
}

if($_POST['idobjestablecido6'] != NULL){
    if(!empty($_POST['racciones6']) && !empty($_POST['rmeses6'])){

        $record6 = new stdClass();
        $record6-> userid = $_POST['userid6'];
        $record6-> courseid = $_POST['courseid6'];
        $record6-> idobjective = $_POST['idobjetivo6'];
        $record6-> idobjectiveestablishment  = $_POST['idobjestablecido6'];
        $record6-> actionpartner = $_POST['racciones6'];
        $record6-> actionsixmonth  = $_POST['rmeses6'];
        $record6-> booscomments = $_POST['rimplementadas6'];
        $record6-> bosssuggestions = $_POST['rimplementar6'];
        $record6-> timecreated = $fecha->getTimestamp();
        $record6-> timemodified = $fecha->getTimestamp();
        try{
        $lastinsertid6 = $DB->insert_record('objective_establishment_revise', $record6);
        //  echo 'REVISION 6 INSERTADO';
        
        } catch(\Throwable $e) {
            // PHP 7 
        //echo 'ERROR AL INSERTAR REVISION 6';
        } 
    }
}

//header("Location:".$_SERVER['HTTP_REFERER']);

?>