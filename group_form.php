<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



require_once("{$CFG->libdir}/formslib.php");



 
class newgroup_form extends moodleform {
    //Lucius - En definition definimos la estructura de nuestro formulario.
    //Lucius - La funcion definition() está definida en la clase moodleform del archivo formslib.php
    function definition() {
        global $DB, $COURSE;

        $mform=& $this->_form;
        

        
         
  
        $mform->addElement('header','displayinfo', 'Crea nuevo grupo', null, false);
        $mform->addElement('hidden', 'userid');
        $mform->addElement('hidden', 'idinstance');
        $mform->addElement('hidden', 'courseid');
        $mform->addElement('hidden','idmod','0');
        $mform->addElement('hidden', 'timecreated');
        $mform->addElement('hidden','timemodified');

        $sql="select * FROM {objective_groups} og WHERE og.courseid=? ORDER BY og.id ASC";

        $cats = $DB->get_records_sql($sql, array($COURSE->id));

        $options = array();
        $options['0']='SUPERIOR';
        foreach($cats as $cat){

            $options[$cat->id]=$cat->namegroup;
        }
        
/*
        $options = array(
            '0' => 'SUPERIOR'
        );*/

        $options2 = array(
            '0' => 'Inactivo',
            '1' => 'Activo'
        );
    
         // Adding the standard "name" field.
        $mform->addElement('text', 'namegroup', 'Nombre del grupo', 'maxlength="80"');
        $mform ->setType ('namegroup' , PARAM_RAW);                    // Establecer el tipo de elemento 
        $mform->addRule('namegroup', null, 'required', null, 'client'); 

        
        $select = $mform->addElement('select', 'category', 'Categoria', $options);
        $select->setSelected('0');
        $mform->addRule('category', null, 'required', null, 'client');

        $select = $mform->addElement('select', 'status', 'Estatus', $options2);
        $select->setSelected('1');
        $mform->addRule('status', null, 'required', null, 'client');




        $this->add_action_buttons();
      

// Add standard buttons.
        
    }
}