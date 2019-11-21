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

?>
<head>
    <title>Establecimiento de objetivos</title>
    <meta charset="UTF-8">
    <meta name="title" content="Establecimiento de objetivos">
    <meta name="description" content="Descripción de la WEB">
    <link href="./css/w3.css"  rel="stylesheet">
    <link href="./css/select2.min.css" rel="stylesheet" />
    <link href="./css/style.css" rel="stylesheet" />
    <link rel="stylesheet" href="./css/jquery-ui.css">
    <link rel="stylesheet" href="./css/w3-theme-grey.css">
    <link rel="stylesheet" href="https://parsleyjs.org/src/parsley.css">
    <script src="./js/select2.min.js" type="text/javascript"></script>
    <script src="./js/jquery-1.12.4.js" type="text/javascript"></script>
    <script src="./js/jquery-ui.js" type="text/javascript"></script>
    <script src="./js/functions.js" type="text/javascript"></script>
   <!-- <script src="./js/enviar.js"></script>-->
    <script src="./js/es.js" type="text/javascript"></script>
    <script src="./js/parsley.js" type="text/javascript"></script>
</head>
<body>
<?php
$query="select distinct u.id as 'iduser', concat(u.firstname, ' ',u.lastname) as 'ncomnpleto'  , (SELECT 
mf3.data
FROM
mdl_user_info_data mf3
WHERE
mf3.userid = u.id AND mf3.fieldid = 2) AS 'jefediecto', ogr.description as 'rol', oe.idjefedirecto as 'idjefe',oe.status as 'estatusavance' ,DATE_FORMAT(FROM_UNIXTIME(oe.timecreated), '%Y-%m-%d') AS fechaestab
from mdl_user u 
join mdl_user_info_data id on id.userid = u.id
join mdl_user_info_field ii on ii.id = id.fieldid 
inner join mdl_objective_establishment oe on oe.userid = u.id
inner join mdl_objective o on o.id = oe.idinstance
inner join mdl_objective_groups_users ogu on ogu.idusuario = u.id
inner join mdl_objective_groups og on og.id = ogu.idgroup
inner join mdl_objective_groups_rol  ogr on ogr.id =  oe.rol
where u.id=?";
$result = $DB->get_records_sql($query, array($USER->id));
$idusuario='';
$nombre='';
$nombrejefe='';
$rolprincipal='';
$estatusa='';
$fechaestablecimiento='';
        
        foreach($result as $value){

               $idusuario=$value->iduser;
               $nombre=$value->ncomnpleto;
               $nombrejefe=$value->jefediecto;
               $rolprincipal=$value->rol;
               $idjefegrupo=$value->idjefe;
               $estatusa=$value->estatusavance;
               $fechaestablecimiento=$value->fechaestab;

           
        }
if($rolprincipal=='COLABORADOR'|| $rolprincipal=='JEFE INMEDIATO'){
                        
    echo '<div class="w3-bar w3-black">';
    if($estatusa==0){
        echo '<button class="w3-bar-item w3-button" onclick="openCity(\'vista1\')">Establecimiento de objetivos</button>';
    }else if($estatusa==1){

        echo '<button class="w3-bar-item w3-button" onclick="openCity(\'vista1\')">Establecimiento de objetivos</button>';
        echo '<button class="w3-bar-item w3-button" onclick="openCity(\'vista2\')">Revision 1</button>';
    }else if($estatusa==2){

        echo '<button class="w3-bar-item w3-button" onclick="openCity(\'vista1\')">Establecimiento de objetivos</button>';
        echo '<button class="w3-bar-item w3-button" onclick="openCity(\'vista2\')">Revision 1</button>';
        echo '<button class="w3-bar-item w3-button" onclick="openCity(\'vista3\')">Revision Final</button>';
    }
    echo'</div>';
                                            $vistajefeinmediato .='<div class="w3-row">
                                                                        <div class="w3-col l1">
                                                                            <p></p>
                                                                        </div>
                                                                        <div class="w3-round-xxlarge w3-col l5 w3-pale-red w3-center">
                                                                            <p>Objetivos del jefe inmediato</p>
                                                                        </div>
                                                                        <div class="w3-round-xxlarge w3-col l5 w3-dark-grey w3-center">  
                                                                            <p>'.$nombrejefe.'</p>
                                                                        </div>
                                                                        <div class="w3-col l1">
                                                                            <p></p>
                                                                        </div>
                                                                </div>';   
                                            $vistajefeinmediato2 .='<div class="w3-row">
                                                                        <div class="w3-col l1"><p></p></div>
                                                                        <div id="jefe-inmediato" class="w3-col l10 w3-pale-red w3-center">
                                                                            <table class="w3-table-all">';
                                            $objetivosjefe='select id, userid, targetnumber, objectivecomplete  from mdl_objective_establishment_captured where userid=?';
                                            $obtenerobj = $DB->get_records_sql($objetivosjefe, array($idjefegrupo));
                                            $j=1;
                                            foreach($obtenerobj as $valueobj){
                                            $contador = $j++;
                                                              $vistaobjetivosjefe.='<tr>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td>'.$contador.'</td>
                                                                    <td style="text-align: justify;">'.$valueobj->objectivecomplete.'</td>
                                                                </tr>';
                                                            }
                                            $vistajefeinmediato3 .='</table>
                                                        </div>
                                                    <div class="w3-col l1"><p></p></div>
                                                </div>';

} else if ($rolprincipal=='DIRECTOR'){

                                        echo '<div class="w3-bar w3-black">
                                                            <button class="w3-bar-item w3-button" onclick="openCity(\'vista1\')">Establecimiento de objetivos</button>
                                                            <button class="w3-bar-item w3-button" onclick="openCity(\'vista3\')">Revision Final</button>
                                                        </div>';
                                                        $vistajefeinmediato .='<div class="w3-row">
                                                                <div class="w3-col l1">
                                                                    <p></p>
                                                                </div>
                                                                <div class="w3-round-xxlarge w3-col l5 w3-center">
                                                                    <p></p>
                                                                </div>
                                                                <div class="w3-round-xxlarge w3-col l5 w3-center">  
                                                                    <p></p>
                                                                </div>
                                                                <div class="w3-col l1">
                                                                    <p></p>
                                                                </div>
                                                        </div>';
                                                        $vistajefeinmediato2 .='<div class="w3-row">
                                                                                    <div class="w3-col l1"><p></p></div>
                                                                                        <div id="jefe-inmediato" class="w3-col l10 w3-pale-red w3-center">
                                                                                            <table>';
                                                        $vistaobjetivosjefe.='<tr>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td></td>
                                                                                <td style="text-align: justify;"></td>
                                                                            </tr>';
                                                        $vistajefeinmediato3 .='</table>
                                                        </div>
                                                    <div class="w3-col l1"><p></p></div>
                                                </div>';

}else{
                    
                    echo 'NO TIENES ROL ASIGNADO';

}
$fcha = date("Y-m-d");
/* INICIA VISTA 1*/
$vista .='<div id="vista1" class="w3-light-grey vistas">
                                <div class="w3-container">
                                    <div class="w3-row">
                                        <div class="w3-col l2">
                                            <p></p>
                                        </div>
                                        <div class="w3-col l8">
                                            <h3 class="w3-center  w3-animate-top">Establecimiento de objetivos</h3>
                                            <p class="w3-animate-opacity">La siguiente evaluación tiene como objetivo analizar, evaluar y comparar los resultados del desempeño de los colaboradores y su acercamiento a las competencias organizacionales. Estos resultados serán parte fundamental para diseñar
                                                programas de capacitación y desarrollo.</p>
                                        </div>
                                        <div class="w3-col l2">
                                            <p></p>
                                        </div>
                                    </div>
                                    <div class="w3-row">
                                        <div class="w3-col l4">
                                            <p></p>
                                        </div>
                                        <div class="w3-col l4">
                                            <p></p>
                                        </div>
                                        <div class="w3-col l4">';
                                        if($fechaestablecimiento=='' || $fechaestablecimiento==NULL){
                                            $vista .='<input id="fechaobjetivo" type="date" class="form-control"  value="'.$fcha.'"  disabled="yes">';
                                            
                                        }else{
                                            
                                            $vista .='<input id="fechaobjetivo" type="date" class="form-control"  value="'.$fechaestablecimiento.'"  disabled="yes">';
                                        }
                                            $vista .='<!--<p>Fecha de establecimiento:<input type="text"></p>-->
                                            <!--<p>Fecha de establecimiento: <input type="text" id="datepicker"></p>-->
                                        </div>
                                    </div>
                                </div>
                                <div class="espacio"></div>
                                <div class="w3-container">
                                    <div class="w3-row">
                                        <div class="w3-col l1">
                                            <p></p>
                                        </div>
                                        <div class="w3-round-xxlarge w3-col l5 w3-pale-red w3-center">
                                            <p>1a. Parte</p>
                                        </div>
                                        <div class="w3-round-xxlarge w3-col l5 w3-dark-grey w3-center">
                                            <p>Objetivos del puesto de trabajo</p>
                                        </div>
                                        <div class="w3-col l1">
                                            <p></p>
                                        </div>
                                    </div>
                                    <div class="w3-row">
                                        <div class="w3-col l1">
                                            <p></p>
                                        </div>
                                        <div class="w3-col l10 w3-center">
                                            <p>Este apartado está estrechamente ligado con el rubro de objetivos del puesto de trabajo; con esta evaluación conoceremos en qué medida se logran. Es importante que consideres los objetivos de tu jefe inmediato que te presentamos a
                                                continuación: *No todos deberán </p>
                                        </div>
                                        <div class="w3-col l1">
                                            <p></p>
                                        </div>
                                    </div>';

//$queryfinal='select * from mdl_objective_establishment_captured where userid=? and courseid=? and idobjective=? order by idobjective ASC';
$querycontrol='select es.id, @rownum:=@rownum+1 contador,  es.userid,es.idobjective ,es.courseid, es.targetnumber, es.whatquestion, es.howquestion, es.thatquestion, es.specifyquestion, es.periodquestion, es.objectivecomplete, DATE_FORMAT(FROM_UNIXTIME(es.startdate), "%Y-%m-%d") as fechaini, DATE_FORMAT(FROM_UNIXTIME(es.enddate), "%Y-%m-%d") as fechafin, es.valueobjective
,(select er.actionpartner from  mdl_objective_establishment_revise er where er.idobjectiveestablishment=es.id) as actionp
,(select er2.actionsixmonth from  mdl_objective_establishment_revise er2 where er2.idobjectiveestablishment=es.id) as actions
,(select er3.bosscomments from  mdl_objective_establishment_revise er3 where er3.idobjectiveestablishment=es.id) as bossc
,(select er4.bosssuggestions from  mdl_objective_establishment_revise er4 where er4.idobjectiveestablishment=es.id) as bosss
,(select a1.mycomments from  mdl_objective_establishment_revise_final a1 where a1.idobjectiveestablishment=es.id) as mycomments
,(select a2.mycommentsfinals from  mdl_objective_establishment_revise_final a2 where a2.idobjectiveestablishment=es.id) as mycommentsfinal
,(select a3.feedbackboos  from mdl_objective_establishment_revise_final a3 where a3.idobjectiveestablishment=es.id) as feedbackboos
,(select a4.feedbackevaluation from mdl_objective_establishment_revise_final a4 where a4.idobjectiveestablishment=es.id) as feddbackevaluation
,(select a5.autoevaluation from mdl_objective_establishment_revise_final a5 where a5.idobjectiveestablishment=es.id) as autoevaluation
,(select a6.evaluationboss from mdl_objective_establishment_revise_final a6 where a6.idobjectiveestablishment=es.id) as evaluationboss
from  mdl_objective_establishment_captured es
inner join mdl_objective_establishment o on o.id = es.idobjective,
(SELECT @rownum:=0) R
where es.courseid=? and es.idobjective=? and es.userid=? order by es.id ASC';

