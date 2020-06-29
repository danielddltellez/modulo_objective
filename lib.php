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
 * Library of interface functions and constants.
 *
 * @package     mod_induction
 * @copyright   2019 Danie daniel.delaluz@triplei.mx
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Return if the plugin supports $feature.
 *
 * @param string $feature Constant representing the feature.
 * @return true | null True if the feature is supported, null otherwise.
 */
function mod_objective_supports($feature) {
    switch ($feature) {
        case FEATURE_GRADE_HAS_GRADE:
            return true;
        case FEATURE_MOD_INTRO:
            return true;
        default:
            return null;
    }
}

function objective_add_instance($moduleobjective, $mform = null){
	global  $DB;
    $moduleobjective->timecreated = time();
    $moduleobjective->timemodified = $moduleobjective->timecreated;

     $id = $DB->insert_record('objective', $moduleobjective);

      return $id;



}

function objective_update_instance($moduleobjective, $mform = null) {
    global $DB;

    //$moduleinduction->timemodified = time();
   // $moduleobjective->timecreated = time();
    $moduleobjective->timemodified = time();
    $moduleobjective->id = $moduleobjective->instance;

    return $DB->update_record('objective', $moduleobjective);


}

function objective_delete_instance($id) {
    global $DB;

    $exists = $DB->get_record('objective', array('id' => $id));
    if (!$exists) {
        return false;
    }

    $DB->delete_records('objective', array('id' => $id));

    return true;
}

function objective_print_groups($viewgroups, $return = 0){
    global $OUTPUT, $USER, $DB, $CFG;
       $display .= html_writer::start_tag('div', array('class' => 'w3-container'));
       $display .= html_writer::start_tag('table', array('class' => 'w3-table-all w3-hoverable'));
       $display .= html_writer::start_tag('tr' , array('style' => 'background-color:  #878786; color: #fff;'));
       $display .= html_writer::start_tag('th');
       $display .= clean_text('<strong>id</strong>');
       $display .= html_writer::end_tag('th');
       $display .= html_writer::start_tag('th');
       $display .= clean_text('<strong>Nombre del grupo</strong>');
       $display .= html_writer::end_tag('th');
       $display .= html_writer::start_tag('th');
       $display .= clean_text('<strong>Acciones</strong>');
       $display .= html_writer::end_tag('th');
       $display .= html_writer::end_tag('tr');
       foreach ($viewgroups as $value) {
           $display .= html_writer::start_tag('tr', array('style' => 'background-color: #d0cdcc;'));
           $display .= html_writer::start_tag('td');
           $display .= clean_text($value->id);
           $display .= html_writer::end_tag('td');
           $display .= html_writer::start_tag('td');
           $display .= clean_text($value->namegroup);
           $display .= html_writer::end_tag('td');
           $display .= html_writer::start_tag('td');
           $display .= html_writer::start_tag('a',array('class' => 'btn btn-info','href' => ''.$CFG->wwwroot.'/mod/objective/viewusergroup.php?courseid='.$value->courseid.'&instance='.$value->idmod.'&id='.$value->id.''));
           $display .= html_writer::start_tag('em', array('class' => 'fa fa-search'));
           $display .= html_writer::end_tag('em');
           $display .= html_writer::end_tag('a');
           $display .= html_writer::start_tag('a',array('onclick'=>'myFunction()','class' => 'btn btn-info'));
           $display .= html_writer::start_tag('em', array('class' => 'fa fa-edit'));
           $display .= html_writer::end_tag('em');
           $display .= html_writer::end_tag('a');
           $display .= html_writer::start_tag('div', array('id'=>'demo', 'class' => 'w3-dropdown-content w3-bar-block w3-border'));
           $display .= html_writer::start_tag('a',array('class' => 'w3-bar-item w3-button'));
           $display .= clean_text('<strong>link 1</strong>');
           $display .= html_writer::end_tag('a');
           $display .= html_writer::start_tag('a',array('class' => 'w3-bar-item w3-button'));
           $display .= clean_text('<strong>link 2</strong>');
           $display .= html_writer::end_tag('a');
           $display .= html_writer::start_tag('a',array('class' => 'w3-bar-item w3-button'));
           $display .= clean_text('<strong>link 3</strong>');
           $display .= html_writer::end_tag('a');
           $display .= html_writer::end_tag('div');
           $display .= html_writer::start_tag('a',array('class' => 'btn btn-danger', 'data-toggle'=>'modal', 'href' => '#delete_group'.$value->id.''));
           $display .= html_writer::start_tag('em', array('class' => 'fa fa-trash'));
           $display .= html_writer::end_tag('em');
           $display .= html_writer::end_tag('a');
           include('modals/modal.php');
           $display .= html_writer::end_tag('td');
           $display .= html_writer::end_tag('tr');
       }
      $display .= html_writer::end_tag('table');
      $display .= html_writer::end_tag('div');

      if($return) {
       return $display;
       } else {
       echo $display;
       }
}

