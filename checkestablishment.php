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
$id = required_param('id', PARAM_INT);
$instance  = required_param('instance', PARAM_INT);
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
    <script src="./js/select2.min.js"></script>
    <script src="./js/jquery-1.12.4.js"></script>
    <script src="./js/jquery-ui.js"></script>
    <script src="./js/functions.js"></script>
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
mf3.userid = u.id AND mf3.fieldid = 2) AS 'jefediecto', ogr.description as 'rol', oe.idjefedirecto as 'idjefe'
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
        
        foreach($result as $value){

               $idusuario=$value->iduser;
               $nombre=$value->ncomnpleto;
               $nombrejefe=$value->jefediecto;
               $rolprincipal=$value->rol;
               $idjefegrupo=$value->idjefe;

           
        }
/*VALIDA SI ES JEFE INMEDIATO DEL DOCUMENTO*/
$valida="select * from mdl_objective_establishment where id=? and courseid=? and idmod=? and idjefedirecto=?";
$validajefe = $DB->get_records_sql($valida, array($id, $courseid, $instance, $USER->id));
if(empty($validajefe)){
             $my = new moodle_url('/mod/objective/view.php?id='.$instance.'');
            redirect($my);
            exit();
}                       
echo '<div class="w3-bar w3-black">
                <button class="w3-bar-item w3-button" onclick="openCity(\'vista1\')">Establecimiento de objetivos</button>
                <button class="w3-bar-item w3-button" onclick="openCity(\'vista2\')">Revision 1</button>
                <button class="w3-bar-item w3-button" onclick="openCity(\'vista3\')">Revision Final</button>
        </div>';
                $vistajefeinmediato .='<div class="w3-row">
                            <div class="w3-col l1">
                                <p></p>
                            </div>
                            <div class="w3-round-xxlarge w3-col l5 w3-pale-red w3-center">
                                <p>Objetivos del jefe inmediato</p>
                            </div>
                            <div class="w3-round-xxlarge w3-col l5 w3-dark-grey w3-center">  
                                <p>'.$nombre.'</p>
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
$obtenerobj = $DB->get_records_sql($objetivosjefe, array($USER->id));
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
$fcha = date("Y-m-d");
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
                    <div class="w3-col l4">
                    <input type="date" class="form-control"  value="'.$fcha.'"  disabled="yes">
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
                        <p>Este apartado está estrechamente ligado con el rubro de objetivos del puesto de trabajo; con esta evaluación conoceremos en qué medida se logran. Es importante que consideres los objetivos de tu jefe inmediato que te presentamos a
                            continuación: *No todos deberán </p>
                    </div>
                    <div class="w3-col l1">
                        <p></p>
                    </div>
                </div>';

//$queryfinal='select * from mdl_objective_establishment_captured where userid=? and courseid=? and idobjective=? order by idobjective ASC';
/*$querycontrol='select  es.id, es.userid,es.idobjective ,es.courseid, es.targetnumber, es.whatquestion, es.howquestion, es.thatquestion, es.specifyquestion, es.periodquestion, es.objectivecomplete, es.startdate, es.enddate, es.valueobjective
from  mdl_objective_establishment_captured es
inner join mdl_objective_establishment o on o.id = es.idobjective 
where es.courseid=? and es.idobjective=? and o.idjefedirecto=? order by idobjective ASC';*/

