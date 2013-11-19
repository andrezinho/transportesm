<?php  include("../lib/helpers.php"); 
       include("../view/header_form.php");
?>
<script type="text/javascript" src="js/app/evt_form_vehiculo.js" ></script>
<script type="text/javascript" src="js/validateradiobutton.js"></script>
<div class="div_container">
<h6 class="ui-widget-header">&nbsp;</h6>
<?php echo $more_options; ?>     
<div class="contain2"> 
<?php header_form('Mantenimiento de vehiculos'); ?>   
<form id="frm" action="index.php" method="POST">
    <input type="hidden" name="controller" value="vehiculo" />
    <input type="hidden" name="action" value="save" />
    <div class="contFrm ui-corner-all" style="background: #fff;">
        
                
                <label for="idvehiculo" class="labels">Codigo:</label>
                <input id="idvehiculo" name="idvehiculo" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->idvehiculo; ?>" readonly />
                <label for="marca" class="labels">Marca:</label>
                <input id="marca" maxlength="100" name="marca" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->marca; ?>" />
                <br>
                <br/>
                <label for="modelo" class="labels">Modelo:</label>
                <input id="modelo" maxlength="100" name="modelo" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->modelo; ?>" />
                <label for="placa" class="labels">Placa:</label>
                <input id="placa" maxlength="100" name="placa" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->placa; ?>" />
                <br>
                <br/>
                <label for="serie_motor" class="labels">Serie (Motor):</label>
                <input id="serie_motor" maxlength="100" name="serie_motor" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->serie_motor; ?>" />
                <label for="anio_fabricacion" class="labels">Año Fabric.:</label>
                <input id="anio_fabricacion" maxlength="4" name="anio_fabricacion" class="text ui-widget-content ui-corner-all" onkeypress="return permite(event,'num')"  style=" width: 200px; text-align: left;" value="<?php echo $obj->anio_fabricacion; ?>" />
                <br>
                <br/>
                <label for="serie_chasis" class="labels">Serie (Chasis):</label>
                <input id="serie_chasis" maxlength="100" name="serie_chasis" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->serie_chasis; ?>" />
                <label for="color" class="labels">Color:</label>
                <input id="color" maxlength="100" name="color" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->color; ?>" />
                <br>
                <br/>
                <label for="fecha_inscripcion" class="labels">Fec. Insc.:</label>
                <input id="fecha_inscripcion" maxlength="8" name="fecha_inscripcion" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->fecha_inscripcion; ?>" />
                <label for="estado" class="labels">Estado:</label>
                <?php echo $estado; ?>
                <br>
                <br/>
                <label for="fec_ven_soat" class="labels">Fec. Venc. (SOAT):</label>
                <input id="fec_ven_soat" maxlength="8" name="fec_ven_soat" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->fec_ven_soat; ?>" />
                <label for="fec_ven_rev" class="labels">Fec. Venc. (Rev.Tec.):</label>
                <input id="fec_ven_rev" maxlength="8" name="fec_ven_rev" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->fec_ven_rev; ?>" />
                <br>
                <br/>
               <label for="idempleado" class="labels" style="width:100px">Propietario:</label>
                <input type="text" name="idempleado" id="idempleado" maxlength="8" value="<?php echo $obj->idpropietario; ?>" class="ui-widget-content ui-corner-all text" onkeypress="return permite(event,'num')"  size="10"  />                
                <input type="text" name="nombre" id="nombre" value="<?php echo $obj->propietario; ?>" class="ui-widget-content ui-corner-all text" title="Nombre del Propietario"  style="width:300px;"/>                
                <br/>
                    
                <div  style="clear: both; padding: 10px; width: auto;text-align: center">
                    <a href="#" id="save" class="button">GRABAR</a>
                    <a href="index.php?controller=vehiculo" class="button">ATRAS</a>
                </div>
        
    </div>
</form>
</div>
</div> 