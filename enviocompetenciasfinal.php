<?php
 require_once '../../config.php';
 if ($CFG->forcelogin) {
     require_login();
 }
 global $USER, $DB, $COURSE;
 
//print_r($_POST);

foreach($_POST as $k=>$v){
    //echo "<h1> $producto </h1>";
                    /*
                echo"<br>";
                echo $v2["idcompetencia"];
                echo"<br>";
                echo $v2["idcomportamiento"];
                echo"<br>";
                echo $v2["courseid"];
                echo"<br>";
                echo $v2["userid"];
                echo"<br>";
                echo $v2["idinstance"];
                echo"<br>";
                echo"nuevo";
                echo"<br>";*/
 
    foreach($v as $k2 => $v2)
	{
    

            $valoropcion = $v2["valorfinal"];
            $valoridcomp= $v2["idcompetenciafinal"];
            $valoridcomportamiento= $v2["idcomportamientofinal"];
            $valorcourseid= $v2["courseidfinal"];
            $valoruser=$v2["useridfinal"];
            $valoridestablecimiento=$v2["idestablecimientofinal"];

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
                $lastinsertid = $DB->insert_record('objective_establishment_competition_final', $record1);
                echo 'REVISION 1 INSERTADO';

                } catch(\Throwable $e) {
                    // PHP 7 
                echo 'ERROR AL INSERTAR REVISION 1';
                } 


            }else{

            }

        
	}


}
/*
$my = new moodle_url('/mod/objective/view.php?id='.$idinstance.'');
redirect($my);
exit();

*/
?>