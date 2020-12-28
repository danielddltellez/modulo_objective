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


$queryrevision="select UPPER(concat(u.firstname, ' ', u.lastname)) as 'nombre', oe.courseid as 'idcurso' ,u.email as 'email'
from {objective_establishment} oe
join {user} u on oe.userid = u.id
where oe.id=?";
$resultcontrolrevision = $DB->get_records_sql($queryrevision, array($id));

foreach($resultcontrolrevision as $valsrevision){
        $nombrerevision=$valsrevision->nombre;
        $emailrevision=$valsrevision->email;
        $idcursorevision=$valsrevision->idcurso;
}
//$email='daniel.delaluz@3ti.mx';

$clienteSOAP = new SoapClient('http://192.168.14.30:8080/svcELearning.svc?wsdl');
$cadena = "email=$emailrevision&courseid=$idcursorevision";
$cadena= base64_encode($cadena);
// https://www.portal3i.mx/URL/new_login.php?email=ingdanieltellez2015@gmail.com&courseid=12
// $mensaje= '¡Hola! Tu Gestor ha Finalizado con la revisión de tus Objetivos 2020,  para ingresa a revisar sus comentario, da clic aquí.~https://www.portal3i.mx/openlms/tripleI.php?email='.$email.'&courseid='.$idcursonot.'~.';
$mensajerev= '¡Hola! tu Gestor ha registrado comentarios en la Revisión Final, da clic aquí.~https://www.portal3i.mx/openlms/tripleI.php?key='.$cadena.'~.';

try{
    $parametrosrevision1=array(); //parametros de la llamada
    $parametrosrevision1['mensaje']=$mensajerev;
    $parametrosrevision1['correo']=$emailrevision;
    $parametrosrevision1['aplicacion']='Establecimiento de Objetivos';
    $parametrosrevision1['idAplicacion']=(int)9;
    $parametrosrevision1['IdAmbiente']=(int)1;
    $parametrosrevision1['IdTipoNotificacion']=(int)0;
    $resultrevision1 = $clienteSOAP->Notificacion($parametrosrevision1);
    $statusfinalrevision1 = $resultrevision1->envioNotificacionUsuarioResult;

   // echo $statusfinalrevision1;
    
} catch(SoapFault $e){
        var_dump($e);
    
}

//header("Location:".$_SERVER['HTTP_REFERER']);
}

$my = new moodle_url('/mod/objective/view.php?id='.$idinstance.'');
redirect($my);
exit();

//header("Location:".$_SERVER['HTTP_REFERER']);


?>