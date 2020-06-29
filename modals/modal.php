<div class="modal fade" id="delete_group<?php echo $value->id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <center><h4 class="modal-title" id="myModalLabel">Borrar el grupo</h4></center>
            </div>
            <div class="modal-body">    
                <p class="text-center">¿Esta seguro de Borrar el grupo?</p>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
                <a href="delete.php?idgrupo=<?php echo $value->id; ?>" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span>Borrar</a>
            </div>
        </div>
    </div>
</div>
<div  class="modal fade" id="edit_group_user<?php echo  $values->id; ?>" role="dialog">
                <div class="modal-dialog">
                     <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Actualizar datos del usuario</h4>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal" method="POST" action="update.php?idgrupouser=<?php echo $values->id; ?>">

                                <div class="form-group">
                                    <label class="col-xs-3 control-label" for="nombrecompleto"><?php echo $values->nombrecompleto; ?></label>
                                   
                                <span class="help-block"></span></div>
                                <div class="form-group" id="updatestatus<?php echo  $values->id; ?>">
                                    <label class="control-label col-md-3" for="status">Acciones</label>
                                    <div class="col-md-9">
                                        <select class="form-control" id="status" name="status<?php echo  $values->id; ?>">
                                        <option value="0">Habilitar</option>
                                        <option value="1">Inhabilitar</option>
                                        </select>
                                    </div>
                                <span class="help-block"></span></div>
                        </div>
                        
                        <div class="modal-footer">

                           <button type="button" class="btn btn-link" data-dismiss="modal">Cerrar</button>
                          <input class="btn btn-primary submitBtn" name="editarusuariogrupo"  type="submit"  value="actualizar" />
                        </div>
                    </form>
                    </div>
                </div>

            </div>
<div class="modal fade" id="delete_group_user<?php echo $values->id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <center><h4 class="modal-title" id="myModalLabel">Borrar usuario del grupo</h4></center>
            </div>
            <div class="modal-body">    
                <p class="text-center">¿Esta seguro de Borrar el <?php echo $values->description; ?> del grupo?</p>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
                <a href="delete.php?idgrupouser=<?php echo $values->id; ?>" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span>Borrar</a>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="delete_nivel<?php echo $value->id; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <center><h4 class="modal-title" id="myModalLabel">Borrar nivel</h4></center>
            </div>
            <div class="modal-body">    
                <p class="text-center">¿Esta seguro de Borrar el nivel?</p>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancelar</button>
                <a href="delete.php?idnivel=<?php echo $value->id; ?>" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span>Borrar</a>
            </div>
        </div>
    </div>
</div>

