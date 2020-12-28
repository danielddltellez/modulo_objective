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

        $query="select UPPER(concat(u.firstname, ' ', u.lastname)) as 'nombre', oe.courseid as 'idcurso' ,u.email as 'email'
        from {objective_establishment} oe
        join {user} u on oe.userid = u.id
        where oe.id=?";
        $resultcontrol = $DB->get_records_sql($query, array($idestab));

        foreach($resultcontrol as $vals){
                $nombrecom=$vals->nombre;
                $email=$vals->email;
                $idcursonot=$vals->idcurso;
        }
        try{
        $lastinsertid1 = $DB->update_record('objective_establishment', $record1, $bulk=false);
        echo 'Se actualizo el estatus del establecimiento';
        $cadena = "email=$email&courseid=$idcursonot";
        $cadena= base64_encode($cadena);
            $clienteSOAP = new SoapClient('http://192.168.14.30:8080/svcELearning.svc?wsdl');
            // https://www.portal3i.mx/URL/new_login.php?email=ingdanieltellez2015@gmail.com&courseid=12
           // $mensaje= '¡Hola! Tu Gestor ha Finalizado con la revisión de tus Objetivos 2020,  para ingresa a revisar sus comentario, da clic aquí.~https://www.portal3i.mx/openlms/tripleI.php?email='.$email.'&courseid='.$idcursonot.'~.';
           $mensaje= '¡Hola! Te hemos asignado el formato Establecimiento de Objetivos 2020 - Revisión Mitad de año (Autoevaluación), para iniciar con el registro de tu Autoevaluación da clic.~https://www.portal3i.mx/openlms/tripleI.php?key='.$cadena.'~.';

            //$mensajeemail='¡Hola! Tu Gestor ha Finalizado con la revisión de tus Objetivos 2020,  para ingresa a revisar sus comentario, da clic aquí. https://www.portal3i.mx/openlms/tripleI.php?email='.$email.'&courseid='.$idcursonot.'.';
            try{
                $parametros1=array(); //parametros de la llamada
                $parametros1['mensaje']=$mensaje;
                $parametros1['correo']=$email;
                $parametros1['aplicacion']='Establecimiento de Objetivos';
                $parametros1['idAplicacion']=(int)9;
                $parametros1['IdAmbiente']=(int)1;
                $parametros1['IdTipoNotificacion']=(int)0;
                $result1 = $clienteSOAP->Notificacion($parametros1);
                $statusfinal1 = $result1->envioNotificacionUsuarioResult;
                
            } catch(SoapFault $e){
                 var_dump($e);
                
            }
             

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