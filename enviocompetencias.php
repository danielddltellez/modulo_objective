<?php
 require_once '../../config.php';
 if ($CFG->forcelogin) {
     require_login();
 }
 global $USER, $DB, $COURSE;
 
//print_r($_POST);

foreach($_POST as $k=>$v){
    //echo "<h1> $producto </h1>";
 
    foreach($v as $k2 => $v2)
	{
    
            echo $v2["valor"];
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
            
            echo"nuevo";
            echo"<br>";
        
	}


}
?>