function objective_print_groups_users($viewgroupusers, $return = 0){
    global $OUTPUT, $USER, $DB, $CFG;
       $display .= html_writer::start_tag('div', array('class' => 'w3-container'));
       $display .= html_writer::start_tag('table', array('class' => 'w3-table-all w3-hoverable'));
       $display .= html_writer::start_tag('tr');
       $display .= html_writer::start_tag('th');
       $display .= clean_text('<strong>Nombre completo</strong>');
       $display .= html_writer::end_tag('th');
       $display .= html_writer::start_tag('th');
       $display .= clean_text('<strong>Correo Electronico</strong>');
       $display .= html_writer::end_tag('th');
       $display .= html_writer::start_tag('th');
       $display .= clean_text('<strong>Rol adquirido</strong>');
       $display .= html_writer::end_tag('th');
       $display .= html_writer::start_tag('th');
       $display .= clean_text('<strong>Puesto</strong>');
       $display .= html_writer::end_tag('th');
       $display .= html_writer::start_tag('th');
       $display .= clean_text('<strong>Jefe Directo</strong>');
       $display .= html_writer::end_tag('th');
       $display .= html_writer::start_tag('th');
       $display .= clean_text('<strong>Estatus</strong>');
       $display .= html_writer::end_tag('th');
       $display .= html_writer::start_tag('th');
       $display .= clean_text('<strong>Acciones</strong>');
       $display .= html_writer::end_tag('th');
       $display .= html_writer::end_tag('tr');
       foreach ($viewgroupusers as $values) {
           $display .= html_writer::start_tag('tr', array('style' => 'background-color: #d0cdcc;'));
           $display .= html_writer::start_tag('td');
           $display .= clean_text($values->nombrecompleto);
           $display .= html_writer::end_tag('td');
           $display .= html_writer::start_tag('td');
           $display .= clean_text($values->correo);
           $display .= html_writer::end_tag('td');
           $display .= html_writer::start_tag('td');
           $display .= clean_text($values->description);
           $display .= html_writer::end_tag('td');
           $display .= html_writer::start_tag('td');
           $display .= clean_text($values->puesto);
           $display .= html_writer::end_tag('td');
           $display .= html_writer::start_tag('td');
           $display .= clean_text($values->jefedirecto);
           $display .= html_writer::end_tag('td');
           $display .= html_writer::start_tag('td');
           $display .= clean_text($values->estatus);
           $display .= html_writer::end_tag('td');
           $display .= html_writer::start_tag('td');
           $display .= html_writer::start_tag('a',array('class' => 'btn btn-info', 'data-toggle'=>'modal', 'href' => '#edit_group_user'.$values->id.''));
           $display .= html_writer::start_tag('em', array('class' => 'fa fa-pencil'));
           $display .= html_writer::end_tag('em');
           $display .= html_writer::end_tag('a');
           $display .= html_writer::start_tag('a',array('class' => 'btn btn-danger', 'data-toggle'=>'modal', 'href' => '#delete_group_user'.$values->id.''));
           $display .= html_writer::start_tag('em', array('class' => 'fa fa-trash'));
           $display .= html_writer::end_tag('em');
           $display .= html_writer::end_tag('a');
           include('modals/modal.php');
           $display .= html_writer::end_tag('td');
           $display .= html_writer::end_tag('tr');
       }
      $display .= html_writer::end_tag('table');
      $display .= html_writer::end_tag('div');

      if($return) {
       return $display;
       } else {
       echo $display;
       }
}

