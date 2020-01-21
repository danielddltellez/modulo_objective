<?php
require_once '../../config.php';
if ($CFG->forcelogin) {
    require_login();
}

global $USER, $DB, $COURSE;
if(isset($_GET['id'])){
$id = $_GET['id'];
$idinstance = $_GET['instance'];

$record1 = new stdClass();
$record1-> id = $id;
$record1-> status  = 9;


$DB->update_record('objective_establishment', $record1, $bulk=false);
$my = new moodle_url('/mod/objective/view.php?id='.$idinstance.'');
redirect($my);
exit();
}

header("Location:".$_SERVER['HTTP_REFERER']);
?>