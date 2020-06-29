<?php
require_once '../../config.php';
if ($CFG->forcelogin) {
    require_login();
}

global $USER, $DB, $COURSE;
if(isset($_GET['sendobj'])){

    echo ('si');
    $idestablecimiento = $_GET['sendobj'];
    $updateest = new stdClass();
    $updateest-> id = $idestablecimiento;
    $updateest-> status = 3;
    
    $updateobjetivos = $DB->update_record('objective_establishment', $updateest, $bulk=false);
    $sql='select id as idestablecimiento from {objective_establishment_captured} where idobjective=?';
    $resultcontrol = $DB->get_records_sql($sql, array($idestablecimiento));

    foreach($resultcontrol as $values){

        $ids = $values->idestablecimiento;
        $updatestatus = new stdClass();
        $updatestatus-> id = $ids;
        $updatestatus-> status = 2;
        $actobj = $DB->update_record('objective_establishment_captured', $updatestatus, $bulk=false);

    }
                
    $destinatario=new stdClass();
    $destinatario-> id=449;
    $destinatario-> email = 'daniel.delaluz@triplei.mx';


    try{            
    $fechaap=date("F j, Y, g:i a");
    $subject='Establecimiento de Objetivos director';
    $message ="Estimado(a)  Administrador, \n\n";
    $message .="Te informamos que el director ha finalizado sus objetivos \n\n";
    $message .="La fecha límite para realizar esta acción es: $fechaap\n\n";
    $sendenvio = email_to_user($destinatario, $USER , $subject, $message);
        
    } catch(\Throwable $e) {
        // PHP 7 
    echo 'ERROR AL ACTUALIZAR OBJETIVO 6';
    } 
    header("Location:".$_SERVER['HTTP_REFERER']);



}

?>