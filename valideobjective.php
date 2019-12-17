<?php
require_once '../../config.php';
if ($CFG->forcelogin) {
    require_login();
}

global $USER, $DB, $COURSE;



if($_POST['valideidobjetivo1'] !=0){

    $record1 = new stdClass();
    $record1-> id = $_POST['valideidobjetivo1'];
    $record1-> status = $_POST['estatusobj1'];
    try{
    $lastinsertid1 = $DB->update_record('objective_establishment_captured', $record1, $bulk=false);
    echo 'Se cambio el estatus con éxito';

    } catch(\Throwable $e) {
        // PHP 7 
     echo ' NO Se cambio el estatus con éxito';
    } 
}
if($_POST['valideidobjetivo2'] !=0){

    $record2 = new stdClass();
    $record2-> id = $_POST['valideidobjetivo2'];
    $record2-> status = $_POST['estatusobj2'];
    try{
    $lastinsertid2 = $DB->update_record('objective_establishment_captured', $record2, $bulk=false);
    echo 'Se cambio el estatus con éxito';

    } catch(\Throwable $e) {
        // PHP 7 
        echo 'NO Se cambio el estatus con éxito';
    } 
}
if($_POST['valideidobjetivo3'] !=0){

    $record3 = new stdClass();
    $record3-> id = $_POST['valideidobjetivo3'];
    $record3-> status = $_POST['estatusobj3'];
    try{
    $lastinsertid3 = $DB->update_record('objective_establishment_captured', $record3, $bulk=false);
    echo 'Se cambio el estatus con éxito';

    } catch(\Throwable $e) {
        // PHP 7 
    echo 'NO Se cambio el estatus con éxito';
    } 
}
if($_POST['valideidobjetivo4'] !=0){

    $record4 = new stdClass();
    $record4-> id = $_POST['valideidobjetivo4'];
    $record4-> status = $_POST['estatusobj4'];
    try{
    $lastinsertid4 = $DB->update_record('objective_establishment_captured', $record4, $bulk=false);
    echo 'Se cambio el estatus con éxito';

    } catch(\Throwable $e) {
        // PHP 7 
        echo 'NO Se cambio el estatus con éxito';
    } 
}
if($_POST['valideidobjetivo5'] !=0){

    $record5 = new stdClass();
    $record5-> id = $_POST['valideidobjetivo5'];
    $record5-> status = $_POST['estatusobj5'];
    try{
    $lastinsertid5 = $DB->update_record('objective_establishment_captured', $record5, $bulk=false);
    echo 'Se cambio el estatus con éxito';

    } catch(\Throwable $e) {
        // PHP 7 
        echo 'NO Se cambio el estatus con éxito';
    } 
}
if($_POST['valideidobjetivo6'] !=0){

    $record6 = new stdClass();
    $record6-> id = $_POST['valideidobjetivo6'];
    $record6-> status = $_POST['estatusobj6'];

    try{
    $lastinsertid6 = $DB->update_record('objective_establishment_captured', $record6, $bulk=false);
    echo 'Se cambio el estatus con éxito';

    } catch(\Throwable $e) {
        // PHP 7 
        echo 'NO Se cambio el estatus con éxito';
    } 
}


?>