<form name="frm01" id="frm01">
	<div id="frm01-inputs">
	    <input type="hidden" name="idenvio" id="idenvio" value="<?php echo $idenvio ?>" />
	    <label for="iddestino" class="labels" style="width:130px">Destino:</label>
	    <?php echo $destino; ?>            
	    <br/>
	    <label for="idchofer" class="labels" style="width:130px">Salidas Disponibles:</label>                
	    <select name="salidas" id="salidas" class="ui-widget-content ui-corner-all text" style="width:200px" >
	        <option value="">-No hay disponibles-</option>
	    </select>                
    </div>
    <div id="box-boton-envio" style="display:none; text-align:center;margin-top:20px">
    	<a id="boton-envio-send" href="#" class="button">Click Aqui, para confirmar <br/> la salida de la encomienda</a>
    </div>
</form>