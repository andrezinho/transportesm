<script type="text/javascript">
    $(document).ready(function(){
        $("#fechai,#fechaf").datepicker({ dateFormat:'dd/mm/yy' });
		
		$("#periodoi,#periodof").css("width","auto");
        $("#idarticulo").focus();
        $("#gen").click(function(){      
            if(valid())
                {
                    var str = $("#frm").serialize();
                    $.get('index.php','controller=reportes&action=html_ventas&'+str,function(data){
                        $("#wcont").empty().append(data);
                    });
                }
        });
        $("#pdf").click(function(){
            if(valid())
                {
                    var str = $("#frm").serialize();
                    window.open('index.php?controller=reportes&action=pdf_ventas&'+str,"Reporte");
                }
        });
        $( "#idarticulo" ).autocomplete({
            minLength: 0,
            source: "index.php?controller=articulo&action=search_autocomplete&tipo=1",
            focus: function( event, ui ) {
                $( "#idarticulo" ).val( ui.item.id );
                $( "#descripcion" ).val( ui.item.name );
                return false;
            },
            select: function( event, ui ) {
                $( "#descripciona" ).val( ui.item.name );
                $( "#idarticulo" ).val( ui.item.id );                
                $("#idarticulo").focus();
                return false;
            }
        }).data( "autocomplete" )._renderItem = function( ul, item ) {
            return $( "<li></li>" )
                .data( "item.autocomplete", item )
                .append( "<a>"+ item.id +"-" + item.name + "</a>" )
                .appendTo( ul );
        };
    $("#descripcion").autocomplete({
            minLength: 0,
            source: "index.php?controller=articulo&action=search_autocomplete&tipo=2",
            focus: function( event, ui ) {
                $( "#idarticulo" ).val( ui.item.id );
                $( "#descripcion" ).val( ui.item.name );
                return false;
            },
            select: function( event, ui ) {
                $( "#descripciona" ).val( ui.item.name );
                $( "#idarticulo" ).val( ui.item.id );                
                $("#descripciona").focus();
                return false;
            }
        }).data( "autocomplete" )._renderItem = function( ul, item ) {
            return $( "<li></li>" )
                .data( "item.autocomplete", item )
                .append( "<a>"+ item.id +"-" + item.name + "</a>" )
                .appendTo( ul );
        };
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
<h6 class="ui-widget-header">Reporte Ventas por Fechas</h6>
<div style="padding: 20px; background: #EBECEC">
    <form name="frm" id="frm" action="" method="get">        
        <label class="labels" for="periodoi">Fecha Inicial: </label>
        <input type="text" name="fechai" id="fechai" value="<?php echo date('d/m/Y'); ?>" class="ui-widget-content ui-corner-all text" size="8" />
		<?php //echo $periodoi; ?>
        <label class="labels" for="periodof">Fecha Final: </label>
        <input type="text" name="fechaf" id="fechaf" value="<?php echo date('d/m/Y'); ?>" class="ui-widget-content ui-corner-all text" size="8" />
		<?php //echo $periodof; ?>
    </form>
    <div  style="clear: both; padding: 5px; width: auto;text-align: center">
        <a href="index.php" class="button">CERRAR</a>
        <a href="#" id="gen" class="button">GENERAR</a>
        <a href="#" id="pdf" class="button">VISTA PREVIA</a>
    </div>
</div>
<div id="wcont" style="padding: 10px;"></div>
</div>