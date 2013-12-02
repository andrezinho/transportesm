<script type="text/javascript">
$(document).ready(function() {
   $('.confirm').live('click',function()
    {
        var i = $(this).attr("id");
        var $tr = $(this).parent();        
        i = i.split("-");                
        if(confirm("Estas seguro de Confirmar la llegada de este auto?"))
        {
            $.post('index.php','ctl=entrada&act=llegada&i='+i[1],function(r)
            {
                if(r[0]=="1")
                {
                    $tr.empty().append(r[1]);
                    $tr.parent().find('td:eq(8)').empty().append('CONCLUIDO');                    
                }
                else
                {
                    alert("A ocurrido un error en el servidor, porfavor actualize su pagina presionando la tecla F5 e intente de nuevo relizar este proceso.");
                }
            },'json');
        }
    });
});
</script>    
<div class="div_container">
<h6 class="ui-widget-header">ENTRADA DE VEHICULOS</h6>
<div id="addbotones">
</div>
<?php echo $grilla;?>
</div>