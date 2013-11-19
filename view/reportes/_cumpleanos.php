<script type="text/javascript">
    $(document).ready(function(){
        $("#fechai,#fechaf").datepicker({ dateFormat:'dd/mm/yy' });
		
		$("#periodoi,#periodof").css("width","auto");
        $("#idarticulo").focus();
        $("#gen").click(function(){      
            if(valid())
                {
                    var str = $("#frm").serialize();
                    $.get('index.php','controller=reportes&action=html_cumpleanos&'+str,function(data){
                        $("#wcont").empty().append(data);
                    });
                }
        });
        $("#pdf").click(function(){
            if(valid())
                {
                    var str = $("#frm").serialize();
                    window.open('index.php?controller=reportes&action=pdf_cumpleanos&'+str,"Reporte");
                }
        });
    });
    function valid()
    {
        var bval = true;
            //bval = bval && $("#idarticulo").required();
        return bval;
    }
</script>
<div class="div_container">
<h6 class="ui-widget-header">Reporte de Cumpleaños de los Colaboradores</h6>
<div style="padding: 20px; background: #EBECEC">
    <form name="frm" id="frm" action="" method="get">
        <!--<label class="labels" for="idarticulo">Articulo: </label>
        <input type="text" name="idarticulo" id="idarticulo" value="" class="ui-widget-content ui-corner-all text" size="8" />
        <input type="text" name="descripcion" id="descripcion" value="" class="ui-widget-content ui-corner-all text" size="45" />-->
        <?php
            $mes = array("ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SETIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
        ?>
        <label class="labels" for="periodoi">Mes: </label>
        <select class="ui-widget-content ui-corner-all text" name="mes" id="mes">
            <?php
                    foreach ($mes as $key => $value) {
                        ?>
                    <option value="<?php echo $key+1 ?>"> <?php echo $value;?></option>
                        <?php
                    }
            ?>
        </select> 
    </form>
    <div  style="clear: both; padding: 5px; width: auto;text-align: center">
        <a href="index.php" class="button">CERRAR</a>
        <a href="#" id="gen" class="button">GENERAR</a>
        <a href="#" id="pdf" class="button">VISTA PREVIA</a>
    </div>
</div>
<div id="wcont" style="padding: 10px;"></div>
</div>