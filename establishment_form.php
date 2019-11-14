<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



require_once("{$CFG->libdir}/formslib.php");

 
class newestablishment_form extends moodleform {
    //Lucius - En definition definimos la estructura de nuestro formulario.
    //Lucius - La funcion definition() está definida en la clase moodleform del archivo formslib.php
           
    
    function definition() {
        global $DB, $COURSE, $USER;

        $mform=& $this->_form;
        
        $mform->addElement('header','displayinfo', 'Inicia tu establecimiento de Objetivos', null, false);
        $mform->addElement('hidden', 'userid');
        $mform->addElement('hidden','idmod');
        $mform->addElement('hidden', 'courseid');
        $mform->addElement('hidden','idinstance');
        $mform->addElement('hidden', 'timecreated');
        $mform->addElement('hidden','timemodified');
        $mform->addElement('hidden','status', 0);

/*
        $optionstatus = array(
                
            '0' => 'CREADO',
            '1' => 'AUTORIZADO',
            '2' => 'REVISADO',
            '3' => 'FINALIZADO'
        );
*/

        $sql="select distinct u.id ,MAX(gu.rol) as idrol,
        CASE
        WHEN MAX(gu.rol) = 1 THEN 'COLABORADOR'
        WHEN MAX(gu.rol) = 2 THEN 'JEFE INMEDIATO'
        WHEN MAX(gu.rol) = 3 THEN 'DIRECTOR'
        ELSE 'SIN VALOR'
        END AS estatus
        from mdl_user u 
        inner join mdl_objective_groups_users gu on gu.idusuario = u.id
        inner join mdl_objective_groups g on g.id = gu.idgroup
        inner join mdl_objective_groups_rol dr on dr.id=gu.rol
        where u.id=?
        group by u.id";

        $query="select distinct u.id as 'iduser',( SELECT gu.idusuario as 'idjefegrupo' from mdl_objective_groups_users gu where gu.idgroup=og.id and gu.rol in (3,2)) AS 'idjefegrupo'
        from mdl_user u 
        left join mdl_user_info_data id on id.userid = u.id
        left join mdl_user_info_field ii on ii.id = id.fieldid 
	left join mdl_objective_establishment oe on oe.userid = u.id
        left join mdl_objective o on o.id = oe.idinstance
        left join mdl_objective_groups_users ogu on ogu.idusuario = u.id
        left join mdl_objective_groups og on og.id = ogu.idgroup
        left join mdl_objective_groups_rol  ogr on ogr.id =  oe.rol
        where u.id=? and ogu.rol=1";

        $result = $DB->get_records_sql($query, array($USER->id));

        foreach($result as $value){

        $mform->addElement('hidden','idjefedirecto',$value->idjefegrupo);

        }

        $cats = $DB->get_records_sql($sql, array($USER->id));
        $options=array();
        foreach($cats as $cat){

    

            $options[$cat->idrol]=$cat->estatus;

           
        }
        
       // $mform->addElement('hidden', 'namegroup', $perfil);
         // Adding the standard "name" field.
        $select = $mform->addElement('select', 'rol', 'Rol', $options);
        $select->setSelected('0');
        $mform->addRule('rol', null, 'required', null, 'client');
/*
        $select = $mform->addElement('select', 'status', 'ESTATUS', $optionstatus);
        $select->setSelected('1');
        $mform->addRule('status', null, 'required', null, 'client');

*/

        $this->add_action_buttons();
      

// Add standard buttons.
        
    }
}