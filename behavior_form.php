<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



require_once("{$CFG->libdir}/formslib.php");

//$idcompetition = $_GET['idcompetition'];



 
class newbehavior_form extends moodleform {
    //Lucius - En definition definimos la estructura de nuestro formulario.
    //Lucius - La funcion definition() está definida en la clase moodleform del archivo formslib.php
           
    
    function definition() {
        //global $DB, $COURSE;

        $mform=& $this->_form;
        
        $mform->addElement('header','displayinfo', 'Crea nuevo comportamiento', null, false);
        $mform->addElement('hidden', 'userid');
        $mform->addElement('hidden', 'courseid');
        $mform->addElement('hidden','idcompetition');
        $mform->addElement('hidden', 'timecreated');
        $mform->addElement('hidden','timemodified');
        $mform->addElement('hidden','instance');


        $optionstatus = array(
                
            '0' => 'HABILITADO',
            '1' => 'INHABILITAR'
        );

       
         // Adding the standard "name" field.
        $mform->addElement('text', 'code', 'Codigo de comportamiento', 'maxlength="80"');
        $mform ->setType ('code' , PARAM_RAW);                    // Establecer el tipo de elemento 
        $mform->addRule('code', null, 'required', null, 'client'); 

        $mform->addElement('textarea', 'description','Descripción de comportamiento', 'wrap="virtual" rows="10" cols="80"');
        $mform ->setType ('description' , PARAM_RAW);                    // Establecer el tipo de elemento 
        $mform->addRule('description', null, 'required', null, 'client');  



        $select = $mform->addElement('select', 'status', 'ESTATUS', $optionstatus);
        $select->setSelected('0');
        $mform->addRule('status', null, 'required', null, 'client');



        $this->add_action_buttons();
      

// Add standard buttons.
        
    }
}