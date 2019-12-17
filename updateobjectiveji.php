<?php
require_once '../../config.php';
if ($CFG->forcelogin) {
    require_login();
}

global $USER, $DB, $COURSE;



if(!empty($_POST['comenidobjetivo1'])){

    $record1 = new stdClass();
    $record1-> id = $_POST['comenidobjetivo1'];
    $record1-> comentariosjefe = $_POST['comentariosobjetivo1'];
    try{
    $lastinsertid1 = $DB->update_record('objective_establishment_captured', $record1, $bulk=false);
    echo 'Se agrego con éxito el comentario';

    } catch(\Throwable $e) {
        // PHP 7 
     echo 'Se agrego con éxito el comentario';
    } 
}
if(!empty($_POST['comenidobjetivo2'])){

    $record2 = new stdClass();
    $record2-> id = $_POST['comenidobjetivo2'];
    $record2-> comentariosjefe = $_POST['comentariosobjetivo2'];
    try{
    $lastinsertid2 = $DB->update_record('objective_establishment_captured', $record2, $bulk=false);
    echo 'Se agrego con éxito el comentario';

    } catch(\Throwable $e) {
        // PHP 7 
        echo 'Se agrego con éxito el comentario';
    } 
}
if(!empty($_POST['comenidobjetivo3'])){

    $record3 = new stdClass();
    $record3-> id = $_POST['comenidobjetivo3'];
    $record3-> comentariosjefe = $_POST['comentariosobjetivo3'];
    try{
    $lastinsertid3 = $DB->update_record('objective_establishment_captured', $record3, $bulk=false);
    echo 'Se agrego con éxito el comentario';

    } catch(\Throwable $e) {
        // PHP 7 
    echo 'Se agrego con éxito el comentario';
    } 
}
if(!empty($_POST['comenidobjetivo4'])){

    $record4 = new stdClass();
    $record4-> id = $_POST['comenidobjetivo4'];
    $record4-> comentariosjefe = $_POST['comentariosobjetivo4'];
    try{
    $lastinsertid4 = $DB->update_record('objective_establishment_captured', $record4, $bulk=false);
    echo 'Se agrego con éxito el comentario';

    } catch(\Throwable $e) {
        // PHP 7 
        echo 'Se agrego con éxito el comentario';
    } 
}
if(!empty($_POST['comenidobjetivo5'])){

    $record5 = new stdClass();
    $record5-> id = $_POST['comenidobjetivo5'];
    $record5-> comentariosjefe = $_POST['comentariosobjetivo5'];
    try{
    $lastinsertid5 = $DB->update_record('objective_establishment_captured', $record5, $bulk=false);
    echo 'Se agrego con éxito el comentario';

    } catch(\Throwable $e) {
        // PHP 7 
        echo 'Se agrego con éxito el comentario';
    } 
}
if(!empty($_POST['comenidobjetivo6'])){

    $record6 = new stdClass();
    $record6-> id = $_POST['comenidobjetivo6'];
    $record6-> comentariosjefe = $_POST['comentariosobjetivo6'];

    try{
    $lastinsertid6 = $DB->update_record('objective_establishment_captured', $record6, $bulk=false);
    echo 'Se agrego con éxito el comentario';

    } catch(\Throwable $e) {
        // PHP 7 
        echo 'Se agrego con éxito el comentario';
    } 
}


?>