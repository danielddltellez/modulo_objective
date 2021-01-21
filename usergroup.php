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

require_once('groupuser_form.php');

global $DB, $OUTPUT, $USER;

// Check for all required variables.
$courseid = required_param('courseid', PARAM_INT);
// Next look for optional variables.
$id = optional_param('idgroup',0, PARAM_INT);
$instance = optional_param('instance', 0, PARAM_INT); 
//$a = optional_param('param', 0, PARAM_INT); 

if (!$course = $DB->get_record('course', array('id' => $courseid))) {
    print_error('invalidcourse', 'objective', $courseid);
}

require_login($course); 

$PAGE->set_url('/mod/objective/usergroup.php', array('courseid' => $courseid,'instance' => $instance, 'idgroup' => $id, 'param' => $a));
$PAGE->set_pagelayout('standard');
$groupuserform = new newgroupuser_form();
$toform['userid'] = $USER->id;
$toform['courseid'] = $courseid;
$toform['instance'] = $instance;
$toform['idgroup'] = $id;
$toform['timecreated'] = time();
$toform['timemodified'] = time();
$groupuserform->set_data($toform);


$courseurl = new moodle_url('/mod/objective/viewusergroup.php', array('courseid' => $courseid,'instance' => $instance, 'id' => $id));

//Form processing and displaying is done here
if ($groupuserform->is_cancelled()) {

  redirect($courseurl);



    //Handle form cancel operation, if cancel button is present on form
} else if ($fromform = $groupuserform->get_data()) {
    global $DB;

    //In this case you process validated data. $mform->get_data() returns data posted in form.
   
    $rol = $fromform->rol;
    $idgrupos = $fromform->idgroup;
    $idjefe = $fromform->idusuario;
    $idcourse=$fromform->courseid;
    $idmod=$fromform->instance;
   // echo $rol;
    //echo '<br>';
   $insertusergroup = $DB->insert_record('objective_groups_users', $fromform);
   //print_r($insertusergroup);
   //echo '<br/>';
   //echo $rol;
   //exit();
   // echo '<br>';
/*   
if($rol==2 || $rol==3){

    $sql="select b.id , a.idgroup , b.userid, b.rol , b.status from {objective_groups_users} a
    join {objective_establishment} b on a.idusuario=b.userid
    where a.idgroup=?
    and b.courseid=?
    and b.idmod=?
    and b.userid !=?";
    $viewusers = $DB->get_records_sql($sql, array($idgrupos,$idcourse,$idmod,$idjefe));

    foreach($viewusers as  $values){

        $idestablecimiento= $values->id;

        $record6 = new stdClass();
        $record6-> id = $idestablecimiento;
        $record6-> idjefedirecto = $idjefe;
        $record6-> status = 1;
        try{
          $lastupdateid = $DB->update_record('objective_establishment', $record6, $bulk=false);
        

        } catch(\Throwable $e) {
          
          echo 'ERROR AL ACTUALIZAR OBJETIVO 6';
        } 
        $sqlreiniciarobj="select id from {objective_establishment_captured} where idobjective=? and status !=?";
        $idreiniciarobj = $DB->get_records_sql($sqlreiniciarobj, array($idestablecimiento,3));
        foreach($idreiniciarobj as $val){

          $idobj=$val->id;
          $record = new stdClass();
          $record-> id = $idobj;
          $record-> comentariosjefe = NULL;
          $record-> status = 0;

              try{
                $updatecaptured = $DB->update_record('objective_establishment_captured', $record, $bulk=false);
            
          
              } catch(\Throwable $e) {
              
                echo 'Error al actualizar los objetivos';
              } 


        }
    }

    $cambiorol="select id from {objective_establishment} where userid=?";
    $cambior = $DB->get_records_sql($cambiorol, array($idjefe));

    foreach($cambior as $vals){

      $idest=$vals->id;
      $record = new stdClass();
      $record-> id = $idest;
      $record-> rol = 2;

      
      try{
        $updaterol = $DB->update_record('objective_establishment', $record, $bulk=false);
    
  
      } catch(\Throwable $e) {
        
        echo 'Error al actualizar los objetivos';
      } 




    }

}else{

    $queryestableciminetousuario="select id as idcolaboradorestablecimiento from {objective_establishment} where userid=? and courseid=?";
    $querycolaborador = $DB->get_records_sql($queryestableciminetousuario, array($idjefe , $idcourse));

    if(!empty($querycolaborador)){

        foreach($querycolaborador as $valores){

          $idestcolaborador=$valores->idcolaboradorestablecimiento;

        } 
        $query="select a.idusuario as idjefeinmediato
        from {objective_groups_users} a
        where a.idgroup=?
        and a.courseid=?
        and a.rol !=?";
        $queryjefe = $DB->get_records_sql($query, array($idgrupos,$idcourse,1));

        if(!empty($queryjefe)){
            foreach($queryjefe as $cat){
            $idjefedecolab= $cat->idjefeinmediato;
            }
        }else{

            $queryjefedejefe="select a.id, a.idusuario, 
              (select a2.idusuario as jefe from {objective_groups_users} a2 where a2.rol !=1 and a2.idgroup = b.category) as idjefejefe
              from {objective_groups_users} a
              join {objective_groups} b on b.id=a.idgroup
              where a.idgroup=?
              and a.courseid=?
              and a.rol =?
              and a.idusuario = ?";
              $resultadodejefe = $DB->get_records_sql($queryjefedejefe, array($idgrupos,$idcourse,1, $idjefe));
              foreach($resultadodejefe as $cate){
                $idjefedecolab=$cate->idjefejefe;
              }

        }

        $actjefeesta = new stdClass();
        $actjefeesta -> id = $idestcolaborador;
        $actjefeesta -> idjefedirecto = $idjefedecolab;
        $actjefeesta -> status = 1;

        try{

            $updateestabcolaborador = $DB->update_record('objective_establishment', $actjefeesta, $bulk=false);
  
          } catch(\Throwable $e) {
          
            echo 'ERROR AL ACTUALIZAR OBJETIVO 6';
          } 



    }
  
}
*/
  //exit();







  redirect($courseurl);



} else {
  // this branch is executed if the form is submitted but the data doesn't validate and the form should be redisplayed
  // or on the first display of the form.
	 $site = get_site();
     echo $OUTPUT->header();
    
  //Set default data (if any)
  $groupuserform->set_data($toform);
  //displays the form
  $groupuserform->display(); 
      echo $OUTPUT->footer();
}

