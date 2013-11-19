<script type="text/javascript">
$(document).ready(function() {
	$(".anular").live('click',function(){
        var idx = $(this).attr("id");
            idx = idx.split("-");
        Id = idx[1]; 
		if(Id!="")
		{
            if(confirm("Realmente deseas Anular este Movimiento"))
            {
                    href = "index.php?controller=egreso&action=anular&id="+Id;                    
                    window.location = href;
            }
        }
          else { alert("Seleccione algún Registro para Anularlo"); }
	});
});
</script>   
<div class="div_container">
<h6 class="ui-widget-header">EGRESOS DE CAJA REGISTRADOS</h6>
<div id="addbotones">	
</div>
<?php echo $grilla;?>
</div>
