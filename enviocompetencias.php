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
                echo 'REVISION 1 INSERTADO';

                } catch(\Throwable $e) {
                    // PHP 7 
                echo 'ERROR AL INSERTAR REVISION 1';
                } 


            }else{

            }

        
	}


}
?>