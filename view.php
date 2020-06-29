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

$PAGE->set_url('/mod/objective/view.php', array('id' => $cm->id));
$PAGE->set_title(format_string($moduleobjective->name));
$PAGE->set_heading(format_string($course->fullname));
$PAGE->set_context($modulecontext);



echo $OUTPUT->header();

$button = new single_button(new moodle_url('/mod/objective/viewgroup.php', array('id' => $id)),'Grupos', $buttonadd, 'get');
$button->class = 'buttongroup';
$button->formid = 'newgroup';

$btnivel = new single_button(new moodle_url('/mod/objective/viewnivel.php', array('id' => $id)),'Niveles', $buttonadd, 'get');
$btnivel->class = 'buttonnivel';
$btnivel->formid = 'newnivel';

$btnquiz = new single_button(new moodle_url('/mod/objective/viewquiz.php', array('id' => $id)),'Cuestionarios', $buttonadd, 'get');
$btnquiz->class = 'buttonquiz';
$btnquiz->formid = 'newquiz';

$btncompetititon = new single_button(new moodle_url('/mod/objective/viewcompetition.php', array('id' => $id)),'Competencias', $buttonadd, 'get');
$btncompetititon->class = 'buttoncompetition';
$btncompetititon->formid = 'newcompetition';

$btnnotificacion = new single_button(new moodle_url('/mod/objective/notificacionobjetivos.php', array('id' => $id)),'Notificacion', $buttonadd, 'get');
$btnnotificacion->class = 'buttonnotificacion';
$btnnotificacion->formid = 'newnotificacion';

$btnestablishment = new single_button(new moodle_url('/mod/objective/establishment.php', array('idmod' => $id)),'agrega tus objetivos', $buttonadd, 'get');
$btnestablishment->class = 'establishment';
$btnestablishment->formid = 'establishment';

$sql="select oe.id, u.id as iduser, concat(u.firstname, ' ', u.lastname) as ncompleto, u.email, oe.courseid, oe.idmod, oe.idinstance,
DATE_FORMAT(FROM_UNIXTIME(oe.timecreated), '%d-%m-%Y') AS fecha,
oe.rol as 'finalrol',
CASE
WHEN (gu.rol) = 1 THEN 'COLABORADOR'
WHEN (gu.rol) = 2 THEN 'JEFE INMEDIATO'
WHEN (gu.rol) = 3 THEN 'DIRECTOR'
ELSE 'SIN VALOR'
END AS rol,
-- gu.rol as 'rolfinal',
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
,og.id as idgrupo, oe.status, oe.idjefedirecto
from {objective_establishment} oe
inner join {user} u on u.id = oe.userid
inner join {objective_groups_users} gu on  gu.idusuario = oe.userid and gu.rol = oe.rol
inner join {objective_groups} og on og.id = gu.idgroup
where oe.courseid=? and oe.idinstance=? and oe.idmod=? and u.id = ?";
$viewestablishment = $DB->get_records_sql($sql, array($cm->course, $cm->instance, $id, $USER->id));  
//$viewestablishment = $DB->get_records_sql($sql, array());  
//print_r($viewestablishment);

echo '<head>
<title>Establecimiento de objetivos</title>
<meta charset="UTF-8">
<meta name="Establecimiento de objetivos" content="Establecimiento de objetivos">
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

</head><div class="tabbable">
<ul class="nav nav-tabs">
<li class="active"><a href="#tab1" data-toggle="tab">Mis Objetivos</a></li>';



if (user_has_role_assignment($USER->id, 1) || is_siteadmin() || user_has_role_assignment($USER->id, 2)) {          
echo '<li><a href="#tab2" data-toggle="tab">Administrador</a></li>';
}
echo '</ul><div class="tab-content">
            <div class="tab-pane active" id="tab1">';
            echo $principal;
            if(empty($viewestablishment)){
                echo $OUTPUT->render($btnestablishment);
            }else{
            
            }
            objective_print_establishment($viewestablishment);
            echo '</div>';
            if (is_siteadmin()) {
            echo '<div class="tab-pane" id="tab2">';
            
                echo $OUTPUT->render($button);
                echo ('<br></br>');
                echo $OUTPUT->render($btnivel);
                echo ('<br></br>');
                echo $OUTPUT->render($btnquiz);
                echo ('<br></br>');
                echo $OUTPUT->render($btncompetititon);
                echo ('<br></br>');
                echo $OUTPUT->render($btnnotificacion);
                echo '</div>';
                
            }else if(user_has_role_assignment($USER->id, 1) || user_has_role_assignment($USER->id, 2)){

                echo '<div class="tab-pane" id="tab2">';
            
                echo $OUTPUT->render($button);
                echo ('<br></br>');
                echo '</div>';


            }else{

            }


echo '</div></div>';

echo '<style>

.color-boton {
    color: #fff !important;
    background-color: #db8877 !important;
    background-image: linear-gradient(to bottom, #db8877, #db8877) !important;
}

.color-boton:hover {
    color: #fff !important;
    background-color: #db8877 !important;
}</style>';

echo $OUTPUT->footer($course);


?>
