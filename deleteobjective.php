<?php
require_once '../../config.php';

if ($CFG->forcelogin) {
    require_login();
}

global $USER, $DB, $COURSE;

if(isset($_GET['idobjec'])){
	
		
    $idobjective = $_GET['idobjec'];

    $DB->delete_records('objective_establishment_captured', array('id' => $idobjective)) ;

}
header("Location:".$_SERVER['HTTP_REFERER']);

?>