<?php
require_once '../../config.php';

if ($CFG->forcelogin) {
    require_login();
}

global $USER, $DB, $COURSE;

if(isset($_GET['idgrupo'])){
	
		
    $idgrupo = $_GET['idgrupo'];

    $DB->delete_records('objective_groups', array('id' => $idgrupo)) ;

}

if(isset($_GET['idgrupouser'])){
	
		
    $idgrupouser = $_GET['idgrupouser'];

    $DB->delete_records('objective_groups_users', array('id' => $idgrupouser)) ;

}

if(isset($_GET['idnivel'])){
	
		
    $idnivel = $_GET['idnivel'];

    $DB->delete_records('objective_nivel', array('id' => $idnivel)) ;

}




header("Location:".$_SERVER['HTTP_REFERER']);

?>


?>