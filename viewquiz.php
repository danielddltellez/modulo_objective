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

$PAGE->set_url('/mod/objective/viewquiz.php', array('id' => $id));
$PAGE->set_title(format_string($moduleobjective->name));
$PAGE->set_heading(format_string($course->fullname));
$PAGE->set_context($modulecontext);


echo $OUTPUT->header();
echo '<h1><b>Crea nuevo cuestionario</b></h1>';
$button = new single_button(new moodle_url('/mod/objective/newquiz.php', array('courseid' => $cm->course, 'idinstance'=>$cm->instance, 'idmod'=>$id)),'Agrega Cuestionario', $buttonadd, 'get');
$button->class = 'singlebutton quizaddnew';
$button->formid = 'newquiz';

//Muestras informacion de los cursos

$sql="select oq.id, oq.name, oqf.description , oq.courseid, oq.idinstance, oq.idmod, CASE
WHEN oq.status = 1 THEN 'Activo'
WHEN oq.status = 0 THEN 'Inactivo'
ELSE 'N/A'
END AS estatus 
from {objective_quiz} oq
inner join {objective_quiz_format} oqf on oqf.id = oq.idformat
where oq.courseid='".$cm->course."' and oq.idinstance='".$cm->instance."' and oq.idmod='".$id."'";
$viewquiz = $DB->get_records_sql($sql, array());  

echo $OUTPUT->render($button);
objective_print_quiz($viewquiz);



echo $OUTPUT->footer();


?>
