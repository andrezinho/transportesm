<script type="text/javascript" src="../web/js/required.js"></script>
<script type="text/javascript">
var tr = '';    
$(document).ready(function() {
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
    $(".conf-envio").live('click',function(){
        var idx = $(this).attr("id");
            idx = idx.split("-");
        Id = idx[1];
        var $tr = $(this).parent();
        if(Id!="")
        {
            Sending(Id,$tr);
        }
    });
    $(".conp-envio").live('click',function(){
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
        $tr = $(this).parent();
        recepcion(Id,$tr);
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
    })
    $("#tipoe").live('change',function(){
        var ite = $(this).val();
        if(ite==1)
            window.location = "?controller=envio&action=index";
        else 
            window.location = "?controller=envio&action=indexe";        
    });
    $("#box-envios").dialog(
    {
        autoOpen:false,
        title: 'Completar informacion para el envio de la Encomienda ...',
        modal:true,
        width:450,
        height:160,
        buttons: {
                'Actualizar':function()
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
        var str = $("#frm01").serialize();        
         $.post('index.php','controller=envio&action=update&'+str,function(data){
            if(data[0]=='1')
            {
                $("#box-envios").dialog('close');
                $("#box-msg-envios").empty().append('<p style="text-align:justify; padding:5px;"><b>Se ha actualizado satisfactoriamente los datos de la encomienda, ahora si puede confirmar su respectiva salida.</b></p><br/><p style="font-style:italic; padding:5px;"><b>Nota:</b> Recuerde dar salida tambien al vehiculo que lo est&aacute; llevando.');
                $("#box-msg-envios").dialog({
                    buttons: {
                        'Confirmar salida':function(){
                            Sending(data[2],tr);
                        },
                        'Cerrar': function(){
                            $(this).dialog('close');
                        }
                    }
                });
                $("#box-msg-envios").dialog('open');                
            }
            else 
            {
                alert(data[1]);
            }
         },'json');
    }
    ll
}
function Sending(key,tr)
{
    $.post('index.php','controller=envio&action=sending&id='+key,function(data){        
        if(data[0]=='1')
        {
            tr.empty().append("<span class='box-boton boton-ok'></span>");
            tr.parent().find('td:eq(7)').empty().append('<p style="font-size:9px; font-style:italic">ENVIADA</p>');
            $("#box-msg-envios").dialog('close');
        }        
        else 
        {
            alert("Ocurrio un error, actualize la pagina (F5) y vuleve a intentarlo");
        }
    },'json');
}   
function confirmRecepcion()
{

}
function recepcion(key,tr)
{
    $.post('index.php','controller=envio&action=confirmRecepcion&id='+key,function(data){
        if(data[0]=='1')
        {
            tr.empty().append(data[1]);
            tr.parent().find('td:eq(7)').empty().append("<span class='box-boton boton-ok'></span>");
        }
        else {
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
                        <option value="1" >Encomiendas Salientes</option>
                        <option value="2" selected="">Encomiendas Entrantes</option>
                        <?php
                    } 
                    else 
                    {
                        ?>
                        <option value="1" selected="" >Encomiendas Salientes</option>
                        <option value="2" >Encomiendas Entrantes</option>
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