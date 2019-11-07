<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



require_once("{$CFG->libdir}/formslib.php");



 
class newquiz_form extends moodleform {
    //Daniel - En definition definimos la estructura de nuestro formulario.
    //Daniel - La funcion definition() está definida en la clase moodleform del archivo formslib.php
    function definition() {
     
        global $DB, $COURSE;
        $mform=& $this->_form;
        

        
         
  
        $mform->addElement('header','displayinfo', 'Crea nuevo Nivel', null, false);
        $mform->addElement('hidden', 'userid');
        $mform->addElement('hidden', 'idinstance');
        $mform->addElement('hidden', 'courseid');
        $mform->addElement('hidden','idmod','0');
/**/


        $sql="select * FROM {objective_quiz_format} qf ORDER BY qf.id ASC";

        $cats = $DB->get_records_sql($sql, array($COURSE->id));

        $options = array();
        foreach($cats as $cat){

            $options[$cat->id]=$cat->description;
        }
        
        $options2 = array(
            '0' => 'Inactivo',
            '1' => 'Activo'
        );
    
         // Adding the standard "name" field.
        $mform->addElement('text', 'name', 'Nombre del Cuestionario', 'maxlength="80"');
        $mform ->setType ('name' , PARAM_RAW);                    // Establecer el tipo de elemento 
        $mform->addRule('name', null, 'required', null, 'client'); 


        $select = $mform->addElement('select', 'idformat', 'Formato al que pertenece', $options);
        $select->setSelected('1');
        $mform->addRule('idformat', null, 'required', null, 'client');



        $select = $mform->addElement('select', 'status', 'Estatus', $options2);
        $select->setSelected('1');
        $mform->addRule('status', null, 'required', null, 'client');




        $this->add_action_buttons();
      

// Add standard buttons.
        
    }
}