$resultcontrol = $DB->get_records_sql($querycontrol, array($courseid, $id, $USER->id));
if(empty($resultcontrol)){
$i=1;

$establecimiento .='<form id="establecimientoobj" method="POST" action="envio.php" data-parsley-validate="">';
    for($i;$i<=6; $i++){
                                            
        if($i<=4){
            $requerido='required=""';
            $requeridotext='data-parsley-trigger="keyup" data-parsley-minlength="20" data-parsley-maxlength="100" data-parsley-minlength-message="Debes de capturar la descripcion de tu objetivo" data-parsley-validation-threshold="10"';

        }else{
            $requerido='';
            $requeridotext='';
        }
                                                    
        $establecimiento .='<div id="establecimientoobjetivos'.$i.'">
                                <div class="w3-row">
                                        <div class="w3-col l8 w3-dark-grey">
                                            <p>Breve descripción del objetivo '.$i.'</p>
                                        </div>
                                        <div class="w3-col l2">
                                            <p></p>
                                        </div>
                                        <div class="w3-col l2">
                                            <p></p>
                                        </div>
                                </div>
                                <div class="w3-row">
                                    <input type="hidden" id="userid'.$i.'" name="userid'.$i.'" value="'.$USER->id.'" '.$requerido.'>
                                    <input type="hidden" id="courseid'.$i.'" name="courseid'.$i.'" value="'.$courseid.'" '.$requerido.'>
                                    <input type="hidden" id="idobjetivo'.$i.'" name="idobjetivo'.$i.'" value="'.$id.'" '.$requerido.'>
                                    <div class="w3-col m2 w3-white w3-center">
                                        <p class="text-cuestion">Indica el # de objetivo de tu jefe inmediato al que estará ligado tu objetivo</p>
                                        <!--<p><input  class="w3-input w3-border" type="text"></p>-->
                                            <select class="w3-select w3-border" name="objetivo'.$i.'" id="objetivo'.$i.'" '.$requerido.'>
                                            <option value="" disabled selected>Selecciona el objetivo de tu jefe</option>
                                            <option value="1">Objetivo 1</option>
                                            <option value="2">Objetivo 2</option>
                                            <option value="3">Objetivo 3</option>
                                            <option value="4">Objetivo 4</option>
                                            <option value="5">Objetivo 5</option>
                                            <option value="6">Objetivo 6</option>
                                        </select> 
                                    </div>
                                    <div class="w3-col m2 w3-white w3-center">
                                        <p class="text-cuestion">1. ¿Qué se quiere medir?</p>
                                        <p><input class="w3-input w3-border" maxlength="25"  type="text" placeholder="Ej. Rotación" id="que'.$i.'" name="que'.$i.'" data-parsley-pattern="^[a-zA-Z ]+$" '.$requerido.'></p>
                                    </div>
                                    <div class="w3-col m2 w3-white w3-center">
                                        <p class="text-cuestion">2. ¿Cómo se quiere medir?</p>
                                        <p><input class="w3-input w3-border" maxlength="25" type="text" placeholder="Ej. Aumentar" id="como'.$i.'" name="como'.$i.'" data-parsley-pattern="^[a-zA-Z ]+$" '.$requerido.'></p>
                                    </div>
                                    <div class="w3-col m2 w3-white w3-center">
                                        <p class="text-cuestion">3. ¿Cuánto quieres que mida?</p>
                                        <p><input class="w3-input w3-border" maxlength="25" type="text" placeholder="Ej. 10%" id="cuanto'.$i.'" name="cuanto'.$i.'" '.$requerido.'></p>
                                    </div>
                                    <div class="w3-col m2 w3-white w3-center">
                                        <p class="text-cuestion">4. Especifica</p>
                                        <p><input class="w3-input w3-border" maxlength="25" type="text" placeholder="Ej. Vacantes operativos" id="especifica'.$i.'" name="especifica'.$i.'" data-parsley-pattern="^[a-zA-Z ]+$" '.$requerido.'></p>
                                    </div>
                                    <div class="w3-col m2 w3-white w3-center">
                                        <p class="text-cuestion">5. Periodo</p>
                                        <p><input class="w3-input w3-border" maxlength="25" type="text" placeholder="Ej. Semestral" id="periodo'.$i.'" name="periodo'.$i.'" data-parsley-pattern="^[a-zA-Z ]+$" '.$requerido.'></p>
                                    </div>
                                </div>
                                <div class="w3-row">
                                    <div class="w3-col m12 w3-white w3-center">
                                        <p class="text-oc">Objetivo Completo</p>
                                        <p><textarea class="w3-input w3-border" maxlength="200" rows="4" cols="50" type="text" id="objetivocompleto'.$i.'" name="objetivocompleto'.$i.'" '.$requeridotext.'></textarea></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="w3-col m6 w3-white w3-center">
                                        <p class="text-cuestion"></p>
                                        <p class="w3-input" style="background-color: #ffffff; border-bottom: 1px solid #ffff;"><br></p>
                                    </div>
                                    <div class="w3-col m2 w3-white w3-center">
                                        <p class="text-cuestion">Fecha inicial</p>
                                        <p><input class="w3-input w3-border" type="date" id="fechainicio'.$i.'" name="fechainicio'.$i.'"></p>
                                    </div>
                                    <div class="w3-col m2 w3-white w3-center">
                                        <p class="text-cuestion">Fecha final</p>
                                        <p><input class="w3-input w3-border" type="date" id="fechafinal'.$i.'" name="fechafinal'.$i.'"></p>
                                    </div>
                                    <div class="w3-col m2 w3-white w3-center">
                                        <p class="text-cuestion">Valor del objetivo sobre 100</p>
                                        <p><input class="w3-input w3-border" type="text" id="valorobjetivo'.$i.'" name="valorobjetivo'.$i.'" data-parsley-type="number" '.$requerido.'></p>
                                    </div>
                                </div>
                            </div>';

        
    }
    $establecimiento .='<button type="button" id="BTNvalida" class="button">Registrar Objetivos</button><input type="submit" id="btnEnviar" name="btnEnviar" style="display: none;" value="Enviar formulario"></form>';
}else{
  foreach($resultcontrol as $valuecontrol){

    $cont=$valuecontrol->contador;
    $establecimiento .='<div id="establecimientoobj" data-parsley-validate=""><div id="establecimientoobjetivos'.$cont.'">
                            <div class="w3-row">
                                    <div class="w3-col l8 w3-dark-grey">
                                        <p>Breve descripción del objetivo '.$cont.'</p>
                                    </div>
                                    <div class="w3-col l2">
                                        <p></p>
                                    </div>
                                    <div class="w3-col l2">
                                        <p></p>
                                    </div>
                            </div>
                            <div class="w3-row">
                                <input type="hidden" id="userid'.$i.'" name="userid'.$i.'" value="'.$USER->id.'" '.$requerido.'>
                                <input type="hidden" id="courseid'.$i.'" name="courseid'.$i.'" value="'.$courseid.'" '.$requerido.'>
                                <input type="hidden" id="idobjetivo'.$i.'" name="idobjetivo'.$i.'" value="'.$id.'" '.$requerido.'>
                                <div class="w3-col m2 w3-white w3-center">
                                    <p class="text-cuestion">Indica el # de objetivo de tu jefe inmediato al que estará ligado tu objetivo</p>
                                    <!--<p><input  class="w3-input w3-border" type="text"></p>-->
                                    <p>'.$valuecontrol->targetnumber.'</p>
                                </div>
                                <div class="w3-col m2 w3-white w3-center">
                                    <p class="text-cuestion">1. ¿Qué se quiere medir?</p>
                                    <p>'.$valuecontrol->whatquestion.'</p>
                                </div>
                                <div class="w3-col m2 w3-white w3-center">
                                    <p class="text-cuestion">2. ¿Cómo se quiere medir?</p>
                                    <p>'.$valuecontrol->howquestion.'</p>
                                </div>
                                <div class="w3-col m2 w3-white w3-center">
                                    <p class="text-cuestion">3. ¿Cuánto quieres que mida?</p>
                                    <p>'.$valuecontrol->thatquestion.'</p>
                                </div>
                                <div class="w3-col m2 w3-white w3-center">
                                    <p class="text-cuestion">4. ¿Cómo se quiere medir?</p>
                                    <p>'.$valuecontrol->specifyquestion.'</p>
                                </div>
                                <div class="w3-col m2 w3-white w3-center">
                                    <p class="text-cuestion">5. ¿Cuánto quieres que mida?</p>
                                    <p>'.$valuecontrol->periodquestion.'</p>
                                </div>
                            </div>
                            <div class="w3-row">
                                <div class="w3-col m12 w3-white w3-center">
                                    <p class="text-oc">Objetivo Completo</p>
                                    <p>'.$valuecontrol->objectivecomplete.'</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="w3-col m6 w3-white w3-center">
                                    <p class="text-cuestion"></p>
                                    <p class="w3-input" style="background-color: #ffffff; border-bottom: 1px solid #ffff;"><br></p>
                                </div>
                                <div class="w3-col m2 w3-white w3-center">
                                    <p class="text-cuestion">Fecha inicial</p>
                                    <p>'.$valuecontrol->fechaini.'</p>
                                </div>
                                <div class="w3-col m2 w3-white w3-center">
                                    <p class="text-cuestion">Fecha final</p>
                                    <p>'.$valuecontrol->fechafin.'</p>
                                </div>
                                <div class="w3-col m2 w3-white w3-center">
                                    <p class="text-cuestion">Valor del objetivo sobre 100</p>
                                    <p>'.$valuecontrol->valueobjective.'%</p>
                                </div>
                            </div>
                        </div>
                        </div>';
    
  }
    

}
$envio .='<hr><p id="respuesta"></p> <!-- ESTABLECIMIENTO DE OBJETIVOS 6--></div><div class="w3-col l1"><p></p></div></div></div></div></div><div class="espacio"></div>';
           
$competencias1 .='<div class="w3-container">
                    <div class="w3-row">
                        <div class="w3-col l1">
                            <p></p>
                        </div>
                        <div class="w3-col l10">
                            <div class="w3-container">
                ';
$colaboradortemp.='<div class="w3-row">
                            <div class="w3-round-xlarge w3-col l3 w3-pale-red w3-center">
                            <p>2a.Parte</p>
                            </div>
                            <div class="w3-round-xlarge w3-col l9 w3-dark-grey w3-center">
                                <p>Evaluación de competencias</p>
                            </div>
                    </div>';
$jefetemp.='<div class="w3-row">
                <div class="w3-round-xlarge w3-col l12 w3-dark-grey w3-center">
                    <p>Si eres Gestor de Personal, se te evaluarán las siguientes competencias de liderazgo.</p>
                </div>
            </div>';
$director.='<div class="w3-row">
                <div class="w3-round-xlarge w3-col l12 w3-dark-grey w3-center">
                    <p>Si eres Director, la siguiente competencia también será evaluada.</p>
                </div>
            </div>';
$competencias2 .=' </div>
                        </div>
                        </div>
                        <div class="w3-col l1">
                            <p></p>
                        </div>
                    </div>
                </div></div><!-- </div></div></div> div final-->';
echo $vista;
echo $vistajefeinmediato;
echo '</div><div class="espacio"></div><div id="objetivos-jefe" class="w3-container">';
echo $vistajefeinmediato2;
echo $vistaobjetivosjefe;
echo $vistajefeinmediato3;
echo '<div class="espacio"></div><div class="w3-container"><div class="w3-row"><div class="w3-col l1"><p></p></div><div class="w3-col l10 w3-center"><div class="w3-container">
        <div class="w3-row">
            <div class="w3-round-xxlarge w3-col l8  w3-pale-red">
                <p>Objetivos</p>
            </div>
            <div class="w3-round-xlarge w3-col l2  w3-pale-red">
                <p>Fecha compromiso</p>
            </div>
            <div class="w3-round-xlarge w3-col l2  w3-pale-red">
                <p>Peso anual en %</p>
            </div>';

echo $establecimiento;
echo $envio;
echo $competencias1;

