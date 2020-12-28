<?php
require_once '../../config.php';
if ($CFG->forcelogin) {
    require_login();
}
global $USER, $DB, $COURSE;

$fecha = new DateTime();
$cometariosjefe1;
$comentariosjefe2;
$valorjefe=0;
$record1 = new stdClass();
$record1-> userid = $_POST['useridfinal1'];
$record1-> courseid = $_POST['courseidfinal1'];
$record1-> idobjective = $_POST['idobjetivofinal1'];
$record1-> idobjectiveestablishment  = $_POST['idobjestablecidofinal1'];
$record1-> mycomments = $_POST['micomentarios1'];
$record1-> mycommentsfinals  = $_POST['micomentariosef1'];
$record1-> feedbackboos  = $cometariosjefe1;
$record1-> feedbackevaluation  = $cometariosjefe2;
$record1-> autoevaluation  = $_POST['valorautoevaluacion1'];
$record1-> evaluationboss  = $valorjefe;
$record1-> timecreated = $fecha->getTimestamp();
$record1-> timemodified = $fecha->getTimestamp();


try{
$lastinsertid1 = $DB->insert_record('objective_establishment_revise_final', $record1);


} catch(\Throwable $e) {
    // PHP 7 
//echo 'ERROR AL INSERTAR REVISION 1';
} 


$record2 = new stdClass();
$record2-> userid = $_POST['useridfinal2'];
$record2-> courseid = $_POST['courseidfinal2'];
$record2-> idobjective = $_POST['idobjetivofinal2'];
$record2-> idobjectiveestablishment  = $_POST['idobjestablecidofinal2'];
$record2-> mycomments = $_POST['micomentarios2'];
$record2-> mycommentsfinals  = $_POST['micomentariosef2'];
$record2-> feedbackboos  = $cometariosjefe1;
$record2-> feedbackevaluation  = $cometariosjefe2;
$record2-> autoevaluation  = $_POST['valorautoevaluacion2'];
$record2-> evaluationboss  = $valorjefe;
$record2-> timecreated = $fecha->getTimestamp();
$record2-> timemodified = $fecha->getTimestamp();


try{
$lastinsertid2 = $DB->insert_record('objective_establishment_revise_final', $record2);
//echo 'REVISION 2 INSERTADO';

} catch(\Throwable $e) {
    // PHP 7 
//echo 'ERROR AL INSERTAR REVISION 2';
} 

$record3 = new stdClass();
$record3-> userid = $_POST['useridfinal3'];
$record3-> courseid = $_POST['courseidfinal3'];
$record3-> idobjective = $_POST['idobjetivofinal3'];
$record3-> idobjectiveestablishment  = $_POST['idobjestablecidofinal3'];
$record3-> mycomments = $_POST['micomentarios3'];
$record3-> mycommentsfinals  = $_POST['micomentariosef3'];
$record3-> feedbackboos  = $cometariosjefe1;
$record3-> feedbackevaluation  = $cometariosjefe2;
$record3-> autoevaluation  = $_POST['valorautoevaluacion3'];
$record3-> evaluationboss  = $valorjefe;
$record3-> timecreated = $fecha->getTimestamp();
$record3-> timemodified = $fecha->getTimestamp();


try{
$lastinsertid3 = $DB->insert_record('objective_establishment_revise_final', $record3);
//echo 'REVISION 3 INSERTADO';

} catch(\Throwable $e) {
    // PHP 7 
//echo 'ERROR AL INSERTAR REVISION 3';
} 
$idobjf=$_POST['idobjetivofinal4'];
$record4 = new stdClass();
$record4-> userid = $_POST['useridfinal4'];
$record4-> courseid = $_POST['courseidfinal4'];
$record4-> idobjective = $idobjf;
$record4-> idobjectiveestablishment  = $_POST['idobjestablecidofinal4'];
$record4-> mycomments = $_POST['micomentarios4'];
$record4-> mycommentsfinals  = $_POST['micomentariosef4'];
$record4-> feedbackboos  = $cometariosjefe1;
$record4-> feedbackevaluation  = $cometariosjefe2;
$record4-> autoevaluation  = $_POST['valorautoevaluacion4'];
$record4-> evaluationboss  = $valorjefe;
$record4-> timecreated = $fecha->getTimestamp();
$record4-> timemodified = $fecha->getTimestamp();


