<?php
 require_once '../../config.php';
 if ($CFG->forcelogin) {
     require_login();
 }
 global $USER, $DB, $COURSE;
 
/*print_r($_POST);*/

foreach($_POST as $k=>$v){

 
    foreach($v as $k2 => $v2)
	{
    

            $valoropcion = $v2["valor"];
            $valoridcomp= $v2["idcompetencia"];
            $valoridcomportamiento= $v2["idcomportamiento"];
            $valorcourseid= $v2["courseid"];
            $valoruser=$v2["userid"];
            $valoridestablecimiento=$v2["idestablecimiento"];

            if(!empty($valoropcion)){

                $fecha = new DateTime();
                $record1 = new stdClass();
                $record1-> idobjectiveestablishment = $valoridestablecimiento;
                $record1-> idcompetition = $valoridcomp;
                $record1-> idbehavior  = $valoridcomportamiento;
                $record1-> userid = $valoruser;
                $record1-> courseid = $valorcourseid;
                $record1-> value  = $valoropcion;
                $record1-> timecaptured = $fecha->getTimestamp();

                try{
                $lastinsertid = $DB->insert_record('objective_establishment_competition', $record1);
                //echo 'Se capturaron las competencias';

                } catch(\Throwable $e) {
                    // PHP 7 
                //echo 'Error al capturar las competencias';
                } 


            }else{

            }

        
	}


}
echo 'Se capturaron las competencias';
/*
$iduser=$USER->id;
$querycontrol='select idmod from {objective_establishment} where userid=?';

$resultcontrol = $DB->get_records_sql($querycontrol, array($iduser));
$idins='';
foreach($resultcontrol as $value){

    $idins=$value->idmod;
}

$my = new moodle_url('/mod/objective/view.php?id='.$idins.'');
redirect($my);
exit();
*/

?>