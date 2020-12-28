<?php
require_once '../../config.php';
if ($CFG->forcelogin) {
    require_login();
}
global $USER, $DB, $COURSE;
$fecha = new DateTime();
$idusarioupdate=$USER->id;
if(!empty($_POST['idgrupo']) && !empty($_POST['namegrupo'])){

    $updateficha = new stdClass();
    $updateficha-> id = $_POST['idgrupo'];
    $updateficha-> userid = $idusarioupdate;
    $updateficha-> namegroup  = $_POST['namegrupo'];
    $updateficha-> timemodified = $fecha->getTimestamp();


    try{
    $resultupdateficha  = $DB->update_record('objective_groups', $updateficha  , $bulk=false);
    
      echo 'Se guardo actualizo el usuario';

    } catch(\Throwable $e) {
        // PHP 7 
        echo $e->error;
    } 
}

header("Location:".$_SERVER['HTTP_REFERER']);

?>