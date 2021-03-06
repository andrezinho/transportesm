<?php  include("../lib/helpers.php"); 
       include("../view/header_form.php");
?>
<script type="text/javascript" src="js/app/evt_form_telegiro.js" ></script>
<div class="div_container">
<h6 class="ui-widget-header">&nbsp;</h6>
<?php echo $more_options; ?>
<div class="contain2" >
<?php header_form('TELEGIROS'); ?>  

<form id="frm" action="index.php" method="POST">
    <input type="hidden" name="controller" value="telegiro" />
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
         <br/>
        <div class="contenido" >                            
            <h3 class="stitle">TELEGIRO</h3>    
            <fieldset class="ui-corner-all">
                <legend>Datos Basicos</legend>            
                <label for="idtelegiro" class="labels" style="width:130px">N°:</label>
                <input type="text" id="idtelegiro" name="idtelegiro" class="text ui-widget-content ui-corner-all" style=" text-align: center;" value="<?php if($obj->idtelegiro!=""){ echo str_pad($obj->idtelegiro,8,'0',0); }?>" readonly="" size="10"  />                
                <label for="fecha" class="labels" style="width:130px">Fecha:</label>
                <input type="text" name="fecha" id="fecha" value="<?php if($obj->fecha!=""){echo fdate($obj->fecha,"ES");} else {echo date('d/m/Y');} ?>" class="ui-widget-content ui-corner-all text" size="10" style="text-align: center" title="Ingrese la Fecha" readonly="" />                
                <label for="hora" class="labels" style="width:60px">Hora:</label>
                <input type="text" name="hora" id="hora" value="<?php if($obj->hora!=""){echo $obj->hora;} else {echo date('H:i');} ?>" class="ui-widget-content ui-corner-all text" size="6" style="text-align: center" readonly="" />                                                
                <br/>
                <label for="nrooc" class="labels" style="width:130px">Serie-Numero:</label>
                <input type="text" name="serie" id="serie" value="<?php echo $obj->serie;?>" class="ui-widget-content ui-corner-all text" size="4" title="Serie del Documento" readonly="" />                                
                <input type="text" name="numero" id="numero" value="<?php echo $obj->numero;?>" class="ui-widget-content ui-corner-all text" size="8" title="Numero del Documento" onkeypress="" readonly="" />
                <label for="iddestino" class="labels" style="width:150px">Destino (Oficina):</label>
                <?php echo $destino; ?>
                <br/>                                
                <?php if($obj->nrodocumentor!="00000000") 
                        { $display = "inline"; $ck = ""; } 
                       else {$display = "none"; $ck = "checked"; }
                ?>
                <label for="idremitente" class="labels" style="width:130px">Remitente:</label>
                <input type="hidden" name="idremitente" id="idremitente" value="<?php echo $obj->idremitente; ?>" />
                <input type="text" name="nrodocumentor" id="nrodocumentor" value="<?php echo $obj->nrodocumentor; ?>" class="ui-widget-content ui-corner-all text" size="13" title="Nro de Documento" onkeypress="return permite(event,'num')" placeholder="Nro Documento" style="display:<?php echo $display; ?>"/>
                <input type="text" name="remitente" id="remitente" value="<?php echo $obj->remitente; ?>" class="ui-widget-content ui-corner-all text" style="width:350px" title="Nombre del Remitente" placeholder="Nombre del Remitente" />
                <span style="margin-left: 10px; padding: 2px 5px; background: #dadada;">
                    <input type="checkbox" name="sdni" id="sdni" value="1" <?php echo $ck; ?> />
                    <label for="sdni" style="color:blue; cursor: pointer">Sin DNI</label>
                </span>
                <br/>
                <label for="idconsignado" class="labels" style="width:130px">Consignado a:</label>
                <?php if($obj->idconsignado!="00000000") 
                        { $display = "inline"; $ck = ""; } 
                       else {$display = "none"; $ck = "checked"; }
                ?>
                <input type="text" name="idconsignado" id="nrodocumentoc" value="<?php echo $obj->idconsignado; ?>" class="ui-widget-content ui-corner-all text" size="13" title="Nro de Documento" onkeypress="return permite(event,'num')" placeholder="Nro Documento" style="display:<?php echo $display; ?>" />
                <input type="text" name="consignado" id="consignado" value="<?php echo $obj->consignado; ?>" class="ui-widget-content ui-corner-all text" style="width:350px"  title="Nombre del Consignado" placeholder="Nombre del Consignado" />
                <span style="margin-left: 10px; padding: 2px 5px; background: #dadada;">
                    <input type="checkbox" name="sdni2" id="sdni2" value="1" <?php echo $ck; ?> />
                    <label for="sdni2" style="color:blue; cursor: pointer">Sin DNI</label>
                </span>
                <br/>
                <label for="monto_telegiro" class="labels" style="width:130px">Mont. Teleg.:</label>
                <input type="text" name="monto_telegiro" id="monto_telegiro" value="<?php if($obj->monto_telegiro!="") echo number_format($obj->monto_telegiro,2); else echo "0.00"; ?>" class="ui-widget-content ui-corner-all text" size="13" title="Monto del Telegiro" onkeypress="return permite(event,'num')" style="text-align: right" /> S/.
                <label for="monto_caja" class="labels" style="width:130px">Mont. Caja.:</label>
                <input type="text" name="monto_caja" id="monto_caja" value="<?php if($obj->monto_caja!="") echo number_format($obj->monto_caja,2); else echo "0.00"; ?>" class="ui-widget-content ui-corner-all text" size="13" title="Monto de Caja" onkeypress="return permite(event,'num')" style="text-align: right" /> S/.
                <br/>
                <label for="observacion" class="labels" style="width:130px"></label>
                <textarea name="observacion" id="observacion" rows="5" cols="60" placeholder="Ingrese alguna observacion (opcional)" class="ui-widget-content ui-corner-all "><?php echo $obj->observacion; ?></textarea>
          </fieldset>
          <div id="div-detalle">
            <?php echo $detalle; ?>
          </div>
          <div  style="clear: both; padding: 5px; width: auto;text-align: center">
            <?php if($_GET['action']=="create" || $_GET['action']=="edit") { ?>
            <a href="javascript:" id="save" class="button">GRABAR</a>
            <?php } 
            else if($_GET['action']=="entregar") { ?>
            <a href="javascript:"  id="entregar" class="button">CONFIRMAR ENTREGA</a>
            <?php }
            else if($_GET['action']=="reembolsar") { ?>
            <a href="javascript:" id="reembolsar" class="button">CONFIRMAR REEMBOLSO</a>
            <?php }
            else {
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
            <input type="hidden" id="idestado01" value="<?php echo $obj->estado; ?>" />
            <input type="hidden" id="idof" value="<?php echo $_SESSION['idoficina']; ?>" />
        </div>
    </div>
</form>
</div>
</div>