function objective_print_nivel($viewnivel, $return = 0){
    global $OUTPUT, $USER, $DB, $CFG;
       $display .= html_writer::start_tag('div', array('class' => 'container'));
       $display .= html_writer::start_tag('table', array('class' => 'table table-striped'));
       $display .= html_writer::start_tag('thead');
       $display .= html_writer::start_tag('tr' , array('style' => 'background-color:  #878786; color: #fff;'));
       $display .= html_writer::start_tag('th');
       $display .= clean_text('<strong>id</strong>');
       $display .= html_writer::end_tag('th');
       $display .= html_writer::start_tag('th');
       $display .= clean_text('<strong>Nivel</strong>');
       $display .= html_writer::end_tag('th');
       $display .= html_writer::start_tag('th');
       $display .= clean_text('<strong>Descripción</strong>');
       $display .= html_writer::end_tag('th');
       $display .= html_writer::start_tag('th');
       $display .= clean_text('<strong>Estatus</strong>');
       $display .= html_writer::end_tag('th');
       $display .= html_writer::start_tag('th');
       $display .= clean_text('<strong>Acciones</strong>');
       $display .= html_writer::end_tag('th');
       $display .= html_writer::end_tag('tr');
       $display .= html_writer::end_tag('thead');
       $display .= html_writer::start_tag('tbody');
       foreach ($viewnivel as $value) {
           $display .= html_writer::start_tag('tr', array('style' => 'background-color: #d0cdcc;'));
           $display .= html_writer::start_tag('td' );
           $display .= clean_text($value->id);
           $display .= html_writer::end_tag('td');
           $display .= html_writer::start_tag('td');
           $display .= clean_text($value->namenivel);
           $display .= html_writer::end_tag('td');
           $display .= html_writer::start_tag('td');
           $display .= clean_text($value->description);
           $display .= html_writer::end_tag('td');
           $display .= html_writer::start_tag('td');
           $display .= clean_text($value->estatus);
           $display .= html_writer::end_tag('td');
           $display .= html_writer::start_tag('td');
           $display .= html_writer::start_tag('a',array('class' => 'btn btn-danger', 'data-toggle'=>'modal', 'href' => '#delete_nivel'.$value->id.''));
           $display .= html_writer::start_tag('em', array('class' => 'fa fa-trash'));
           $display .= html_writer::end_tag('em');
           $display .= html_writer::end_tag('a');
           include('modals/modal.php');
           $display .= html_writer::end_tag('td');
           $display .= html_writer::end_tag('tr');
       }
      $display .= html_writer::end_tag('tbody');
      $display .= html_writer::end_tag('table');
      $display .= html_writer::end_tag('div');

      if($return) {
       return $display;
       } else {
       echo $display;
       }
}

function objective_print_quiz($viewquiz, $return = 0){
    global $OUTPUT, $USER, $DB, $CFG;
       $display .= html_writer::start_tag('div', array('class' => 'container'));
       $display .= html_writer::start_tag('table', array('class' => 'table table-striped'));
       $display .= html_writer::start_tag('thead');
       $display .= html_writer::start_tag('tr' , array('style' => 'background-color:  #878786; color: #fff;'));
       $display .= html_writer::start_tag('th');
       $display .= clean_text('<strong>id</strong>');
       $display .= html_writer::end_tag('th');
       $display .= html_writer::start_tag('th');
       $display .= clean_text('<strong>Nombre del cuestionario</strong>');
       $display .= html_writer::end_tag('th');
       $display .= html_writer::start_tag('th');
       $display .= clean_text('<strong>Formato</strong>');
       $display .= html_writer::end_tag('th');
       $display .= html_writer::start_tag('th');
       $display .= clean_text('<strong>Estatus</strong>');
       $display .= html_writer::end_tag('th');
       $display .= html_writer::start_tag('th');
       $display .= clean_text('<strong>Acciones</strong>');
       $display .= html_writer::end_tag('th');
       $display .= html_writer::end_tag('tr');
       $display .= html_writer::end_tag('thead');
       $display .= html_writer::start_tag('tbody');
       foreach ($viewquiz as $value) {
           $display .= html_writer::start_tag('tr', array('style' => 'background-color: #d0cdcc;'));
           $display .= html_writer::start_tag('td' );
           $display .= clean_text($value->id);
           $display .= html_writer::end_tag('td');
           $display .= html_writer::start_tag('td');
           $display .= clean_text($value->name);
           $display .= html_writer::end_tag('td');
           $display .= html_writer::start_tag('td');
           $display .= clean_text($value->description);
           $display .= html_writer::end_tag('td');
           $display .= html_writer::start_tag('td');
           $display .= clean_text($value->estatus);
           $display .= html_writer::end_tag('td');
           $display .= html_writer::start_tag('td');
           $display .= html_writer::start_tag('a',array('class' => 'btn btn-info','href' => ''.$CFG->wwwroot.'/mod/objective/viewquestions.php?courseid='.$value->courseid.'&idinstance='.$value->idmod.'&id='.$value->id.''));
           $display .= html_writer::start_tag('em', array('class' => 'fa fa-search'));
           $display .= html_writer::end_tag('em');
           $display .= html_writer::end_tag('a');
           $display .= html_writer::start_tag('a',array('class' => 'btn btn-danger', 'data-toggle'=>'modal', 'href' => '#delete_quiz'.$value->id.''));
           $display .= html_writer::start_tag('em', array('class' => 'fa fa-trash'));
           $display .= html_writer::end_tag('em');
           $display .= html_writer::end_tag('a');
           include('modals/modal.php');
           $display .= html_writer::end_tag('td');
           $display .= html_writer::end_tag('tr');
       }
      $display .= html_writer::end_tag('tbody');
      $display .= html_writer::end_tag('table');
      $display .= html_writer::end_tag('div');

      if($return) {
       return $display;
       } else {
       echo $display;
       }
}

