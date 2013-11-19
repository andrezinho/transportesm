<?php  include("../lib/helpers.php"); 
       include("../view/header_form.php");
?>
<script type="text/javascript" src="js/app/evt_form_proveedor.js" ></script>
<script type="text/javascript" src="js/validateradiobutton.js"></script>
<div class="div_container">
<h6 class="ui-widget-header">&nbsp;</h6>
<?php echo $more_options; ?>     
<div class="contain2" > 
<?php header_form('Mantenimiento de proveedor'); ?>   
<form id="frm" action="index.php" method="POST">
    <input type="hidden" name="controller" value="proveedor" />
    <input type="hidden" name="action" value="save" />
    <div class="contFrm ui-corner-all" style="background: #fff;">
                <label for="idproveedor" class="labels">Codigo:</label>
                <input id="idproveedor" name="idproveedor" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->idproveedor; ?>" readonly />
                <label for="razonsocial" class="labels">Razon Social:</label>
                <input id="razonsocial" maxlength="100" name="razonsocial" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->razonsocial; ?>" />
                <br>
                <label for="ruc" class="labels">Ruc/Dni:</label>
                <input id="ruc" maxlength="100" name="ruc" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->ruc; ?>" />
                <label for="direccion" class="labels">Direccion:</label>
                <input id="direccion" maxlength="100" name="direccion" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->direccion; ?>" />
                <br>
                <label for="telefonos" class="labels">Telf/Cel/Rpm:</label>
                <input id="telefonos" maxlength="100" name="telefonos" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->telefonos; ?>" />
                <br>
                    
                <div  style="clear: both; padding: 10px; width: auto;text-align: center">
                    <a href="#" id="save" class="button">GRABAR</a>
                    <a href="index.php?controller=proveedor" class="button">ATRAS</a>
                </div>
        
    </div>
</form>
</div>
</div> 