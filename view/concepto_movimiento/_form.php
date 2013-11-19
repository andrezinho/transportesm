<?php  include("../lib/helpers.php"); 
       include("../view/header_form.php");
?>
<script type="text/javascript" src="js/app/evt_form_concepto_movimiento.js" ></script>
<script type="text/javascript" src="js/validateradiobutton.js"></script>
<div class="div_container">
<h6 class="ui-widget-header">&nbsp;</h6>
<?php echo $more_options; ?>     
<div class="contain2" > 
<?php header_form('Registro de concepto movimiento'); ?> 
<form id="frm" action="index.php" method="POST">
    <input type="hidden" name="controller" value="concepto_movimiento" />
    <input type="hidden" name="action" value="save" />
    <div class="contFrm ui-corner-all" style="background: #fff;">
        
                
                <label for="idconcepto_movimiento" class="labels">Codigo:</label>
                <input id="idconcepto_movimiento" name="idconcepto_movimiento" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->idconcepto_movimiento; ?>" readonly />
                <br/>
                <label for="tipo" class="labels">Tipo:</label>
                <?php echo $descripcion; ?>
                <br/>
                <label for="descripcion" class="labels">Descripcion:</label>
                <input id="descripcion" maxlength="100" name="descripcion" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->descripcion; ?>" />
                <br>
                    
                <div  style="clear: both; padding: 10px; width: auto;text-align: center">
                    <a href="#" id="save" class="button">GRABAR</a>
                    <a href="index.php?controller=concepto_movimiento" class="button">ATRAS</a>
                </div>
        
    </div>
</form>
</div>
</div> 