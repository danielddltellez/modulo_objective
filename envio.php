<?php
require_once '../../config.php';
if ($CFG->forcelogin) {
    require_login();
}
global $USER, $DB, $COURSE;

if($_POST['objetivocompleto1'] != NULL && $_POST['valorobjetivo1'] != NULL){
$record1 = new stdClass();
$record1-> userid = $_POST['userid1'];
$record1-> courseid = $_POST['courseid1'];
$record1-> idobjective = $_POST['idobjetivo1'];
$record1-> targetnumber = $_POST['objetivo1'];
$record1-> whatquestion  = $_POST['que1'];
$record1-> howquestion = $_POST['como1'];
$record1-> thatquestion = $_POST['cuanto1'];
$record1-> specifyquestion = $_POST['especifica1'];
$record1-> periodquestion = $_POST['periodo1'];
$record1-> objectivecomplete = $_POST['objetivocompleto1'];
$record1-> startdate = strtotime($_POST['fechainicio1']);
$record1-> enddate = strtotime($_POST['fechafinal1']);
$record1-> valueobjective = $_POST['valorobjetivo1'];
try{
$lastinsertid1 = $DB->insert_record('objective_establishment_captured', $record1);
echo 'OBJETIVO 1 INSERTADO';

} catch(\Throwable $e) {
    // PHP 7 
echo 'ERROR AL INSERTAR OBJETIVO 1';
} 
}
if($_POST['objetivocompleto2'] != NULL && $_POST['valorobjetivo2'] != NULL){
$record2 = new stdClass();
$record2-> userid = $_POST['userid2'];
$record2-> courseid = $_POST['courseid2'];
$record2-> idobjective = $_POST['idobjetivo2'];
$record2-> targetnumber = $_POST['objetivo2'];
$record2-> whatquestion  = $_POST['que2'];
$record2-> howquestion = $_POST['como2'];
$record2-> thatquestion = $_POST['cuanto2'];
$record2-> specifyquestion = $_POST['especifica2'];
$record2-> periodquestion = $_POST['periodo2'];
$record2-> objectivecomplete = $_POST['objetivocompleto2'];
$record2-> startdate = strtotime($_POST['fechainicio2']);
$record2-> enddate = strtotime($_POST['fechafinal2']);
$record2-> valueobjective = $_POST['valorobjetivo2'];

try{
$lastinsertid2 = $DB->insert_record('objective_establishment_captured', $record2);

echo 'OBJETIVO 2 INSERTADO';

} catch(\Throwable $e) {
    // PHP 7 
echo 'ERROR AL INSERTAR OBJETIVO 2';
} 
}
if($_POST['objetivocompleto3'] != NULL && $_POST['valorobjetivo3'] != NULL){
$record3 = new stdClass();
$record3-> userid = $_POST['userid3'];
$record3-> courseid = $_POST['courseid3'];
$record3-> idobjective = $_POST['idobjetivo3'];
$record3-> targetnumber = $_POST['objetivo3'];
$record3-> whatquestion  = $_POST['que3'];
$record3-> howquestion = $_POST['como3'];
$record3-> thatquestion = $_POST['cuanto3'];
$record3-> specifyquestion = $_POST['especifica3'];
$record3-> periodquestion = $_POST['periodo3'];
$record3-> objectivecomplete = $_POST['objetivocompleto3'];
$record3-> startdate = strtotime($_POST['fechainicio3']);
$record3-> enddate = strtotime($_POST['fechafinal3']);
$record3-> valueobjective = $_POST['valorobjetivo3'];

try{
$lastinsertid3 = $DB->insert_record('objective_establishment_captured', $record3);
echo 'OBJETIVO 3 INSERTADO';
}catch(\Throwable $e) {
    // PHP 7 
echo 'ERROR AL INSERTAR OBJETIVO 3';
}
}
if($_POST['objetivocompleto4'] != NULL && $_POST['valorobjetivo4'] != NULL){
$record4 = new stdClass();
$record4-> userid = $_POST['userid4'];
$record4-> courseid = $_POST['courseid4'];
$record4-> idobjective = $_POST['idobjetivo4'];
$record4-> targetnumber = $_POST['objetivo4'];
$record4-> whatquestion  = $_POST['que4'];
$record4-> howquestion = $_POST['como4'];
$record4-> thatquestion = $_POST['cuanto4'];
$record4-> specifyquestion = $_POST['especifica4'];
$record4-> periodquestion = $_POST['periodo4'];
$record4-> objectivecomplete = $_POST['objetivocompleto4'];
$record4-> startdate = strtotime($_POST['fechainicio4']);
$record4-> enddate = strtotime($_POST['fechafinal4']);
$record4-> valueobjective = $_POST['valorobjetivo4'];

try{
$lastinsertid4 = $DB->insert_record('objective_establishment_captured', $record4);
echo 'tus objetivos fueron guardados con éxito';
}catch(\Throwable $e) {
    // PHP 7 
echo 'error al enviar tus objetivos';
} 
}
if($_POST['objetivocompleto5'] != NULL && $_POST['valorobjetivo5'] != NULL){
$record5 = new stdClass();
$record5-> userid = $_POST['userid5'];
$record5-> courseid = $_POST['courseid5'];
$record5-> idobjective = $_POST['idobjetivo5'];
$record5-> targetnumber = $_POST['objetivo5'];
$record5-> whatquestion  = $_POST['que5'];
$record5-> howquestion = $_POST['como5'];
$record5-> thatquestion = $_POST['cuanto5'];
$record5-> specifyquestion = $_POST['especifica5'];
$record5-> periodquestion = $_POST['periodo5'];
$record5-> objectivecomplete = $_POST['objetivocompleto5'];
$record5-> startdate = strtotime($_POST['fechainicio5']);
$record5-> enddate = strtotime($_POST['fechafinal5']);
$record5-> valueobjective = $_POST['valorobjetivo5'];
try{
$lastinsertid5 = $DB->insert_record('objective_establishment_captured', $record5);
echo 'OBJETIVO 5 INSERTADO';
}catch(\Throwable $e) {
    // PHP 7 
echo 'ERROR AL INSERTAR OBJETIVO 5';
} 
}

if($_POST['objetivocompleto6'] != NULL && $_POST['valorobjetivo6'] != NULL){

$record6 = new stdClass();
$record6-> userid = $_POST['userid6'];
$record6-> courseid = $_POST['courseid6'];
$record6-> idobjective = $_POST['idobjetivo6'];
$record6-> targetnumber = $_POST['objetivo6'];
$record6-> whatquestion  = $_POST['que6'];
$record6-> howquestion = $_POST['como6'];
$record6-> thatquestion = $_POST['cuanto6'];
$record6-> specifyquestion = $_POST['especifica6'];
$record6-> periodquestion = $_POST['periodo6'];
$record6-> objectivecomplete = $_POST['objetivocompleto6'];
$record6-> startdate = strtotime($_POST['fechainicio6']);
$record6-> enddate = strtotime($_POST['fechafinal6']);
$record6-> valueobjective = $_POST['valorobjetivo6'];
try{
$lastinsertid6 = $DB->insert_record('objective_establishment_captured', $record6);

echo 'OBJETIVO 6 INSERTADO';
}catch(\Throwable $e) {
    // PHP 7 
echo 'ERROR AL INSERTAR OBJETIVO 6';
} 
}

?>