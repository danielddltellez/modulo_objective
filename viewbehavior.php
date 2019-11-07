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

$courseid = required_param('courseid', PARAM_INT);

//$id es el id del grupo
$id = optional_param('id', 0, PARAM_INT);
$instance  = optional_param('instance', 0, PARAM_INT);



if ($instance) {
    $cm             = get_coursemodule_from_id('objective', $instance, 0, false, MUST_EXIST);
    $course         = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
    $moduleobjective = $DB->get_record('objective', array('id' => $cm->instance), '*', MUST_EXIST);
}else{
    print_error(get_string('missingidandcmid', mod_objective));
}



 
if (!$course = $DB->get_record('course', array('id' => $courseid))) {
    print_error('invalidcourse', 'objective', $courseid);
}


require_login($course, true, $cm);
$modulecontext = context_module::instance($cm->id);

$PAGE->set_url('/mod/objective/viewbehavior.php', array('courseid' => $courseid,'instance' => $instance, 'id' => $id));
$PAGE->set_title(format_string($moduleobjective->name));
$PAGE->set_heading(format_string($course->fullname));
$PAGE->set_context($modulecontext);


echo $OUTPUT->header();

echo '<h1><b>Comportamientos de la competencia</b></h1>';
$button = new single_button(new moodle_url('/mod/objective/behavior.php', array('courseid' => $courseid,'instance' => $instance,'idcompetition'=>$id)),'Agrega competencia', $buttonadd, 'get');
$button->class = 'singlebutton addbehavior';
$button->formid = 'addbehavior';
echo $OUTPUT->render($button);
//Muestras informacion de los cursos

$sql="select ocb.id, ocb.code, ocb.description, ocb.status, oc.name as competencia, CASE
WHEN ocb.status = 0 THEN 'HABILITADO'
WHEN ocb.status = 1 THEN 'INHABILITADO'
ELSE 'SIN VALOR'
END AS estatus
from mdl_objective_competition_behavior ocb
inner join mdl_objective_competition oc on oc.id=ocb.idcompetition
where ocb.idcompetition='".$id."' and oc.courseid='".$courseid."' ORDER BY ocb.id ASC";
$viewbehavior = $DB->get_records_sql($sql, array());  

objective_print_competition_behavior($viewbehavior);

echo $OUTPUT->footer();

?>