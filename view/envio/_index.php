<script type="text/javascript" src="../web/js/required.js"></script>
<script type="text/javascript">
var tr = '';    
$(document).ready(function() {


    $("#box-envios").dialog(
    {
        autoOpen:false,
        title: 'Agregar Salida a la Encomienda-Telegiro',
        modal:true,
        width:450,
        height:160,
        buttons: {
                'Confirmar':function()
                        {
                            updateSend();
                        },
                'Cerrar':function()
                        {
                            $(this).dialog('close');
                        }
    }});
    $("#box-msg-envios").dialog({
        autoOpen:false,
        title: 'Dar salida a la encomienda',
        modal: true,
        width:400
    });
    $("#box-salidas").dialog({
        autoOpen:false,
        title: 'Salidas Asignadas a este envio',
        modal: true,
        width:680
    });
    $("#box-recepcion").dialog(
    {
        autoOpen:false,
        title: 'Encomienda de tipo Contra-Entrega',
        modal:true,
        width:450,
        height:160,
        buttons: {
                'Confirmar Recepcion':function()
                        {
                            confirmRecepcion();
                        },
                'Cancelar':function()
                        {
                            $(this).dialog('close');
                        }
    }

    });  

	$(".anular").live('click',function()
    {
        var idx = $(this).attr("id");
            idx = idx.split("-");
        Id = idx[1];
		if(Id!="")
		{
            if(confirm("Realmente deseas Anular este Envio"))
            {
                href = "index.php?controller=envio&action=anular&id="+Id;                    
                window.location = href;
            }
        }
          else { alert("Seleccione algún Registro para Anularlo"); }
	});

    $(".anular-envio_salida").live('click',function(){
        var idx = $(this).attr("id");
            idx = idx.split("-");
        Id = idx[1];
        anular_es(Id);
    });

    $(".cancelar-envio_salida").live('click',function(){
        var idx = $(this).attr("id");
            idx = idx.split("-");
        Id = idx[1];
        cancelar_es(Id);
    });

    $(".conf-envio").live('click',function(){
        var idx = $(this).attr("id");
            idx = idx.split("-");
        Id = idx[1];        
        if(Id!="")
        {
            //1: Para confirmar su salida
            Sending(Id,tr,1);
        }
    });
    $(".conf-envio-llegada").live('click',function(){
        var idx = $(this).attr("id");
            idx = idx.split("-");
        Id = idx[1];        
        if(Id!="")
        {
            //Para confirmar su llegada
            Sending(Id,tr,2);
        }
    });

    $(".get-salidas").live('click',function(){
        var idx = $(this).attr("id");
            idx = idx.split("-");
        Id = idx[1];
        tr = $(this).parent();

        getlistsalidas(Id);
        
    })

    $(".conp-envio").live('click',function()
    {
        var idx = $(this).attr("id");
            idx = idx.split("-");
        Id = idx[1];
        $("#box-envios").dialog('open');        
        tr = $(this).parent();
        $.get('index.php','controller=envio&action=frmcmpl&id='+Id,function(data){
            $("#box-envios").empty().append(data);
            var idd = $("#iddestino").val();
            loadSalidas(idd);
        });
    });

    $(".recepcion").live('click',function(){
        var idx = $(this).attr("id");
            idx = idx.split("-");
        Id = idx[1];
        recepcion(Id,tr);
    });

    $(".recepcion-ce").live('click',function(){
        var idx = $(this).attr("id");
            idx = idx.split("-");
        Id = idx[1];
        $("#box-recepcion").dialog('open');
        tr = $(this).parent();
         $.get('index.php','controller=envio&action=frmRecepcion&id='+Id,function(data){
             $("#box-recepcion").empty().append(data);
         });
    });

    $("#tipoe").live('change',function(){
        var ite = $(this).val();
        if(ite==1)
            window.location = "?controller=envio&action=index";
        else 
            window.location = "?controller=envio&action=indexe";        
    });

      
    $("#iddestino").live('change',function()
    {  
       var idd = $(this).val();
       loadSalidas(idd);       
    });    
});
function loadSalidas(idd)
{
    if(idd!="")
       {
            $.get('index.php','controller=itinerario&action=getPriceEncomienda&idd='+idd,function(p){
                p = parseFloat(p);
                $("#precio").val(p.toFixed(2));
                //calcTotales();
            });
            $("#loadsalida").css("display","inline");
            $.get('index.php','controller=salida&action=getSalidasOk&idd='+idd,function(result){
                $("#salidas").empty();
                var html = '';
                $.each(result, function(index, value) {
                    html += '<option value="'+value['idsalida']+'">'+value['descripcion']+'</option>';
                });                
                $("#salidas").append(html);
                $("#loadsalida").css("display","none");
            },'json')
       }
}
function updateSend()
{
    var bval = true;
    bval = bval && $("#iddestino").required();
    bval = bval && $("#salidas").required();    
    if(bval)
    {
        var str = $("#frm01").serialize(),
            idenvio = $("#idenvio").val();
         $.post('index.php','controller=envio&action=update&'+str,function(data){
            if(data[0]=='1')
            {
                $("#box-envios").dialog('close');
                getlistsalidas(idenvio);
            }
            else 
            {
                alert(data[1]);
            }
         },'json');
    }    
}
function getlistsalidas(ide)
{
    $("#box-salidas").dialog('open');     
    $("#box-salidas").empty().append('Cargando datos....');       
        $.get('index.php','controller=envio&action=getlistsalidas&id='+ide,function(data){
            $("#box-salidas").empty().append(data);            
        });
}
function Sending(key,tr, tipo)
{
    $.post('index.php','controller=envio&action=sending&id='+key+'&tipo='+tipo,function(data){        
        if(data[0]=='1')
        {            
            if(tipo==1)
                tr.parent().find('td:eq(8)').empty().append('<p style="font-size:9px; font-style:italic">EN PROCESO</p>');
            else
                tr.parent().find('td:eq(9)').empty().append('<p style="font-size:9px; font-style:italic">EN ESPERA</p>');

            $("#box-msg-envios").dialog('close');
            getlistsalidas(data[2]);
        }        
        else 
        {
            alert("Ocurrio un error, actualize la pagina (F5) y vuleve a intentarlo");
        }
    },'json');
}   
function anular_es(key)
{
    $.post('index.php','controller=envio&action=anular_es&id='+key,function(data){ 
        if(data[0]=='1')
        {
            getlistsalidas(data[2]);
        }
        else
        {
            alert("Ocurrio un error, actualiza la pagina (F5) y vuelve a intentarlo");
        }
    },'json');
}
function cancelar_es(key)
{
    $.post('index.php','controller=envio&action=cancelar_es&id='+key,function(data){ 
        if(data[0]=='1')
        {
            getlistsalidas(data[2]);
        }
        else
        {
            alert(data[2]);
        }
    },'json');
}
function recepcion(key,tr)
{
    $.post('index.php','controller=envio&action=confirmRecepcion&id='+key,function(data){
        if(data[0]=='1')
        {
            
            tr.parent().find('td:eq(9)').empty().append('<p style="font-size:9px; font-style:italic">FINALIZADO</p>');

            $("#box-msg-envios").dialog('close');
            getlistsalidas(data[2]);
        }
        else 
        {
            alert("Ocurrio un error, actualize la pagina (F5) y vuleve a intentarlo");
        }
    },'json');
}
</script>    
<div class="div_container">
<h6 class="ui-widget-header">ENCOMIENDAS REGISTRADAS</h6>
<div>
    <div id="addbotones">
        <a>            
            <span  class="box-boton" style="width:140px;background:transparent;padding:0">
                <select name="tipoe" id="tipoe" class="ui-widget-content">
                    <?php if($tipoe==2) 
                    {
                        ?>
                        <option value="1" >Encomiendas-Telegiros Salientes</option>
                        <option value="2" selected="">Encomiendas-Telegiros Entrantes</option>
                        <?php
                    } 
                    else 
                    {
                        ?>
                        <option value="1" selected="" >Encomiendas-Telegiros Salientes</option>
                        <option value="2" >Encomiendas-Telegiros Entrantes</option>
                        <?php
                    }
                    ?>
                </select>
            </span> 
        </a>
        
    </div>
</div>
<?php echo $grilla;?>
</div>
<div id="box-envios"></div>
<div id="box-recepcion"></div>
<div id="box-msg-envios"></div>
<div id="box-salidas"></div>