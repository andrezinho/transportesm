<form name="frm01" id="frm01">
    <input type="hidden" name="idenvio" id="idenvio" value="<?php echo $idenvio ?>" />
    <label for="iddestino" class="labels" style="width:130px">Destino:</label>
    <?php echo $destino; ?>            
    <br/>
    <label for="idchofer" class="labels" style="width:130px">Salidas Disponibles:</label>                
    <select name="salidas" id="salidas" class="ui-widget-content ui-corner-all text" style="width:200px" >
        <option value="">-No hay disponibles-</option>
    </select>                
</form>