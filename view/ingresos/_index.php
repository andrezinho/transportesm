<script type="text/javascript">
$(document).ready(function() {
	$(".anular").live('click',function()
    {
        var idx = $(this).attr("id");
            idx = idx.split("-");
        Id = idx[1];  
		if(Id!="")
		{
            if(confirm("Realmente deseas Anular este Movimiento"))
            {
                    href = "index.php?controller=ingreso&action=anular&id="+Id;                    
                    window.location = href;
            }
        }
          else { alert("Seleccione algún Registro para Anularlo"); }
	});
});
</script>   
<div class="div_container">
<h6 class="ui-widget-header">INGRESOS DE CAJA REGISTRADOS</h6>
<div id="addbotones">
	<!-- <a class="anular" href="javascript:" title="Anular Movimiento">
            <span class="box-boton">Anular</span>
            <span class="box-boton"><img src="images/delete.png"/></span>        
    </a> -->
</div>
<?php echo $grilla;?>
</div>
