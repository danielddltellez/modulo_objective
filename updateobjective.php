<?php
require_once '../../config.php';
if ($CFG->forcelogin) {
    require_login();
}

global $USER, $DB, $COURSE;

if(!empty($_POST['idobjetivo1'])){

    $record1 = new stdClass();
    $record1-> id = $_POST['idobjetivo1'];
    $record1-> objectivecomplete = $_POST['objetivocompleto1'];
    $record1-> startdate = strtotime($_POST['fechainicio1']);
    $record1-> enddate = strtotime($_POST['fechafinal1']);
    $record1-> valueobjective = $_POST['valorobjetivo1'];
    try{
    $lastinsertid1 = $DB->update_record('objective_establishment_captured', $record1, $bulk=false);
    echo 'OBJETIVO 1 ACTUALIZADO';

    } catch(\Throwable $e) {
        // PHP 7 
    echo 'ERROR AL ACTUALIZAR OBJETIVO 1';
    } 
}
if(!empty($_POST['idobjetivo2'])){

    $record2 = new stdClass();
    $record2-> id = $_POST['idobjetivo2'];
    $record2-> objectivecomplete = $_POST['objetivocompleto2'];
    $record2-> startdate = strtotime($_POST['fechainicio2']);
    $record2-> enddate = strtotime($_POST['fechafinal2']);
    $record2-> valueobjective = $_POST['valorobjetivo2'];
    try{
    $lastinsertid2 = $DB->update_record('objective_establishment_captured', $record2, $bulk=false);
    echo 'OBJETIVO 2 ACTUALIZADO';

    } catch(\Throwable $e) {
        // PHP 7 
    echo 'ERROR AL ACTUALIZAR OBJETIVO 2';
    } 
}
if(!empty($_POST['idobjetivo3'])){

    $record3 = new stdClass();
    $record3-> id = $_POST['idobjetivo3'];
    $record3-> objectivecomplete = $_POST['objetivocompleto3'];
    $record3-> startdate = strtotime($_POST['fechainicio3']);
    $record3-> enddate = strtotime($_POST['fechafinal3']);
    $record3-> valueobjective = $_POST['valorobjetivo3'];
    try{
    $lastinsertid3 = $DB->update_record('objective_establishment_captured', $record3, $bulk=false);
    echo 'OBJETIVO 3 ACTUALIZADO';

    } catch(\Throwable $e) {
        // PHP 7 
    echo 'ERROR AL ACTUALIZAR OBJETIVO 3';
    } 
}
if(!empty($_POST['idobjetivo4'])){

    $record4 = new stdClass();
    $record4-> id = $_POST['idobjetivo4'];
    $record4-> objectivecomplete = $_POST['objetivocompleto4'];
    $record4-> startdate = strtotime($_POST['fechainicio4']);
    $record4-> enddate = strtotime($_POST['fechafinal4']);
    $record4-> valueobjective = $_POST['valorobjetivo4'];
    try{
    $lastinsertid4 = $DB->update_record('objective_establishment_captured', $record4, $bulk=false);
    echo 'OBJETIVO 4 ACTUALIZADO';

    } catch(\Throwable $e) {
        // PHP 7 
    echo 'ERROR AL ACTUALIZAR OBJETIVO 4';
    } 
}
if(!empty($_POST['idobjetivo5'])){

    $record5 = new stdClass();
    $record5-> id = $_POST['idobjetivo5'];
    $record5-> objectivecomplete = $_POST['objetivocompleto5'];
    $record5-> startdate = strtotime($_POST['fechainicio5']);
    $record5-> enddate = strtotime($_POST['fechafinal5']);
    $record5-> valueobjective = $_POST['valorobjetivo5'];
    try{
    $lastinsertid5 = $DB->update_record('objective_establishment_captured', $record5, $bulk=false);
    echo 'OBJETIVO 5 ACTUALIZADO';

    } catch(\Throwable $e) {
        // PHP 7 
    echo 'ERROR AL ACTUALIZAR OBJETIVO 5';
    } 
}
if(!empty($_POST['idobjetivo6'])){

    $record6 = new stdClass();
    $record6-> id = $_POST['idobjetivo6'];
    $record6-> objectivecomplete = $_POST['objetivocompleto6'];
    $record6-> startdate = strtotime($_POST['fechainicio6']);
    $record6-> enddate = strtotime($_POST['fechafinal6']);
    $record6-> valueobjective = $_POST['valorobjetivo6'];
    try{
    $lastinsertid6 = $DB->update_record('objective_establishment_captured', $record6, $bulk=false);
    echo 'OBJETIVO 6 ACTUALIZADO';

    } catch(\Throwable $e) {
        // PHP 7 
    echo 'ERROR AL ACTUALIZAR OBJETIVO 6';
    } 
}
if(isset($_GET['sendobj'])){
    $idestablecimiento = $_GET['sendobj'];
    $updateest = new stdClass();
    $updateest-> id = $idestablecimiento;
    $updateest-> status = 2;

    $query="select UPPER(concat(u.firstname, ' ', u.lastname)) as 'nombre', oe.idjefedirecto as 'idjefedirecto' , (select u2.email from mdl_user u2 where oe.idjefedirecto = u2.id) as 'emailjefedirecto'
    from mdl_objective_establishment oe
    join mdl_user u on oe.userid = u.id
    where oe.id=?";
    $resultcontrol = $DB->get_records_sql($query, array($idestablecimiento));
    $nombrecom="";
    foreach($resultcontrol as $vals){
        $nombrecom=$vals->nombre;
        $idjefed=$vals->idjefedirecto;
        $emailjefed=$vals->emailjefedirecto;

        $destinatario=new stdClass();
        $destinatario-> id=$idjefed;
        $destinatario-> email = $emailjefed;


    }
    try{
        $updateobjetivos = $DB->update_record('objective_establishment', $updateest, $bulk=false);
        $fechaap=date("d-m-Y H:i:s");
        $subject='Establecimiento de Objetivos';
        $message ="Estimado(a)  Marco Polo, \n\n";
        $message .="Hacemos de tu conocimiento que $nombrecom ha finalizado el\n\n";
        $message .="registrado de sus Objetivos 2020, es momento de que ingreses a plataforma a Validar sus Objetivos, ingresa a la plataforma e-learning para Aprobar, Rechazar y/o Para validar los objetivos, \n\n";
        $message .="ingresa a tu perfil dando clic https://www.portal3i.mx/2546-Triplei/mod/objective/view.php?id=6105 \n\n";
        $message .="La fecha límite para realizar esta acción es el 07 de febrero del 2020\n\n";
        $message .="Glosario: \n\n";
        $message .="•	Aprobar – Estas de acuerdo con el objetivo ingresado por tu colaborador ya que se encuentra alineado a los objetivos de la Organización. \n\n";
        $message .="•	Rechazar – Parte del objetivo deberá ser editarlo por tu colaborador y deberá redactarlo nuevamente desde su perfil, ya que no está apegado a la estrategia de la Organización. \n\n";
        $message .="•	Cancelar – El objetivo es Cancelado ya que la estrategia / rol / prioridades del colaborador/ puesto ha cambiado y ya no es necesario ese objetivo. \n\n";
       // print_r($USER);
        $sendenvio = email_to_user($destinatario, $USER , $subject, $message);

       // print_r($sendenvio);
        

    
    } catch(\Throwable $e) {
            // PHP 7 
        echo 'ERROR AL ACTUALIZAR OBJETIVO 6';
    } 
        header("Location:".$_SERVER['HTTP_REFERER']);


}

?>