$querycontrol='select es.id, @rownum:=@rownum+1 contador,  es.userid,es.idobjective ,es.courseid, es.targetnumber, es.whatquestion, es.howquestion, es.thatquestion, es.specifyquestion, es.periodquestion, es.objectivecomplete, DATE_FORMAT(FROM_UNIXTIME(es.startdate), "%Y-%m-%d") as fechaini, DATE_FORMAT(FROM_UNIXTIME(es.enddate), "%Y-%m-%d") as fechafin, es.valueobjective
,(select er.actionpartner from  mdl_objective_establishment_revise er where er.idobjectiveestablishment=es.id) as actionp
,(select er2.actionsixmonth from  mdl_objective_establishment_revise er2 where er2.idobjectiveestablishment=es.id) as actions
,(select er3.bosscomments from  mdl_objective_establishment_revise er3 where er3.idobjectiveestablishment=es.id) as bossc
,(select er4.bosssuggestions from  mdl_objective_establishment_revise er4 where er4.idobjectiveestablishment=es.id) as bosss
,(select er5.id from  mdl_objective_establishment_revise er5 where er5.idobjectiveestablishment=es.id) as idrevision
from  mdl_objective_establishment_captured es
inner join mdl_objective_establishment o on o.id = es.idobjective,
(SELECT @rownum:=0) R
where es.courseid=? and es.idobjective=? and o.idjefedirecto=123 order by es.id ASC';
$resultcontrol = $DB->get_records_sql($querycontrol, array($courseid, $id, $USER->id));
if(empty($resultcontrol)){

    $establecimiento .='<div class="w3-container"><div class="w3-row"> <div class="w3-col ml2">
    <p>EL COLABORADOR AUN NO CAPTURA SUS OBJETIVOS</p>
    </div></div></div>';
   
}else{
  foreach($resultcontrol as $valuecontrol){
    $establecimiento .='<div id="ACTUALIZADOetivos'.$valuecontrol->targetnumber.'">
                            <div class="w3-row">
                                    <div class="w3-col l8 w3-dark-grey">
                                        <p>Breve descripción del objetivo '.$valuecontrol->targetnumber.'</p>
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
                                    <p class="text-cuestion">4. Especifica</p>
                                    <p>'.$valuecontrol->specifyquestion.'</p>
                                </div>
                                <div class="w3-col m2 w3-white w3-center">
                                    <p class="text-cuestion">5. Periodo</p>
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
                        </div>';
    
  }


  $establecimiento .='<button onclick="document.getElementById(\''.$id.'\').style.display=\'block\'" class="w3-button w3-pale-red">Validar Objetivos</button>';

  $establecimiento .='<div id="'.$id.'" class="w3-modal">
    <div class="w3-modal-content w3-card-4">
      <header class="w3-container w3-pale-red"> 
        <span onclick="document.getElementById(\''.$id.'\').style.display=\'none\'" 
        class="w3-button w3-display-topright">&times;</span>
        <h2>Validar objetivos</h2>
      </header>
      <div class="w3-container">
        <p><p class="text-center">Esta seguro de validar los objetivos de tu colaborador</p></p>
      </div>
      <footer class="w3-container w3-pale-red">
      <button onclick="document.getElementById(\''.$id.'\').style.display=\'none\'" type="button" class="w3-button w3-gray">Cancelar</button>
      <a href="validar_objetivos.php?id='.$id.'&instance='.$instance.'" type="button" class="w3-button w3-red">Validar</a>
      </footer>
    </div>
  </div>';

}
           
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
$competencias2 .='</div>
                        </div>
                        </div>
                        <div class="w3-col l1">
                            <p></p>
                        </div>
                        </div>
                        </div><!-- </div></div></div></div> div final-->';
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
echo '<hr><p id="respuesta"></p> <!-- ESTABLECIMIENTO DE OBJETIVOS 6-->
</div>
<div class="w3-col l1"><p></p></div>
</div>
</div>
</div>
</div>
<div class="espacio"></div>
</div>';
echo $competencias1;

