<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



require_once("{$CFG->libdir}/formslib.php");



 
class newcompetition_form extends moodleform {
    //Lucius - En definition definimos la estructura de nuestro formulario.
    //Lucius - La funcion definition() está definida en la clase moodleform del archivo formslib.php
    function definition() {
     
        global $DB, $COURSE;
        $mform=& $this->_form;
        

        
         
  
        $mform->addElement('header','displayinfo', 'Crea nueva competencia', null, false);
        $mform->addElement('hidden', 'userid');
        $mform->addElement('hidden', 'idinstance');
        $mform->addElement('hidden', 'courseid');
        $mform->addElement('hidden','idmod','0');
        $mform->addElement('hidden', 'timecreated');
        $mform->addElement('hidden','timemodified');
/**/


        $sql="select * FROM {objective_nivel} og WHERE og.courseid=? ORDER BY og.id DESC";

        $cats = $DB->get_records_sql($sql, array($COURSE->id));

        $options = array();
        
        foreach($cats as $cat){

            $options[$cat->id]=$cat->namenivel;
        }
        
        $options2 = array(
            '1' => '10',
            '2' => '9',
            '3' => '8',
            '4' => '7',
            '5' => '6',
            '6' => '5',
            '7' => '4',
            '8' => '3',
            '9' => '2',
            '10' => '1',
            '11' => '0',
            '12' => '-1',
            '13' => '-2',
            '14' => '-3',
            '15' => '-4',
            '16' => '-5',
            '17' => '-6',
            '18' => '-7',
            '19' => '-8',
            '20' => '-9',

        );
    

    
    
         // Adding the standard "name" field.

         
        $select = $mform->addElement('select', 'idnivel', 'Nivel', $options);
        $select->setSelected('3');
        $mform->addRule('idnivel', null, 'required', null, 'client');

        $mform->addElement('text', 'name', 'Nombre de la competencia', 'maxlength="80"');
        $mform ->setType ('name' , PARAM_RAW);                    // Establecer el tipo de elemento 
        $mform->addRule('name', null, 'required', null, 'client'); 

        $mform->addElement('text', 'code', 'Codigo', 'maxlength="80"');
        $mform ->setType ('code' , PARAM_RAW);                    // Establecer el tipo de elemento 
        $mform->addRule('code', null, 'required', null, 'client'); 
                 
        $select = $mform->addElement('select', 'orden', 'Ordena la competencia', $options2);
        $select->setSelected('0');
        $mform->addRule('orden', null, 'required', null, 'client');





        /*
        $mform->addElement('textarea', 'description','Descripción', 'wrap="virtual" rows="20" cols="50"');
        $mform ->setType ('description' , PARAM_RAW);                    // Establecer el tipo de elemento 
        $mform->addRule('description', null, 'required', null, 'client'); 
        $select = $mform->addElement('select', 'status', 'Estatus', $options2);
        $select->setSelected('1');
        $mform->addRule('status', null, 'required', null, 'client');*/





        $this->add_action_buttons();
      

// Add standard buttons.
        
    }
}