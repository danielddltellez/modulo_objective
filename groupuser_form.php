<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



require_once("{$CFG->libdir}/formslib.php");

$idgrupo = $_GET['idgroup'];



 
class newgroupuser_form extends moodleform {
    //Lucius - En definition definimos la estructura de nuestro formulario.
    //Lucius - La funcion definition() está definida en la clase moodleform del archivo formslib.php
           
    
    function definition() {
        global $DB, $COURSE, $idgrupo;

        $mform=& $this->_form;
        
        $mform->addElement('header','displayinfo', 'Crea nuevo grupo', null, false);
        $mform->addElement('hidden', 'userid');
        $mform->addElement('hidden', 'courseid');
        $mform->addElement('hidden','idgroup');
        $mform->addElement('hidden', 'timecreated');
        $mform->addElement('hidden','timemodified');
        $mform->addElement('hidden','instance');





        $validar="select distinct ob.id
        from mdl_objective_groups ob 
        where ob.courseid=? and ob.category=? and ob.id=?";
        $result = $DB->get_records_sql($validar, array($COURSE->id, 0, $idgrupo));

        if($result != null){

            $validacion="select id from {objective_groups_users} where courseid=? and idgroup=? and rol=? and status=?";
            $resultado = $DB->get_records_sql($validacion, array($COURSE->id, $idgrupo, 3, 0));
            if($resultado == NULL){
            
            
                $options2 = array(
                    '3' => 'DIRECTOR',
                    '1' => 'COLABORADOR'
                    
                );
            }else{
                $options2 = array(
                        
                    '1' => 'COLABORADOR'
                );


            }
   
        }else{

                $validacion="select id from {objective_groups_users} where courseid=? and idgroup=? and rol=? and status=?";

                $resultado = $DB->get_records_sql($validacion, array($COURSE->id, $idgrupo, 2, 0));

                if($resultado == NULL){
                    $options2 = array(
                        '2' => 'JEFE INMEDIATO',
                        '1' => 'COLABORADOR'
                    );
                
                    
                }else{
                    $options2 = array(
                        
                        '1' => 'COLABORADOR'
                    );
                
                
                }
                  
        }

        $optionstatus = array(
                
            '0' => 'HABILITADO',
            '1' => 'INHABILITAR'
        );

        $sql="select u.id as idusuario , concat(u.firstname, ' ',u.lastname) as nombrecompleto  FROM {user} u INNER JOIN {role_assignments} ra ON (u.id = ra.userid) INNER JOIN {context} ctx ON (ra.contextid = ctx.id) INNER JOIN {course} c ON (ctx.instanceid = c.id) WHERE ctx.contextlevel = 50 and ra.roleid = 5 and u.suspended = 0  and c.id=? and u.id NOT IN (select idusuario from {objective_groups_users} where idgroup=?) ORDER BY nombrecompleto ASC
        ";
        $cats = $DB->get_records_sql($sql, array($COURSE->id, $idgrupo));

        $options = array();
        foreach($cats as $cat){

            $options[$cat->idusuario]=$cat->nombrecompleto;
        }
        
       
         // Adding the standard "name" field.
        $select = $mform->addElement('select', 'idusuario', 'Selecciona Empleado', $options);
        $select->setSelected('0');
        $mform->addRule('idusuario', null, 'required', null, 'client');

        $select = $mform->addElement('select', 'rol', 'Rol', $options2);
        $select->setSelected('1');
        $mform->addRule('rol', null, 'required', null, 'client');

        $select = $mform->addElement('select', 'status', 'ESTATUS', $optionstatus);
        $select->setSelected('0');
        $mform->addRule('status', null, 'required', null, 'client');



        $this->add_action_buttons();
      

// Add standard buttons.
        
    }
}