$compcolaborador="select id as ido, userid as idu, rol as rcolaborador from mdl_objective_establishment where id=? and courseid=? and idmod=? and idjefedirecto=?";
$colaborador = $DB->get_records_sql($compcolaborador, array($id, $courseid, $instance, $USER->id));
$rolcolaborador='';
foreach($colaborador as $obtencion){
    $obtencion->ido;
    $obtencion->idu;
    $rolcolaborador=$obtencion->rcolaborador;

}
if($rolcolaborador==1){

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


   

}else if($rolcolaborador==2){

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
    


}else if($rolcolaborador==3){

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
//echo'<div id="vista2" class="w3-light-grey vistas" style="display:none;">Hola mundo</div>';

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
            <input type="date" class="form-control"  value="'.$fcha.'"  disabled="yes">
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
                <p>Este apartado está estrechamente ligado con el rubro de objetivos del puesto de trabajo; con esta evaluación conoceremos en qué medida se logran. Es importante que consideres los objetivos de tu jefe inmediato que te presentamos a
                    continuación: *No todos deberán </p>
            </div>
            <div class="w3-col l1">
                <p></p>
            </div>
        </div>';
echo $vistarevision;
echo $vistajefeinmediato;
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
        echo '<form id="revisionjefe" method="POST" action="updaterevision.php" data-parsley-validate="">';
        $requeridcolaborador='required=""';
        foreach($resultcontrol as $valuecontrol){

        $cont=$valuecontrol->contador;
    // $actionp=$valuecontrol->actionp;
    $boos=$valuecontrol->bossc;
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
            <input type="hidden" id="idrevision'.$cont.'" name="idrevision'.$cont.'" value="'.$valuecontrol->idrevision.'" '.$requeridcolaborador.'>
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
                        if(empty($valuecontrol->actionp)){
                            $establecimientorevision .='<p><textarea class="w3-input w3-border" rows="1" cols="10" type="text" id="racciones'.$cont.'" name="racciones'.$cont.'" '.$requeridcolaborador.'></textarea></p>';
                        }else{
                            $establecimientorevision .='<p class="w3-input w3-border">'.$valuecontrol->actionp.'</p>';
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
                if(empty($boos)){
                    $establecimientorevision .='<p><textarea class="w3-input w3-border" rows="1" cols="10" type="text" id="rimplementadas'.$cont.'" name="rimplementadas'.$cont.'" '.$requeridcolaborador.'></textarea></p>';
                }else{
                    $establecimientorevision .='<p class="w3-input w3-border">'.$boos.'</p>';
                }
                $establecimientorevision .='</div>
            <div class="w3-col m6 w3-white w3-center">

                <p class="text-cuestion">Sugerencias sobre acciones a implementar:</p>';
                if(empty($valuecontrol->bosss)){
                    $establecimientorevision .='<p><textarea class="w3-input w3-border" rows="1" cols="10" type="text" id="rimplementar'.$cont.'" name="rimplementar'.$cont.'" '.$requeridcolaborador.'></textarea></p>';
                }else{
                    $establecimientorevision .='<p class="w3-input w3-border">'.$valuecontrol->bosss.'</p>';
                }

                $establecimientorevision .='</div>
            </div>
            </div>
        </div>
    </div>';

        }

        if(empty($boos)){
        $enviorevision .='<input type="submit" id="btnUpdate" name="btnUpdate"  value="Enviar">';
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
        //echo $competencias1;
        /*
        $compcolaborador="select id as ido, userid as idu, rol as rcolaborador from mdl_objective_establishment where id=? and courseid=? and idmod=? and idjefedirecto=?";
        $colaborador = $DB->get_records_sql($compcolaborador, array($id, $courseid, $instance, $USER->id));
        $rolcolaborador='';
        foreach($colaborador as $obtencion){
            $obtencion->ido;
            $obtencion->idu;
            $rolcolaborador=$obtencion->rcolaborador;

        }
        */
    ?>
<form id="idcompetencias" method="POST" action="enviocompetencias.php">
<div class="w3-container">
        <div class="w3-row">
            <div class="w3-col l1">
                <p></p>
            </div>
            <div class="w3-col l10">
                <div class="w3-container">
    <?php

    if($rolcolaborador==1){

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


    

    }else if($rolcolaborador==2){

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
                <div class="w3-round-xlarge w3-col l7  w3-pale-red w3-center">
                    <p>Comportamientos</p>
                </div>
                <div class="w3-round-xlarge w3-col l2  w3-pale-red w3-center">
                <p>Escala de</p>
                </div>
            </div>
            <div class="w3-row">
                <div class="w3-round-xlarge w3-col l3  w3-dark-grey w3-center">
                    <p>Definición de competencias</p>
                </div>
                <div class="w3-round-xlarge w3-col l7  w3-dark-grey w3-center">
                    <p>Comportamientos asociados a la competencia</p>
                </div>
                <div class="w3-round-xlarge w3-col l2  w3-dark-grey w3-center">
                <p>[4][3][2][1]</p>
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
            if(!empty($valorresultado)){

                //print_r($resultado);
                echo '<div class="w3-col l9">
                <table class="w3-table-all">';
                foreach($valorresultado as $comportamiento2){
                    // $idcomportamiento=$comportamiento->id;
                    /*echo'<tr>
                    <td>'.$comportamiento2->description.'</td>';*/
                    if($comportamiento2->code==1){
                    echo'<tr><td>'.$comportamiento2->description.'</td>';
                    echo'<td>';
                    ?>
                                <input type="radio" id="valores<?php echo $comportamiento2->id; ?>" name="valores[<?php echo $comportamiento2->id; ?>][valor]" value="4" <?php if (!(strcmp(4, htmlentities($comportamiento2->value, ENT_COMPAT, 'utf-8')))) {echo "checked";} ?>><label for="valores<?php echo $comportamiento2->id;?>" >4</label>
                                <input type="radio" id="valores<?php echo $comportamiento2->id; ?>" name="valores[<?php echo $comportamiento2->id; ?>][valor]" value="3" <?php if (!(strcmp(3, htmlentities($comportamiento2->value, ENT_COMPAT, 'utf-8')))) {echo "checked";} ?>><label for="valores<?php echo $comportamiento2->id;?>" >3</label>
                                <input type="radio" id="valores<?php echo $comportamiento2->id; ?>" name="valores[<?php echo $comportamiento2->id; ?>][valor]" value="2" <?php if (!(strcmp(2, htmlentities($comportamiento2->value, ENT_COMPAT, 'utf-8')))) {echo "checked";} ?>><label for="valores<?php echo $comportamiento2->id;?>" >2</label>
                                <input type="radio" id="valores<?php echo $comportamiento2->id; ?>" name="valores[<?php echo $comportamiento2->id; ?>][valor]" value="1" <?php if (!(strcmp(1, htmlentities($comportamiento2->value, ENT_COMPAT, 'utf-8')))) {echo "checked";} ?>><label for="valores<?php echo $comportamiento2->id;?>" >1</label>
                    <?php
                    echo'</td>';
                    echo'   <td style="display: none;"><p><input class="w3-input w3-border" type="text" id="valores'.$comportamiento2->id.'" name="valores['.$comportamiento2->id.'][idcompetencia]" value="'.$comportamiento2->idcompetencia.'"></p></td>
                            <td style="display: none;"><p><input class="w3-input w3-border" type="text" id="valores'.$comportamiento2->id.'" name="valores['.$comportamiento2->id.'][idcomportamiento]" value="'.$comportamiento2->id.'"></p></td>
                            <td style="display: none;"><p><input class="w3-input w3-border" type="text" id="valores'.$comportamiento2->id.'" name="valores['.$comportamiento2->id.'][courseid]" value="'.$comportamiento2->courseid.'"></p></td>
                            <td style="display: none;"><p><input class="w3-input w3-border" type="text" id="valores'.$comportamiento2->id.'" name="valores['.$comportamiento2->id.'][userid]" value="'.$USER->id.'"></p></td>
                            <td style="display: none;"><p><input class="w3-input w3-border" type="text" id="valores'.$comportamiento2->id.'" name="valores['.$comportamiento2->id.'][idestablecimiento]" value="'.$id.'"></p></td>
                        </tr>';
                    }else if ($comportamiento2->code==2){
                        echo'<tr><td>'.$comportamiento2->description.'</td>';
                        echo'<td><p><input class="w3-input w3-border" type="text" id="valores'.$comportamiento2->id.'" name="valores['.$comportamiento2->id.'][valor]" value="'.$comportamiento2->value.'"></p></td>';
                        echo'   <td style="display: none;"><p><input class="w3-input w3-border" type="text" id="valores'.$comportamiento2->id.'" name="valores['.$comportamiento2->id.'][idcompetencia]" value="'.$comportamiento2->idcompetencia.'"></p></td>
                                <td style="display: none;"><p><input class="w3-input w3-border" type="text" id="valores'.$comportamiento2->id.'" name="valores['.$comportamiento2->id.'][idcomportamiento]" value="'.$comportamiento2->id.'"></p></td>
                                <td style="display: none;"><p><input class="w3-input w3-border" type="text" id="valores'.$comportamiento2->id.'" name="valores['.$comportamiento2->id.'][courseid]" value="'.$comportamiento2->courseid.'"></p></td>
                                <td style="display: none;"><p><input class="w3-input w3-border" type="text" id="valores'.$comportamiento2->id.'" name="valores['.$comportamiento2->id.'][userid]" value="'.$USER->id.'"></p></td>
                                <td style="display: none;"><p><input class="w3-input w3-border" type="text" id="valores'.$comportamiento2->id.'" name="valores['.$comportamiento2->id.'][idestablecimiento]" value="'.$id.'"></p></td>
                            </tr>';
                    }else if($comportamiento2->code==3){
                        echo'<tr><td>'.$comportamiento2->description.'</td></tr>';
                        echo'<tr><td><textarea class="w3-input w3-border" rows="4" cols="50" type="text" id="valores'.$comportamiento2->id.'" name="valores['.$comportamiento2->id.'][valor]">'.$comportamiento2->value.'</textarea></td>';
                        echo'   <td style="display: none;"><p><input class="w3-input w3-border" type="text" id="valores'.$comportamiento2->id.'" name="valores['.$comportamiento2->id.'][idcompetencia]" value="'.$comportamiento2->idcompetencia.'"></p></td>
                                <td style="display: none;"><p><input class="w3-input w3-border" type="text" id="valores'.$comportamiento2->id.'" name="valores['.$comportamiento2->id.'][idcomportamiento]" value="'.$comportamiento2->id.'"></p></td>
                                <td style="display: none;"><p><input class="w3-input w3-border" type="text" id="valores'.$comportamiento2->id.'" name="valores['.$comportamiento2->id.'][courseid]" value="'.$comportamiento2->courseid.'"></p></td>
                                <td style="display: none;"><p><input class="w3-input w3-border" type="text" id="valores'.$comportamiento2->id.'" name="valores['.$comportamiento2->id.'][userid]" value="'.$USER->id.'"></p></td>
                                <td style="display: none;"><p><input class="w3-input w3-border" type="text" id="valores'.$comportamiento2->id.'" name="valores['.$comportamiento2->id.'][idestablecimiento]" value="'.$id.'"></p></td>
                            </tr>';
                    }else{

                    }

                }
                

            }else{
            

            $consulta='select ocb.id, ocb.description, oc.id as idcompetencia, oc.courseid, oc.idinstance ,ocb.code 
            from mdl_objective_competition_behavior ocb 
            inner join mdl_objective_competition oc on oc.id=ocb.idcompetition
            where ocb.idcompetition=? and ocb.status=0 order by ocb.code asc';
            $resultado = $DB->get_records_sql($consulta, array($valores->idcompe));

            //print_r($resultado);
            echo '<div class="w3-col l9">
                            <table class="w3-table-all">';
                foreach($resultado as $comportamiento2){

                                if($comportamiento2->code==1){
                                    echo'<tr><td>'.$comportamiento2->description.'</td>';
                                    echo'   <td>
                                                <input type="radio" id="valores'.$comportamiento2->id.'" name="valores['.$comportamiento2->id.'][valor]" value="4"><label for="valores'.$comportamiento2->id.'">4</label>
                                                <input type="radio" id="valores'.$comportamiento2->id.'" name="valores['.$comportamiento2->id.'][valor]" value="3"><label for="valores'.$comportamiento2->id.'">3</label>
                                                <input type="radio" id="valores'.$comportamiento2->id.'" name="valores['.$comportamiento2->id.'][valor]" value="2"><label for="valores'.$comportamiento2->id.'">2</label>
                                                <input type="radio" id="valores'.$comportamiento2->id.'" name="valores['.$comportamiento2->id.'][valor]" value="1"><label for="valores'.$comportamiento2->id.'">1</label>
                                            </td>';
                                    echo'   <td style="display: none;"><p><input class="w3-input w3-border" type="text" id="valores'.$comportamiento2->id.'" name="valores['.$comportamiento2->id.'][idcompetencia]" value="'.$comportamiento2->idcompetencia.'"></p></td>
                                            <td style="display: none;"><p><input class="w3-input w3-border" type="text" id="valores'.$comportamiento2->id.'" name="valores['.$comportamiento2->id.'][idcomportamiento]" value="'.$comportamiento2->id.'"></p></td>
                                            <td style="display: none;"><p><input class="w3-input w3-border" type="text" id="valores'.$comportamiento2->id.'" name="valores['.$comportamiento2->id.'][courseid]" value="'.$comportamiento2->courseid.'"></p></td>
                                            <td style="display: none;"><p><input class="w3-input w3-border" type="text" id="valores'.$comportamiento2->id.'" name="valores['.$comportamiento2->id.'][userid]" value="'.$USER->id.'"></p></td>
                                            <td style="display: none;"><p><input class="w3-input w3-border" type="text" id="valores'.$comportamiento2->id.'" name="valores['.$comportamiento2->id.'][idestablecimiento]" value="'.$id.'"></p></td>
                                        </tr>';
                                }else if ($comportamiento2->code==2){
                                    echo'<tr><td>'.$comportamiento2->description.'</td>';
                                    echo'<td><p><input class="w3-input w3-border" type="text" id="valores'.$comportamiento2->id.'" name="valores['.$comportamiento2->id.'][valor]"></p></td>';
                                    echo'   <td style="display: none;"><p><input class="w3-input w3-border" type="text" id="valores'.$comportamiento2->id.'" name="valores['.$comportamiento2->id.'][idcompetencia]" value="'.$comportamiento2->idcompetencia.'"></p></td>
                                            <td style="display: none;"><p><input class="w3-input w3-border" type="text" id="valores'.$comportamiento2->id.'" name="valores['.$comportamiento2->id.'][idcomportamiento]" value="'.$comportamiento2->id.'"></p></td>
                                            <td style="display: none;"><p><input class="w3-input w3-border" type="text" id="valores'.$comportamiento2->id.'" name="valores['.$comportamiento2->id.'][courseid]" value="'.$comportamiento2->courseid.'"></p></td>
                                            <td style="display: none;"><p><input class="w3-input w3-border" type="text" id="valores'.$comportamiento2->id.'" name="valores['.$comportamiento2->id.'][userid]" value="'.$USER->id.'"></p></td>
                                            <td style="display: none;"><p><input class="w3-input w3-border" type="text" id="valores'.$comportamiento2->id.'" name="valores['.$comportamiento2->id.'][idestablecimiento]" value="'.$id.'"></p></td>
                                        </tr>';
                                }else if($comportamiento2->code==3){
                                    echo'<tr><td>'.$comportamiento2->description.'</td></tr>';
                                    echo'<tr><td><textarea class="w3-input w3-border" rows="4" cols="50" type="text" id="valores'.$comportamiento2->id.'" name="valores['.$comportamiento2->id.'][valor]"></textarea></td>';
                                    echo'   <td style="display: none;"><p><input class="w3-input w3-border" type="text" id="valores'.$comportamiento2->id.'" name="valores['.$comportamiento2->id.'][idcompetencia]" value="'.$comportamiento2->idcompetencia.'"></p></td>
                                            <td style="display: none;"><p><input class="w3-input w3-border" type="text" id="valores'.$comportamiento2->id.'" name="valores['.$comportamiento2->id.'][idcomportamiento]" value="'.$comportamiento2->id.'"></p></td>
                                            <td style="display: none;"><p><input class="w3-input w3-border" type="text" id="valores'.$comportamiento2->id.'" name="valores['.$comportamiento2->id.'][courseid]" value="'.$comportamiento2->courseid.'"></p></td>
                                            <td style="display: none;"><p><input class="w3-input w3-border" type="text" id="valores'.$comportamiento2->id.'" name="valores['.$comportamiento2->id.'][userid]" value="'.$USER->id.'"></p></td>
                                            <td style="display: none;"><p><input class="w3-input w3-border" type="text" id="valores'.$comportamiento2->id.'" name="valores['.$comportamiento2->id.'][idestablecimiento]" value="'.$id.'"></p></td>
                                        </tr>';
                                }else{

                                }
                        
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
                    <div class="w3-round-xlarge w3-col l7  w3-pale-red w3-center">
                        <p>Comportamientos</p>
                    </div>
                    <div class="w3-round-xlarge w3-col l2  w3-pale-red w3-center">
                    <p>Escala de</p>
                    </div>
                </div>
                <div class="w3-row">
                    <div class="w3-round-xlarge w3-col l3  w3-dark-grey w3-center">
                        <p>Definición de competencias</p>
                    </div>
                    <div class="w3-round-xlarge w3-col l7  w3-dark-grey w3-center">
                        <p>Comportamientos asociados a la competencia</p>
                    </div>
                    <div class="w3-round-xlarge w3-col l2  w3-dark-grey w3-center">
                    <p>[4][3][2][1]</p>
                    </div>
                </div>';

                echo '<div class="w3-row">
                <div class="w3-col l3">
                    <p>'.$valores2->nombrecompetencia.'</p>
                </div>';

                $valorconsulta2='select ocb.id, ocb.description, oc.id as idcompetencia, oc.courseid, oc.idinstance ,ocb.code, oec.value
                from mdl_objective_competition_behavior ocb 
                inner join mdl_objective_competition oc on oc.id=ocb.idcompetition 
                inner join mdl_objective_establishment_competition oec on oec.idbehavior = ocb.id
                where ocb.idcompetition=? and oec.idobjectiveestablishment=? and ocb.status=0 order by ocb.code asc';
                $valorresultado2 = $DB->get_records_sql($valorconsulta2, array($valores2->idcompe, $id));
                if(!empty($valorresultado2)){
                                //print_r($resultado);
                        echo '<div class="w3-col l9">
                        <table class="w3-table-all">';
                    foreach($valorresultado2 as $comportamientofinal){
                        if($comportamientofinal->code==1){
                            echo'<tr><td>'.$comportamientofinal->description.'</td>';
                            echo'<td>';
                            ?>
                                        <input type="radio" id="valores<?php echo $comportamientofinal->id; ?>" name="valores[<?php echo $comportamientofinal->id; ?>][valor]" value="4" <?php if (!(strcmp(4, htmlentities($comportamientofinal->value, ENT_COMPAT, 'utf-8')))) {echo "checked";} ?>><label for="valores<?php echo $comportamientofinal->id;?>" >4</label>
                                        <input type="radio" id="valores<?php echo $comportamientofinal->id; ?>" name="valores[<?php echo $comportamientofinal->id; ?>][valor]" value="3" <?php if (!(strcmp(3, htmlentities($comportamientofinal->value, ENT_COMPAT, 'utf-8')))) {echo "checked";} ?>><label for="valores<?php echo $comportamientofinal->id;?>" >3</label>
                                        <input type="radio" id="valores<?php echo $comportamientofinal->id; ?>" name="valores[<?php echo $comportamientofinal->id; ?>][valor]" value="2" <?php if (!(strcmp(2, htmlentities($comportamientofinal->value, ENT_COMPAT, 'utf-8')))) {echo "checked";} ?>><label for="valores<?php echo $comportamientofinal->id;?>" >2</label>
                                        <input type="radio" id="valores<?php echo $comportamientofinal->id; ?>" name="valores[<?php echo $comportamientofinal->id; ?>][valor]" value="1" <?php if (!(strcmp(1, htmlentities($comportamientofinal->value, ENT_COMPAT, 'utf-8')))) {echo "checked";} ?>><label for="valores<?php echo $comportamientofinal->id;?>" >1</label>
                            <?php
                            echo'</td>';
                            echo'   <td style="display: none;"><p><input class="w3-input w3-border" type="text" id="valores'.$comportamientofinal->id.'" name="valores['.$comportamientofinal->id.'][idcompetencia]" value="'.$comportamientofinal->idcompetencia.'"></p></td>
                                    <td style="display: none;"><p><input class="w3-input w3-border" type="text" id="valores'.$comportamientofinal->id.'" name="valores['.$comportamientofinal->id.'][idcomportamiento]" value="'.$comportamientofinal->id.'"></p></td>
                                    <td style="display: none;"><p><input class="w3-input w3-border" type="text" id="valores'.$comportamientofinal->id.'" name="valores['.$comportamientofinal->id.'][courseid]" value="'.$comportamientofinal->courseid.'"></p></td>
                                    <td style="display: none;"><p><input class="w3-input w3-border" type="text" id="valores'.$comportamientofinal->id.'" name="valores['.$comportamientofinal->id.'][userid]" value="'.$USER->id.'"></p></td>
                                    <td style="display: none;"><p><input class="w3-input w3-border" type="text" id="valores'.$comportamientofinal->id.'" name="valores['.$comportamientofinal->id.'][idestablecimiento]" value="'.$id.'"></p></td>
                                </tr>';
                            }else if ($comportamientofinal->code==2){
                                echo'<tr><td>'.$comportamientofinal->description.'</td>';
                                echo'<td><p><input class="w3-input w3-border" type="text" id="valores'.$comportamientofinal->id.'" name="valores['.$comportamientofinal->id.'][valor]" value="'.$comportamientofinal->value.'"></p></td>';
                                echo'   <td style="display: none;"><p><input class="w3-input w3-border" type="text" id="valores'.$comportamientofinal->id.'" name="valores['.$comportamientofinal->id.'][idcompetencia]" value="'.$comportamientofinal->idcompetencia.'"></p></td>
                                        <td style="display: none;"><p><input class="w3-input w3-border" type="text" id="valores'.$comportamientofinal->id.'" name="valores['.$comportamientofinal->id.'][idcomportamiento]" value="'.$comportamientofinal->id.'"></p></td>
                                        <td style="display: none;"><p><input class="w3-input w3-border" type="text" id="valores'.$comportamientofinal->id.'" name="valores['.$comportamientofinal->id.'][courseid]" value="'.$comportamientofinal->courseid.'"></p></td>
                                        <td style="display: none;"><p><input class="w3-input w3-border" type="text" id="valores'.$comportamientofinal->id.'" name="valores['.$comportamientofinal->id.'][userid]" value="'.$USER->id.'"></p></td>
                                        <td style="display: none;"><p><input class="w3-input w3-border" type="text" id="valores'.$comportamientofinal->id.'" name="valores['.$comportamientofinal->id.'][idestablecimiento]" value="'.$id.'"></p></td>
                                    </tr>';
                            }else if($comportamientofinal->code==3){
                                echo'<tr><td>'.$comportamientofinal->description.'</td></tr>';
                                echo'<td><textarea class="w3-input w3-border" rows="4" cols="50" type="text" id="valores'.$comportamientofinal->id.'" name="valores['.$comportamientofinal->id.'][valor]">'.$comportamientofinal->value.'</textarea></td>';
                                echo'   <td style="display: none;"><p><input class="w3-input w3-border" type="text" id="valores'.$comportamientofinal->id.'" name="valores['.$comportamientofinal->id.'][idcompetencia]" value="'.$comportamientofinal->idcompetencia.'"></p></td>
                                        <td style="display: none;"><p><input class="w3-input w3-border" type="text" id="valores'.$comportamientofinal->id.'" name="valores['.$comportamientofinal->id.'][idcomportamiento]" value="'.$comportamientofinal->id.'"></p></td>
                                        <td style="display: none;"><p><input class="w3-input w3-border" type="text" id="valores'.$comportamientofinal->id.'" name="valores['.$comportamientofinal->id.'][courseid]" value="'.$comportamientofinal->courseid.'"></p></td>
                                        <td style="display: none;"><p><input class="w3-input w3-border" type="text" id="valores'.$comportamientofinal->id.'" name="valores['.$comportamientofinal->id.'][userid]" value="'.$USER->id.'"></p></td>
                                        <td style="display: none;"><p><input class="w3-input w3-border" type="text" id="valores'.$comportamientofinal->id.'" name="valores['.$comportamientofinal->id.'][idestablecimiento]" value="'.$id.'"></p></td>
                                    </tr>';
                            }else{
        
                            }


                    }
            
                }else{
                                //print_r($resultado);
                    echo '<div class="w3-col l9">
                    <table class="w3-table-all">';
                    $vconsulta2='select ocb.id, ocb.description, oc.id as idcompetencia, oc.courseid, oc.idinstance ,ocb.code 
                    from mdl_objective_competition_behavior ocb 
                    inner join mdl_objective_competition oc on oc.id=ocb.idcompetition
                    where ocb.idcompetition=? and ocb.status=0 order by ocb.code asc';
                    $vresultado2 = $DB->get_records_sql($vconsulta2, array($valores2->idcompe));

                // print_r($resultado2);
                    echo '<div class="w3-col l9">
                                    <table class="w3-table-all">';
                    foreach($vresultado2 as $comportamientofinal){
                        //$idcomportamiento2=$comportamiento2->id;
                        
                    if($comportamientofinal->code==1){
                    echo'<tr>
                            <td>'.$comportamientofinal->description.'</td>';
                    echo'<td>
                        <input type="radio" id="valores'.$comportamientofinal->id.'" name="valores['.$comportamientofinal->id.'][valor]" value="4"><label for="valores'.$comportamientofinal->id.'">4</label>
                        <input type="radio" id="valores'.$comportamientofinal->id.'" name="valores['.$comportamientofinal->id.'][valor]" value="3"><label for="valores'.$comportamientofinal->id.'">3</label>
                        <input type="radio" id="valores'.$comportamientofinal->id.'" name="valores['.$comportamientofinal->id.'][valor]" value="2"><label for="valores'.$comportamientofinal->id.'">2</label>
                        <input type="radio" id="valores'.$comportamientofinal->id.'" name="valores['.$comportamientofinal->id.'][valor]" value="1"><label for="valores'.$comportamientofinal->id.'">1</label>
                    </td>';
                    echo'<td style="display: none;"><p><input class="w3-input w3-border" type="text" id="valores'.$comportamientofinal->id.'" name="valores['.$comportamientofinal->id.'][idcompetencia]" value="'.$comportamientofinal->idcompetencia.'"></p></td>
                    <td style="display: none;"><p><input class="w3-input w3-border" type="text" id="valores'.$comportamientofinal->id.'" name="valores['.$comportamientofinal->id.'][idcomportamiento]" value="'.$comportamientofinal->id.'"></p></td>
                    <td style="display: none;"><p><input class="w3-input w3-border" type="text" id="valores'.$comportamientofinal->id.'" name="valores['.$comportamientofinal->id.'][courseid]" value="'.$comportamientofinal->courseid.'"></p></td>
                    <td style="display: none;"><p><input class="w3-input w3-border" type="text" id="valores'.$comportamientofinal->id.'" name="valores['.$comportamientofinal->id.'][userid]" value="'.$USER->id.'"></p></td>
                    <td style="display: none;"><p><input class="w3-input w3-border" type="text" id="valores'.$comportamientofinal->id.'" name="valores['.$comportamientofinal->id.'][idestablecimiento]" value="'.$id.'"></p></td>
                    </tr>';

                    }else if ($comportamientofinal->code==2){
                    echo'<tr>
                        <td>'.$comportamientofinal->description.'</td>';
                    echo'<td><p><input class="w3-input w3-border" type="text" id="valores'.$comportamientofinal->id.'" name="valores['.$comportamientofinal->id.'][valor]"></p></td>';
                    echo'<td style="display: none;"><p><input class="w3-input w3-border" type="text" id="valores'.$comportamientofinal->id.'" name="valores['.$comportamientofinal->id.'][idcompetencia]" value="'.$comportamientofinal->idcompetencia.'"></p></td>
                        <td style="display: none;"><p><input class="w3-input w3-border" type="text" id="valores'.$comportamientofinal->id.'" name="valores['.$comportamientofinal->id.'][idcomportamiento]" value="'.$comportamientofinal->id.'"></p></td>
                        <td style="display: none;"><p><input class="w3-input w3-border" type="text" id="valores'.$comportamientofinal->id.'" name="valores['.$comportamientofinal->id.'][courseid]" value="'.$comportamientofinal->courseid.'"></p></td>
                        <td style="display: none;"><p><input class="w3-input w3-border" type="text" id="valores'.$comportamientofinal->id.'" name="valores['.$comportamientofinal->id.'][userid]" value="'.$USER->id.'"></p></td>
                        <td style="display: none;"><p><input class="w3-input w3-border" type="text" id="valores'.$comportamientofinal->id.'" name="valores['.$comportamientofinal->id.'][idestablecimiento]" value="'.$id.'"></p></td>
                        </tr>';
                    }else if($comportamientofinal->code==3){
                    echo'<tr>
                    <td style="width: 82% !important;">'.$comportamientofinal->description.'</td><tr>';
                    echo'<tr><td><textarea class="w3-input w3-border" rows="4" cols="50" type="text" id="valores'.$comportamientofinal->id.'" name="valores['.$comportamientofinal->id.'][valor]"></textarea></td></tr>';
                    echo'<td style="display: none;"><p><input class="w3-input w3-border" type="text" id="valores'.$comportamientofinal->id.'" name="valores['.$comportamientofinal->id.'][idcompetencia]" value="'.$comportamientofinal->idcompetencia.'"></p></td>
                    <td style="display: none;"><p><input class="w3-input w3-border" type="text" id="valores'.$comportamientofinal->id.'" name="valores['.$comportamientofinal->id.'][idcomportamiento]" value="'.$comportamientofinal->id.'"></p></td>
                    <td style="display: none;"><p><input class="w3-input w3-border" type="text" id="valores'.$comportamientofinal->id.'" name="valores['.$comportamientofinal->id.'][courseid]" value="'.$comportamientofinal->courseid.'"></p></td>
                    <td style="display: none;"><p><input class="w3-input w3-border" type="text" id="valores'.$comportamientofinal->id.'" name="valores['.$comportamientofinal->id.'][userid]" value="'.$USER->id.'"></p></td>
                    <td style="display: none;"><p><input class="w3-input w3-border" type="text" id="valores'.$comportamientofinal->id.'" name="valores['.$comportamientofinal->id.'][idestablecimiento]" value="'.$id.'"></p></td>
                    </tr>';
                    }else{
                    
                    }
        
                }
                        
                    
            }
                    echo '</table></div>';
                    echo'</div><div class="espacio"></div>';
                
        }
                


    }else if($rolcolaborador==3){

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
    echo '</form><input type="submit" id="btnCompetencia" name="btnCompetencia"  value="Calificar Compétencias"><button onclick="document.getElementById(\'revision'.$id.'\').style.display=\'block\'" class="w3-button w3-pale-red">Validar Revision</button><div id="revision'.$id.'" class="w3-modal">
    <div class="w3-modal-content w3-card-4">
      <header class="w3-container w3-pale-red"> 
        <span onclick="document.getElementById(\'revision'.$id.'\').style.display=\'none\'" 
        class="w3-button w3-display-topright">&times;</span>
        <h2>Validar objetivos</h2>
      </header>
      <div class="w3-container">
        <p><p class="text-center">Esta seguro de validar los objetivos de tu colaborador</p></p>
      </div>
      <footer class="w3-container w3-pale-red">
      <button onclick="document.getElementById(\'revision'.$id.'\').style.display=\'none\'" type="button" class="w3-button w3-gray">Cancelar</button>
      <a href="validar_revision.php?id='.$id.'&instance='.$instance.'" type="button" class="w3-button w3-red">Validar</a>
      </footer>
    </div>
  </div></div> <!-- cierra vista -->';
    
    echo $competencias2;
/*INICIA VISTA 3*/
echo'<div id="vista3" class="w3-light-grey vistas" style="display: none;">Hola mundo</div>';

echo'<style>input.parsley-error,
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

    $('#revisionjefe').parsley().on('field:validated', function() {
        var ok = $('.parsley-error').length === 0;
        $('.bs-callout-info').toggleClass('hidden', !ok);
        $('.bs-callout-warning').toggleClass('hidden', ok);
    })


    $("#revisionjefe").bind("submit",function(){
        // Capturamnos el boton de envío
        var btnUpdate = $("#btnUpdate");
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
                btnUpdate.val("Enviando"); // Para input de tipo button
                btnUpdate.attr("disabled","disabled");
            },
            complete:function(data){
                /*
                * Se ejecuta al termino de la petición
                * */
                btnUpdate.val("Enviar formulario");
                btnUpdate.removeAttr("disabled");
            },
            success: function(data){
                /*
                * Se ejecuta cuando termina la petición y esta ha sido
                * correcta
                * */
                $("#rev").html(data);
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