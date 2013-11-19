<script type="text/javascript">
$(document).ready(function() {
	$(".anular").live('click',function(){
        var i = $(this).attr("id");        
        var $tr = $(this).parent();        
        i = i.split("-");        		
        if(confirm("Realmente deseas Anular este Envio"))
        {
            $.post('index.php','ctl=salida&act=anular&id='+i[1],function(r)
            {
                if(r[0]=="1")
                {
                    $tr.empty().append('&nbsp;');
                    $tr.parent().find('td:eq(8)').empty().append('ANULADO');
                    $tr.parent().find('td:eq(10)').empty();
                    $tr.parent().find('td:eq(11)').empty();                    
                }
            },'json');
        }        
	});

    $(".pay-ticket").live('click',function()
    {
        var i = $(this).attr("id");        
        var $tr = $(this).parent();        
        i = i.split("-");         
        if(confirm("Estas seguro de Generar el Ticket ?"))
        {            
            $.post('index.php','ctl=salida&act=payticket&i='+i[1],function(r)
            {
                if(r[0]=="1")
                {
                    $tr.empty().append('<a title="Imprimir" href="index.php?controller=salida&amp;action=printer&amp;ie='+i[1]+'" target="_blank"><img src="images/print.png"></a>');
                    $tr.parent().find('td:eq(6)').empty().append(r[1]);
                    $tr.parent().find('td:eq(8)').empty().append('DISPONIBLE');
                    $tr.parent().find('td:eq(11)').empty().append('<a title="Confirmar Salida" href="#" id="cf-'+i[1]+'" class="confirm"><img src="images/hand_thumbsup.png"></a>');
                }
                else 
                {
                    alert("A ocurrido un error en el servidor, porfavor actualize su pagina presionando la tecla F5 e intente de nuevo relizar este proceso."+r[1]);
                }
                
            },'json');
            //},'json');         
        }            
    });
    $('.confirm').live('click',function()
    {
        var i = $(this).attr("id");
        var $tr = $(this).parent();        
        i = i.split("-");        
        if(confirm("Estas seguro de Confirmar la salida de este ticket ?"))
        {
            $.post('index.php','ctl=salida&act=despachar&i='+i[1],function(r)
            {
                if(r[0]=="1")
                {
                    $tr.empty().append(r[1]);
                    $tr.parent().find('td:eq(8)').empty().append('EN CURSO');
                    $tr.parent().find('td:eq(12)').empty();
                }
                else
                {
                    alert("A ocurrido un error en el servidor, porfavor actualize su pagina presionando la tecla F5 e intente de nuevo relizar este proceso.");
                }
            },'json');
        }
    });
});
function changehtml(obj,str)
{
    obj.empty().append(str);        
}

</script>    
<div class="div_container">
<h6 class="ui-widget-header">GESTION DE SALIDAS DE VEHICULOS</h6>
<div id="addbotones">
	<!-- <a class="anular" href="javascript:" title="Anular Envio">
            <span class="box-boton">Anular</span>
            <span class="box-boton"><img src="images/delete.png"/></span>        
    </a> -->
</div>
<?php echo $grilla;?>
</div>