try{
        $lastinsertid4 = $DB->insert_record('objective_establishment_revise_final', $record4);
        $updaterevisionf = new stdClass();
        $updaterevisionf-> id = $idobjf;
        $updaterevisionf-> status = 8;

        try{
        $updaterev = $DB->update_record('objective_establishment', $updaterevisionf, $bulk=false);
        
        $querynotificacion="select UPPER(concat(u.firstname, ' ', u.lastname)) as 'nombre', oe.idjefedirecto as 'idjefedirecto' , (select u2.email from {user} u2 where oe.idjefedirecto = u2.id) as 'emailjefedirecto', oe.courseid as 'idcurso' ,
        (select FROM_UNIXTIME(ue.timeend, '%Y-%m-%d')
            FROM {course} AS course  
            JOIN {enrol} AS en ON en.courseid = course.id 
            JOIN {user_enrolments} AS ue ON ue.enrolid = en.id
            WHERE ue.userid = oe.idjefedirecto and course.id=oe.courseid) AS finm 
        from {objective_establishment} oe
        join {user} u on oe.userid = u.id
        where oe.id=?";
        $resultnot = $DB->get_records_sql($querynotificacion, array($idobjf));
        $nombrenot="";
        foreach($resultnot  as $vals){
            $nombrecom=$vals->nombre;
            $idjefed=$vals->idjefedirecto;
            $emailjefed=$vals->emailjefedirecto;
            $fechafinal=$vals->finm;
            $idcurso=$vals->idcurso;
        }

        $cadena = "email=$emailjefed&courseid=$idcurso";
        $cadena= base64_encode($cadena);
        $clienteSOAP = new SoapClient('http://192.168.14.30:8080/svcELearning.svc?wsdl');
        // https://www.portal3i.mx/URL/new_login.php?email=ingdanieltellez2015@gmail.com&courseid=12
        $mensaje=''.$nombrecom.' ha finalizado el registrado de su Revisión Final (Autoevaluación), ingresa a  colocar tus comentarios y  la Retroalimentación de fin de año dando clic.~https://www.portal3i.mx/openlms/tripleI.php?key='.$cadena.'~. La fecha límite para realizar esta acción es '.$fechafinal.'';
        $parametros1=array(); //parametros de la llamada
        $parametros1['mensaje']=$mensaje;
        $parametros1['correo']=$emailjefed;
        $parametros1['aplicacion']='Establecimiento de Objetivos';
        $parametros1['idAplicacion']=(int)9;
        $parametros1['IdAmbiente']=(int)1;
        $parametros1['IdTipoNotificacion']=(int)0;
        $result1 = $clienteSOAP->Notificacion($parametros1);
        } catch(\Throwable $e) {
            // PHP 7 
        //echo 'ERROR AL INSERTAR REVISION 3';
        } 
        echo 'Guardado con éxito';

            
} catch(\Throwable $e) {
    // PHP 7 
//echo 'ERROR AL INSERTAR REVISION 3';
} 

if(!empty($_POST['idobjestablecidofinal5'])){

    $record5 = new stdClass();
    $record5-> userid = $_POST['useridfinal5'];
    $record5-> courseid = $_POST['courseidfinal5'];
    $record5-> idobjective = $_POST['idobjetivofinal5'];
    $record5-> idobjectiveestablishment  = $_POST['idobjestablecidofinal5'];
    $record5-> mycomments = $_POST['micomentarios5'];
    $record5-> mycommentsfinals  = $_POST['micomentariosef5'];
    $record5-> feedbackboos  = $cometariosjefe1;
    $record5-> feedbackevaluation  = $cometariosjefe2;
    $record5-> autoevaluation  = $_POST['valorautoevaluacion5'];
    $record5-> evaluationboss  = $valorjefe;
    $record5-> timecreated = $fecha->getTimestamp();
    $record5-> timemodified = $fecha->getTimestamp();
    
    
    try{
    $lastinsertid5 = $DB->insert_record('objective_establishment_revise_final', $record5);
//    echo 'REVISION 5 INSERTADO';
    
    } catch(\Throwable $e) {
        // PHP 7 
 //   echo 'ERROR AL INSERTAR REVISION 5';
    } 

}

if(!empty($_POST['idobjestablecidofinal6'])){

$record6 = new stdClass();
$record6-> userid = $_POST['useridfinal6'];
$record6-> courseid = $_POST['courseidfinal6'];
$record6-> idobjective = $_POST['idobjetivofinal6'];
$record6-> idobjectiveestablishment  = $_POST['idobjestablecidofinal6'];
$record6-> mycomments = $_POST['micomentarios6'];
$record6-> mycommentsfinals  = $_POST['micomentariosef6'];
$record6-> feedbackboos  = $cometariosjefe1;
$record6-> feedbackevaluation  = $cometariosjefe2;
$record6-> autoevaluation  = $_POST['valorautoevaluacion6'];
$record6-> evaluationboss  = $valorjefe;
$record6-> timecreated = $fecha->getTimestamp();
$record6-> timemodified = $fecha->getTimestamp();


try{
$lastinsertid6 = $DB->insert_record('objective_establishment_revise_final', $record6);
//echo 'REVISION 6 INSERTADO';

} catch(\Throwable $e) {
    // PHP 7 
//echo 'ERROR AL INSERTAR REVISION 6';
} 


}

//header("Location:".$_SERVER['HTTP_REFERER']);

?>