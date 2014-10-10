<script type="text/javascript">
    $(document).ready(function(){
        $("#fechai,#fechaf").datepicker({ dateFormat:'dd/mm/yy' });
		
		$("#periodoi,#periodof").css("width","auto");
        $("#idarticulo").focus();
        $("#gen").click(function(){      
            if(valid())
                {
                    var str = $("#frm").serialize();
                    $.get('index.php','controller=reportes&action=html_fec_ven_lic&'+str,function(data){
                        $("#wcont").empty().append(data);
                    });
                }
        });
        $("#pdf").click(function(){
            if(valid())
                {
                    var str = $("#frm").serialize();
                    window.open('index.php?controller=reportes&action=pdf_fec_ven_lic&'+str,"Reporte");
                }
        });
    });
    function valid()
    {
        var bval = true;
            //bval = bval && $("#idarticulo").required();
        return bval;
    }
    function exec_reporte()
    {
        if(valid())
        {
            var str = $("#frm").serialize();
                    $.get('index.php','controller=reportes&action=html_fec_ven_lic&'+str,function(data){
                        $("#wcont").empty().append(data);
                    });
        }
    }
</script>
<div class="div_container">
<h6 class="ui-widget-header">Reporte de Vencimiento de Licencias de Vehiculos</h6>
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
            <option value="">-Todos-</option>
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
<?php 
    if(isset($_GET['p'])&&$_GET['p']==1) 
    {
        ?>
        <script type="text/javascript">exec_reporte();</script>
        <?php
    }
?>