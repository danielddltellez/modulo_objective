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
        $destinatario=new stdClass();
        $destinatario-> id=449;
        $destinatario-> email = 'daniel.delaluz@triplei.mx';

        
        try{
            $updaterev = $DB->update_record('objective_establishment', $updaterevision, $bulk=false);

            $fechaap=date("F j, Y, g:i a");
            $subject='Establecimiento de Objetivos';
            $message ="Estimado(a)  Lucio Garcia, \n\n";
            $message .="Hacemos de tu conocimiento que NOMBRE DEL COLABORADOR ha finalizado el registrado de su Autoevaluación,  \n\n";
            $message .="es momento de que ingreses a la plataforma e-learning a Colocar tus comentarios y brindar la Retroalimentación de medio año. \n\n";
            $message .="Para registrar tus comentarios, ingresa a tu perfil dando clic aquí. \n\n";
            $message .="La fecha límite para realizar esta acción es: $fechaap\n\n";
            $message .="Que tenga un excelente día\n\n";
           // print_r($USER);
            $sendenvio = email_to_user($destinatario, $USER , $subject, $message);
    
          /*print_r($sendenvio);*/
            
             echo 'Guardado con éxito';
        
        } catch(\Throwable $e) {
                // PHP 7 
            echo 'Error al guardar';
        } 
         //   header("Location:".$_SERVER['HTTP_REFERER']);

    } catch(\Throwable $e) {
        // PHP 7 
    echo 'Error al guardar';
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

?>