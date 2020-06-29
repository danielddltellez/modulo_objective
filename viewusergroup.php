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

$PAGE->set_url('/mod/objective/viewusergroup.php', array('courseid' => $courseid,'instance' => $instance, 'id' => $id));
$PAGE->set_title(format_string($moduleobjective->name));
$PAGE->set_heading(format_string($course->fullname));
$PAGE->set_context($modulecontext);


echo $OUTPUT->header();
/*
$consulta="select distinct ob.id
from {objective_groups} ob 
where ob.courseid=? and ob.category=? and ob.id=?";
$r = $DB->get_records_sql($consulta, array($courseid, 0, $id));
//print_r($r);

if(!empty($r)){
    $a=1; 
}else{
    $a=0;
}
*/

echo '<h1><b>Grupos establecimiento de objetivos</b></h1>';
$button = new single_button(new moodle_url('/mod/objective/usergroup.php', array('courseid' => $courseid,'instance' => $instance,'idgroup'=>$id)),'Agrega usuario', $buttonadd, 'get');
$button->class = 'singlebutton addusergroup';
$button->formid = 'addusergroup';
echo $OUTPUT->render($button);
//Muestras informacion de los cursos
echo '<link rel="stylesheet" href="./css/w3.css">';

$sql="select  distinct ogu.id , CONCAT(u.firstname, ' ', u.lastname) as nombrecompleto, u.email as correo, ogr.description
,(select mf3.data from {user_info_data} mf3 where mf3.userid=u.id and mf3.fieldid=3) as puesto 
,(select mf4.data from {user_info_data} mf4 where mf4.userid=u.id and mf4.fieldid=2) as jefedirecto,
ogu.courseid ,ogu.idgroup,
CASE
    WHEN ogu.status = 0 THEN 'HABILITADO'
    WHEN ogu.status = 1 THEN 'INHABILITADO'
    ELSE 'SIN VALOR'
END AS estatus
from {objective_groups_users} ogu
inner join {objective_groups_rol} ogr on ogr.id=ogu.rol
inner join {user} u on u.id = ogu.idusuario
inner join {user_info_data} md ON md.userid = u.id
inner join {user_info_field} mf ON mf.id = md.fieldid  where ogu.courseid='".$courseid."' and ogu.idgroup='".$id."' ORDER BY ogr.description DESC";
$viewgroupusers = $DB->get_records_sql($sql, array());  

objective_print_groups_users($viewgroupusers);

echo $OUTPUT->footer();

?>