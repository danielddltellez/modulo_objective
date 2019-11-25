<?php
require_once '../../config.php';
if ($CFG->forcelogin) {
    require_login();
}
global $USER, $DB, $COURSE;

$fecha = new DateTime();
$record1 = new stdClass();
$record1-> id = $_POST['idrevisionfinal1'];
$record1-> feedbackboos = $_POST['retroalimentacion1'];
$record1-> feedbackevaluation = $_POST['retrojefe1'];
$record1-> evaluationboss = $_POST['valorevaluacionjefe1'];
$record1-> timemodified = $fecha->getTimestamp();
try{
$lastinsertid1 = $DB->update_record('objective_establishment_revise_final', $record1);
//echo 'REVISION 1 ACTUALIZADO';

} catch(\Throwable $e) {
    // PHP 7 
//echo 'ERROR AL ACTUALIZADO REVISION 1';
} 

$record2 = new stdClass();
$record2-> id = $_POST['idrevisionfinal2'];
$record2-> feedbackboos = $_POST['retroalimentacion2'];
$record2-> feedbackevaluation = $_POST['retrojefe2'];
$record2-> evaluationboss = $_POST['valorevaluacionjefe2'];
$record2-> timemodified = $fecha->getTimestamp();
try{
$lastinsertid2 = $DB->update_record('objective_establishment_revise_final', $record2);
//echo 'REVISION 2 ACTUALIZADO';

} catch(\Throwable $e) {
    // PHP 7 
//echo 'ERROR AL ACTUALIZADO REVISION 2';
} 
$record3 = new stdClass();
$record3-> id = $_POST['idrevisionfinal3'];
$record3-> feedbackboos = $_POST['retroalimentacion3'];
$record3-> feedbackevaluation = $_POST['retrojefe3'];
$record3-> evaluationboss = $_POST['valorevaluacionjefe3'];
$record3-> timemodified = $fecha->getTimestamp();
try{
$lastinsertid3 = $DB->update_record('objective_establishment_revise_final', $record3);
//echo 'REVISION 3 ACTUALIZADO';

} catch(\Throwable $e) {
    // PHP 7 
//echo 'ERROR AL ACTUALIZADO REVISION 3';
} 
$record4 = new stdClass();
$record4-> id = $_POST['idrevisionfinal4'];
$record4-> feedbackboos = $_POST['retroalimentacion4'];
$record4-> feedbackevaluation = $_POST['retrojefe4'];
$record4-> evaluationboss = $_POST['valorevaluacionjefe4'];
$record4-> timemodified = $fecha->getTimestamp();
try{
$lastinsertid4 = $DB->update_record('objective_establishment_revise_final', $record4);
echo 'Se registraron con exito los datos';

} catch(\Throwable $e) {
    // PHP 7 
echo 'Erro al guardar los comentarios';
} 
if($_POST['idrevisionfinal5'] != NULL){
    $record5 = new stdClass();
    $record5-> id = $_POST['idrevisionfinal5'];
    $record5-> feedbackboos = $_POST['retroalimentacion5'];
    $record5-> feedbackevaluation = $_POST['retrojefe5'];
    $record5-> evaluationboss = $_POST['valorevaluacionjefe5'];
    $record5-> timemodified = $fecha->getTimestamp();
    try{
    $lastinsertid5 = $DB->update_record('objective_establishment_revise_final', $record5);
   // echo 'REVISION 5 ACTUALIZADO';
    
    } catch(\Throwable $e) {
        // PHP 7 
    //echo 'ERROR AL ACTUALIZADO REVISION 5';
    } 
}

if($_POST['idrevisionfinal6'] != NULL){

    $record6 = new stdClass();
    $record6-> id = $_POST['idrevisionfinal6'];
    $record6-> feedbackboos = $_POST['retroalimentacion6'];
    $record6-> feedbackevaluation = $_POST['retrojefe6'];
    $record6-> evaluationboss = $_POST['valorevaluacionjefe6'];
    $record6-> timemodified = $fecha->getTimestamp();
    try{
    $lastinsertid6 = $DB->update_record('objective_establishment_revise_final', $record6);
    //echo 'REVISION 6 ACTUALIZADO';
    
    } catch(\Throwable $e) {
        // PHP 7 
    //echo 'ERROR AL ACTUALIZADO REVISION 6';
    } 
}


?>