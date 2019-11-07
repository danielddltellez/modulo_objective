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
require_once('establishment_form.php');
global $DB, $OUTPUT, $USER;

// Course_module ID, or
$idmod = optional_param('idmod', 0, PARAM_INT);
// ... module instance id.
$i  = optional_param('i', 0, PARAM_INT);

if ($idmod) {
    $cm             = get_coursemodule_from_id('objective', $idmod, 0, false, MUST_EXIST);
    $course         = $DB->get_record('course', array('id' => $cm->course), '*', MUST_EXIST);
    $moduleobjective = $DB->get_record('objective', array('id' => $cm->instance), '*', MUST_EXIST);
} else if ($i) {
    $moduleobjective = $DB->get_record('objective', array('id' => $n), '*', MUST_EXIST);
    $course         = $DB->get_record('course', array('id' => $moduleobjective->course), '*', MUST_EXIST);
    $cm             = get_coursemodule_from_instance('objective', $moduleobjective->id, $course->id, false, MUST_EXIST);
} else {
    print_error(get_string('missingidandcmid', mod_objective));
}

$courseid = $cm->course;
if (!$course = $DB->get_record('course', array('id' => $courseid))) {
    print_error('invalidcourse', 'objective', $courseid);
}

require_login($course, true, $cm);
$modulecontext = context_module::instance($cm->id);

$PAGE->set_url('/mod/objective/view.php', array('id' => $idmod));
$PAGE->set_title(format_string($moduleobjective->name));
$PAGE->set_heading(format_string($course->fullname));
$PAGE->set_context($modulecontext);

//$courseurl = new moodle_url('/mod/objective/view.php', array('id' => $id));
//'courseid' => $cm->course, 'idinstance'=>$cm->instance, 'idmod'=>$id


$establishmentform = new newestablishment_form();
$toform['userid'] = $USER->id;
$toform['idinstance'] = $cm->instance;
$toform['courseid'] = $courseid;
$toform['idmod'] = $idmod;
$toform['timecreated'] = time();
$toform['timemodified'] = time();
$establishmentform->set_data($toform);


$courseurl = new moodle_url('/mod/objective/view.php', array('id' => $idmod));
//Form processing and displaying is done here
if ($establishmentform->is_cancelled()) {

  redirect($courseurl);


    //Handle form cancel operation, if cancel button is present on form
} else if ($fromform = $establishmentform->get_data()) {
    global $DB;
  //In this case you process validated data. $mform->get_data() returns data posted in form.
  //print_r($fromform);
 $lastinsertid = $DB->insert_record('objective_establishment', $fromform);

 
    redirect($courseurl);



} else {
  // this branch is executed if the form is submitted but the data doesn't validate and the form should be redisplayed
  // or on the first display of the form.
	 $site = get_site();
     echo $OUTPUT->header();
    
  //Set default data (if any)
  $establishmentform->set_data($toform);
  //displays the form
  $establishmentform->display(); 
      echo $OUTPUT->footer();
}
