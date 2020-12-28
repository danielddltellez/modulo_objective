<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.
/**
* Prints an instance of mod_objective.
*
* @package     mod_objective
* @copyright   2019 Danie daniel.delaluz@triplei.mx
* @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
*/
require(__DIR__.'/../../config.php');
require_once(__DIR__.'/lib.php');

global $DB, $OUTPUT, $USER;

// Course_module ID, or
$id = optional_param('id', 0, PARAM_INT);
// ... module instance id.
$i  = optional_param('i', 0, PARAM_INT);

if ($id) {
    $cm             = get_coursemodule_from_id('objective', $id, 0, false, MUST_EXIST);
    $course         = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
    $moduleobjective = $DB->get_record('objective', array('id' => $cm->instance), '*', MUST_EXIST);
} else if ($i) {
    $moduleobjective = $DB->get_record('objective', array('id' => $n), '*', MUST_EXIST);
    $course         = $DB->get_record('course', array('id' => $moduleobjective->course), '*', MUST_EXIST);
    $cm             = get_coursemodule_from_instance('objective', $moduleobjective->id, $course->id, false, MUST_EXIST);
} else {
    print_error(get_string('missingidandcmid', mod_objective));
}

require_login($course, true, $cm);
$modulecontext = context_module::instance($cm->id);

$PAGE->set_url('/mod/objective/notificacionobjetivos.php', array('id' => $id));
$PAGE->set_title(format_string($moduleobjective->name));
$PAGE->set_heading(format_string($course->fullname));
$PAGE->set_context($modulecontext);


echo $OUTPUT->header();
$courseid=$cm->course;

$sql='select user2.firstname AS nombre, user2.lastname AS apellido, user2.email AS correo, user2.username AS username, course.fullname AS curso ,(SELECT shortname FROM {role} WHERE id=en.roleid) AS ROLE ,(SELECT name FROM {role} WHERE id=en.roleid) AS RoleName ,FROM_UNIXTIME(ue.timestart, \'%Y-%m-%d\') AS iniciom ,FROM_UNIXTIME(ue.timeend, \'%Y-%m-%d\') AS finm
FROM {course} AS course  JOIN {enrol} AS en ON en.courseid = course.id JOIN {user_enrolments} AS ue ON ue.enrolid = en.id JOIN {user} AS user2 ON ue.userid = user2.id
WHERE course.id=? AND FROM_UNIXTIME(ue.timestart, \'%Y-%m-%d\') = CURDATE()';
try{
$query = $DB->get_records_sql($sql, array($courseid));
            //valida si el curso envia notificaciones

        foreach ($query as $val) {
            $clienteSOAP = new SoapClient('http://192.168.14.30:8080/svcELearning.svc?wsdl');
           // https://www.portal3i.mx/URL/new_login.php?email=ingdanieltellez2015@gmail.com&courseid=12
            $mensaje='¡Hola! Te hemos asignado el formato Establecimiento de Objetivos 2020, para iniciar con el registro de tus Objetivos da clic aquí ~https://www.portal3i.mx/openlms/tripleI.php?email='.$val->correo.'&courseid='.$courseid.'~. La fecha límite para realizar esta acción es '.$val->finm.'';

            $mensajeemail='¡Hola! Te hemos asignado el formato Establecimiento de Objetivos 2020, para iniciar con el registro de tus Objetivos da clic aquí https://www.portal3i.mx/openlms/tripleI.php?email='.$val->correo.'&courseid='.$courseid.'. La fecha límite para realizar esta acción es '.$val->finm.'';

                try{
                    $parametros1=array(); //parametros de la llamada
                    $parametros1['mensaje']=$mensaje;
                    $parametros1['correo']=$val->correo;
                    $parametros1['aplicacion']='Establecimiento de Objetivos';
                    $parametros1['idAplicacion']=(int)9;
                    $parametros1['IdAmbiente']=(int)1;
                    $parametros1['IdTipoNotificacion']=(int)0;
                    $result1 = $clienteSOAP->Notificacion($parametros1);
                    $statusfinal1 = $result1->envioNotificacionUsuarioResult;
                   
                    } catch(SoapFault $e){
                    var_dump($e);
                   
                }
  
            }
        echo '<h1>Se enviaron las notificaciones</h1>';
} catch(SoapFault $e){
            var_dump($e);
           
}
 
echo $OUTPUT->footer();

?>