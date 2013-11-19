<?php  include("../lib/helpers.php"); 
       include("../view/header_form.php");
?>
<script type="text/javascript" src="js/app/evt_form_oficina.js" ></script>
<script type="text/javascript" src="js/validateradiobutton.js"></script>
<div class="div_container">
<h6 class="ui-widget-header">&nbsp;</h6>
<?php echo $more_options; ?>     
<div class="contain2" > 
<?php header_form('Mantenimiento de Oficina'); ?>   
<form id="frm" action="index.php" method="POST">
    <input type="hidden" name="controller" value="oficina" />
    <input type="hidden" name="action" value="save" />
    <div class="contFrm ui-corner-all" style="background: #fff;">
                <label for="idoficina" class="labels">Codigo:</label>
                <input id="idoficina" name="idoficina" class="text ui-widget-content ui-corner-all" style=" width: 100px; text-align: left;" value="<?php echo $obj->idoficina; ?>" readonly />
                <br/>
                <label for="idsucursal" class="labels">Sucursal: </label>
                <?php echo $sucursal; ?>                   
                <br/>
                <label for="descripcion" class="labels">Descripcion:</label>
                <input id="descripcion" maxlength="100" name="descripcion" class="text ui-widget-content ui-corner-all" style=" width: 300px; text-align: left;" value="<?php echo $obj->descripcion; ?>" />
                <br/>
                <label for="direccion" class="labels">Direccion: </label>
                <input id="direccion" maxlength="100" name="direccion" class="text ui-widget-content ui-corner-all" style=" width: 300px; text-align: left;" value="<?php echo $obj->direccion; ?>" />
                <br/>
                <label for="telefono" class="labels">telefono: </label>
                <input id="telefono" maxlength="100" name="telefono" class="text ui-widget-content ui-corner-all" style=" width: 300px; text-align: left;" value="<?php echo $obj->telefono; ?>" />                    
                <br/>
                <label for="caja" class="labels">Caja: </label>
                <?php 
                    $ck = "";
                    if($obj->caja==1)
                    {
                        $ck = "checked=''";
                    }
                ?>                
                <input type="checkbox" name="caja" id="caja" value="1" <?php echo $ck; ?> />
                Si.
                <div  style="clear: both; padding: 10px; width: auto;text-align: center">
                    <a href="#" id="save" class="button">GRABAR</a>
                    <a href="index.php?controller=oficina" class="button">ATRAS</a>
                </div>
        
    </div>
</form>
</div>
</div> 