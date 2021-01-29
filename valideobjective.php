<?php
require_once '../../config.php';
if ($CFG->forcelogin) {
    require_login();
}

global $USER, $DB, $COURSE;



if($_POST['valideidobjetivo1'] !=0){
    $status1=$_POST['estatusobj1'];
    $idobjetivo1=$_POST['idobjectivo1'];
    $record1 = new stdClass();
    $record1-> id = $_POST['valideidobjetivo1'];
    $record1-> status = $_POST['estatusobj1'];
    $record1-> comentariosjefe = $_POST['comentariosobjetivo1'];
    try{
    $lastinsertid1 = $DB->update_record('objective_establishment_captured', $record1, $bulk=false);
    if($status1==1 || $status1==3){

        $updateobjective1 = new stdClass();
        $updateobjective1 -> id = $idobjetivo1;
        $updateobjective1 -> status = 10;
        $update1 = $DB->update_record('objective_establishment', $updateobjective1, $bulk=false);
    }
    echo 'Se cambio el estatus con éxito';

    } catch(\Throwable $e) {
        // PHP 7 
     echo ' NO Se cambio el estatus con éxito';
    } 
}
if($_POST['valideidobjetivo2'] !=0){
    $status2=$_POST['estatusobj2'];
    $idobjetivo2=$_POST['idobjectivo2'];
    $record2 = new stdClass();
    $record2-> id = $_POST['valideidobjetivo2'];
    $record2-> status = $_POST['estatusobj2'];
    $record2-> comentariosjefe = $_POST['comentariosobjetivo2'];
    try{
    $lastinsertid2 = $DB->update_record('objective_establishment_captured', $record2, $bulk=false);
    if($status2==1 || $status2==3){

        $updateobjective2 = new stdClass();
        $updateobjective2 -> id = $idobjetivo2;
        $updateobjective2 -> status = 10;
        $update2 = $DB->update_record('objective_establishment', $updateobjective2, $bulk=false);
    }
    echo 'Se cambio el estatus con éxito';

    } catch(\Throwable $e) {
        // PHP 7 
        echo 'NO Se cambio el estatus con éxito';
    } 
}
if($_POST['valideidobjetivo3'] !=0){
    $status3=$_POST['estatusobj3'];
    $idobjetivo3=$_POST['idobjectivo3'];
    $record3 = new stdClass();
    $record3-> id = $_POST['valideidobjetivo3'];
    $record3-> status = $_POST['estatusobj3'];
    $record3-> comentariosjefe = $_POST['comentariosobjetivo3'];
    try{
    $lastinsertid3 = $DB->update_record('objective_establishment_captured', $record3, $bulk=false);
    echo 'Se cambio el estatus con éxito';
    if($status3==1 || $status3==3){

        $updateobjective3 = new stdClass();
        $updateobjective3 -> id = $idobjetivo3;
        $updateobjective3 -> status = 10;
        $update3 = $DB->update_record('objective_establishment', $updateobjective3, $bulk=false);
    }

    } catch(\Throwable $e) {
        // PHP 7 
    echo 'NO Se cambio el estatus con éxito';
    } 
}
if($_POST['valideidobjetivo4'] !=0){
    $status4=$_POST['estatusobj4'];
    $idobjetivo4=$_POST['idobjectivo4'];
    $record4 = new stdClass();
    $record4-> id = $_POST['valideidobjetivo4'];
    $record4-> status = $_POST['estatusobj4'];
    $record4-> comentariosjefe = $_POST['comentariosobjetivo4'];
    try{
    $lastinsertid4 = $DB->update_record('objective_establishment_captured', $record4, $bulk=false);
    echo 'Se cambio el estatus con éxito';
    if($status4==1 || $status4==3){

        $updateobjective4 = new stdClass();
        $updateobjective4 -> id = $idobjetivo4;
        $updateobjective4 -> status = 10;
        $update4 = $DB->update_record('objective_establishment', $updateobjective4, $bulk=false);
    }

    } catch(\Throwable $e) {
        // PHP 7 
        echo 'NO Se cambio el estatus con éxito';
    } 
}
if($_POST['valideidobjetivo5'] !=0){
    $status5=$_POST['estatusobj5'];
    $idobjetivo5=$_POST['idobjectivo5'];
    $record5 = new stdClass();
    $record5-> id = $_POST['valideidobjetivo5'];
    $record5-> status = $_POST['estatusobj5'];
    $record5-> comentariosjefe = $_POST['comentariosobjetivo5'];
    try{
    $lastinsertid5 = $DB->update_record('objective_establishment_captured', $record5, $bulk=false);
    echo 'Se cambio el estatus con éxito';
    if($status5==1 || $status5==3){

        $updateobjective5 = new stdClass();
        $updateobjective5 -> id = $idobjetivo5;
        $updateobjective5 -> status = 10;
        $update5 = $DB->update_record('objective_establishment', $updateobjective5, $bulk=false);
    }

    } catch(\Throwable $e) {
        // PHP 7 
        echo 'NO Se cambio el estatus con éxito';
    } 
}
if($_POST['valideidobjetivo6'] !=0){
    $status6=$_POST['estatusobj6'];
    $idobjetivo6=$_POST['idobjectivo6'];
    $record6 = new stdClass();
    $record6-> id = $_POST['valideidobjetivo6'];
    $record6-> status = $_POST['estatusobj6'];
    $record6-> comentariosjefe = $_POST['comentariosobjetivo6'];

    try{
    $lastinsertid6 = $DB->update_record('objective_establishment_captured', $record6, $bulk=false);
    echo 'Se cambio el estatus con éxito';
    if($status6==1 || $status6==3){

        $updateobjective6 = new stdClass();
        $updateobjective6 -> id = $idobjetivo6;
        $updateobjective6 -> status = 10;
        $update6 = $DB->update_record('objective_establishment', $updateobjective6, $bulk=false);
    }

    } catch(\Throwable $e) {
        // PHP 7 
        echo 'NO Se cambio el estatus con éxito';
    } 
}


?>