function objective_print_quiz_question($viewquestion, $return = 0){
    global $OUTPUT, $USER, $DB, $CFG;
       $display .= html_writer::start_tag('div', array('class' => 'container'));
       $display .= html_writer::start_tag('table', array('class' => 'table table-striped'));
       $display .= html_writer::start_tag('thead');
       $display .= html_writer::start_tag('tr' , array('style' => 'background-color:  #878786; color: #fff;'));
       $display .= html_writer::start_tag('th');
       $display .= clean_text('<strong>id</strong>');
       $display .= html_writer::end_tag('th');
       $display .= html_writer::start_tag('th');
       $display .= clean_text('<strong>Codigo</strong>');
       $display .= html_writer::end_tag('th');
       $display .= html_writer::start_tag('th');
       $display .= clean_text('<strong>Pregunta</strong>');
       $display .= html_writer::end_tag('th');
       $display .= html_writer::start_tag('th');
       $display .= clean_text('<strong>Orden</strong>');
       $display .= html_writer::end_tag('th');
       $display .= html_writer::start_tag('th');
       $display .= clean_text('<strong>Captura</strong>');
       $display .= html_writer::end_tag('th');
       $display .= html_writer::start_tag('th');
       $display .= clean_text('<strong>Acciones</strong>');
       $display .= html_writer::end_tag('th');
       $display .= html_writer::end_tag('tr');
       $display .= html_writer::end_tag('thead');
       $display .= html_writer::start_tag('tbody');
       foreach ($viewquestion as $value) {
           $display .= html_writer::start_tag('tr', array('style' => 'background-color: #d0cdcc;'));
           $display .= html_writer::start_tag('td' );
           $display .= clean_text($value->id);
           $display .= html_writer::end_tag('td');
           $display .= html_writer::start_tag('td');
           $display .= clean_text($value->code);
           $display .= html_writer::end_tag('td');
           $display .= html_writer::start_tag('td');
           $display .= clean_text($value->description);
           $display .= html_writer::end_tag('td');
           $display .= html_writer::start_tag('td');
           $display .= clean_text($value->orden);
           $display .= html_writer::end_tag('td');
           $display .= html_writer::start_tag('td');
           $display .= clean_text($value->responsable);
           $display .= html_writer::end_tag('td');
           $display .= html_writer::start_tag('td');
           $display .= html_writer::start_tag('a',array('class' => 'btn btn-danger', 'data-toggle'=>'modal', 'href' => '#delete_question'.$value->id.''));
           $display .= html_writer::start_tag('em', array('class' => 'fa fa-trash'));
           $display .= html_writer::end_tag('em');
           $display .= html_writer::end_tag('a');
           include('modals/modal.php');
           $display .= html_writer::end_tag('td');
           $display .= html_writer::end_tag('tr');
       }
      $display .= html_writer::end_tag('tbody');
      $display .= html_writer::end_tag('table');
      $display .= html_writer::end_tag('div');

      if($return) {
       return $display;
       } else {
       echo $display;
       }
}
function objective_print_competition($viewcompetition, $return = 0){
    global $OUTPUT, $USER, $DB, $CFG;
       $display .= html_writer::start_tag('div', array('class' => 'container'));
       $display .= html_writer::start_tag('table', array('class' => 'table table-striped'));
       $display .= html_writer::start_tag('thead');
       $display .= html_writer::start_tag('tr' , array('style' => 'background-color:  #878786; color: #fff;'));
       $display .= html_writer::start_tag('th');
       $display .= clean_text('<strong>id</strong>');
       $display .= html_writer::end_tag('th');
       $display .= html_writer::start_tag('th');
       $display .= clean_text('<strong>Codigo</strong>');
       $display .= html_writer::end_tag('th');
       $display .= html_writer::start_tag('th');
       $display .= clean_text('<strong>Competencia</strong>');
       $display .= html_writer::end_tag('th');
       $display .= html_writer::start_tag('th');
       $display .= clean_text('<strong>Orden</strong>');
       $display .= html_writer::end_tag('th');
       $display .= html_writer::start_tag('th');
       $display .= clean_text('<strong>Nivel</strong>');
       $display .= html_writer::end_tag('th');
       $display .= html_writer::start_tag('th');
       $display .= clean_text('<strong>Acciones</strong>');
       $display .= html_writer::end_tag('th');
       $display .= html_writer::end_tag('tr');
       $display .= html_writer::end_tag('thead');
       $display .= html_writer::start_tag('tbody');
       foreach ($viewcompetition as $value) {
           $display .= html_writer::start_tag('tr', array('style' => 'background-color: #d0cdcc;'));
           $display .= html_writer::start_tag('td' );
           $display .= clean_text($value->id);
           $display .= html_writer::end_tag('td');
           $display .= html_writer::start_tag('td');
           $display .= clean_text($value->code);
           $display .= html_writer::end_tag('td');
           $display .= html_writer::start_tag('td');
           $display .= clean_text($value->name);
           $display .= html_writer::end_tag('td');
           $display .= html_writer::start_tag('td');
           $display .= clean_text($value->orden);
           $display .= html_writer::end_tag('td');
           $display .= html_writer::start_tag('td');
           $display .= clean_text($value->namenivel);
           $display .= html_writer::end_tag('td');
           $display .= html_writer::start_tag('td');
           $display .= html_writer::start_tag('a',array('class' => 'btn btn-info','href' => ''.$CFG->wwwroot.'/mod/objective/viewbehavior.php?courseid='.$value->courseid.'&instance='.$value->idmod.'&id='.$value->id.''));
           $display .= html_writer::start_tag('em', array('class' => 'fa fa-search'));
           $display .= html_writer::end_tag('em');
           $display .= html_writer::end_tag('a');
           $display .= html_writer::start_tag('a',array('class' => 'btn btn-danger', 'data-toggle'=>'modal', 'href' => '#delete_competition'.$value->id.''));
           $display .= html_writer::start_tag('em', array('class' => 'fa fa-trash'));
           $display .= html_writer::end_tag('em');
           $display .= html_writer::end_tag('a');
           include('modals/modal.php');
           $display .= html_writer::end_tag('td');
           $display .= html_writer::end_tag('tr');
       }
      $display .= html_writer::end_tag('tbody');
      $display .= html_writer::end_tag('table');
      $display .= html_writer::end_tag('div');

      if($return) {
       return $display;
       } else {
       echo $display;
       }
}
function objective_print_competition_behavior($viewbehavior, $return = 0){
    global $OUTPUT, $USER, $DB, $CFG;
       $display .= html_writer::start_tag('div', array('class' => 'container'));
       $display .= html_writer::start_tag('table', array('class' => 'table table-striped'));
       $display .= html_writer::start_tag('thead');
       $display .= html_writer::start_tag('tr' , array('style' => 'background-color:  #878786; color: #fff;'));
       $display .= html_writer::start_tag('th', array('style' => 'display:  none;'));
       $display .= clean_text('<strong>id</strong>');
       $display .= html_writer::end_tag('th');
       $display .= html_writer::start_tag('th');
       $display .= clean_text('<strong>Codigo</strong>');
       $display .= html_writer::end_tag('th');
       $display .= html_writer::start_tag('th');
       $display .= clean_text('<strong>Comportamiento</strong>');
       $display .= html_writer::end_tag('th');
       $display .= html_writer::start_tag('th');
       $display .= clean_text('<strong>Competencia</strong>');
       $display .= html_writer::end_tag('th');
       $display .= html_writer::start_tag('th');
       $display .= clean_text('<strong>Estatus</strong>');
       $display .= html_writer::end_tag('th');
       $display .= html_writer::start_tag('th');
       $display .= clean_text('<strong>Acciones</strong>');
       $display .= html_writer::end_tag('th');
       $display .= html_writer::end_tag('tr');
       $display .= html_writer::end_tag('thead');
       $display .= html_writer::start_tag('tbody');
       foreach ($viewbehavior as $value) {
           $display .= html_writer::start_tag('tr', array('style' => 'background-color: #d0cdcc;'));
           $display .= html_writer::start_tag('td', array('style' => 'display:  none;') );
           $display .= clean_text($value->id);
           $display .= html_writer::end_tag('td');
           $display .= html_writer::start_tag('td');
           $display .= clean_text($value->code);
           $display .= html_writer::end_tag('td');
           $display .= html_writer::start_tag('td');
           $display .= clean_text($value->description);
           $display .= html_writer::end_tag('td');
           $display .= html_writer::start_tag('td');
           $display .= clean_text($value->competencia);
           $display .= html_writer::end_tag('td');
           $display .= html_writer::start_tag('td');
           $display .= clean_text($value->estatus);
           $display .= html_writer::end_tag('td');
           $display .= html_writer::start_tag('td');
           $display .= html_writer::start_tag('a',array('class' => 'btn btn-info', 'data-toggle'=>'modal', 'href' => '#edit_behavior'.$value->id.''));
           $display .= html_writer::start_tag('em', array('class' => 'fa fa-pencil'));
           $display .= html_writer::end_tag('em');
           $display .= html_writer::end_tag('a');
           $display .= html_writer::start_tag('a',array('class' => 'btn btn-danger', 'data-toggle'=>'modal', 'href' => '#delete_behavior'.$value->id.''));
           $display .= html_writer::start_tag('em', array('class' => 'fa fa-trash'));
           $display .= html_writer::end_tag('em');
           $display .= html_writer::end_tag('a');
           include('modals/modal.php');
           $display .= html_writer::end_tag('td');
           $display .= html_writer::end_tag('tr');
       }
      $display .= html_writer::end_tag('tbody');
      $display .= html_writer::end_tag('table');
      $display .= html_writer::end_tag('div');

      if($return) {
       return $display;
       } else {
       echo $display;
       }
}

