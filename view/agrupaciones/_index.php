<?php  
    include("../lib/helpers.php"); 
    include("../view/header_form.php");
?>
<script type="text/javascript" src="js/app/evt_form_agrupaciones.js" ></script>
<script type="text/javascript" src="js/validateradiobutton.js"></script>
<div class="div_container">
<h6 class="ui-widget-header">&nbsp;</h6>
<?php echo $more_options; ?>     
<div class="contain2">     
<?php header_form('ASIGNACION A GRUPOS'); ?>       
<div class="box-msg"></div>
<form id="frm" action="index.php" method="POST">
    <input type="hidden" name="controller" value="agrupaciones" />
    <input type="hidden" name="action" value="save" />
    <div class="contFrm ui-corner-all" style="background: #fff;">
        <br/>
        <label for="idperfil" class="labels">Grupos:</label>
        <?php echo $grupo; ?>            
        <br/>
        <label for="idpropietario" class="labels">Propietario:</label>
        <?php echo $propietario; ?>
        <br/>
        <label for="idchofer" class="labels">Chofer:</label>
        <?php echo $chofer; ?>
        <br/>
        <label for="idvehiculo" class="labels">Vehiculo:</label>
        <select name="idvehiculo" id="idvehiculo" class="ui-widget-content ui-corner-all text">
            <option value="">...</option>
        </select>
        <br/>
        <div  style="clear: both; padding: 10px; width: auto;text-align: center">
            <a href="#" id="add" class="button">AGREGAR</a>            
        </div>
        
        <div id="detalle">
        	<?php echo $detalle; ?>
       	</div>
    </div>
</form>
</div>
</div> 