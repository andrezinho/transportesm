<?php  include("../lib/helpers.php"); 
       include("../view/header_form.php");
?>
<script type="text/javascript" src="js/app/evt_form_venta.js" ></script>
<script type="text/javascript" src="js/validateradiobutton.js"></script>
<div class="div_container">
<h6 class="ui-widget-header">PROCESOS/VENTAS</h6>
<?php echo $more_options; ?>
<div class="contain2">
<?php header_form('GESTION DE VENTAS'); ?>  
<form id="frm" action="index.php" method="POST">
    <input type="hidden" name="controller" value="venta" />
    <input type="hidden" name="action" value="save" />
    <div class="box-msg" style="display:none"></div>
    <div class="contFrm">            
        <div class="contenido" >                            
            <?php if($obj->idventa=="")
            {
            ?>
            <div style="text-align: right">
            Tipo de Venta:
            <select id="tipo_venta" name="tipo_venta" style="background: #72A9D3; color:#fff; border: 0; padding: .1em">
                <option value="1">Venta de Pasajes</option>           
                <option value="2">Venta Otros</option>
            </select>
            </div>
            <?php
            }
            ?>
            <fieldset class="ui-corner-all">
                <legend>Datos Basicos</legend>            
                <label for="idventa" class="labels" style="width:130px">N°:</label>
                <input type="text" id="idventa" name="idventa" class="text ui-widget-content ui-corner-all" style=" text-align: center; width:100px" value="<?php if($obj->idventa!=""){ echo str_pad($obj->idventa,8,'0',0); }?>" readonly=""  />                
                <label for="fecha" class="labels" style="width:109px">Fecha:</label>
                <input type="text" name="fecha" id="fecha" value="<?php if($obj->fecha!=""){echo fdate($obj->fecha,"ES");} else {echo date('d/m/Y');} ?>" class="ui-widget-content ui-corner-all text" size="10" style="text-align: center" title="Ingrese la Fecha" readonly="" />                
                <br/>
                <label for="nrooc" class="labels" style="width:130px">Documento:</label>
                <?php echo $tipo_documento; ?>
                <label for="nrooc" class="labels" style="width:110px">Serie-Numero:</label>
                <input type="text" name="serie" id="serie" value="<?php echo $obj->serie;?>" class="ui-widget-content ui-corner-all text" title="Serie del Documento" readonly="" style="width:50px" />                                
                <input type="text" name="numero" id="numero" value="<?php echo $obj->numero;?>" class="ui-widget-content ui-corner-all text" title="Numero del Documento" onkeypress="" readonly="" />
                <br/>                
                <label for="idpasajero" class="labels" style="width:130px" id="pasaj">Pasajero (DNI):</label>
                <input type="hidden" name="idpasajero" id="idpasajero" value="<?php echo $obj->idpasajero; ?>" />
                <input type="text" name="nrodocumento" id="nrodocumento" value="<?php echo $obj->nrodocumento; ?>" class="ui-widget-content ui-corner-all text" size="13" title="Nro de Documento" onkeypress="return permite(event,'num')" />
                <input type="text" name="nombre" id="nombre" value="<?php echo $obj->nombre; ?>" class="ui-widget-content ui-corner-all text" title="Nombre Pasajero" style="width:400px"  />
                <br/>
                <label for="direccion" class="labels" style="width: 130px;">Direccion: </label>
                <input type="text" name="direccion" id="direccion" value="<?php echo $obj->direccion; ?>" class="ui-widget-content ui-corner-all text" title="Direccion" style="width:510px" />                
                <br/>
                <div id="gr" style="display: none">
                    <label for="guia_remision" class="labels" style="width: 130px;">Guia de Remision: </label>
                    <input type="text" name="guia_remision" id="guia_remision" value="<?php echo $obj->guia_remision; ?>" class="ui-widget-content ui-corner-all text" size="70" title="guia de remision" />
                </div>
                <br/>                
          </fieldset>
          <?php if($_GET['action']!="show") { ?>
          <fieldset class="ui-corner-all" style="background: #fafafa;">
            <legend>Detalle de Venta</legend>             
            <div id="box-itinerario">
            <label id="liditinerario" for="iditinerario" class="labels" style="width:100px">Itinerario:</label>
            <?php echo $itinerario; ?>       
            </div>
            <label for="descripcioni" class="labels" style="width:100px">Descripcion:</label>
            <input type="text" name="descripcioni" id="descripcioni" value="" class="ui-widget-content ui-corner-all text" style="width:390px" />
            <label for="precio" class="labels" style="width:50px">Precio:</label>
            <input type="tex" name="precio" id="precio" value="0.00" class="ui-widget-content ui-corner-all text" onkeypress="venter(event)" style="width:50px" />
            <label for="precio" class="labels" style="width:40px">Cant:</label>
            <input type="tex" name="cantidad" id="cantidad" value="1" class="ui-widget-content ui-corner-all text" maxlength="1" style="width:15px;" />                 
            <a href="javascript:" id="adddetalle"  class="button">
            Agregar </a>            
          </fieldset>
          <?php } ?>
          <div id="div-detalle">
            <?php echo $detalle; ?>
          </div>
                <div  style="clear: both; padding: 5px; width: auto;text-align: center">
                     <?php if($_GET['action']!="show") { ?>
                        <a href="#div-msg" id="save" class="button">GRABAR</a>
                        <?php } 
                        else {
                            if($obj->estado=="1")
                            {
                            ?>
                            <a href="index.php?controller=venta&action=anular&id=<?php echo $_GET['id']; ?>" class="button">ANULAR</a>
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