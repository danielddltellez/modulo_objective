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

require_once('behavior_form.php');

global $DB, $OUTPUT, $USER;

// Check for all required variables.
$courseid = required_param('courseid', PARAM_INT);
// Next look for optional variables.
$id = optional_param('idcompetition', 0, PARAM_INT);
$instance = optional_param('instance', 0, PARAM_INT); 

if (!$course = $DB->get_record('course', array('id' => $courseid))) {
    print_error('invalidcourse', 'objective', $courseid);
}

require_login($course); 

$PAGE->set_url('/mod/objective/behavior.php', array('courseid' => $courseid,'instance' => $instance, 'idcomp' => $id));
$PAGE->set_pagelayout('standard');
$behaviorform = new newbehavior_form();
$toform['userid'] = $USER->id;
$toform['courseid'] = $courseid;
$toform['instance'] = $instance;
$toform['idcompetition'] = $id;
$toform['timecreated'] = time();
$toform['timemodified'] = time();
$behaviorform->set_data($toform);


$courseurl = new moodle_url('/mod/objective/viewbehavior.php', array('courseid' => $courseid,'instance' => $instance, 'id' => $id));

//Form processing and displaying is done here
if ($behaviorform->is_cancelled()) {

  redirect($courseurl);



    //Handle form cancel operation, if cancel button is present on form
} else if ($fromform = $behaviorform->get_data()) {
    global $DB;
  //In this case you process validated data. $mform->get_data() returns data posted in form.

  $lastinsertid = $DB->insert_record('objective_competition_behavior', $fromform);
  redirect($courseurl);



} else {
  // this branch is executed if the form is submitted but the data doesn't validate and the form should be redisplayed
  // or on the first display of the form.
	 $site = get_site();
     echo $OUTPUT->header();
    
  //Set default data (if any)
  $behaviorform->set_data($toform);
  //displays the form
  $behaviorform->display(); 
      echo $OUTPUT->footer();
}

