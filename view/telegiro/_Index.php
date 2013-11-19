<script type="text/javascript">
    $(document).ready(function() {
        $(".btnreembolso").live('click',function(){
            var idt = $(this).attr('id');
            if(idt!="")
            {
                if(confirm("Realmente deseas Reembolsar este telegiro"))
                {
                    $.post('index.php','controller=telegiro&action=reembolsar&idtelegiro='+idt,function(r){
                        alert(r);
                        window.location = "?controller=telegiro";
                    });
                }
            }
            else { alert("Seleccione algún Registro Reembolsar"); }
        });
        
        $(".origen").live("change",function(){
            window.location = "?controller=telegiro&action=index&op=" + $(".origen").val();
        });
        
        $('.anular').live("click", function(){
            var idt = Id;
            if(idt!="")
            {alert(idt);
                if(confirm("¿Realmente deseas anular el telegiro?")){
                    $.post('index.php','controller=telegiro&action=anular&idtelegiro='+idt,function(r){
                        alert(r);
                        window.location = "?controller=telegiro";
                    });
                }
            }
        });
    });
</script>    
<div class="div_container">
    <h6 class="ui-widget-header">TELEGIROS REGISTRADOS</h6>
    <div id="addbotones">
        <?php if ((int) $op == 0) { ?>
            <a class="anular" href="javascript:" title="Anular Telegiro">
                <span class="box-boton boton-anular"></span>                
            </a>
        <?php } ?>
        <a>            
            <span  class="box-boton boton-edit" style="width:140px;background:transparent;">
                <select name="tipotelegiro" class="origen ui-widget-content">
                    <?php if ((int) $op == 0) { ?>
                        <option value="0" selected>Telegiros Remitidos</option>
                        <option value="1">Telegiros Por Atender</option>
                    <?php } else { ?>
                        <option value="0">Telegiros Remitidos</option>
                        <option value="1" selected>Telegiros Por Atender</option>
                    <?php } ?>
                </select>
            </span> 
        </a>
        
    </div>

    <?php echo $grilla; ?>
</div>
