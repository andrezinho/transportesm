var source = "index.php?controller=pasajero&action=search_autocomplete&tipo=1&t=1";
$(function() {    
    $("#iditinerario").css("width","350px");
    $("#idtipo_documento").css("width","105px");
    if($("#serie").val()=="")
    {
        load_sernum(1);
    }    
    $("#tipo_venta").change(function(){
        var tv = $(this).val();        
        if(tv==1){ $("#iditinerario").val('');$("#box-itinerario").show();$("#pasaj").html("Pasajero");}
            else if(tv==2){$("#iditinerario").val('');$("#box-itinerario").hide();$("#pasaj").html("Clinte");}
                else {alert("Tipo de venta no definido");}
    });
    
    $("#idtipo_documento").change(function(){
        var id = $(this).val();
        var tv = $("#tipo_venta").val();
        var str = "Pasajero";
        if(tv==2){str = "Cliente"};
        if(id!="")
            {
                if(id==2)
                {                    
                    $("#pasaj").empty().append(str+" (RUC)");
                    $("#gr").css("display","block");
                    source = "index.php?controller=pasajero&action=search_autocomplete&tipo=1&t=2";
                }
                else {
                    source = "index.php?controller=pasajero&action=search_autocomplete&tipo=1&t=1";
                    $("#pasaj").empty().append(str+" (DNI)");
                    $("#gr").css("display","none");
                }          
                $( "#nrodocumento" ).autocomplete({source:source});
                load_sernum(id);
            }
        else {
            $("#serie,#numero").val('');            
        }
    });
    $( "#nrodocumento" ).autocomplete({
            minLength: 0,
            source: source,
            focus: function( event, ui ) {
                $( "#nrodocumento" ).val( ui.item.nrodocumento );                  
                return false;
            },
            select: function( event, ui ) {
                $("#idpasajero").val(ui.item.id);
                $( "#nrodocumento" ).val( ui.item.nrodocumento );
                $( "#nombre" ).val( ui.item.nombre );
                $( "#direccion" ).val( ui.item.direccion );
                habilitar(1);
                $("#iditinerario").focus();
                return false;
            },
            change: function(event, ui) { 
                clear_pasajero();
                habilitar(0);
            }
        }).data( "autocomplete" )._renderItem = function( ul, item ) {
            
            return $( "<li></li>" )
                .data( "item.autocomplete", item )
                .append( "<a>"+ item.nrodocumento +" - " + item.nombre + "</a>" )
                .appendTo( ul );
        };
    $("#iditinerario").change(function()
    {        
        var txt = $("#iditinerario option:selected").html(),
            pos1 = txt.lastIndexOf('('),
            pos2 = txt.lastIndexOf(')'),
            precio = txt.substring((pos1+1),pos2),
            texto = txt.substring(1,(pos1-1));
        $("#precio").val(precio);
        $("#descripcioni").val('PASAJE '+texto).focus();
    });
    $("#adddetalle").click(function(){
        add();
    });
    $( "#save" ).click(function(){
        var ht = $(this).html();
        if(ht=="GRABAR")
        {
            bval = true;
            bval = bval && $( "#idtipo_documento" ).required();
            bval = bval && $( "#nrodocumento" ).required();
            var nrodoc = $("#nrodocumento").val();
            if(nrodoc.length==8||nrodoc.length==11)
            {
                if(nrodoc.length==11)
                {
                    if(!esrucok(nrodoc))
                    {
                        alert("Por favor, ingrese numero de RUC valido.");
                        bval=false;
                    }
                }
            }
            else 
            {
                alert("Ingrese un nro de documento valido");
                bval = false;
            }
            bval = bval && $( "#nombre" ).required();
            if ( bval ) 
            {
                $("#save").empty().append("Grabando...");
                    showboxmsg('Registrando Venta...',3);
                    var str = $("#frm").serialize();            
                    $.post('index.php',str,function(result){
                        var html_printer = "";
                        if(result[0]==1)
                        {
                                html_printer = '<a class="lnk-results" target="_blank" href="index.php?controller=venta&action=printer&iv='+result[2]+'">Imprimir</a>';                       
                                html_printer += '<a class="lnk-results" href="javascript:" id="re-new">Registrar Nuevo</a>';
                                $("#save").empty().append("Venta Guardado.");
                                $("#idventa").val(result[2]);
                        }
                        else 
                        {
                            $("#save").empty().append("GRABAR");
                        }
                        showboxmsg(result[1]+' '+html_printer,result[0]);
                    },'json');            
            }
            return false;
        }
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
    $("#idtipo_documento").val(idtd);
    $.get('index.php','controller=genn_doc&action=getcurrent&idtd='+idtd,function(r){        
        $("#serie").val(r.serie);
        $("#numero").val(r.numero);
    },'json');
    $("#nrodocumento").focus();
}
function clear_pasajero()
{
    $("#idpasajero,#nombre,#direccion").val('');    
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
            var iditinerario = $("#iditinerario").val(),
                itinerario   = $("#descripcioni").val(),
                precio       = $("#precio").val(),
                cantidad     = $("#cantidad").val();
                
                var parametros = {iditinerario:iditinerario,
                                  itinerario:itinerario,
                                  precio:precio,
                                  cantidad:cantidad}
                
                var str = jQuery.param(parametros);
                
                $.post('index.php','controller=venta&action=add&'+str,function(resp)
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
        boxi = $("#box-itinerario").css("display");
        if(boxi=="block")
        {
            bval = bval && $("#iditinerario").required();
        }        
        bval = bval && $("#precio").required();
        bval = bval && $("#cantidad").required();
    return bval;
}
function clear_frm_detalle()
{
    $("#iditinerario,#descripcioni").val('');
    $("#precio").val('0.00');
    $("#cantidad").val('1');
    $("#iditinerario").focus();
}
function clear_frm()
{
    var form =  document.forms.frm;
    $(form).find(':input').each(function() {
        nam = this.name;
        id = this.id;            
        if(nam!="fecha"&&nam!="controller"&&nam!="action"&&nam!="tipo_venta")
        {            
            this.value = "";
        }
    });
    $.get('index.php','controller=venta&action=getDetalle',function(resp){                     
        $("#div-detalle").empty().append(resp);
    });
    load_sernum(1);
    clear_frm_detalle();
    $("#save").empty().append("GRABAR");
    $("#nrodocumento").focus();
}
function quit(item)
{
    if(confirm("Realmente deseas quitar este Item?"))
    {
        $.post('index.php','controller=venta&action=quit&i='+item,function(resp){                     
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

function habilitar(b)
{
    if(b==0)
        {
            $("#nombre").removeAttr("readonly");
        }
      else {
          $("#nombre").attr("readonly",true);
      }
}