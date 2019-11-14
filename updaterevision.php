<?php
require_once '../../config.php';
if ($CFG->forcelogin) {
    require_login();
}
global $USER, $DB, $COURSE;

$fecha = new DateTime();
$record1 = new stdClass();
$record1-> id = $_POST['idrevision1'];
$record1-> bosscomments = $_POST['rimplementadas1'];
$record1-> bosssuggestions = $_POST['rimplementar1'];
$record1-> timemodified = $fecha->getTimestamp();
try{
$lastinsertid1 = $DB->update_record('objective_establishment_revise', $record1);
echo 'REVISION 1 ACTUALIZADO';

} catch(\Throwable $e) {
    // PHP 7 
echo 'ERROR AL ACTUALIZADO REVISION 1';
} 

$record2 = new stdClass();
$record2-> id = $_POST['idrevision2'];
$record2-> bosscomments = $_POST['rimplementadas2'];
$record2-> bosssuggestions = $_POST['rimplementar2'];
$record2-> timemodified = $fecha->getTimestamp();
try{
$lastinsertid2 = $DB->update_record('objective_establishment_revise', $record2);
echo 'REVISION 2 ACTUALIZADO';

} catch(\Throwable $e) {
    // PHP 7 
echo 'ERROR AL ACTUALIZADO REVISION 2';
} 
$record3 = new stdClass();
$record3-> id = $_POST['idrevision3'];
$record3-> bosscomments = $_POST['rimplementadas3'];
$record3-> bosssuggestions = $_POST['rimplementar3'];
$record3-> timemodified = $fecha->getTimestamp();
try{
$lastinsertid3 = $DB->update_record('objective_establishment_revise', $record3);
echo 'REVISION 3 ACTUALIZADO';

} catch(\Throwable $e) {
    // PHP 7 
echo 'ERROR AL ACTUALIZADO REVISION 3';
} 
$record4 = new stdClass();
$record4-> id = $_POST['idrevision4'];
$record4-> bosscomments = $_POST['rimplementadas4'];
$record4-> bosssuggestions = $_POST['rimplementar4'];
$record4-> timemodified = $fecha->getTimestamp();
try{
$lastinsertid4 = $DB->update_record('objective_establishment_revise', $record4);
echo 'REVISION 4 ACTUALIZADO';

} catch(\Throwable $e) {
    // PHP 7 
echo 'ERROR AL ACTUALIZADO REVISION 4';
} 
if($_POST['idrevision5'] != NULL){
    $record5 = new stdClass();
    $record5-> id = $_POST['idrevision5'];
    $record5-> bosscomments = $_POST['rimplementadas5'];
    $record5-> bosssuggestions = $_POST['rimplementar5'];
    $record5-> timemodified = $fecha->getTimestamp();
    try{
    $lastinsertid5 = $DB->update_record('objective_establishment_revise', $record5);
    echo 'REVISION 5 ACTUALIZADO';
    
    } catch(\Throwable $e) {
        // PHP 7 
    echo 'ERROR AL ACTUALIZADO REVISION 5';
    } 
}

if($_POST['idrevision6'] != NULL){

    $record6 = new stdClass();
    $record6-> id = $_POST['idrevision6'];
    $record6-> bosscomments = $_POST['rimplementadas6'];
    $record6-> bosssuggestions = $_POST['rimplementar6'];
    $record6-> timemodified = $fecha->getTimestamp();
    try{
    $lastinsertid6 = $DB->update_record('objective_establishment_revise', $record6);
    echo 'REVISION 6 ACTUALIZADO';
    
    } catch(\Throwable $e) {
        // PHP 7 
    echo 'ERROR AL ACTUALIZADO REVISION 6';
    } 
}


?>