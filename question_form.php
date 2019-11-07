<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



require_once("{$CFG->libdir}/formslib.php");



 
class newquestion_form extends moodleform {
    //Daniel - En definition definimos la estructura de nuestro formulario.
    //Daniel - La funcion definition() está definida en la clase moodleform del archivo formslib.php
    function definition() {
     
        global $DB, $COURSE;
        $mform=& $this->_form;
        

        
         
  
        $mform->addElement('header','displayinfo', 'Crea nueva pregunta', null, false);
        $mform->addElement('hidden', 'userid');
       $mform->addElement('hidden', 'idinstance');
        $mform->addElement('hidden', 'courseid');
        $mform->addElement('hidden','idquiz');
/**/

/*
        $sql="select * FROM {objective_quiz_format} qf ORDER BY qf.id ASC";

        $cats = $DB->get_records_sql($sql, array($COURSE->id));

        $options = array();
        foreach($cats as $cat){

            $options[$cat->id]=$cat->description;
        }
        */
        $option = array(
            '1' => '1',
            '2' => '2',
            '3' => '3',
            '4' => '4',
            '5' => '5',
            '6' => '6',
            '7' => '7',
            '8' => '8',
            '9' => '9',
            '10' => '10'
        );
        $option2 = array(
            '1' => 'COLABORADOR',
            '2' => 'JEFE INMEDIATO'
        );

        
        $sql="select * FROM {objective_question_type} ORDER BY id ASC";

        $result = $DB->get_records_sql($sql, array());

        $options3 = array();
        foreach($result as $value){

            $options3[$value->id]=$value->description;
        }


        $mform->addElement('text', 'code', 'Codigo', 'maxlength="100"');
        $mform ->setType ('code' , PARAM_RAW);                    // Establecer el tipo de elemento 
        $mform->addRule('code', null, 'required', null, 'client'); 

        
         // Adding the standard "name" field.
        $mform->addElement('text', 'description', 'Enunciado de la pregunta', 'maxlength="100"');
        $mform ->setType ('description' , PARAM_RAW);                    // Establecer el tipo de elemento 
        $mform->addRule('description', null, 'required', null, 'client'); 


        $select = $mform->addElement('select', 'orden', 'Elige la posicion de la pregunta', $option);
        $select->setSelected('0');
        $mform->addRule('orden', null, 'required', null, 'client');

        $select = $mform->addElement('select', 'responsable', 'Contesta el: ', $option2);
        $select->setSelected('0');
        $mform->addRule('responsable', null, 'required', null, 'client');

        $select = $mform->addElement('select', 'typequiz', 'Tipo de pregunta ', $options3);
        $select->setSelected('1');
        $mform->addRule('typequiz', null, 'required', null, 'client');








        $this->add_action_buttons();
      

// Add standard buttons.
        
    }
}