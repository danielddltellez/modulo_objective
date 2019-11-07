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
$instance  = optional_param('idinstance', 0, PARAM_INT);



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

$PAGE->set_url('/mod/objective/viewquestions.php', array('courseid' => $courseid,'idinstance' => $instance, 'id' => $id));
$PAGE->set_title(format_string($moduleobjective->name));
$PAGE->set_heading(format_string($course->fullname));
$PAGE->set_context($modulecontext);


echo $OUTPUT->header();

echo '<h1><b>Preguntas</b></h1>';
$button = new single_button(new moodle_url('/mod/objective/questions.php', array('courseid' => $courseid,'idinstance' => $instance,'idquiz'=>$id)),'Agrega pregunta al cuestionario', $buttonadd, 'get');
$button->class = 'singlebutton addquestion';
$button->formid = 'addquestion';
echo $OUTPUT->render($button);
//Muestras informacion de los cursos

$sql="select * from mdl_objective_quiz_question where idquiz='".$id."' ORDER BY orden ASC";
$viewquestion = $DB->get_records_sql($sql, array());  

objective_print_quiz_question($viewquestion);

echo $OUTPUT->footer();

?>