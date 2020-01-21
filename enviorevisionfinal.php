<?php
require_once '../../config.php';
if ($CFG->forcelogin) {
    require_login();
}
global $USER, $DB, $COURSE;



$fecha = new DateTime();
$cometariosjefe1='';
$comentariosjefe2='';
$valorjefe='';
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
//echo 'REVISION 1 INSERTADO';

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
        $destinatario=new stdClass();
        $destinatario-> id=449;
        $destinatario-> email = 'daniel.delaluz@triplei.mx';

        
        try{
            $updaterev = $DB->update_record('objective_establishment', $updaterevisionf, $bulk=false);

            $fechaap=date("F j, Y, g:i a");
            $subject='Establecimiento de Objetivos';
            $message ="Estimado(a)  Lucio Garcia, \n\n";
            $message .="Hacemos de tu conocimiento que NOMBRE DEL COLABORADOR ha finalizado el registrado de su Autoevaluación,  \n\n";
            $message .="es momento de que ingreses a la plataforma e-learning a Colocar tus comentarios y brindar la Retroalimentación de medio año. \n\n";
            $message .="Para registrar tus comentarios, ingresa a tu perfil dando clic aquí. \n\n";
            $message .="La fecha límite para realizar esta acción es: $fechaap\n\n";
            $message .="Que tenga un excelente día\n\n";
           // print_r($USER);
            $sendenvio = email_to_user($destinatario, $USER , $subject, $message);
    
          /*print_r($sendenvio);*/
            
             echo 'Guardado con éxito';
        
        } catch(\Throwable $e) {
                // PHP 7 
            echo 'Error al guardar';
        } 
         //   header("Location:".$_SERVER['HTTP_REFERER']);
        } catch(\Throwable $e) {
    // PHP 7 
echo 'Error al guardar';
} 

