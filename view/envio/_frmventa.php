<form name="frmventa" id="frmventa">
<fieldset class="ui-corner-all">
    <legend>Datos Basicos</legend>                    
    <label for="nrooc" class="labels" style="width:130px">Comprobante:</label>
    <?php echo $tipo_documento; ?>    
    <br/>                
    <label for="idpasajero" class="labels" style="width:130px" id="pasaj">Cliente:</label>
    <input type="hidden" name="idremitentev" id="idremitentev" value="<?php echo $obj->idremitente; ?>" />
    <input type="text" name="nrodocumentov" id="nrodocumentov" value="<?php echo $obj->nrodocumentor; ?>" class="ui-widget-content ui-corner-all text" size="13" title="Nro de Documento" onkeypress="return permite(event,'num')" />
    <input type="text" name="remitentev" id="remitentev" value="<?php echo $obj->remitente; ?>" class="ui-widget-content ui-corner-all text" title="Nombre Pasajero" style="width:300px"  />
    <br/>
    <label for="direccion" class="labels" style="width: 130px;">Direccion: </label>
    <input type="text" name="direccionv" id="direccionv" value="<?php echo $obj->direccion; ?>" class="ui-widget-content ui-corner-all text" title="Direccion" style="width:410px" />                
    <br/>
    <div id="gr" style="display: none">
        <label for="guia_remision" class="labels" style="width: 130px;">Guia de Remision: </label>
        <input type="text" name="guia_remision" id="guia_remision" value="<?php echo $obj->guia_remision; ?>" class="ui-widget-content ui-corner-all text" style="width:410px" title="guia de remision" />
    </div>               
</fieldset>
<?php 
    echo $detalle;
?>
</form>