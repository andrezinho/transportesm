<?php  
       include("../lib/helpers.php"); 
       include("../view/header_form.php"); 
?>
<script type="text/javascript" src="js/app/evt_form_itinerario.js" ></script>
<script type="text/javascript" src="js/validateradiobutton.js"></script>
<div class="div_container">
<h6 class="ui-widget-header">&nbsp;</h6>
<?php echo $more_options; ?>     
<div class="contain2" > 
<?php header_form('Mantenimiento de itinerario'); ?>
<form id="frm" action="index.php" method="POST">
    <input type="hidden" name="controller" value="itinerario" />
    <input type="hidden" name="action" value="save" />
    <div class="contFrm ui-corner-all" style="background: #fff;">
                <label for="iditinerario" class="labels" style="width:130px">Codigo:</label>
                <input id="iditinerario" name="iditinerario" class="text ui-widget-content ui-corner-all" style=" width: 100px; text-align: left;" value="<?php echo $obj->iditinerario; ?>" readonly />
                <br/>
                <label for="descripcion" class="labels" style="width:130px">Origen:</label>
                <?php echo $origen; ?>
                <br/>
                <label for="descripcion" class="labels" style="width:130px">Destino:</label>
                <?php echo $destino; ?>
                <br>
                <label for="precio" class="labels" style="width:130px">Precio Pasaje:</label>
                <input type="text" name="precio" id="precio" value="<?php echo $obj->precio; ?>" class="ui-widget-content ui-corner-all text"  style="width:100px;" /> (*Valor Referencial)
                <br/>
                <label for="precio_ticket" class="labels" style="width:130px">Precio Ticket:</label>
                <input type="text" name="precio_ticket" id="precio_ticket" value="<?php echo $obj->precio_ticket; ?>" class="ui-widget-content ui-corner-all text"  style="width:100px;" /> (*Valor Referencial)
                <br/>
                <label for="precio_encomienda" class="labels" style="width:130px">Precio Encomienda:</label>
                <input type="text" name="precio_encomienda" id="precio_encomienda" value="<?php echo $obj->precio_encomienda; ?>" class="ui-widget-content ui-corner-all text"  style="width:100px;" /> (*Valor Referencial)
                <div  style="clear: both; padding: 10px; width: auto;text-align: center">
                    <a href="#" id="save" class="button">GRABAR</a>
                    <a href="index.php?controller=itinerario" class="button">ATRAS</a>
                </div>        
    </div>
</form>
</div>
</div> 