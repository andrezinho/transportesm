<?php  include("../lib/helpers.php"); 
       include("../view/header_form.php");
?>
<script type="text/javascript" src="js/app/evt_form_salida.js" ></script>
<script type="text/javascript" src="js/validateradiobutton.js"></script>
<div class="div_container">
<h6 class="ui-widget-header">&nbsp;</h6>
<?php echo $more_options; ?>
<div class="contain2">
<?php header_form('INGRESOS / TICKETS'); ?>  
<form id="frm" action="index.php" method="POST">
    <input type="hidden" name="controller" value="salida" />
    <input type="hidden" name="action" value="save" />    
    <div class="box-msg" style="display:none"></div>
    <div class="contFrm">        
        <div class="contenido" >                            
            <h3 class="stitle">TICKETS DE SALIDAS</h3>    
            <fieldset class="ui-corner-all">
                <legend>Datos Basicos</legend>
                <?php 
                    $estados = array(0=>'ANULADO',1=>'RESERVADO',2=>'DISPONIBLE',3=>'EN CURSO',4=>'CONCLUIDO');
                      if($obj->idsalida!="")
                    {
                ?>
                <div style="padding:5px 0; text-align:center; background:#dadada; margin:0 0 10px 0; font-weight:bold">ESTADO : <?php echo $estados[$obj->estado] ?></div>            
                <?php } ?>
                <label for="idsalida" class="labels" style="width:130px">N°:</label>
                <input type="text" id="idsalida" name="idsalida" class="text ui-widget-content ui-corner-all" style=" text-align: center;" value="<?php if($obj->idsalida!=""){ echo str_pad($obj->idsalida,8,'0',0); }?>" readonly="" size="10"  />
                <br/>
                <label for="fecha" class="labels" style="width:130px">Fecha:</label>
                <input type="text" name="fecha" id="fecha" value="<?php if($obj->fecha!=""){echo fdate($obj->fecha,"ES");} else {echo date('d/m/Y');} ?>" class="ui-widget-content ui-corner-all text" size="10" style="text-align: center" title="Ingrese la Fecha" readonly="" />                                                
                <label for="hora" class="labels" style="width:60px">Hora:</label>
                <input type="text" name="hora" id="hora" value="<?php if($obj->hora!=""){echo $obj->hora;} else {echo date('H:i');} ?>" class="ui-widget-content ui-corner-all text" size="6" style="text-align: center" readonly="" />                                                
                <br/>
                <label for="idchofer" class="labels" style="width:130px">Chofer:</label>
                <div class="ui-widget" style="display:inline-block">
                <?php echo $chofer; ?>
                </div>
                <br/>
                <label for="idvehiculo" class="labels" style="width:130px">Vehiculo:</label>
                <?php echo $vehiculo; ?>
                <br/>
                <label for="origen" class="labels" style="width:130px">Salida de:</label>                               
                <input type="text" name="origen" id="origen" value="<?php echo $_SESSION['sucursal'] ?>" readonly="true" class="ui-widget-content ui-corner-all text" style="text-align:left; width:150px;" />
                <br/>
                <label for="iddestino" class="labels" style="width:130px">Con destino a:</label>                               
                <?php echo $destino; ?>
                <br/>
                <label for="precio" class="labels" style="width:130px">Precio:</label>
                <input type="text" name="precio" id="precio" class="ui-widget-content ui-corner-all text" value="<?php if($obj->monto!=""){echo $obj->monto;} else {echo "0.00";} ?>" style="text-align: right" /> S/.
                <?php 
                    if($obj->tipo!="") { if($obj->tipo==1){ echo "(Ida y Vuelta)"; } else {echo "(Solo Ida)";} } 
                    else {
                ?>    
                <br/><br/>
                <label for="iyv" class="labels" style="width:130px">Ida y Vuelta:</label>
                <input type="checkbox" name="iyv" id="iyv" value="1" /><br/>
                <?php }
                ?>
                
                <?php 
                if($obj->numero!="")
                {
                    ?>                
                    <br/>
                    <label for="nrooc" class="labels" style="width:130px">Numero:</label>
                    <input type="hidden" name="serie" id="serie" value="<?php echo $obj->serie;?>" class="ui-widget-content ui-corner-all text" size="4" title="Serie del Documento" readonly="" />                                
                    <input type="text" name="numero" id="numero" value="<?php echo $obj->numero;?>" class="ui-widget-content ui-corner-all text" size="10" title="Numero del Documento" onkeypress="" readonly="" disabled="" />
                    <?php 
                    }
                else {
                    ?>
                <br/>           
                <label for="gticket" class="labels" style="width:130px">Generar Ticket:</label>
                <input type="checkbox" name="gticket" id="gticket" value="1" checked="" />
                <?php
                }
                if($obj->idsalida!="")
                {
                ?>                
                <br/>
                <label for="fechasalida" class="labels" style="width:130px">Fecha de Salida:</label>
                <input type="text" name="fechasalida" id="fechasalida" value="<?php echo fdate($obj->fecha_sal,"ES"); ?>" class="ui-widget-content ui-corner-all text" size="10" style="text-align: center" readonly="" disabled="" />
                <label for="hora_sal" class="labels" style="width:60px">Hora:</label>
                <input type="text" name="hora_sal" id="hora_sal" value="<?php echo $obj->hora_sal; ?>" class="ui-widget-content ui-corner-all text" size="6" style="text-align: center" readonly="" disabled="" />                                                
                <br/>
                <label for="fechallegada" class="labels" style="width:130px">Fecha de Llegada:</label>
                <input type="text" name="fechallegada" id="fechallegada" value="<?php echo fdate($obj->fecha_llegada,"ES"); ?>" class="ui-widget-content ui-corner-all text" size="10" style="text-align: center" readonly="" disabled="" />
                <label for="hora_llegada" class="labels" style="width:60px">Hora:</label>
                <input type="text" name="hora_llegada" id="hora_llegada" value="<?php echo $obj->hora_llegada; ?>" class="ui-widget-content ui-corner-all text" size="6" style="text-align: center" readonly="" disabled="" />                                                
                <?php 
                }   
                ?>
                <br/>
          </fieldset>          
          <div  style="clear: both; padding: 5px; width: auto;text-align: center">
            <?php if($_GET['action']!="show") { ?>
            <a href="#" id="save" class="button">GRABAR</a>
            <?php } 
            else {
                if($obj->estado=="1")
                {
                ?>
                <a href="index.php?controller=salida&action=anular&id=<?php echo $_GET['id']; ?>" class="button">ANULAR</a>
                <?php
            }
            }
            ?>
            <a href="index.php?controller=<?php echo $_GET['controller'] ?>" class="button">ATRAS</a>
          </div>
        </div>
    </div>
</form>
</div>
</div>