if($_POST['idobjestablecidofinal5'] != NULL){

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

if($_POST['idobjestablecidofinal6'] != NULL){

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
/*
$record2 = new stdClass();
$record2-> userid = $_POST['userid2'];
$record2-> courseid = $_POST['courseid2'];
$record2-> idobjective = $_POST['idobjetivo2'];
$record2-> idobjectiveestablishment  = $_POST['idobjestablecido2'];
$record1-> mycomments = $_POST['micomentarios2'];
$record1-> mycommentsfinals   = $_POST['micomentariosef2'];
$record1-> feedbackboos  = $_POST['cometariosjefe2'];
$record1-> feedbackevaluation  = $_POST['comentariosjefefinal2'];
$record1-> autoevaluation  = $_POST['valorautoevaluacion2'];
$record1-> evaluationboss  = $_POST['valorevaluacionboss2'];
$record2-> timecreated = $fecha->getTimestamp();
$record2-> timemodified = $fecha->getTimestamp();
try{
$lastinsertid2 = $DB->insert_record('objective_establishment_revise_final', $record2);
echo 'REVISION 2 INSERTADO';

} catch(\Throwable $e) {
    // PHP 7 
echo 'ERROR AL INSERTAR REVISION 2';
} 
$record3 = new stdClass();
$record3-> userid = $_POST['userid3'];
$record3-> courseid = $_POST['courseid3'];
$record3-> idobjective = $_POST['idobjetivo3'];
$record3-> idobjectiveestablishment  = $_POST['idobjestablecido3'];
$record1-> mycomments = $_POST['micomentarios3'];
$record1-> mycommentsfinals   = $_POST['micomentariosef3'];
$record1-> feedbackboos  = $_POST['cometariosjefe3'];
$record1-> feedbackevaluation  = $_POST['comentariosjefefinal3'];
$record1-> autoevaluation  = $_POST['valorautoevaluacion3'];
$record1-> evaluationboss  = $_POST['valorevaluacionboss3'];
$record3-> timecreated = $fecha->getTimestamp();
$record3-> timemodified = $fecha->getTimestamp();
try{
$lastinsertid3 = $DB->insert_record('objective_establishment_revise_final', $record3);
echo 'REVISION 3 INSERTADO';

} catch(\Throwable $e) {
    // PHP 7 
echo 'ERROR AL INSERTAR REVISION 3';
} 
$record4 = new stdClass();
$record4-> userid = $_POST['userid4'];
$record4-> courseid = $_POST['courseid4'];
$record4-> idobjective = $_POST['idobjetivo4'];
$record4-> idobjectiveestablishment  = $_POST['idobjestablecido4'];
$record1-> mycomments = $_POST['micomentarios3'];
$record1-> mycommentsfinals   = $_POST['micomentariosef4'];
$record1-> feedbackboos  = $_POST['cometariosjefe4'];
$record1-> feedbackevaluation  = $_POST['comentariosjefefinal4'];
$record1-> autoevaluation  = $_POST['valorautoevaluacion4'];
$record1-> evaluationboss  = $_POST['valorevaluacionboss4'];
$record4-> timecreated = $fecha->getTimestamp();
$record4-> timemodified = $fecha->getTimestamp();
try{
$lastinsertid4 = $DB->insert_record('objective_establishment_revise_final', $record4);
echo 'REVISION 4 INSERTADO';

} catch(\Throwable $e) {
    // PHP 7 
echo 'ERROR AL INSERTAR REVISION 4';
} 
if($_POST['idobjestablecido5'] != NULL){
    $record5 = new stdClass();
    $record5-> userid = $_POST['userid5'];
    $record5-> courseid = $_POST['courseid5'];
    $record5-> idobjective = $_POST['idobjetivo5'];
    $record5-> idobjectiveestablishment  = $_POST['idobjestablecido5'];
    $record1-> mycomments = $_POST['micomentarios5'];
    $record1-> mycommentsfinals   = $_POST['micomentariosef5'];
    $record1-> feedbackboos  = $_POST['cometariosjefe5'];
    $record1-> feedbackevaluation  = $_POST['comentariosjefefinal5'];
    $record1-> autoevaluation  = $_POST['valorautoevaluacion5'];
    $record1-> evaluationboss  = $_POST['valorevaluacionboss5'];
    $record5-> timecreated = $fecha->getTimestamp();
    $record5-> timemodified = $fecha->getTimestamp();
    try{
    $lastinsertid5 = $DB->insert_record('objective_establishment_revise_final', $record5);
    echo 'REVISION 5 INSERTADO';
    
    } catch(\Throwable $e) {
        // PHP 7 
    echo 'ERROR AL INSERTAR REVISION 5';
    } 
}

if($_POST['idobjestablecido6'] != NULL){

    $record6 = new stdClass();
    $record6-> userid = $_POST['userid6'];
    $record6-> courseid = $_POST['courseid6'];
    $record6-> idobjective = $_POST['idobjetivo6'];
    $record6-> idobjectiveestablishment  = $_POST['idobjestablecido6'];
    $record1-> mycomments = $_POST['micomentarios6'];
    $record1-> mycommentsfinals   = $_POST['micomentariosef6'];
    $record1-> feedbackboos  = $_POST['cometariosjefe6'];
    $record1-> feedbackevaluation  = $_POST['comentariosjefefinal6'];
    $record1-> autoevaluation  = $_POST['valorautoevaluacion6'];
    $record1-> evaluationboss  = $_POST['valorevaluacionboss6'];
    $record6-> timecreated = $fecha->getTimestamp();
    $record6-> timemodified = $fecha->getTimestamp();
    try{
    $lastinsertid6 = $DB->insert_record('objective_establishment_revise_final', $record6);
    echo 'REVISION 6 INSERTADO';
    
    } catch(\Throwable $e) {
        // PHP 7 
    echo 'ERROR AL INSERTAR REVISION 6';
    } 
}

*/
/*
$iduser=$USER->id;
$querycontrol='select idmod from mdl_objective_establishment where userid=?';

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