function objective_print_establishment($viewestablishment, $return = 0){
    global $OUTPUT, $USER, $DB, $CFG;

       $idjefeinmediato='';
       $idgrupojefe='';
       $idcurso='';
       $idmodulo='';
       $idinstancia='';
       $role='';
       $display .= html_writer::start_tag('div', array('class' => 'container'));
       $display .= html_writer::start_tag('table', array('class' => 'table table-striped'));
       $display .= html_writer::start_tag('thead');
       $display .= html_writer::start_tag('tr' , array('style' => 'background-color:  #878786; color: #fff;'));
       $display .= html_writer::start_tag('th');
       $display .= clean_text('<strong>Nombre Completo</strong>');
       $display .= html_writer::end_tag('th');
       $display .= html_writer::start_tag('th');
       $display .= clean_text('<strong>Email</strong>');
       $display .= html_writer::end_tag('th');
       $display .= html_writer::start_tag('th');
       $display .= clean_text('<strong>Fecha</strong>');
       $display .= html_writer::end_tag('th');
       $display .= html_writer::start_tag('th');
       $display .= clean_text('<strong>Rol</strong>');
       $display .= html_writer::end_tag('th');
       $display .= html_writer::start_tag('th');
       $display .= clean_text('<strong>Estatus</strong>');
       $display .= html_writer::end_tag('th');
       $display .= html_writer::start_tag('th');
       $display .= clean_text('<strong>Acciones</strong>');
       $display .= html_writer::end_tag('th');
       $display .= html_writer::end_tag('tr');
       $display .= html_writer::end_tag('thead');
       $display .= html_writer::start_tag('tbody');
       foreach ($viewestablishment as $valuest) {

           $idjefeinmediato=$valuest->iduser;
           $idgrupojefe=$valuest->idgrupo;
           $idcurso=$valuest->courseid;
           $idmodulo=$valuest->idmod;
           $idinstancia=$valuest->idinstance;
           $role=$valuest->finalrol;
           $display .= html_writer::start_tag('tr', array('style' => 'background-color: #d0cdcc;'));
           $display .= html_writer::start_tag('td');
           $display .= clean_text($valuest->ncompleto);
           $display .= html_writer::end_tag('td');
           $display .= html_writer::start_tag('td');
           $display .= clean_text($valuest->email);
           $display .= html_writer::end_tag('td');
           $display .= html_writer::start_tag('td');
           $display .= clean_text($valuest->fecha);
           $display .= html_writer::end_tag('td');
           $display .= html_writer::start_tag('td');
           $display .= clean_text($valuest->rol);
           $display .= html_writer::end_tag('td');
           $display .= html_writer::start_tag('td');
           $display .= clean_text($valuest->estatus);
           $display .= html_writer::end_tag('td');
           $display .= html_writer::start_tag('td');
           $display .= html_writer::start_tag('a',array('class' => 'btn btn-info color-boton','href' => ''.$CFG->wwwroot.'/mod/objective/viewestablishment.php?courseid='.$idcurso.'&instance='.$idmodulo.'&id='.$valuest->id.''));
           $display .= html_writer::start_tag('em', array('class' => 'fa fa-search'));
           $display .= html_writer::end_tag('em');
           $display .= html_writer::end_tag('a');
           /*
           if($valuest->status==0){
           $display .= html_writer::start_tag('a',array('class' => 'btn btn-info color-boton','href' => ''.$CFG->wwwroot.'/mod/objective/editestablishment.php?courseid='.$idcurso.'&instance='.$idmodulo.'&id='.$valuest->id.''));
           $display .= html_writer::start_tag('em', array('class' => 'fa fa-pencil'));
           $display .= html_writer::end_tag('em');
           $display .= html_writer::end_tag('a');
           }else{

           }*/
           include('modals/modal.php');
           $display .= html_writer::end_tag('td');
           $display .= html_writer::end_tag('tr');
       }
      $display .= html_writer::end_tag('tbody');
      $display .= html_writer::end_tag('table');
      $display .= html_writer::end_tag('div');
      if($role==1){



      }else{
                /*$esql="select oe.id, u.id as iduser, concat(u.firstname, ' ', u.lastname) as ncompleto, u.email, oe.courseid, oe.idmod, oe.idinstance,
                DATE_FORMAT(FROM_UNIXTIME(oe.timecreated), '%d-%m-%Y') AS fecha,
                CASE
                WHEN (oe.rol) = 1 THEN 'COLABORADOR'
                WHEN (oe.rol) = 2 THEN 'JEFE INMEDIATO'
                WHEN (oe.rol) = 3 THEN 'DIRECTOR'
                ELSE 'SIN VALOR'
                END AS rol,
                gu.rol as rolfinal,
                CASE
                WHEN (oe.status) = 0 THEN 'Por Iniciar Establecimiento'
                WHEN (oe.status) = 1 THEN 'En Proceso Establecimiento'
                WHEN (oe.status) = 2 THEN 'Enviado a Aprobación Establecimiento'
                WHEN (oe.status) = 3 THEN 'Finalizado Establecimiento'
                WHEN (oe.status) = 4 THEN 'En Proceso Revisión 1'
                WHEN (oe.status) = 5 THEN 'Enviado a Aprobación Revisión 1'
                WHEN (oe.status) = 6 THEN 'Finalizado Revisión 1'
                WHEN (oe.status) = 7 THEN 'En Proceso Revisión Final'
                WHEN (oe.status) = 8 THEN 'Enviado a Aprobación Revisión Final'
                WHEN (oe.status) = 9 THEN 'Finalizado Revisión Final'
                ELSE 'SIN VALOR'
                END AS estatus
                , og.id as idgrupo
                from {objective_establishment} oe
                inner join {user} u on u.id = oe.userid
                inner join {objective_groups_users} gu on  gu.idusuario = oe.userid
                inner join {objective_groups} og on og.id = gu.idgroup
                where oe.courseid=? and oe.idinstance=? and oe.idmod=? and u.id != ? and og.id=? order by ncompleto asc";*/

                $esql="select distinct oe.id, u.id as iduser, concat(u.firstname, ' ', u.lastname) as ncompleto, u.email, oe.courseid, oe.idmod, oe.idinstance,
                DATE_FORMAT(FROM_UNIXTIME(oe.timecreated), '%d-%m-%Y') AS fecha,
                CASE
                WHEN (MAX(oe.rol)) = 1 THEN 'COLABORADOR'
                WHEN (MAX(oe.rol)) = 2 THEN 'JEFE INMEDIATO'
                WHEN (MAX(oe.rol)) = 3 THEN 'DIRECTOR'
                ELSE 'SIN VALOR'
                END AS rol,
                -- MAX(gu.rol) as rolfinal,
                CASE
                WHEN (oe.status) = 0 THEN 'Por Iniciar Establecimiento'
                WHEN (oe.status) = 1 THEN 'En Proceso Establecimiento'
                WHEN (oe.status) = 2 THEN 'Enviado a Aprobación Establecimiento'
                WHEN (oe.status) = 3 THEN 'Finalizado Establecimiento'
                WHEN (oe.status) = 4 THEN 'En Proceso Revisión Mitad de año'
                WHEN (oe.status) = 5 THEN 'Enviado a Aprobación Revisión Mitad de año'
                WHEN (oe.status) = 6 THEN 'Finalizado Revisión Mitad de año'
                WHEN (oe.status) = 7 THEN 'En Proceso Revisión Final'
                WHEN (oe.status) = 8 THEN 'Enviado a Aprobación Revisión Final'
                WHEN (oe.status) = 9 THEN 'Finalizado Revisión Final'
                ELSE 'SIN VALOR'
                END AS estatus
                -- , MAX(og.id) as idgrupo
                from mdl_objective_establishment oe
                inner join mdl_user u on u.id = oe.userid
                inner join mdl_objective_groups_users gu on  gu.idusuario = oe.userid
                inner join mdl_objective_groups og on og.id = gu.idgroup
                where oe.courseid=? and oe.idinstance=? and oe.idmod=? and u.id != ? and oe.idjefedirecto=? and og.id=? and  gu.status=?
				GROUP BY oe.id, u.id,oe.rol,gu.rol";

                $result = $DB->get_records_sql($esql, array($idcurso, $idinstancia, $idmodulo, $idjefeinmediato, $idjefeinmediato, $idgrupojefe,0));  

                $display .= html_writer::start_tag('div', array('class' => 'container'));
                $display .= html_writer::start_tag('table', array('class' => 'table table-striped'));
                $display .= html_writer::start_tag('thead');
                $display .= html_writer::start_tag('tr' , array('style' => 'background-color:  #878786; color: #fff;'));
                $display .= html_writer::start_tag('th');
                $display .= clean_text('<strong>Colaboradores</strong>');
                $display .= html_writer::end_tag('th');
                $display .= html_writer::start_tag('th');
                $display .= clean_text('<strong>Email</strong>');
                $display .= html_writer::end_tag('th');
                $display .= html_writer::start_tag('th');
                $display .= clean_text('<strong>Fecha</strong>');
                $display .= html_writer::end_tag('th');
                $display .= html_writer::start_tag('th');
                $display .= clean_text('<strong>Rol</strong>');
                $display .= html_writer::end_tag('th');
                $display .= html_writer::start_tag('th');
                $display .= clean_text('<strong>Estatus</strong>');
                $display .= html_writer::end_tag('th');
                $display .= html_writer::start_tag('th');
                $display .= clean_text('<strong>Acciones</strong>');
                $display .= html_writer::end_tag('th');
                $display .= html_writer::end_tag('tr');
                $display .= html_writer::end_tag('thead');
                $display .= html_writer::start_tag('tbody');
                foreach ($result as $valores) {

                    $display .= html_writer::start_tag('tr', array('style' => 'background-color: #d0cdcc;'));
                    $display .= html_writer::start_tag('td');
                    $display .= clean_text($valores->ncompleto);
                    $display .= html_writer::end_tag('td');
                    $display .= html_writer::start_tag('td');
                    $display .= clean_text($valores->email);
                    $display .= html_writer::end_tag('td');
                    $display .= html_writer::start_tag('td');
                    $display .= clean_text($valores->fecha);
                    $display .= html_writer::end_tag('td');
                    $display .= html_writer::start_tag('td');
                    $display .= clean_text($valores->rol);
                    $display .= html_writer::end_tag('td');
                    $display .= html_writer::start_tag('td');
                    $display .= clean_text($valores->estatus);
                    $display .= html_writer::end_tag('td');
                    $display .= html_writer::start_tag('td');
                    $display .= html_writer::start_tag('a',array('class' => 'btn btn-info color-boton','href' => ''.$CFG->wwwroot.'/mod/objective/checkestablishment.php?courseid='.$valores->courseid.'&instance='.$valores->idmod.'&id='.$valores->id.''));
                    $display .= html_writer::start_tag('em', array('class' => 'fa fa-search'));
                    $display .= html_writer::end_tag('em');
                    $display .= html_writer::end_tag('a');
                    $display .= html_writer::end_tag('td');
                    $display .= html_writer::end_tag('tr');
                }
  
                    $display .= html_writer::end_tag('tbody');
                    $display .= html_writer::end_tag('table');
                     $display .= html_writer::end_tag('div');





      }


      if($return) {
       return $display;
       } else {
       echo $display;
       }
}


?>
