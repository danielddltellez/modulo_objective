<?php
require_once '../../config.php';
if ($CFG->forcelogin) {
    require_login();
}

global $USER, $DB, $COURSE;
if(isset($_GET['idgrupouser'])){
$id = $_GET['idgrupouser'];

$record1 = new stdClass();
$record1-> id = $id;
$record1-> status  = $_POST['status'];
$DB->update_record('objective_groups_users', $record1, $bulk=false);
}
header("Location:".$_SERVER['HTTP_REFERER']);
?>