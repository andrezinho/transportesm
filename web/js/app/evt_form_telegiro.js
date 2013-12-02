var source = "index.php?controller=pasajero&action=search_autocomplete&tipo=1t=0";
$(function() {    
    $("#iddestino").css("width","160px").attr("title","Seleccione el destino");
    //$("#iddestino").attr("")
    $("#idchofer,#idvehiculo").css("width","430px");
    $("#iddestino").focus();
    load_sernum(5);
    
    $( "#nrodocumentor" ).autocomplete({
            minLength: 0,
            source: source,
            focus: function( event, ui ) {
                $( "#nrodocumentor" ).val( ui.item.nrodocumento );
                return false;
            },
            select: function( event, ui ) {
                $("#idpasajero").val(ui.item.id);
                $( "#nrodocumentor" ).val( ui.item.nrodocumento );
                $( "#remitente" ).val( ui.item.nombre );
                habilitarr(1);
                $("#idconsignado").focus();
                return false;
            },
            change: function(event, ui) { 
                //clear_remitente();
                habilitarr(0);
            }
        }).data( "autocomplete" )._renderItem = function( ul, item ) {            
            return $( "<li></li>" )
                .data( "item.autocomplete", item )
                .append( "<a>"+ item.nrodocumento +" - " + item.nombre + "</a>" )
                .appendTo( ul );
        };
        
    $("#iddestino").change(function()
    {       
       $("#idchofer").focus();
    });
    $("#idchofer").change(function(){
       $("#idvehiculo").focus(); 
    });
    $("#idvehiculo").change(function(){
        $("#nrodocumentor").focus();
    });
    $("#adddetalle").click(function(){
        add();
    });
    $("#entregar").click(function(){        
        var id = $('#idtelegiro').val();
        $.post('index.php','controller=telegiro&action=exec_entrega&idtelegiro='+id,function(r){
           
               alert(r);
               window.location = "?controller=telegiro";
           
        });
    });
    $("#guardarCambios").click(function(){
        
    });
    $("#reembolsar").click(function(){        
        var id = $('#idtelegiro').val();
        $.post('index.php','controller=telegiro&action=reembolsar&idtelegiro='+id,function(r){
           
               alert(r);
               window.location = "?controller=telegiro";
           
        });
    });
    $( "#save" ).click(function(){
        if($("#iddestino").val() == $("#idof").val()){
            alert("Debe seleccionar un destino diferente");
        } else{
        if($("#idestado01").val() == '' || $("#idestado01").val() == '1'){
        var ht = $(this).html();
        
        if(ht=="GRABAR")
        {
             bval = true;
             bval = bval && $("#iddestino").required();
             bval = bval && $("#nrodocumentor").required();
             bval = bval && $("#nrodocumentoc").required();
             bval = bval && $("#consignado").required();
             bval = bval && $("#monto_telegiro").required();
             bval = bval && $("#monto_caja").required();
             
             var mt = parseFloat($("#monto_telegiro").val());             
             if(mt<=0)
                 {
                     bval = false;
                     alert("El monto del telegiro debe ser mayor a cero");
                     $("#monto_telegiro").focus();
                 }
                 
             
            if ( bval ) {
                $("#save").empty().append("Grabando...");
                showboxmsg('Registrando Telegiro...',3);
                var str = $("#frm").serialize();
                $.post('index.php',str,function(result){
                    var html_printer = "";
                    if(result[0]==1)
                        {
                        html_printer = '<a class="lnk-results" target="_blank" href="index.php?controller=telegiro&action=printer&id='+result[2]+'">Imprimir</a>';                       
                        html_printer += '<a class="lnk-results" href="javascript:" id="re-new">Registrar Nuevo</a>';
                        $("#save").empty().append("Telegiro Guardado.");
                        $("#idenvio").val(result[2]);
                        }
                    showboxmsg(result[1]+' '+html_printer,result[0]);
                },'json');                
            }             
        }           } else{
            alert("No se puede modificar el telegiro por que ya fue entregado");
        }}
    });
    $("#re-new").live('click',function(){
        clear_frm();
        hideboxmsg();
    })
    $(".quit").live('click',function(){
        var item = $(this).parent().parent().attr("id");
        quit(item);
    });
    $( "#delete" ).click(function(){
    if(confirm("Confirmar Eliminacion de Registro"))
        {
            $("#frm").submit();
        }
    });
});
function load_sernum(idtd)
{
    if($("#idtelegiro").val() == ""){
    $("#idtipo_documento").val(idtd);
    $.get('index.php','controller=genn_doc&action=getcurrent&idtd='+idtd,function(r){        
        $("#serie").val(r.serie);
        $("#numero").val(r.numero);
    },'json');   
    }
}
function load_sernum2(idtd)
{
    $("#idtipo_documento").val(idtd);
    $.get('index.php','controller=genn_doc&action=getcurrent&idtd='+idtd,function(r){        
        $("#serie_comprobante").val(r.serie);
        $("#numero_comprobante").val(r.numero);
    },'json');
}
function clear_remitente()
{
    $("#idremitente,#remitente").val('');    
}
function clear_consignado()
{
    $("#idconsignado,#consignado").val('');    
}
function venter(evt)
{
    var keyPressed = (evt.which) ? evt.which : event.keyCode
    if (keyPressed==13)
    {
        add();
    }
}
function add()
{
    if(validard())
        {
            var descripcion = $("#descripcion").val(),                
                precio       = $("#precio").val(),
                cantidad     = $("#cantidad").val();
                
                var parametros = {descripcion:descripcion,
                                  precio:precio,
                                  cantidad:cantidad}                
                var str = jQuery.param(parametros);                
                $.post('index.php','controller=envio&action=add&'+str,function(resp)
                {                
                    
                    if(resp.resp=="1")
                    {
                        $("#div-detalle").empty().append(resp.data);                        
                        clear_frm_detalle();
                        $("#save").focus();
                    }
                    else 
                    {
                        alert(resp.data);
                        clear_frm_detalle();
                    }
                },'json');
        }
        
}
function validard()
{
    var bval = true;
        bval = bval && $("#descripcion").required();
        bval = bval && $("#precio").required();
        bval = bval && $("#cantidad").required();
    return bval;
}
function clear_frm_detalle()
{
    $("#descripcion").val('');
    $("#precio").val('5.00');
    $("#cantidad").val('1');
    $("#descripcion").focus();
}
function clear_frm()
{
    var form =  document.forms.frm;
    $(form).find(':input').each(function() {
        nam = this.name;
        id = this.id;            
        if(nam!="fecha"&&nam!="controller"&&nam!="action")
        {            
            this.value = "";
        }
    });
    $.get('index.php','controller=envio&action=getDetalle',function(resp){                     
        $("#div-detalle").empty().append(resp);
    });
    load_sernum(3);
    clear_frm_detalle();
    $("#save").empty().append("GRABAR");
    $("#iddestino").focus();
}
function quit(item)
{
    if(confirm("Realmente deseas quitar este Item?"))
    {
        $.post('index.php','controller=envio&action=quit&i='+item,function(resp){                     
                $("#div-detalle").empty().append(resp);
        });
    }    
}
function overlay()
{    
    var h = $("#div-more-options").height();       
    h = h - 5;    
    var os = $(".contain").offset();
    var w = $(".contain").width();
    w = w - 6;
    $("#div-msg").css({"left":os.left+"px","top":os.top+"px","width":w+"px","height":h+"px"});    
    $("#div-msg").fadeIn();
}

function habilitarr(b)
{
    if(b==0)
        {
            $("#remitente").removeAttr("readonly");
        }
      else {
          $("#remitente").attr("readonly",true);
      }
}
function habilitarc(b)
{
    if(b==0)
        {
            $("#consignado").removeAttr("readonly");
        }
      else 
      {
          $("#consignado").attr("readonly",true);
      }
}