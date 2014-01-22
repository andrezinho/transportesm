<script type="text/javascript">
    $(document).ready(function(){        
 $("#fechai,#fechaf").datepicker({ dateFormat:'dd/mm/yy' });
$("#gen").click(function(){      
             if(valid())
                {
                    var str = $("#frm").serialize();
                    $.get('index.php','controller=reportes&action=html_envio&'+str,function(data){
                        $("#wcont").empty().append(data);
                    });
				}
        });
        $("#pdf").click(function(){
                 if(valid())
                {              
                    var str = $("#frm").serialize();
					window.open('index.php?controller=reportes&action=pdf_envio&'+str,"Reporte");
				}
        });
        
    });
	    function valid()
    {
        var bval = true;
            //bval = bval && $("#idarticulo").required();
            bval = bval && $("#fechai").required();
            bval = bval && $("#fechaf").required();
        return bval;
    }

</script>
<div class="div_container">
<h6 class="ui-widget-header">Reporte de Envios</h6>
    

<div style="padding: 20px; background: #EBECEC">
    <fieldset class="ui-corner-all">
    <legend>Parametros del Reporte</legend>
    <form name="frm" id="frm" action="" method="get">        
        <label class="labels" for="periodoi">Fecha Inicial: </label>
        <input type="text" name="fechai" id="fechai" value="<?php echo date('d/m/Y'); ?>" class="ui-widget-content ui-corner-all text" size="8" />
        <label class="labels" for="periodof">Fecha Final: </label>
        <input type="text" name="fechaf" id="fechaf" value="<?php echo date('d/m/Y'); ?>" class="ui-widget-content ui-corner-all text" size="8" />
        <label class="labels" style="width:100px">Filtros</label>
        <select name="filtro" id="filtro">
            <optgroup label="MOSTRAR TODOS LOS ENVIOS">
                <option value="0">MOSTRAR EMITIDOS Y RECEPCIONADOS</option>    
            </optgroup>
            <optgroup label="EMITIDOS">
                <option value="1">TODOS LOS ENVIOS EMITIDOS</option>            
                <option value="2">ENVIOS EMITIDOS CON CONTRA-ENTREGA</option>
                <option value="3">ENVIO EMITIDOS CON ENTREGA A DOMICILIO</option>    
            </optgroup>
            <optgroup label="RECIBIDOS">
                <option value="4">TODOS LOS ENVIOS RECIBIDOS</option>
                <option value="5">ENVIOS RECIBIDOS CON CONTRA-ENTREGA</option>
                <option value="6">ENVIO RECIBIDOS CON ENTREGA A DOMICILIO</option>
            </optgroup>
        </select>
    </form>
    </fieldset>
    <div  style="clear: both; padding: 5px; width: auto;text-align: center">
        <a href="index.php" class="button">CERRAR</a>
        <a href="#" id="gen" class="button">GENERAR</a>
        <a href="#" id="pdf" class="button">VISTA PREVIA</a>
    </div>
</div>
<div id="wcont" style="padding: 10px;"></div>
</div>