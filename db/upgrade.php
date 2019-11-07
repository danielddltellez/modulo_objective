
<?PHP
function xmldb_objective_upgrade( $oldversion = 0 )  { 

        // Agregar nuevos campos a la tabla de certificados. 
        $table  =  new xmldb_table ( 'objective' ) ; 
        $field  =  new xmldb_field ( 'showcode' ) ; 
        $field -> set_attributes ( XMLDB_TYPE_INTEGER ,  '1' , XMLDB_UNSIGNED , XMLDB_NOTNULL ,  null,  '0' ,  'saveind' ) ; 
        if  ( !$dbman->field_exists ( $table ,  $field ) )  { 
            $dbman->add_field ( $table ,  $field ) ; 
        } 
        // Añadir nuevos campos a la tabla certificate_issues. 
       /* $table  =  new xmldb_table ( 'objective_issues' ) ; 
        $field  =  new xmldb_field ( 'código' ) ; 
        $campo->set_attributes ( XMLDB_TYPE_CHAR ,  '50' ,  null ,  null ,  null ,  null ,  'objectiveid' ) ; 
        if  ( !$dbman->field_exists ($table ,  $field ) )  { 
            $dbman->add_field ( $table ,  $field ) ; 
        }*/
 
        // Se ha alcanzado el punto de salvaguarda del certificado. 
        upgrade_mod_savepoint ( true ,  2019040300  ,  'objective' ) ; 
    
}

?>