if($rolprincipal=='COLABORADOR'){

    $sql='select obc.id as idcompe, c.id as idcourse , o.name as nestablecimiento, obn.namenivel, obc.orden ,obc.name as nombrecompetencia ,obn.id as categoria
    from mdl_course c
    inner join mdl_objective o on o.course = c.id
    inner join mdl_objective_competition obc on obc.idinstance = o.id
    inner join mdl_objective_nivel obn on obn.id = obc.idnivel
    where c.id=?
    and obn.id=3
    order by obc.idnivel asc ;';
    $resultados = $DB->get_records_sql($sql, array($courseid));

    echo $colaboradortemp;
    foreach($resultados as $valores){

        echo '<div class="espacio"></div>
        <div class="w3-row">
            <div class="w3-round-xlarge w3-col l3  w3-pale-red w3-center">
                <p>Competencias</p>
            </div>
            <div class="w3-round-xlarge w3-col l9  w3-pale-red w3-center">
                <p>Comportamientos</p>
            </div>
        </div>
        <div class="w3-row">
            <div class="w3-round-xlarge w3-col l3  w3-dark-grey w3-center">
                <p>Definición de competencias</p>
            </div>
            <div class="w3-round-xlarge w3-col l9  w3-dark-grey w3-center">
                <p>Comportamientos asociados a la competencia</p>
            </div>
        </div>';

        echo '<div class="w3-row">
        <div class="w3-col l3">
            <p>'.$valores->nombrecompetencia.'</p>
        </div>';

    
        $consulta='select ocb.id, ocb.description, ocb.idcompetition 
        from mdl_objective_competition_behavior ocb 
        inner join mdl_objective_competition oc on oc.id=ocb.idcompetition
        where ocb.idcompetition=? and ocb.code=1';
        $resultado = $DB->get_records_sql($consulta, array($valores->idcompe));

        //print_r($resultado);
        echo '<div class="w3-col l9">
                        <table class="w3-table-all">';
       foreach($resultado as $comportamiento){
        $idcomportamiento=$comportamiento->id;
                echo'<tr>
                    <td>'.$comportamiento->description.'</td>
                </tr>';
            
         
        }
        echo '</table></div>';
        echo'</div><div class="espacio"></div>';
    
    }


   

}else if($rolprincipal=='JEFE INMEDIATO'){

    $sql='select  obc.id as idcompe, c.id as idcourse , o.name as nestablecimiento, obn.namenivel, obc.orden ,obc.name as nombrecompetencia ,obn.id as categoria
    from mdl_course c
    inner join mdl_objective o on o.course = c.id
    inner join mdl_objective_competition obc on obc.idinstance = o.id
    inner join mdl_objective_nivel obn on obn.id = obc.idnivel
    where c.id=?
    and obn.id=3
    order by obc.idnivel asc';
    $resultados = $DB->get_records_sql($sql, array($courseid));

    echo $colaboradortemp;
    foreach($resultados as $valores){

        echo '<div class="espacio"></div>
        <div class="w3-row">
            <div class="w3-round-xlarge w3-col l3  w3-pale-red w3-center">
                <p>Competencias</p>
            </div>
            <div class="w3-round-xlarge w3-col l9  w3-pale-red w3-center">
                <p>Comportamientos</p>
            </div>
        </div>
        <div class="w3-row">
            <div class="w3-round-xlarge w3-col l3  w3-dark-grey w3-center">
                <p>Definición de competencias</p>
            </div>
            <div class="w3-round-xlarge w3-col l9  w3-dark-grey w3-center">
                <p>Comportamientos asociados a la competencia</p>
            </div>
        </div>';

        echo '<div class="w3-row">
        <div class="w3-col l3">
            <p>'.$valores->nombrecompetencia.'</p>
        </div>';

    
        $consulta='select ocb.id, ocb.description, ocb.idcompetition 
        from mdl_objective_competition_behavior ocb 
        inner join mdl_objective_competition oc on oc.id=ocb.idcompetition
        where ocb.idcompetition=? and ocb.code=1';
        $resultado = $DB->get_records_sql($consulta, array($valores->idcompe));

        //print_r($resultado);
        echo '<div class="w3-col l9">
                        <table class="w3-table-all">';
       foreach($resultado as $comportamiento){
        // $idcomportamiento=$comportamiento->id;
                echo'<tr>
                    <td>'.$comportamiento->description.'</td>
                </tr>';
            
         
        }
        echo '</table></div>';
        echo'</div><div class="espacio"></div>';
    
    }
  
    $sql2='select  obc.id as idcompe, c.id as idcourse , o.name as nestablecimiento, obn.namenivel, obc.orden ,obc.name as nombrecompetencia ,obn.id as categoria
    from mdl_course c
    inner join mdl_objective o on o.course = c.id
    inner join mdl_objective_competition obc on obc.idinstance = o.id
    inner join mdl_objective_nivel obn on obn.id = obc.idnivel
    where c.id=?
    and obn.id=2
    order by obc.idnivel asc';
    $resultados2 = $DB->get_records_sql($sql2, array($courseid));
    echo $jefetemp;
   foreach($resultados2 as $valores2){

        echo '<div class="espacio"></div>
                <div class="w3-row">
                    <div class="w3-round-xlarge w3-col l3  w3-pale-red w3-center">
                        <p>Competencias</p>
                    </div>
                    <div class="w3-round-xlarge w3-col l9  w3-pale-red w3-center">
                        <p>Comportamientos</p>
                    </div>
                </div>
                <div class="w3-row">
                    <div class="w3-round-xlarge w3-col l3  w3-dark-grey w3-center">
                        <p>Definición de competencias</p>
                    </div>
                    <div class="w3-round-xlarge w3-col l9  w3-dark-grey w3-center">
                        <p>Comportamientos asociados a la competencia</p>
                    </div>
                </div>';

        echo '<div class="w3-row">
                <div class="w3-col l3">
                    <p>'.$valores2->nombrecompetencia.'</p>
                </div>';

    
        $consulta2='select ocb.id, ocb.description, ocb.idcompetition 
        from mdl_objective_competition_behavior ocb 
        inner join mdl_objective_competition oc on oc.id=ocb.idcompetition
        where ocb.idcompetition=? and ocb.code=1';
        $resultado2 = $DB->get_records_sql($consulta2, array($valores2->idcompe));

       // print_r($resultado2);
        echo '<div class="w3-col l9">
                        <table class="w3-table-all">';
       foreach($resultado2 as $comportamients){
        //$idcomportamiento2=$comportamiento2->id;
                echo'<tr>
                         <td>'.$comportamients->description.'</td>
                     </tr>';
            
         
        }
        echo '</table></div>';
        echo'</div><div class="espacio"></div>';
    
    }
    


}else if($rolprincipal=='DIRECTOR'){

    $sql='select  obc.id as idcompe, c.id as idcourse , o.name as nestablecimiento, obn.namenivel, obc.orden ,obc.name as nombrecompetencia ,obn.id as categoria
    from mdl_course c
    inner join mdl_objective o on o.course = c.id
    inner join mdl_objective_competition obc on obc.idinstance = o.id
    inner join mdl_objective_nivel obn on obn.id = obc.idnivel
    where c.id=?
    and obn.id=3
    order by obc.idnivel asc';
    $resultados = $DB->get_records_sql($sql, array($courseid));

    echo $colaboradortemp;
    foreach($resultados as $valores){

        echo '<div class="espacio"></div>
        <div class="w3-row">
            <div class="w3-round-xlarge w3-col l3  w3-pale-red w3-center">
                <p>Competencias</p>
            </div>
            <div class="w3-round-xlarge w3-col l9  w3-pale-red w3-center">
                <p>Comportamientos</p>
            </div>
        </div>
        <div class="w3-row">
            <div class="w3-round-xlarge w3-col l3  w3-dark-grey w3-center">
                <p>Definición de competencias</p>
            </div>
            <div class="w3-round-xlarge w3-col l9  w3-dark-grey w3-center">
                <p>Comportamientos asociados a la competencia</p>
            </div>
        </div>';

        echo '<div class="w3-row">
                    <div class="w3-col l3">
                        <p>'.$valores->nombrecompetencia.'</p>
                    </div>';

    
        $consulta='select ocb.id, ocb.description, ocb.idcompetition 
        from mdl_objective_competition_behavior ocb 
        inner join mdl_objective_competition oc on oc.id=ocb.idcompetition
        where ocb.idcompetition=? and ocb.code=1';
        $resultado = $DB->get_records_sql($consulta, array($valores->idcompe));

        //print_r($resultado);
        echo '<div class="w3-col l9">
                        <table class="w3-table-all">';
       foreach($resultado as $comportamiento){
        // $idcomportamiento=$comportamiento->id;
                echo'<tr>
                        <td>'.$comportamiento->description.'</td>
                    </tr>';
            
         
        }
        echo '</table></div>';
        echo'</div><div class="espacio"></div>';
    
    }
  
    $sql2='select  obc.id as idcompe, c.id as idcourse , o.name as nestablecimiento, obn.namenivel, obc.orden ,obc.name as nombrecompetencia ,obn.id as categoria
    from mdl_course c
    inner join mdl_objective o on o.course = c.id
    inner join mdl_objective_competition obc on obc.idinstance = o.id
    inner join mdl_objective_nivel obn on obn.id = obc.idnivel
    where c.id=?
    and obn.id=2
    order by obc.idnivel asc';
    $resultados2 = $DB->get_records_sql($sql2, array($courseid));
    echo $jefetemp;
    foreach($resultados2 as $valores2){

        echo '<div class="espacio"></div>
                    <div class="w3-row">
                        <div class="w3-round-xlarge w3-col l3  w3-pale-red w3-center">
                            <p>Competencias</p>
                        </div>
                        <div class="w3-round-xlarge w3-col l9  w3-pale-red w3-center">
                            <p>Comportamientos</p>
                        </div>
                    </div>
                    <div class="w3-row">
                        <div class="w3-round-xlarge w3-col l3  w3-dark-grey w3-center">
                            <p>Definición de competencias</p>
                        </div>
                        <div class="w3-round-xlarge w3-col l9  w3-dark-grey w3-center">
                            <p>Comportamientos asociados a la competencia</p>
                        </div>
                    </div>';

        echo '<div class="w3-row">
                <div class="w3-col l3">
                    <p>'.$valores2->nombrecompetencia.'</p>
                </div>';

    
        $consulta2='select ocb.id, ocb.description, ocb.idcompetition 
        from mdl_objective_competition_behavior ocb 
        inner join mdl_objective_competition oc on oc.id=ocb.idcompetition
        where ocb.idcompetition=? and ocb.code=1';
        $resultado2 = $DB->get_records_sql($consulta2, array($valores2->idcompe));

       // print_r($resultado2);
        echo '<div class="w3-col l9">
                        <table class="w3-table-all">';
       foreach($resultado2 as $comportamients){
        //$idcomportamiento2=$comportamiento2->id;
                        echo'<tr>
                                <td>'.$comportamients->description.'</td>
                            </tr>';
            
         
        }
        echo '</table></div>';
        echo'</div><div class="espacio"></div>';
    
    }
    $sql3='select  obc.id as idcompe, c.id as idcourse , o.name as nestablecimiento, obn.namenivel, obc.orden ,obc.name as nombrecompetencia ,obn.id as categoria
    from mdl_course c
    inner join mdl_objective o on o.course = c.id
    inner join mdl_objective_competition obc on obc.idinstance = o.id
    inner join mdl_objective_nivel obn on obn.id = obc.idnivel
    where c.id=?
    and obn.id=1
    order by obc.idnivel asc';
    $resultados3 = $DB->get_records_sql($sql3, array($courseid));
    echo $director;
    foreach($resultados3 as $valores3){

        echo '<div class="espacio"></div>
                    <div class="w3-row">
                        <div class="w3-round-xlarge w3-col l3  w3-pale-red w3-center">
                            <p>Competencias</p>
                        </div>
                        <div class="w3-round-xlarge w3-col l9  w3-pale-red w3-center">
                            <p>Comportamientos</p>
                        </div>
                    </div>
                    <div class="w3-row">
                        <div class="w3-round-xlarge w3-col l3  w3-dark-grey w3-center">
                            <p>Definición de competencias</p>
                        </div>
                        <div class="w3-round-xlarge w3-col l9  w3-dark-grey w3-center">
                            <p>Comportamientos asociados a la competencia</p>
                        </div>
                    </div>';

        echo '<div class="w3-row">
                    <div class="w3-col l3">
                        <p>'.$valores3->nombrecompetencia.'</p>
                    </div>';
        $consulta3='select ocb.id, ocb.description, ocb.idcompetition 
        from mdl_objective_competition_behavior ocb 
        inner join mdl_objective_competition oc on oc.id=ocb.idcompetition
        where ocb.idcompetition=? and ocb.code=1';
        $resultado3 = $DB->get_records_sql($consulta3, array($valores3->idcompe));

       // print_r($resultado2);
        echo '<div class="w3-col l9">
                        <table class="w3-table-all">';
       foreach($resultado3 as $comportamients2){
        //$idcomportamiento2=$comportamiento2->id;
                echo'<tr>
                         <td>'.$comportamients2->description.'</td>
                     </tr>';
            
         
        }
        echo '</table></div>';
        echo'</div><div class="espacio"></div>';
    
    }

}else{

}

