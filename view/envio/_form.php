<?php  include("../lib/helpers.php"); 
       include("../view/header_form.php");  ?>
<script type="text/javascript" src="js/app/evt_form_envio.js" ></script>
<script type="text/javascript" src="js/validateradiobutton.js"></script>
<div class="div_container">
<h6 class="ui-widget-header">&nbsp;</h6>
<?php echo $more_options; ?>
<div class="contain2">
<?php header_form('ENCOMIENDAS Y ENVIOS'); ?>  
<form id="frm" action="index.php" method="POST">
    <input type="hidden" name="controller" value="envio" />
    <input type="hidden" name="action" value="save" />             
    <?php if($obj->estado!=1&&$obj->idenvio!="") 
    {
        ?>
        <div class="box-msg ui-state-error-adz" style="width:inherit"><?php echo $msg; ?></div>
        <?php
    } 
    else 
    {
        ?>
        <div class="box-msg" style="display:none"></div>
        <?php
    }
    ?>    
    <div class="contFrm">    
        <div class="contenido" >                            
            <h3 class="stitle">GUIA DE CORRESPONDENCIA</h3>
            <fieldset class="ui-corner-all">
                <legend>Datos Basicos</legend>            
                <label for="idenvio" class="labels" style="width:130px">N°:</label>
                <input type="text" id="idenvio" name="idenvio" class="text ui-widget-content ui-corner-all" style=" text-align: center;width:60px" value="<?php if($obj->idenvio!=""){ echo $obj->idenvio; }?>" readonly=""  />                
                <label for="fecha" class="labels" style="width:80px">Fecha:</label>
                <input type="text" name="fecha" id="fecha" value="<?php if($obj->fecha!=""){echo fdate($obj->fecha,"ES");} else {echo date('d/m/Y');} ?>" class="ui-widget-content ui-corner-all text" size="10" style="text-align: center" title="Ingrese la Fecha" readonly="" />                                                
                <?php $w = 80; if(isset($obj->idenvio)) { $w = 130; ?>
                <label for="nrooc" class="labels" style="width:130px">Serie-Numero:</label>
                <input type="text" name="serie" id="serie" value="<?php echo $obj->serie;?>" class="ui-widget-content ui-corner-all text" title="Serie del Documento" readonly="" style="width:40px" />
                <input type="text" name="numero" id="numero" value="<?php echo $obj->numero;?>" class="ui-widget-content ui-corner-all text"  title="Numero del Documento" onkeypress="" readonly="" style="width:80px" /> 
                <br/>  
                <?php } ?>
                <label for="iddestino" class="labels" style="width:<?php echo $w; ?>px">Destino:</label>
                <?php echo $destino; ?>            
                <br/>  
                <?php 
                if($contrae!="1")
                {    
                    ?>
                    <label for="salidas" class="labels" style="width:130px">Salidas Disponibles:</label>                
                    <?php 
                    if($obj->idenvio!="") 
                    { 
                        if($obj->estado==1)
                            {
                                echo $salidasok;  
                            }
                        else 
                            {
                                echo $obj->salida;
                            }                            
                    } 
                    else 
                    {                
                        ?>                              
                        <select name="salidas" id="salidas" class="ui-widget-content ui-corner-all text" >
                            <option value="">-No hay disponibles-</option>
                        </select>
                        <?php 
                    } 
                    ?>

                    <?php 
                    if($obj->estado==1||$obj->estado=="")
                    { 
                        ?>
                        <a href="javascript:" class="box-boton boton-refresh" title="Recargar Lista de Salidas" id="reload-salidas"></a>
                        <a href="index.php?controller=salida&action=create" target="_blank" class="box-boton boton-new" title="Registrar Nueva Salida" style="margin-left:10px"></a>                
                        <a href="javascript:" style="font-weight:bold">&nbsp;</a>                
                        <span id="loadsalida" style="display:none"><img src="images/loader.gif"/> Buscando Salidas Disponibles ...</span>                
                        <?php 
                    } 
                    echo '<br/> ';
                }
                ?>
                               
                <label for="idremitente" class="labels" style="width:130px">Remitente:</label>
                <input type="hidden" name="idremitente" id="idremitente" value="<?php echo $obj->idremitente; ?>" />
                <?php if($obj->nrodocumentor!="00000000") 
                        { $display = "inline"; $ck = ""; } 
                       else {$display = "none"; $ck = "checked"; }
                ?>
                <input type="text" name="nrodocumentor" id="nrodocumentor" value="<?php echo $obj->nrodocumentor; ?>" class="ui-widget-content ui-corner-all text" size="13" title="Nro de Documento" onkeypress="return permite(event,'num')" maxlength="11" placeholder="Nro Documento" style="display:<?php echo $display; ?>" />
                <input type="text" name="remitente" id="remitente" value="<?php echo $obj->remitente; ?>" class="ui-widget-content ui-corner-all text" title="Nombre del Remitente" style="width:394px" placeholder="Nombres y/o Razon Social" />
                <span style="margin-left: 10px; padding: 2px 5px; background: #dadada;">
                    <input type="checkbox" name="sdni" id="sdni" value="1" <?php echo $ck; ?>  />
                    <label for="sdni" style="color:blue; cursor: pointer">Sin DNI</label>
                </span>
                <br/>
                <label for="idconsignado" class="labels" style="width:130px">Consignado a:</label>
                <input type="hidden" name="idconsignado" id="idconsignado" value="<?php echo $obj->idconsignado; ?>" />
                <input type="hidden" name="nrodocumentoc" id="nrodocumentoc" value="<?php echo $obj->nrodocumentoc; ?>" class="ui-widget-content ui-corner-all text" size="13" title="Nro de Documento" onkeypress="return permite(event,'num')" />
                <input type="text" name="consignado" id="consignado" value="<?php echo $obj->consignado; ?>" class="ui-widget-content ui-corner-all text" title="Nombre del Consignado" style="width:502px;" placeholder="Nombres del Consignado" />
                <br/>
                <label for="idconsignado" class="labels" style="width:130px">Atentamente :</label>
                <input type="text" name="atentamente" id="atentamente" value="<?php echo $obj->atentamente; ?>" class="ui-widget-content ui-corner-all text" title="Atentamente" style="width:502px;" placeholder="Nombres del Representante" /> (* Opcional)
                <br/>
                
                <label for="direccion" class="labels" style="width: 130px;">Direccion: </label>
                <input type="text" name="direccion" id="direccion" value="<?php echo $obj->direccion; ?>" class="ui-widget-content ui-corner-all text" title="Direccion" style="width:502px;" placeholder="Direccion de domicilio y/o oficina del consignado" />                
                <label for="adomicilio" style="font-size:9px; margin-left:15px; color:blue">ENTREGA A DOMICILIO:</label>
                <?php $ck=""; if($obj->adomicilio==1) { $ck ="checked"; } ?>
                <input type="checkbox" name="adomicilio" id="adomicilio" value="1" <?php echo $ck; ?> /> 
                <br/>
                <label for="precio_encomienda" class="labels" style="width:130px">Contra-Entrega:</label>
                <?php $ck=""; if($obj->cpago==1) { $ck ="checked"; } ?>
                <?php if($_GET['action']=="create") { ?>
                <input type="checkbox" name="cp" id="cp" value="1" <?php echo $ck; ?> /> Si
                <?php } 
                    else 
                    {
                        if($obj->cpago==1)  echo "<b>SI</b>";
                            else echo "<b>NO</b>";
                    }
                ?>
                <span id="div-conf-salida" style="display:none">
                    <label for="confirma_salida" class="labels" style="width:130px">Confirmar Salida:</label>
                    <input type="checkbox" name="confirma_salida" id="confirma_salida" value="1" /> Si<br/>
                </span>
                <br/>       
          </fieldset>
          <?php if($_GET['action']!="show"&&$contrae!="1") 
          { 
            ?>
            <fieldset class="ui-corner-all" style="background: #fafafa;">
                <legend>Detalle de envio</legend>             
                <label for="descripcion" class="labels" style="width:10px">&nbsp;</label>
                <input type="text" name="descripcion" id="descripcion" value="" class="ui-widget-content ui-corner-all text" maxlength="300" style="width:40%" placeholder="Descripcion del objeto a enviar..." />                
                <label for="cantidad" class="labels" style="width:50px">Cant:</label>
                <input type="text" name="cantidad" id="cantidad" value="1" class="ui-widget-content ui-corner-all text" maxlength="1" style="width:15px;" onkeypress="return permite(event,'num')" />                 
                <label for="precio" class="labels" style="width:50px">Monto:</label>
                <input type="text" name="precio" id="precio" value="5.00" class="ui-widget-content ui-corner-all text money" onkeypress="return permite(event,'num')" style="width:40px" /> S/.
                <label for="subtt" class="labels" style="width:70px">Sub total:</label>
                <input type="text" name="stt" id="stt" value="5.00" class="ui-widget-content ui-corner-all text money" onkeypress="return permite(event,'num')" style="width:40px" readonly="readonly" /> S/.
                <span style="background:#dadada; padding:4px 3px 3px 3px; display:none">
                    <label for="precioc" class="labels" style="width:90px">Monto Caja:</label>
                    <input type="text" name="precioc" id="precioc" value="0.00" class="ui-widget-content ui-corner-all text money" onkeypress="return permite(event,'num')" style="width:40px;" /> S/.
                    <label for="precio" class="labels" style="width:90px">Sub total Caja:</label>
                    <input type="text" name="sttc" id="sttc" value="0.00" class="ui-widget-content ui-corner-all text money" onkeypress="return permite(event,'num')" style="width:40px;" readonly="readonly" />S/.
                </span>
                <a href="javascript:" id="adddetalle"  class="button">
                    Agregar 
                </a>            
            </fieldset>
            <?php 
            } ?>
          <div id="div-detalle">
            <?php echo $detalle; ?>
          </div>
          <?php 
            $display = "block";
            if($_GET['action']=='edit' && $obj->cpago==1) { $display = "none"; }
          ?>
          <div style="background:#9FD89D; text-align:center; display:<?php echo $display; ?>" id="tr-ce">                
            <b>MONTO A CAJA S/.</b>
            <input type="text" name="monto_caja" id="monto_caja"  value = "<?php if($obj->monto_caja>0) echo $obj->monto_caja; else echo "0.00"; ?>" class="ui-widget-content ui-corner-all text" style="font-size:12px; text-align:right; width:80px" onkeypress="return permite(event,'num')" />                
          </div>
          <div  style="clear: both; padding: 5px; width: auto;text-align: center">
            <?php 
                if(isset($contrae)&&$contrae=="1")
                {
                    ?>
                    <a href="javascript:" id="confirmce" class="button">CONFIRMAR CONTRAENTREGA</a>
                    <?php
                }
            ?>
            <?php if($obj->estado==1||$obj->idenvio=="") 
            { 
                ?>
                <a href="javascript:" id="save" class="button">GRABAR</a>
                <?php 
            } 
            else 
            {
                if($obj->estado=="1")
                {
                    ?>
                        <a href="index.php?controller=envio&action=anular&id=<?php echo $_GET['id']; ?>" class="button">ANULAR</a>
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
<div id="venta"></div>
<div id="printv"></div>