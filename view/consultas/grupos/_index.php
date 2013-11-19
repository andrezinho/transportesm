<script type="text/javascript">
    $(document).ready(function(){
        $("#iddestino").change(function(){
            var i = $(this).val();
            $.get('index.php','controller=Grupo&action=getGrupos&i='+i,function(r){                
                $("#idgrupo").empty().append(r);
            });
        });

        $("#gen").click(function(){      
            if(valid())
                {
                    var str = $("#frm").serialize();                    
                    $.get('index.php','controller=consultas&action=html_grupos&'+str,function(data){
                        $("#wcont").empty().append(data);
                    });
                }
        });
        $("#pdf").click(function(){
            if(valid())
                {
                    var str = $("#frm").serialize();
                    window.open('index.php?controller=consultas&action=pdf_grupos&'+str,"Reporte");
                }
        });
    });
    function valid()
    {
        var bval = true;            
            bval = bval && $("#iddestino").required();
            bval = bval && $("#idgrupo").required();
        return bval;
    }
</script>
<div class="div_container">
<h6 class="ui-widget-header">Consulta de Grupos por Destinos</h6>
<div style="padding: 20px; background: #EBECEC">
    <form name="frm" id="frm" action="" method="get">        
        <label class="labels" for="periodoi">Con destino a: </label>
        <?php echo $destino; ?>
        <label class="labels" for="periodoi">Grupos: </label>
        <select name="idgrupo" id="idgrupo" class="ui-widget-content ui-corner-all text">
            <option value="">-Seleccione-</option>
        </select>
    </form>
    <div  style="clear: both; padding: 5px; width: auto;text-align: center">
        <a href="index.php" class="button">CERRAR</a>
        <a href="#" id="gen" class="button">GENERAR</a>
<!--        <a href="#" id="pdf" class="button">VISTA PREVIA</a>-->
    </div>
</div>
<div id="wcont" style="padding: 10px;"></div>
</div>