echo $competencias2;
/*Vista 2 */
if($estatusa==1 || $estatusa==2){
    if($rolprincipal=='COLABORADOR'|| $rolprincipal=='JEFE INMEDIATO'){

            /* INICIA VISTA 2*/
        $vistarevision .='<div id="vista2" class="w3-light-grey vistas" style="display: none;">
                            <div class="w3-container">
                                <div class="w3-row">
                                    <div class="w3-col l2">
                                        <p></p>
                                    </div>
                                    <div class="w3-col l8">
                                        <h3 class="w3-center  w3-animate-top">Establecimiento de objetivos</h3>
                                        <p class="w3-animate-opacity">La siguiente evaluación tiene como objetivo analizar, evaluar y comparar los resultados del desempeño de los colaboradores y su acercamiento a las competencias organizacionales. Estos resultados serán parte fundamental para diseñar
                                            programas de capacitación y desarrollo.</p>
                                    </div>
                                    <div class="w3-col l2">
                                        <p></p>
                                    </div>
                                </div>
                                <div class="w3-row">
                                    <div class="w3-col l4">
                                        <p></p>
                                    </div>
                                    <div class="w3-col l4">
                                        <p></p>
                                    </div>
                                    <div class="w3-col l4">
                                    <input type="date" class="form-control"  value="'.$fechaestablecimiento.'"  disabled="yes">
                                        <!--<p>Fecha de establecimiento:<input type="text"></p>-->
                                        <!--<p>Fecha de establecimiento: <input type="text" id="datepicker"></p>-->
                                    </div>
                                </div>
                            </div>
                            <div class="espacio"></div>
                            <div class="w3-container">
                                <div class="w3-row">
                                    <div class="w3-col l1">
                                        <p></p>
                                    </div>
                                    <div class="w3-round-xxlarge w3-col l5 w3-pale-red w3-center">
                                        <p>1a. Parte</p>
                                    </div>
                                    <div class="w3-round-xxlarge w3-col l5 w3-dark-grey w3-center">
                                        <p>Objetivos del puesto de trabajo</p>
                                    </div>
                                    <div class="w3-col l1">
                                        <p></p>
                                    </div>
                                </div>
                                <div class="w3-row">
                                    <div class="w3-col l1">
                                        <p></p>
                                    </div>
                                    <div class="w3-col l10 w3-center">
                                        <p>Este apartado está estrechamente ligado con el rubro de objetivos del puesto de trabajo; con esta evaluación conoceremos en qué medida se logran.</p>
                                    </div>
                                    <div class="w3-col l1">
                                        <p></p>
                                    </div>
                                </div>';
        echo $vistarevision;
      //  echo $vistajefeinmediato;
        echo '</div><div class="espacio"></div><div id="objetivos-jefe" class="w3-container">';
        ?>
        <div class="espacio"></div><div class="w3-container"><div class="w3-row"><div class="w3-col l1"><p></p></div><div class="w3-col l10 w3-center"><div class="w3-container">
        <div class="w3-row">
        <div class="w3-round-xxlarge w3-col l8  w3-pale-red">
        <p>Objetivos</p>
        </div>
        <div class="w3-round-xlarge w3-col l2  w3-pale-red">
        <p>Fecha compromiso</p>
        </div>
        <div class="w3-round-xlarge w3-col l2  w3-pale-red">
        <p>Peso anual en %</p>
        </div>
                
        <?php
        echo '<form id="revisionobj" method="POST" action="enviorevision.php" data-parsley-validate="">';
        $requeridcolaborador='required=""';
        foreach($resultcontrol as $valuecontrol){

        $cont=$valuecontrol->contador;
        $actionp=$valuecontrol->actionp;
        $establecimientorevision .='<div id="revisionobjetivos'.$cont.'">
        <div class="w3-row">
            <div class="w3-col l8 w3-dark-grey">
                <p>Breve descripción del objetivo '.$cont.'</p>
            </div>
            <div class="w3-col l2">
                <p></p>
            </div>
            <div class="w3-col l2">
                <p></p>
            </div>
        </div>
        <div class="w3-row">
            <input type="hidden" id="id'.$cont.'" name="idobjestablecido'.$cont.'" value="'.$valuecontrol->id.'" '.$requeridcolaborador.'>
            <input type="hidden" id="userid'.$cont.'" name="userid'.$cont.'" value="'.$USER->id.'" '.$requeridcolaborador.'>
            <input type="hidden" id="courseid'.$cont.'" name="courseid'.$cont.'" value="'.$courseid.'" '.$requeridcolaborador.'>
            <input type="hidden" id="idobjetivo'.$cont.'" name="idobjetivo'.$cont.'" value="'.$id.'" '.$requeridcolaborador.'>
            <div class="w3-col m2 w3-white w3-center">
                <p class="text-cuestion">Indica el # de objetivo de tu jefe inmediato al que estará ligado tu objetivo</p>
            <!--<p><input  class="w3-input w3-border" type="text"></p>-->
                <p>'.$valuecontrol->targetnumber.'</p>
            </div>
            <div class="w3-col m2 w3-white w3-center">
                <p class="text-cuestion">1. ¿Qué se quiere medir?</p>
                <p>'.$valuecontrol->whatquestion.'</p>
            </div>
            <div class="w3-col m2 w3-white w3-center">
                <p class="text-cuestion">2. ¿Cómo se quiere medir?</p>
                <p>'.$valuecontrol->howquestion.'</p>
            </div>
            <div class="w3-col m2 w3-white w3-center">
                <p class="text-cuestion">3. ¿Cuánto quieres que mida?</p>
                <p>'.$valuecontrol->thatquestion.'</p>
            </div>
            <div class="w3-col m2 w3-white w3-center">
                <p class="text-cuestion">4. ¿Cómo se quiere medir?</p>
                <p>'.$valuecontrol->specifyquestion.'</p>
            </div>
            <div class="w3-col m2 w3-white w3-center">
                <p class="text-cuestion">5. ¿Cuánto quieres que mida?</p>
                <p>'.$valuecontrol->periodquestion.'</p>
            </div>
        </div>
        <div class="w3-row">
            <div class="w3-col m12 w3-white w3-center">
                <p class="text-oc">Objetivo Completo</p>
                <p>'.$valuecontrol->objectivecomplete.'</p>
            </div>
        </div>
        <div class="row">
            <div class="w3-col m6 w3-white w3-center">
                <p class="text-cuestion" style="height: 33px;"></p>
                <p class="w3-input" style="background-color: #ffffff; border-bottom: 1px solid #ffff;"><br></p>
            </div>
            <div class="w3-col m2 w3-white w3-center">
                <p class="text-cuestion">Fecha inicial</p>
                <p>'.$valuecontrol->fechaini.'</p>
            </div>
            <div class="w3-col m2 w3-white w3-center">
                <p class="text-cuestion">Fecha final</p>
                <p>'.$valuecontrol->fechafin.'</p>
            </div>
            <div class="w3-col m2 w3-white w3-center">
                <p class="text-cuestion">Valor del objetivo sobre 100</p>
                <p>'.$valuecontrol->valueobjective.'%</p>
            </div>
        </div><!--aqui empieza-->
        <div class="w3-row">
            <div class="w3-col m5 w3-white w3-center">
                <div class="w3-row">
                    <div class="w3-col m6 w3-white w3-center">
                        <p class="text-cuestion">Qué acciones he implementado:</p>';
                        if(empty($actionp)){
                            $establecimientorevision .='<p><textarea class="w3-input w3-border" rows="1" cols="10" type="text" id="racciones'.$cont.'" name="racciones'.$cont.'" '.$requeridcolaborador.'></textarea></p>';
                        }else{
                            $establecimientorevision .='<p class="w3-input w3-border">'.$actionp.'</p>';
                        }
                        $establecimientorevision .='</div>
                    <div class="w3-col m6 w3-white w3-center">
                        <p class="text-cuestion">Acciones para los siguientes 6 meses:</p>';
                        if(empty($valuecontrol->actions)){
                            $establecimientorevision .='<p><textarea class="w3-input w3-border" rows="1" cols="10" type="text" id="rmeses'.$cont.'" name="rmeses'.$cont.'" '.$requeridcolaborador.'></textarea></p>';
                        }else{
                            $establecimientorevision .='<p class="w3-input w3-border">'.$valuecontrol->actions.'</p>';
                        }
                        
                        $establecimientorevision .='</div>
                </div>
            </div>
            <div class="w3-col m2 w3-white w3-center">
                <p class="text-cuestion" style="height: 68px;">Retroalimentación de mi jefe: </p>
                <p class="text-cuestion"><br></p>
            </div>
            <div class="w3-col m5 w3-white w3-center">
            <div class="w3-row">
            <div class="w3-col m6 w3-white w3-center">
                <p class="text-cuestion">Cometarios sobre acciones ya implementadas:</p>';
                if(empty($valuecontrol->bossc)){
                    $establecimientorevision .='<p class="w3-input w3-border"></p>';
                }else{
                    $establecimientorevision .='<p class="w3-input w3-border">'.$valuecontrol->bossc.'</p>';
                }
                $establecimientorevision .='</div>
            <div class="w3-col m6 w3-white w3-center">
                <p class="text-cuestion">Sugerencias sobre acciones a implementar:</p>';
                if(empty($valuecontrol->bosss)){
                    $establecimientorevision .='<p class="w3-input w3-border"></p>';
                }else{
                    $establecimientorevision .='<p class="w3-input w3-border">'.$valuecontrol->bosss.'</p>';
                }
                $establecimientorevision .='</div>
            </div>
            </div>
        </div>
        </div>';

        }

        if(empty($actionp)){
        $enviorevision .='<input type="submit" id="btnRevisar" name="btnRevisar"  value="Enviar">';
        }else{
        $enviorevision .='<br>';
        }
        $enviorevision .='
        </form>
        <hr><p id="rev"></p> <!-- ESTABLECIMIENTO DE OBJETIVOS 6-->
        </div>
        <div class="w3-col l1"><p></p></div>
        </div>
        </div>
        </div>
        </div>
        <div class="espacio"></div>
        </div><!-- Finaliza objetivos id-->';

        echo $establecimientorevision;
        echo $enviorevision;
        ?>
        <!--<form id="idcompetencias" method="POST" action="enviocompetencias.php">-->
        <div class="w3-container">
        <div class="w3-row">
        <div class="w3-col l1">
        <p></p>
        </div>
        <div class="w3-col l10">
        <div class="w3-container">
        <?php

        if($rolprincipal=='COLABORADOR'){

            $sql='select  obc.id as idcompe, c.id as idcourse , o.name as nestablecimiento, obn.namenivel, obc.orden ,obc.name as nombrecompetencia ,obn.id as categoria
            from mdl_course c
            inner join mdl_objective o on o.course = c.id
            inner join mdl_objective_competition obc on obc.idinstance = o.id
            inner join mdl_objective_nivel obn on obn.id = obc.idnivel
            where c.id=?
            and obn.id=3
            order by obc.idnivel asc';
            $resultados = $DB->get_records_sql($sql, array($courseid));

            echo $colaboradortemp;
            foreach($resultados as $valores){

            echo '<div class="espacio"></div>
            <div class="w3-row">
            <div class="w3-round-xlarge w3-col l3  w3-pale-red w3-center">
            <p>Competencias</p>
            </div>
            <div class="w3-round-xlarge w3-col l9  w3-pale-red w3-center">
            <p>Comportamientos</p>
            </div>
            </div>
            <div class="w3-row">
            <div class="w3-round-xlarge w3-col l3  w3-dark-grey w3-center">
            <p>Definición de competencias</p>
            </div>
            <div class="w3-round-xlarge w3-col l9  w3-dark-grey w3-center">
            <p>Comportamientos asociados a la competencia</p>
            </div>
            </div>';

            echo '<div class="w3-row">
            <div class="w3-col l3">
            <p>'.$valores->nombrecompetencia.'</p>
            </div>';



            $valorconsulta='select ocb.id, ocb.description, oc.id as idcompetencia, oc.courseid, oc.idinstance ,ocb.code, oec.value
            from mdl_objective_competition_behavior ocb 
            inner join mdl_objective_competition oc on oc.id=ocb.idcompetition 
            inner join mdl_objective_establishment_competition oec on oec.idbehavior = ocb.id
            where ocb.idcompetition=? and oec.idobjectiveestablishment=? and ocb.status=0 order by ocb.code asc';
            $valorresultado = $DB->get_records_sql($valorconsulta, array($valores->idcompe, $id));

            //print_r($resultado);
            echo '<div class="w3-col l9">
            <table class="w3-table-all">';
            foreach($valorresultado as $comportamientofinal){
            // $idcomportamiento=$comportamiento->id;
            if($comportamientofinal->code==1){
                echo'<tr><td>'.$comportamientofinal->description.'</td>';
                echo'<td>';
                ?>
                            <input type="radio" id="valores<?php echo $comportamientofinal->id; ?>" name="valores[<?php echo $comportamientofinal->id; ?>][valor]" value="4" <?php if (!(strcmp(4, htmlentities($comportamientofinal->value, ENT_COMPAT, 'utf-8')))) {echo "checked";} ?> disabled><label for="valores<?php echo $comportamientofinal->id;?>">4</label>
                            <input type="radio" id="valores<?php echo $comportamientofinal->id; ?>" name="valores[<?php echo $comportamientofinal->id; ?>][valor]" value="3" <?php if (!(strcmp(3, htmlentities($comportamientofinal->value, ENT_COMPAT, 'utf-8')))) {echo "checked";} ?> disabled><label for="valores<?php echo $comportamientofinal->id;?>">3</label>
                            <input type="radio" id="valores<?php echo $comportamientofinal->id; ?>" name="valores[<?php echo $comportamientofinal->id; ?>][valor]" value="2" <?php if (!(strcmp(2, htmlentities($comportamientofinal->value, ENT_COMPAT, 'utf-8')))) {echo "checked";} ?> disabled><label for="valores<?php echo $comportamientofinal->id;?>">2</label>
                            <input type="radio" id="valores<?php echo $comportamientofinal->id; ?>" name="valores[<?php echo $comportamientofinal->id; ?>][valor]" value="1" <?php if (!(strcmp(1, htmlentities($comportamientofinal->value, ENT_COMPAT, 'utf-8')))) {echo "checked";} ?> disabled><label for="valores<?php echo $comportamientofinal->id;?>">1</label>
                <?php
                echo'</td></tr>';

                }else if ($comportamientofinal->code==2){
                    echo'<tr><td>'.$comportamientofinal->description.'</td>';
                    echo'<td><p class="w3-input w3-border" type="text" id="valores'.$comportamientofinal->id.'" name="valores['.$comportamientofinal->id.'][valor]" >'.$comportamientofinal->value.'</p></td>';
                    echo'</tr>';
                }else if($comportamientofinal->code==3){
                    echo'<tr><td>'.$comportamientofinal->description.'</td></tr>';
                    echo'<tr><td><p class="w3-input w3-border" rows="4" cols="50"  id="valores'.$comportamientofinal->id.'" name="valores['.$comportamientofinal->id.'][valor]">'.$comportamientofinal->value.'</p></td>';
                    echo'</tr>';
                }else{

                }


            }
            echo '</table></div>';
            echo'</div><div class="espacio"></div>';

            }




        }else if($rolprincipal=='JEFE INMEDIATO'){

                $sql='select  obc.id as idcompe, c.id as idcourse , o.name as nestablecimiento, obn.namenivel, obc.orden ,obc.name as nombrecompetencia ,obn.id as categoria
                from mdl_course c
                inner join mdl_objective o on o.course = c.id
                inner join mdl_objective_competition obc on obc.idinstance = o.id
                inner join mdl_objective_nivel obn on obn.id = obc.idnivel
                where c.id=?
                and obn.id=3
                order by obc.idnivel asc';
                $resultados = $DB->get_records_sql($sql, array($courseid));

                echo $colaboradortemp;
                foreach($resultados as $valores){

                echo '<div class="espacio"></div>
                <div class="w3-row">
                <div class="w3-round-xlarge w3-col l3  w3-pale-red w3-center">
                <p>Competencias</p>
                </div>
                <div class="w3-round-xlarge w3-col l9  w3-pale-red w3-center">
                <p>Comportamientos</p>
                </div>
                </div>
                <div class="w3-row">
                <div class="w3-round-xlarge w3-col l3  w3-dark-grey w3-center">
                <p>Definición de competencias</p>
                </div>
                <div class="w3-round-xlarge w3-col l9  w3-dark-grey w3-center">
                <p>Comportamientos asociados a la competencia</p>
                </div>
                </div>';

                echo '<div class="w3-row">
                <div class="w3-col l3">
                <p>'.$valores->nombrecompetencia.'</p>
                </div>';



                $valorconsulta='select ocb.id, ocb.description, oc.id as idcompetencia, oc.courseid, oc.idinstance ,ocb.code, oec.value
                from mdl_objective_competition_behavior ocb 
                inner join mdl_objective_competition oc on oc.id=ocb.idcompetition 
                inner join mdl_objective_establishment_competition oec on oec.idbehavior = ocb.id
                where ocb.idcompetition=? and oec.idobjectiveestablishment=? and ocb.status=0 order by ocb.code asc';
                $valorresultado = $DB->get_records_sql($valorconsulta, array($valores->idcompe, $id));

                //print_r($resultado);
                echo '<div class="w3-col l9">
                <table class="w3-table-all">';
                foreach($valorresultado as $comportamientofinal){
                // $idcomportamiento=$comportamiento->id;
                if($comportamientofinal->code==1){
                    echo'<tr><td>'.$comportamientofinal->description.'</td>';
                    echo'<td>';
                    ?>
                                <input type="radio" id="valores<?php echo $comportamientofinal->id; ?>" name="valores[<?php echo $comportamientofinal->id; ?>][valor]" value="4" <?php if (!(strcmp(4, htmlentities($comportamientofinal->value, ENT_COMPAT, 'utf-8')))) {echo "checked";} ?> disabled><label for="valores<?php echo $comportamientofinal->id;?>">4</label>
                                <input type="radio" id="valores<?php echo $comportamientofinal->id; ?>" name="valores[<?php echo $comportamientofinal->id; ?>][valor]" value="3" <?php if (!(strcmp(3, htmlentities($comportamientofinal->value, ENT_COMPAT, 'utf-8')))) {echo "checked";} ?> disabled><label for="valores<?php echo $comportamientofinal->id;?>">3</label>
                                <input type="radio" id="valores<?php echo $comportamientofinal->id; ?>" name="valores[<?php echo $comportamientofinal->id; ?>][valor]" value="2" <?php if (!(strcmp(2, htmlentities($comportamientofinal->value, ENT_COMPAT, 'utf-8')))) {echo "checked";} ?> disabled><label for="valores<?php echo $comportamientofinal->id;?>">2</label>
                                <input type="radio" id="valores<?php echo $comportamientofinal->id; ?>" name="valores[<?php echo $comportamientofinal->id; ?>][valor]" value="1" <?php if (!(strcmp(1, htmlentities($comportamientofinal->value, ENT_COMPAT, 'utf-8')))) {echo "checked";} ?> disabled><label for="valores<?php echo $comportamientofinal->id;?>">1</label>
                    <?php
                    echo'</td></tr>';

                    }else if ($comportamientofinal->code==2){
                        echo'<tr><td>'.$comportamientofinal->description.'</td>';
                        echo'<td><p class="w3-input w3-border" type="text" id="valores'.$comportamientofinal->id.'" name="valores['.$comportamientofinal->id.'][valor]" >'.$comportamientofinal->value.'</p></td>';
                        echo'</tr>';
                    }else if($comportamientofinal->code==3){
                        echo'<tr><td>'.$comportamientofinal->description.'</td></tr>';
                        echo'<tr><td><p class="w3-input w3-border" rows="4" cols="50"  id="valores'.$comportamientofinal->id.'" name="valores['.$comportamientofinal->id.'][valor]">'.$comportamientofinal->value.'</p></td>';
                        echo'</tr>';
                    }else{

                    }


                }
                echo '</table></div>';
                echo'</div><div class="espacio"></div>';

                }

                $sql2='select  obc.id as idcompe, c.id as idcourse , o.name as nestablecimiento, obn.namenivel, obc.orden ,obc.name as nombrecompetencia ,obn.id as categoria
                from mdl_course c
                inner join mdl_objective o on o.course = c.id
                inner join mdl_objective_competition obc on obc.idinstance = o.id
                inner join mdl_objective_nivel obn on obn.id = obc.idnivel
                where c.id=?
                and obn.id=2
                order by obc.idnivel asc';
                $resultados2 = $DB->get_records_sql($sql2, array($courseid));
                echo $jefetemp;
                foreach($resultados2 as $valores2){

                echo '<div class="espacio"></div>
                <div class="w3-row">
                <div class="w3-round-xlarge w3-col l3  w3-pale-red w3-center">
                <p>Competencias</p>
                </div>
                <div class="w3-round-xlarge w3-col l9  w3-pale-red w3-center">
                <p>Comportamientos</p>
                </div>
                </div>
                <div class="w3-row">
                <div class="w3-round-xlarge w3-col l3  w3-dark-grey w3-center">
                <p>Definición de competencias</p>
                </div>
                <div class="w3-round-xlarge w3-col l9  w3-dark-grey w3-center">
                <p>Comportamientos asociados a la competencia</p>
                </div>
                </div>';

                echo '<div class="w3-row">
                <div class="w3-col l3">
                <p>'.$valores2->nombrecompetencia.'</p>
                </div>';


                $valorconsultajefe='select ocb.id, ocb.description, oc.id as idcompetencia, oc.courseid, oc.idinstance ,ocb.code, oec.value
                from mdl_objective_competition_behavior ocb 
                inner join mdl_objective_competition oc on oc.id=ocb.idcompetition 
                inner join mdl_objective_establishment_competition oec on oec.idbehavior = ocb.id
                where ocb.idcompetition=? and oec.idobjectiveestablishment=? and ocb.status=0 order by ocb.code asc';
                $valorresultadojefe = $DB->get_records_sql($valorconsultajefe, array($valores2->idcompe, $id));

                // print_r($resultado2);
                echo '<div class="w3-col l9">
                <table class="w3-table-all">';
                foreach($valorresultadojefe  as $comportamientojefe){
                //$idcomportamiento2=$comportamiento2->id;
                if($comportamientojefe->code==1){
                    echo'<tr><td>'.$comportamientojefe->description.'</td>';
                    echo'<td>';
                    ?>
                                <input type="radio" id="valores<?php echo $comportamientojefe->id; ?>" name="valores[<?php echo $comportamientojefe->id; ?>][valor]" value="4" <?php if (!(strcmp(4, htmlentities($comportamientojefe->value, ENT_COMPAT, 'utf-8')))) {echo "checked";} ?> disabled><label for="valores<?php echo $comportamientojefe->id;?>">4</label>
                                <input type="radio" id="valores<?php echo $comportamientojefe->id; ?>" name="valores[<?php echo $comportamientojefe->id; ?>][valor]" value="3" <?php if (!(strcmp(3, htmlentities($comportamientojefe->value, ENT_COMPAT, 'utf-8')))) {echo "checked";} ?> disabled><label for="valores<?php echo $comportamientojefe->id;?>">3</label>
                                <input type="radio" id="valores<?php echo $comportamientojefe->id; ?>" name="valores[<?php echo $comportamientojefe->id; ?>][valor]" value="2" <?php if (!(strcmp(2, htmlentities($comportamientojefe->value, ENT_COMPAT, 'utf-8')))) {echo "checked";} ?> disabled><label for="valores<?php echo $comportamientojefe->id;?>">2</label>
                                <input type="radio" id="valores<?php echo $comportamientojefe->id; ?>" name="valores[<?php echo $comportamientojefe->id; ?>][valor]" value="1" <?php if (!(strcmp(1, htmlentities($comportamientojefe->value, ENT_COMPAT, 'utf-8')))) {echo "checked";} ?> disabled><label for="valores<?php echo $comportamientojefe->id;?>">1</label>
                    <?php
                    echo'</td></tr>';

                    }else if ($comportamientojefe->code==2){
                        echo'<tr><td>'.$comportamientojefe->description.'</td>';
                        echo'<td><p class="w3-input w3-border" type="text" id="valores'.$comportamientojefe->id.'" name="valores['.$comportamientojefe->id.'][valor]">'.$comportamientojefe->value.'</p></td>';
                        echo'</tr>';
                    }else if($comportamientojefe->code==3){
                        echo'<tr><td>'.$comportamientojefe->description.'</td></tr>';
                        echo'<tr><td><p class="w3-input w3-border" rows="4" cols="50"  id="valores'.$comportamientojefe->id.'" name="valores['.$comportamientojefe->id.'][valor]">'.$comportamientojefe->value.'</p></td>';
                        echo'</tr>';
                    }else{

                    }
                }
                echo '</table></div>';
                echo'</div><div class="espacio"></div>';

                }



        }else{

        }
        //echo '</form><input type="submit" id="btnCompetencia" name="btnCompetencia"  value="Calificar Compétencias">';
        echo '</div></div></div></div></div> <!-- cierra vista -->';
    }

    
}
/* INICIA VISTA 3*/
if($estatusa==2){
   
    //echo '<div id="vista3" class="w3-light-grey vistas" style="display:none;">Hola mundo vista 3</div>';
    if($rolprincipal=='COLABORADOR'|| $rolprincipal=='JEFE INMEDIATO' || $rolprincipal=='DIRECTOR'){

                    /* INICIA VISTA 3*/
                $vistarevisionfinal .='<div id="vista3" class="w3-light-grey vistas" style="display: none;">
                                    <div class="w3-container">
                                        <div class="w3-row">
                                            <div class="w3-col l2">
                                                <p></p>
                                            </div>
                                            <div class="w3-col l8">
                                                <h3 class="w3-center  w3-animate-top">Establecimiento de objetivos</h3>
                                                <p class="w3-animate-opacity">La siguiente evaluación tiene como objetivo analizar, evaluar y comparar los resultados del desempeño de los colaboradores y su acercamiento a las competencias organizacionales. Estos resultados serán parte fundamental para diseñar programas de capacitación y desarrollo.</p>
                                            </div>
                                            <div class="w3-col l2">
                                                <p></p>
                                            </div>
                                        </div>
                                        <div class="w3-row">
                                            <div class="w3-col l4">
                                                <p></p>
                                            </div>
                                            <div class="w3-col l4">
                                                <p></p>
                                            </div>
                                            <div class="w3-col l4">
                                            <input type="date" class="form-control"  value="'.$fechaestablecimiento.'"  disabled="yes">
                                                <!--<p>Fecha de establecimiento:<input type="text"></p>-->
                                                <!--<p>Fecha de establecimiento: <input type="text" id="datepicker"></p>-->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="espacio"></div>
                                    <div class="w3-container">
                                        <div class="w3-row">
                                            <div class="w3-col l1">
                                                <p></p>
                                            </div>
                                            <div class="w3-round-xxlarge w3-col l5 w3-pale-red w3-center">
                                                <p>1a. Parte</p>
                                            </div>
                                            <div class="w3-round-xxlarge w3-col l5 w3-dark-grey w3-center">
                                                <p>Objetivos del puesto de trabajo</p>
                                            </div>
                                            <div class="w3-col l1">
                                                <p></p>
                                            </div>
                                        </div>
                                        <div class="w3-row">
                                            <div class="w3-col l1">
                                                <p></p>
                                            </div>
                                            <div class="w3-col l10 w3-center">
                                                <p>Este apartado está estrechamente ligado con el rubro de objetivos del puesto de trabajo; con esta evaluación conoceremos en qué medida se logran.</p>
                                            </div>
                                            <div class="w3-col l1">
                                                <p></p>
                                            </div>
                                        </div>';
                echo $vistarevisionfinal;
            //  echo $vistajefeinmediato;
                echo '</div><div class="espacio"></div><div id="objetivos-jefe" class="w3-container">';
                ?>
                <div class="espacio"></div><div class="w3-container"><div class="w3-row"><div class="w3-col l1"><p></p></div><div class="w3-col l10 w3-center"><div class="w3-container">
                <div class="w3-row">
                <div class="w3-round-xxlarge w3-col l4  w3-pale-red">
                <p>Objetivos</p>
                </div>
                <div class="w3-round-xlarge w3-col l2  w3-pale-red">
                <p>Fecha compromiso</p>
                </div>
                <div class="w3-round-xlarge w3-col l2  w3-pale-red">
                <p>Peso anual en %</p>
                </div>
                <div class="w3-round-xlarge w3-col l2  w3-pale-red">
                <p>Auto - Evaluación final</p>
                </div>
                <div class="w3-round-xlarge w3-col l2  w3-pale-red">
                <p>Evaluación final - jefe inmediato</p>
                </div>
                <?php
                echo '<form id="revisionobjfinal" method="POST" action="enviorevisionfinal.php" data-parsley-validate="">';
                //$requeridcolaborador='required=""';
                foreach($resultcontrol as $valuecontrol){

                $contfinal=$valuecontrol->contador;
                $mycomments=$valuecontrol->mycomments;
                $establecimientorevisionfinal .='<div id="revisionobjetivos'.$contfinal.'">
                <div class="w3-row">
                    <div class="w3-col l8 w3-dark-grey">
                        <p>Breve descripción del objetivo '.$cont.'</p>
                    </div>
                    <div class="w3-col l2">
                        <p></p>
                    </div>
                    <div class="w3-col l2">
                        <p></p>
                    </div>
                </div>
                <div class="w3-row">
                    <input type="hidden" id="id'.$contfinal.'" name="idobjestablecidofinal'.$contfinal.'" value="'.$valuecontrol->id.'" '.$requeridcolaborador.'>
                    <input type="hidden" id="userid'.$contfinal.'" name="useridfinal'.$contfinal.'" value="'.$USER->id.'" '.$requeridcolaborador.'>
                    <input type="hidden" id="courseid'.$contfinal.'" name="courseidfinal'.$contfinal.'" value="'.$courseid.'" '.$requeridcolaborador.'>
                    <input type="hidden" id="idobjetivo'.$contfinal.'" name="idobjetivofinal'.$contfinal.'" value="'.$id.'" '.$requeridcolaborador.'>
                    <div class="w3-col m2 w3-white w3-center">
                        <p class="text-cuestion">Indica el # de objetivo de tu jefe inmediato al que estará ligado tu objetivo</p>
                    <!--<p><input  class="w3-input w3-border" type="text"></p>-->
                        <p>'.$valuecontrol->targetnumber.'</p>
                    </div>
                    <div class="w3-col m2 w3-white w3-center">
                        <p class="text-cuestion">1. ¿Qué se quiere medir?</p>
                        <p>'.$valuecontrol->whatquestion.'</p>
                    </div>
                    <div class="w3-col m2 w3-white w3-center">
                        <p class="text-cuestion">2. ¿Cómo se quiere medir?</p>
                        <p>'.$valuecontrol->howquestion.'</p>
                    </div>
                    <div class="w3-col m2 w3-white w3-center">
                        <p class="text-cuestion">3. ¿Cuánto quieres que mida?</p>
                        <p>'.$valuecontrol->thatquestion.'</p>
                    </div>
                    <div class="w3-col m2 w3-white w3-center">
                        <p class="text-cuestion">4. ¿Cómo se quiere medir?</p>
                        <p>'.$valuecontrol->specifyquestion.'</p>
                    </div>
                    <div class="w3-col m2 w3-white w3-center">
                        <p class="text-cuestion">5. ¿Cuánto quieres que mida?</p>
                        <p>'.$valuecontrol->periodquestion.'</p>
                    </div>
                </div>
                <div class="w3-row">
                    <div class="w3-col m12 w3-white w3-center">
                        <p class="text-oc">Objetivo Completo</p>
                        <p>'.$valuecontrol->objectivecomplete.'</p>
                    </div>
                </div>
                <div class="row">
                    <div class="w3-col m3 w3-white w3-center">
                        <p class="text-cuestion">Fecha inicial</p>
                        <p>'.$valuecontrol->fechaini.'</p>
                    </div>
                    <div class="w3-col m3 w3-white w3-center">
                        <p class="text-cuestion">Fecha final</p>
                        <p>'.$valuecontrol->fechafin.'</p>
                    </div>
                    <div class="w3-col m2 w3-white w3-center">
                        <p class="text-cuestion">Valor del objetivo sobre 100</p>
                        <p>'.$valuecontrol->valueobjective.'%</p>
                    </div>
                    <div class="w3-col m2 w3-white w3-center">
                        <p class="text-cuestion">Auto - Evaluación final</p>';
                        if(empty($valuecontrol->autoevaluation)){
                            $establecimientorevisionfinal .='<p><input class="w3-input w3-border" type="text" id="valorautoevaluacion'.$contfinal.'" name="valorautoevaluacion'.$contfinal.'" data-parsley-type="number" '.$requeridcolaborador.'></p>';
                        }else{
                            $establecimientorevisionfinal .='<p class="w3-input w3-border">'.$valuecontrol->autoevaluation.'</p>';
                        }
                        $establecimientorevisionfinal .='</div>
                    <div class="w3-col m2 w3-white w3-center">
                        <p class="text-cuestion">Evaluación final - jefe inmediato</p>';
                        if(empty($valuecontrol->evaluationboss)){
                            $establecimientorevisionfinal .='<p class="w3-input w3-border">&nbsp;</p>';
                        }else{
                            $establecimientorevisionfinal .='<p class="w3-input w3-border">'.$valuecontrol->evaluationboss.'</p>';
                        }
                        $establecimientorevisionfinal .='</div>
                </div><!--aqui empieza-->
                <div class="w3-row">
                    <div class="w3-col m6 w3-white w3-center">
                        <div class="w3-row">
                            <div class="w3-col m6 w3-white w3-center">
                                <p class="text-cuestion">Mis comentarios:</p>';
                                if(empty($mycomments)){
                                    $establecimientorevisionfinal .='<p><textarea class="w3-input w3-border" rows="1" cols="10" type="text" id="micomentarios'.$contfinal.'" name="micomentarios'.$contfinal.'" '.$requeridcolaborador.'></textarea></p>';
                                }else{
                                    $establecimientorevisionfinal .='<p class="w3-input w3-border">'.$mycomments.'</p>';
                                }
                                $establecimientorevisionfinal .='</div>
                            <div class="w3-col m6 w3-white w3-center">
                                <p class="text-cuestion">Mis comentarios, Evaluación Final:</p>';
                                if(empty($valuecontrol->mycommentsfinal)){
                                    $establecimientorevisionfinal .='<p><textarea class="w3-input w3-border" rows="1" cols="10" type="text" id="micomentariosef'.$contfinal.'" name="micomentariosef'.$contfinal.'" '.$requeridcolaborador.'></textarea></p>';
                                }else{
                                    $establecimientorevisionfinal .='<p class="w3-input w3-border">'.$valuecontrol->mycommentsfinal.'</p>';
                                }
                                    $establecimientorevisionfinal .='</div>
                        </div>
                    </div>
                    <div class="w3-col m6 w3-white w3-center">
                    <div class="w3-row">
                    <div class="w3-col m6 w3-white w3-center">
                        <p class="text-cuestion">Retroalimentación de mi jefe:</p>';
                        if(empty($valuecontrol->feedbackboos)){
                            $establecimientorevisionfinal .='<p class="w3-input w3-border">&nbsp;</p>';
                        }else{
                            $establecimientorevisionfinal .='<p class="w3-input w3-border">'.$valuecontrol->feedbackboos.'</p>';
                        }
                        $establecimientorevisionfinal .='</div>
                    <div class="w3-col m6 w3-white w3-center">
                        <p class="text-cuestion">Retroalimentación de Jefe, Evaluación final: </p>';
                        if(empty($valuecontrol->feddbackevaluation)){
                            $establecimientorevisionfinal .='<p class="w3-input w3-border">&nbsp;</p>';
                        }else{
                            $establecimientorevisionfinal .='<p class="w3-input w3-border">'.$valuecontrol->feddbackevaluation.'</p>';
                        }
                        $establecimientorevisionfinal .='</div>
                    </div>
                    </div>
                </div>
                </div>';

                }

                if(empty($mycomments)){
                $enviorevisionfinal .='<input type="submit" id="btnRevisarFinal" name="btnRevisarFinal"  value="Enviar">';
                }else{
                $enviorevisionfinal .='<br>';
                }
                $enviorevisionfinal .='
                </form>
                <hr><p id="revfinal"></p> <!-- ESTABLECIMIENTO DE OBJETIVOS 6-->
                </div>
                <div class="w3-col l1"><p></p></div>
                </div>
                </div>
                </div>
                </div>
                <div class="espacio"></div>
                </div><!-- Finaliza objetivos id-->';

                echo $establecimientorevisionfinal;
                echo $enviorevisionfinal;

                ?>
               
                <div class="w3-container">
                <div class="w3-row">
                <div class="w3-col l1">
                <p></p>
                </div>
                <div class="w3-col l10">
                <div class="w3-container">
                <?php

                    if($rolprincipal=='COLABORADOR'){

                        $sql='select  obc.id as idcompe, c.id as idcourse , o.name as nestablecimiento, obn.namenivel, obc.orden ,obc.name as nombrecompetencia ,obn.id as categoria
                        from mdl_course c
                        inner join mdl_objective o on o.course = c.id
                        inner join mdl_objective_competition obc on obc.idinstance = o.id
                        inner join mdl_objective_nivel obn on obn.id = obc.idnivel
                        where c.id=?
                        and obn.id=3
                        order by obc.idnivel asc';
                        $resultados = $DB->get_records_sql($sql, array($courseid));

                        echo $colaboradortemp;
                        foreach($resultados as $valores){

                        echo '<div class="espacio"></div>
                        <div class="w3-row">
                        <div class="w3-round-xlarge w3-col l3  w3-pale-red w3-center">
                        <p>Competencias</p>
                        </div>
                        <div class="w3-round-xlarge w3-col l9  w3-pale-red w3-center">
                        <p>Comportamientos</p>
                        </div>
                        </div>
                        <div class="w3-row">
                        <div class="w3-round-xlarge w3-col l3  w3-dark-grey w3-center">
                        <p>Definición de competencias</p>
                        </div>
                        <div class="w3-round-xlarge w3-col l9  w3-dark-grey w3-center">
                        <p>Comportamientos asociados a la competencia</p>
                        </div>
                        </div>';

                        echo '<div class="w3-row">
                        <div class="w3-col l3">
                        <p>'.$valores->nombrecompetencia.'</p>
                        </div>';



                        $valorconsulta='select ocb.id, ocb.description, oc.id as idcompetencia, oc.courseid, oc.idinstance ,ocb.code, oec.value
                        from mdl_objective_competition_behavior ocb 
                        inner join mdl_objective_competition oc on oc.id=ocb.idcompetition 
                        inner join mdl_objective_establishment_competition_final oec on oec.idbehavior = ocb.id
                        where ocb.idcompetition=? and oec.idobjectiveestablishment=? and ocb.status=0 order by ocb.code asc';
                        $valorresultado = $DB->get_records_sql($valorconsulta, array($valores->idcompe, $id));

                        //print_r($resultado);
                        echo '<div class="w3-col l9">
                        <table class="w3-table-all">';
                        foreach($valorresultado as $comportamientofinal){
                        // $idcomportamiento=$comportamiento->id;
                        if($comportamientofinal->code==1){
                            echo'<tr><td>'.$comportamientofinal->description.'</td>';
                            echo'<td>';
                            ?>
                                        <input type="radio" id="valoresrf<?php echo $comportamientofinal->id; ?>" name="valoresrf[<?php echo $comportamientofinal->id; ?>][valor]" value="4" <?php if (!(strcmp(4, htmlentities($comportamientofinal->value, ENT_COMPAT, 'utf-8')))) {echo "checked";} ?> disabled><label for="valoresrf<?php echo $comportamientofinal->id;?>">4</label>
                                        <input type="radio" id="valoresrf<?php echo $comportamientofinal->id; ?>" name="valoresrf[<?php echo $comportamientofinal->id; ?>][valor]" value="3" <?php if (!(strcmp(3, htmlentities($comportamientofinal->value, ENT_COMPAT, 'utf-8')))) {echo "checked";} ?> disabled><label for="valoresrf<?php echo $comportamientofinal->id;?>">3</label>
                                        <input type="radio" id="valoresrf<?php echo $comportamientofinal->id; ?>" name="valoresrf[<?php echo $comportamientofinal->id; ?>][valor]" value="2" <?php if (!(strcmp(2, htmlentities($comportamientofinal->value, ENT_COMPAT, 'utf-8')))) {echo "checked";} ?> disabled><label for="valoresrf<?php echo $comportamientofinal->id;?>">2</label>
                                        <input type="radio" id="valoresrf<?php echo $comportamientofinal->id; ?>" name="valoresrf[<?php echo $comportamientofinal->id; ?>][valor]" value="1" <?php if (!(strcmp(1, htmlentities($comportamientofinal->value, ENT_COMPAT, 'utf-8')))) {echo "checked";} ?> disabled><label for="valoresrf<?php echo $comportamientofinal->id;?>">1</label>
                            <?php
                            echo'</td></tr>';

                            }else if ($comportamientofinal->code==2){
                                echo'<tr><td>'.$comportamientofinal->description.'</td>';
                                echo'<td><p class="w3-input w3-border" type="text" id="valoresrf'.$comportamientofinal->id.'" name="valoresrf['.$comportamientofinal->id.'][valor]" >'.$comportamientofinal->value.'</p></td>';
                                echo'</tr>';
                            }else if($comportamientofinal->code==3){
                                echo'<tr><td>'.$comportamientofinal->description.'</td></tr>';
                                echo'<tr><td><p class="w3-input w3-border" rows="4" cols="50"  id="valoresrf'.$comportamientofinal->id.'" name="valoresrf['.$comportamientofinal->id.'][valor]">'.$comportamientofinal->value.'</p></td>';
                                echo'</tr>';
                            }else{

                            }


                        }
                        echo '</table></div>';
                        echo'</div><div class="espacio"></div>';

                        }




                    }else if($rolprincipal=='JEFE INMEDIATO'){

                            $finalsql='select  obc.id as idcompe, c.id as idcourse , o.name as nestablecimiento, obn.namenivel, obc.orden ,obc.name as nombrecompetencia ,obn.id as categoria
                            from mdl_course c
                            inner join mdl_objective o on o.course = c.id
                            inner join mdl_objective_competition obc on obc.idinstance = o.id
                            inner join mdl_objective_nivel obn on obn.id = obc.idnivel
                            where c.id=?
                            and obn.id=3
                            order by obc.idnivel asc';
                            $finalresultados = $DB->get_records_sql($finalsql, array($courseid));

                            echo $colaboradortemp;
                            foreach($finalresultados as $finalvalores){

                            echo '<div class="espacio"></div>
                            <div class="w3-row">
                            <div class="w3-round-xlarge w3-col l3  w3-pale-red w3-center">
                            <p>Competencias</p>
                            </div>
                            <div class="w3-round-xlarge w3-col l9  w3-pale-red w3-center">
                            <p>Comportamientos</p>
                            </div>
                            </div>
                            <div class="w3-row">
                            <div class="w3-round-xlarge w3-col l3  w3-dark-grey w3-center">
                            <p>Definición de competencias</p>
                            </div>
                            <div class="w3-round-xlarge w3-col l9  w3-dark-grey w3-center">
                            <p>Comportamientos asociados a la competencia</p>
                            </div>
                            </div>';

                            echo '<div class="w3-row">
                            <div class="w3-col l3">
                            <p>'.$finalvalores->nombrecompetencia.'</p>
                            </div>';



                            $finalvalorconsulta='select ocb.id, ocb.description, oc.id as idcompetencia, oc.courseid, oc.idinstance ,ocb.code, oec.value
                            from mdl_objective_competition_behavior ocb 
                            inner join mdl_objective_competition oc on oc.id=ocb.idcompetition 
                            inner join mdl_objective_establishment_competition_final oec on oec.idbehavior = ocb.id
                            where ocb.idcompetition=? and oec.idobjectiveestablishment=? and ocb.status=0 order by ocb.code asc';
                            $finalvalorresultado = $DB->get_records_sql($finalvalorconsulta, array($finalvalores->idcompe, $id));

                            //print_r($resultado);
                            echo '<div class="w3-col l9">
                            <table class="w3-table-all">';
                            foreach($finalvalorresultado as $finalcomportamiento){
                            // $idcomportamiento=$comportamiento->id;
                            if($finalcomportamiento->code==1){
                                echo'<tr><td>'.$finalcomportamiento->description.'</td>';
                                echo'<td>';
                                ?>
                                            <input type="radio" id="valoresrf<?php echo $finalcomportamiento->id; ?>" name="valoresrf[<?php echo $finalcomportamiento->id; ?>][valor]" value="4" <?php if (!(strcmp(4, htmlentities($finalcomportamiento->value, ENT_COMPAT, 'utf-8')))) {echo "checked";} ?> disabled><label for="valoresrf<?php echo $finalcomportamiento->id;?>">4</label>
                                            <input type="radio" id="valoresrf<?php echo $finalcomportamiento->id; ?>" name="valoresrf[<?php echo $finalcomportamiento->id; ?>][valor]" value="3" <?php if (!(strcmp(3, htmlentities($finalcomportamiento->value, ENT_COMPAT, 'utf-8')))) {echo "checked";} ?> disabled><label for="valoresrf<?php echo $finalcomportamiento->id;?>">3</label>
                                            <input type="radio" id="valoresrf<?php echo $finalcomportamiento->id; ?>" name="valoresrf[<?php echo $finalcomportamiento->id; ?>][valor]" value="2" <?php if (!(strcmp(2, htmlentities($finalcomportamiento->value, ENT_COMPAT, 'utf-8')))) {echo "checked";} ?> disabled><label for="valoresrf<?php echo $finalcomportamiento->id;?>">2</label>
                                            <input type="radio" id="valoresrf<?php echo $finalcomportamiento->id; ?>" name="valoresrf[<?php echo $finalcomportamiento->id; ?>][valor]" value="1" <?php if (!(strcmp(1, htmlentities($finalcomportamiento->value, ENT_COMPAT, 'utf-8')))) {echo "checked";} ?> disabled><label for="valoresrf<?php echo $finalcomportamiento->id;?>">1</label>
                                <?php
                                echo'</td></tr>';

                                }else if ($finalcomportamiento->code==2){
                                    echo'<tr><td>'.$finalcomportamiento->description.'</td>';
                                    echo'<td><p class="w3-input w3-border" type="text" id="valoresrf'.$finalcomportamiento->id.'" name="valoresrf['.$finalcomportamiento->id.'][valor]" >'.$finalcomportamiento->value.'</p></td>';
                                    echo'</tr>';
                                }else if($finalcomportamiento->code==3){
                                    echo'<tr><td>'.$finalcomportamiento->description.'</td></tr>';
                                    echo'<tr><td><p class="w3-input w3-border" rows="4" cols="50"  id="valoresrf'.$finalcomportamiento->id.'" name="valoresrf['.$finalcomportamiento->id.'][valor]">'.$finalcomportamiento->value.'</p></td>';
                                    echo'</tr>';
                                }else{

                                }


                            }
                            echo '</table></div>';
                            echo'</div><div class="espacio"></div>';

                            }

                            $finalsql2='select  obc.id as idcompe, c.id as idcourse , o.name as nestablecimiento, obn.namenivel, obc.orden ,obc.name as nombrecompetencia ,obn.id as categoria
                            from mdl_course c
                            inner join mdl_objective o on o.course = c.id
                            inner join mdl_objective_competition obc on obc.idinstance = o.id
                            inner join mdl_objective_nivel obn on obn.id = obc.idnivel
                            where c.id=?
                            and obn.id=2
                            order by obc.idnivel asc';
                            $finalresultados2 = $DB->get_records_sql($finalsql2, array($courseid));
                            echo $jefetemp;
                            foreach($finalresultados2 as $finalvalores2){

                            echo '<div class="espacio"></div>
                            <div class="w3-row">
                            <div class="w3-round-xlarge w3-col l3  w3-pale-red w3-center">
                            <p>Competencias</p>
                            </div>
                            <div class="w3-round-xlarge w3-col l9  w3-pale-red w3-center">
                            <p>Comportamientos</p>
                            </div>
                            </div>
                            <div class="w3-row">
                            <div class="w3-round-xlarge w3-col l3  w3-dark-grey w3-center">
                            <p>Definición de competencias</p>
                            </div>
                            <div class="w3-round-xlarge w3-col l9  w3-dark-grey w3-center">
                            <p>Comportamientos asociados a la competencia</p>
                            </div>
                            </div>';

                            echo '<div class="w3-row">
                            <div class="w3-col l3">
                            <p>'.$finalvalores2->nombrecompetencia.'</p>
                            </div>';


                            $finalvalorconsultajefe='select ocb.id, ocb.description, oc.id as idcompetencia, oc.courseid, oc.idinstance ,ocb.code, oec.value
                            from mdl_objective_competition_behavior ocb 
                            inner join mdl_objective_competition oc on oc.id=ocb.idcompetition 
                            inner join mdl_objective_establishment_competition_final oec on oec.idbehavior = ocb.id
                            where ocb.idcompetition=? and oec.idobjectiveestablishment=? and ocb.status=0 order by ocb.code asc';
                            $finalvalorresultadojefe = $DB->get_records_sql($finalvalorconsultajefe, array($finalvalores2->idcompe, $id));

                            // print_r($resultado2);
                            echo '<div class="w3-col l9">
                            <table class="w3-table-all">';
                            foreach($finalvalorresultadojefe  as $finalcomportamientojefe){
                            
                                if($finalcomportamientojefe->code==1){
                                echo'<tr><td>'.$finalcomportamientojefe->description.'</td>';
                                echo'<td>';
                                ?>
                                            <input type="radio" id="valoresrf<?php echo $finalcomportamientojefe->id; ?>" name="valoresrf[<?php echo $finalcomportamientojefe->id; ?>][valor]" value="4" <?php if (!(strcmp(4, htmlentities($finalcomportamientojefe->value, ENT_COMPAT, 'utf-8')))) {echo "checked";} ?> disabled><label for="valoresrf<?php echo $finalcomportamientojefe->id;?>" disabled>4</label>
                                            <input type="radio" id="valoresrf<?php echo $finalcomportamientojefe->id; ?>" name="valoresrf[<?php echo $finalcomportamientojefe->id; ?>][valor]" value="3" <?php if (!(strcmp(3, htmlentities($finalcomportamientojefe->value, ENT_COMPAT, 'utf-8')))) {echo "checked";} ?> disabled><label for="valoresrf<?php echo $finalcomportamientojefe->id;?>" disabled>3</label>
                                            <input type="radio" id="valoresrf<?php echo $finalcomportamientojefe->id; ?>" name="valoresrf[<?php echo $finalcomportamientojefe->id; ?>][valor]" value="2" <?php if (!(strcmp(2, htmlentities($finalcomportamientojefe->value, ENT_COMPAT, 'utf-8')))) {echo "checked";} ?> disabled><label for="valoresrf<?php echo $finalcomportamientojefe->id;?>" disabled>2</label>
                                            <input type="radio" id="valoresrf<?php echo $finalcomportamientojefe->id; ?>" name="valoresrf[<?php echo $finalcomportamientojefe->id; ?>][valor]" value="1" <?php if (!(strcmp(1, htmlentities($finalcomportamientojefe->value, ENT_COMPAT, 'utf-8')))) {echo "checked";} ?> disabled><label for="valoresrf<?php echo $finalcomportamientojefe->id;?>" disabled>1</label>
                                <?php
                                echo'</td></tr>';

                                }else if ($finalcomportamientojefe->code==2){
                                    echo'<tr><td>'.$finalcomportamientojefe->description.'</td>';
                                    echo'<td><p class="w3-input w3-border" type="text" id="valoresrf'.$finalcomportamientojefe->id.'" name="valoresrf['.$finalcomportamientojefe->id.'][valor]">'.$finalcomportamientojefe->value.'</p></td>';
                                    echo'</tr>';
                                }else if($finalcomportamientojefe->code==3){
                                    echo'<tr><td>'.$finalcomportamientojefe->description.'</td></tr>';
                                    echo'<tr><td><p class="w3-input w3-border" rows="4" cols="50"  id="valoresrf'.$finalcomportamientojefe->id.'" name="valoresrf['.$finalcomportamientojefe->id.'][valor]">'.$finalcomportamientojefe->value.'</p></td>';
                                    echo'</tr>';
                                }else{

                                }
                            }
                            echo '</table></div>';
                            echo'</div><div class="espacio"></div>';

                            }



                    }else{

                    }
                    //echo '</form><input type="submit" id="btnCompetencia" name="btnCompetencia"  value="Calificar Compétencias">';
                    echo '</div></div></div></div></div> <!-- cierra vista -->';
    }
}
echo'<style>
input.parsley-error,
select.parsley-error,
textarea.parsley-error {    
    border-color:#843534;
    box-shadow: none;
}
input.parsley-error:focus,
select.parsley-error:focus,
textarea.parsley-error:focus {    
    border-color:#843534;
    box-shadow:inset 0 1px 1px rgba(0,0,0,.075),0 0 6px #ce8483
}</style>';
?>
<script>
$(document).on('ready', function() {

    $('#BTNvalida').parsley().on('field:validated', function() {
        var ok = $('.parsley-error').length === 0;
        $('.bs-callout-info').toggleClass('hidden', !ok);
        $('.bs-callout-warning').toggleClass('hidden', ok);
    });


    $("#establecimientoobj").bind("submit",function(){
        // Capturamnos el boton de envío
        var btnEnviar = $("#btnEnviar");
        $.ajax({
            type: $(this).attr("method"),
            url: $(this).attr("action"),
            data:$(this).serialize(),
            beforeSend: function(){
                /*
                * Esta función se ejecuta durante el envió de la petición al
                * servidor.
                * */
                // btnEnviar.text("Enviando"); Para button 
                btnEnviar.val("Enviando"); // Para input de tipo button
                btnEnviar.attr("disabled","disabled");
            },
            complete:function(data){
                /*
                * Se ejecuta al termino de la petición
                * */
                btnEnviar.val("Enviar formulario");
                btnEnviar.removeAttr("disabled");
            },
            success: function(data){
                /*
                * Se ejecuta cuando termina la petición y esta ha sido
                * correcta
                * */
                $("#respuesta").html(data);
            },
            error: function(data){
                /*
                * Se ejecuta si la peticón ha sido erronea
                * */
                alert("Problemas al tratar de enviar el formulario");
            }
        });
        // Nos permite cancelar el envio del formulario
        return false;
    });

    $('#revisionobj').parsley().on('field:validated', function() {
        var mensaje = $('.parsley-error').length === 0;
        $('.bs-callout-info').toggleClass('hidden', !mensaje);
        $('.bs-callout-warning').toggleClass('hidden', mensaje);
    });


    $("#revisionobj").bind("submit",function(){
        // Capturamnos el boton de envío
        var btnRevisar = $("#btnRevisar");
        
        $.ajax({
            type: $(this).attr("method"),
            url: $(this).attr("action"),
            data:$(this).serialize(),
            beforeSend: function(){
                /*
                * Esta función se ejecuta durante el envió de la petición al
                * servidor.
                * */
                // btnEnviar.text("Enviando"); Para button 
                btnRevisar.val("Enviando"); // Para input de tipo button
                btnRevisar.attr("disabled","disabled");
            },
            complete:function(data){
                /*
                * Se ejecuta al termino de la petición
                * */
                btnRevisar.val("Enviar");
              
            },
            success: function(data){
                /*
                * Se ejecuta cuando termina la petición y esta ha sido
                * correcta
                * */
                $("#rev").html(data);
                location.reload();
                
            },
            error: function(data){
                /*
                * Se ejecuta si la peticón ha sido erronea
                * */
                alert("Problemas al tratar de enviar el formulario");
            }
        });
        // Nos permite cancelar el envio del formulario
        return false;
    });

    $('#revisionobjfinal').parsley().on('field:validated', function() {
        var mensaje = $('.parsley-error').length === 0;
        $('.bs-callout-info').toggleClass('hidden', !mensaje);
        $('.bs-callout-warning').toggleClass('hidden', mensaje);
    });


    $("#revisionobjfinal").bind("submit",function(){
        // Capturamnos el boton de envío
        var btnRevisarFinal = $("#btnRevisarFinal");
        $.ajax({
            type: $(this).attr("method"),
            url: $(this).attr("action"),
            data:$(this).serialize(),
            beforeSend: function(){
                /*
                * Esta función se ejecuta durante el envió de la petición al
                * servidor.
                * */
                // btnEnviar.text("Enviando"); Para button 
                btnRevisarFinal.val("Enviando"); // Para input de tipo button
                btnRevisarFinal.attr("disabled","disabled");
            },
            complete:function(data){
                /*
                * Se ejecuta al termino de la petición
                * */
                btnRevisarFinal.val("Enviar");
              
            },
            success: function(data){
                /*
                * Se ejecuta cuando termina la petición y esta ha sido
                * correcta
                * */
                $("#revfinal").html(data);
                 location.reload();
                
            },
            error: function(data){
                /*
                * Se ejecuta si la peticón ha sido erronea
                * */
                alert("Problemas al tratar de enviar el formulario");
            }
        });
        // Nos permite cancelar el envio del formulario
        return false;
    });
    function openCity(cityName) {
            var i;
            var x = document.getElementsByClassName("vistas");
            for (i = 0; i < x.length; i++) {
                x[i].style.display = "none";
            }
            document.getElementById(cityName).style.display = "block";
        }

});
</script>
</body>
<?php



//echo $OUTPUT->footer();



?>