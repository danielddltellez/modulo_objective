<?php
require_once '../../config.php';
if ($CFG->forcelogin) {
    require_login();
}

global $USER, $DB, $COURSE;


if(!empty($_POST['idformatoeo'])){

    $idestab = $_POST['idformatoeo'];
    $idstatus =$_POST['estatusobj'];

    if($idstatus == 2 || $idstatus == 3 || $idstatus == 4){
        $record1 = new stdClass();
        $record1-> id = $idestab;
        $record1-> status = $idstatus;
        try{
        $lastinsertid1 = $DB->update_record('objective_establishment', $record1, $bulk=false);
        echo 'Se actualizo el estatus del establecimiento';

        } catch(\Throwable $e) {
            // PHP 7 
        echo 'Error al actualizar estatus';
        } 


    }else{

    header("Location:".$_SERVER['HTTP_REFERER']);
    }
}

/*

0.	Por Iniciar Establecimiento
1.	En Proceso Establecimiento
2.	Enviado a Aprobación Establecimiento
3.	Finalizado Establecimiento
4.	En Proceso Revisión 1
5.	Enviado a Aprobación Revisión 1
6.	Finalizado Revisión 1
7.	En Proceso Revisión Final
8.	Enviado a Aprobación Revisión Final
90.	Finalizado Revisión Final

if(isset($_GET['id'])){
$id = $_GET['id'];
$idinstance = $_GET['instance'];

$record1 = new stdClass();
$record1-> id = $id;
$record1-> status  = 1;


$DB->update_record('objective_establishment', $record1, $bulk=false);
$my = new moodle_url('/mod/objective/view.php?id='.$idinstance.'');
redirect($my);
exit();
}



*/
?>