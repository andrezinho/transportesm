<script type="text/javascript">
$(document).ready(function() 
{    
    $(".anular").live('click',function()
    {        
        var idx = $(this).attr("id");
            idx = idx.split("-");
            Id = idx[1];
            if(Id!="")
            {
                if(confirm("Realmente deseas Anular Movimiento en caja banco"))
                {
                        href = "index.php?controller=caja_banco&action=anular&id="+Id;                    
                        window.location = href;
                }
            }
          else { alert("Seleccione algún Registro para Anularlo"); }
	});
})
</script>
<div class="div_container">
<h6 class="ui-widget-header">Caja de Bancos</h6>
<?php echo $grilla; ?>
</div>