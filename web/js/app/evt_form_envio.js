var idventa = '';
var source = "index.php?controller=pasajero&action=search_autocomplete&tipo=1&t=0";
var source2 = "index.php?controller=pasajero&action=search_autocomplete&tipo=1&t=1";
$(function() {    
    $("#box-msg-result").dialog({
        autoOpen:false,
        title: 'Mensaje',
        modal: true,
        resizable: false
        
    });
    $("#tipo_pro").click(function(){
        changeTipoProceso();
    });
    $("#sdni").click(function(){
        var ck = $(this).attr("checked");
        if(ck=='checked')
            {
                $("#nrodocumentor").hide();
                $("#remitente").animate({
                    width:'502px'
                }, 100, function(){
                    $("#nrodocumentor").val('00000000');
                });
            }
        else
            {
                $("#nrodocumentor").show();
                $("#remitente").animate({
                    width:'394px'
                }, 100, function(){
                    $("#nrodocumentor,#idremitente").val('');                    
                });
            }
    });

    $("#cp").click(function()
    {
        var ck = $(this).attr("checked");
        if(ck=='checked')
        {
            $("#tr-ce").hide();
            $("#monto_envio").val('0.00');
        }
        else
        {
            $("#tr-ce").show();
        }
    });

    $("#iddestino").css("width","160px");
    $("#salidas").css("width","460px");
    calcTotales();
    $("#iddestino").focus();
    load_sernum(3);
    $("#venta").dialog({
        autoOpen:false,
        title: 'Comprobante de Pago',
        modal:true,
        width:650,
        height:350,
        buttons: {
                'Generar Comprobante':function()
                        {
                            if(confirm('Confirmar la operacion'))
                            {
                                save_venta();
                            }
                        },
                'Cancelar':function()
                        {
                            $(this).dialog('close');
                        }
        }

    });
    $("#printv").dialog({
        autoOpen:false,
        title:'Impresion de Comprobante',
        modal:true,
        width:300,
        height:160,
        buttons: {
            'Imprimir': function()
                        {
                            window.open('index.php?controller=venta&action=printer&iv='+idventa);
                        },
            'Cerrar' : function ()
                        {
                             $(this).dialog('close');
                        }
        }
    });
    $('.money').change(function(){
        validMoney($(this));
        calcTotales();
    });
    $("#cantidad").change(function(){
       calcTotales(); 
    });
    $("#precioc").change(function(){
        validMoney($(this));
        validarPriceCaja();
    })
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
                $("#consignado").focus();                
                return false;
            },
            change: function(event, ui) { 
                clear_remitente();
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
       //Load precio de encomienda y Tikets disponibles
       //get price encomienda
       var idd = $(this).val();
       loadSalidas(idd);       
    });    
    $("#salidas").change(function(){
        $("#nrodocumentor").focus();
        var i = $(this).val();
        if(i!="")
            $("#div-conf-salidas").css("display","inline");
        else 
            $("#div-conf-salidas").css("display","none");
    });
    $("#reload-salidas").click(function(){
        var idd = $("#iddestino").val();        
        if(idd!="")        
         {loadSalidas(idd);}
        else 
        {
            alert("Primero seleccione un destino");
            $("#iddestino").focus();
        }            
    });
    $("#adddetalle").click(function(){
        add();
    });
    $( "#save" ).click(function()
    {
        var ht = $(this).html();
        if(ht=="GRABAR")
        {
            bval = true;
            bval = bval && $( "#iddestino" ).required();
            
            var ck = $("#sdni").attr("checked");
            if(ck!='checked')
            {
                bval = bval && $( "#nrodocumentor" ).required();
                if(bval)
                {                    
                    var nrodoc = $("#nrodocumentor").val();
                    if(nrodoc.length==8||nrodoc.length==11)
                    {
                        if(nrodoc.length==11)
                        {
                            if(!esrucok(nrodoc))
                            {
                                alert("Por favor, ingrese numero de RUC valido del remitente");
                                bval=false;
                            }
                        }
                    }
                    else 
                    {
                        alert("Ingrese un nro de documento valido del remitente");
                        bval = false;
                    }
                }
            }
            else
            {                
                bval = bval && $("#remitente").required();
            }
                        
            bval = bval && $("#consignado").required();

            var ck_ad = $("#adomicilio").attr("checked");            
            if(ck_ad=='checked')
                bval = bval = $("#direccion").required();

            var display_monto_caja = $("#tr-ce").css("display");
            
            if(display_monto_caja!="none")
            {    
                var ck_cp = $("#cp").attr("checked");            
                if(ck_cp!='checked')
                {
                    bval = bval = $("#monto_caja").required();
                    var mont_c = $("#monto_caja").val();
                    mont_c = parseFloat(mont_c);
                    
                    if(mont_c<=0)
                    {
                        if(!confirm("El monto que ingresará a caja es cero (0), esta seguro de enviar este valor para la caja?"))
                        {
                            $("#monto_caja").focus();
                            bval = false;
                        }
                    }
                }
            }
            if ( bval )
            {
               
                $("#save").empty().append("Grabando...");
                var idenvio = $("#idenvio").val();
                showMensaje('Procesando....');
                
                
                var str = $("#frm").serialize();
                $.post('index.php',str,function(result)
                {
                    var html_printer = "";                    
                    if(result[0]=='1')
                    {
                        html_printer = '<a class="lnk-results" target="_blank" href="index.php?controller=envio&action=printer&iv='+result[2]+'">Imprimir</a>';                       
                        html_printer += '<a class="lnk-results" href="index.php?controller=envio&action=create" id="">Registrar Nuevo</a>';
                        if(result[3]=="1")
                        {
                            html_printer += '<a class="lnk-results" href="javascript:" id="re-genv">Generar Comprobante</a>';
                        }                        
                        if(idenvio=="")
                        {
                            $("#save").empty().append("Envio Guardado.");
                        }
                        else {
                            $("#save").empty().append("Envio Actualizado.");
                        }
                        $("#idenvio").val(result[2]);
                    }
                    else {
                        $("#save").empty().append("GRABAR");
                    }
                    showMensaje(result[1]+' '+html_printer,result[0]);                    
                },'json');
                
            }
        }
    });
    $("#confirmce").live('click',function()
    {
         bval = true;         
         bval = bval && $( "#idenvio" ).required();

         bval = bval = $("#monto_caja").required();
         var mont_c = $("#monto_caja").val();
         mont_c = parseFloat(mont_c);
        
         if(mont_c<=0)
         {
            if(!confirm("El monto que ingresará a caja es cero (0), esta seguro de enviar este valor para la caja?"))
            {
                $("#monto_caja").focus();
                bval = false;
            }
         }

         if ( bval )
         {
            $("#confirmce").empty().append("CONFIRMANDO...");
            var idenvio = $("#idenvio").val();

            showMensaje('Procesando la confirmacion de la entrega...');                                    
            $.post('index.php','controller=envio&action=save_ce&id='+idenvio+'&mont_c='+mont_c,function(result)
            {
                var html_printer = "";                    
                    if(result[0]=='1')
                    {
                        html_printer = '<a class="lnk-results" target="_blank" href="index.php?controller=envio&action=printer&iv='+result[2]+'">Imprimir</a>';                                               
                        html_printer += '<a class="lnk-results" href="javascript:" id="re-genv">Generar Comprobante</a>';                        
                        $("#confirmce").empty().append("CONFIRMADA LA RECEPCION");                        
                    }
                    else 
                    {
                        $("#confirmce").empty().append("CONFIRMAR CONTRAENTREGA");
                    }
                    showMensaje(result[1]+' '+html_printer,result[0]);                    
            },'json');

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
    $("#re-genv").live('click',function(){
        var i = $("#idenvio").val();
        loadFrmVenta(i);
    })
    $( "#delete" ).click(function(){
    if(confirm("Confirmar Eliminacion de Registro"))
        {
            $("#frm").submit();
        }
    });
    $(".descripcion-envio").live('change',function(){
        
    })
});
function load_sernum(idtd)
{
    var idenvio = $("#idenvio").val();
    if(idenvio=="")
    {
        $("#idtipo_documento").val(idtd);
        $.get('index.php','controller=genn_doc&action=getcurrent&idtd='+idtd,function(r){        
            $("#serie").val(r.serie);
            $("#numero").val(r.numero);
        },'json');    
    }    
}
function load_sernum2(idtd)
{
    var idenvio = $("#idenvio").val();
    if(idenvio=="")
    {
        $("#idtipo_documento").val(idtd);
        $.get('index.php','controller=genn_doc&action=getcurrent&idtd='+idtd,function(r){        
            $("#serie_comprobante").val(r.serie);
            $("#numero_comprobante").val(r.numero);
        },'json');
    }
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
                precioc      = $("#precioc").val();
                
                var parametros = {descripcion:descripcion,
                                  precio:precio,
                                  cantidad:cantidad,
                                  precioc:precioc}                
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
function loadFrmVenta(i)
{
    $("#venta").dialog('open');
    $("#venta").load('index.php?controller=envio&action=loadVenta&i='+i,function(){
        loadBasicVenta();
    })
}
function loadBasicVenta()
{
    $("#idtipo_documento").css("width","105px");
    $("#idtipo_documento").change(function(){
        var id = $(this).val();
        var tv = 2;
        var str = "Pasajero";
        if(tv==2){str = "Cliente"};
        if(id!="")
            {
                if(id==2)
                {                    
                    $("#pasaj").empty().append(str+" (RUC)");
                    $("#gr").css("display","block");
                    source2 = "index.php?controller=pasajero&action=search_autocomplete&tipo=1&t=2";
                }
                else {
                    source2 = "index.php?controller=pasajero&action=search_autocomplete&tipo=1&t=1";
                    $("#pasaj").empty().append(str+" (DNI)");
                    $("#gr").css("display","none");
                }          
                $( "#nrodocumentov" ).autocomplete({source:source});                
            }
        else {
            $("#serie,#numero").val('');            
        }
    });
    $( "#nrodocumentov" ).autocomplete({
            minLength: 0,
            source: source2,
            focus: function( event, ui ) {
                $( "#nrodocumentov" ).val( ui.item.nrodocumento );                  
                return false;
            },
            select: function( event, ui ) {
                $("#idremitentev").val(ui.item.id);
                $( "#nrodocumentov" ).val( ui.item.nrodocumento );
                $( "#remitentev" ).val( ui.item.nombre );
                $( "#direccionv" ).val( ui.item.direccion );
                return false;
            },
            change: function(event, ui) { }
        }).data( "autocomplete" )._renderItem = function( ul, item ) {
            
            return $( "<li></li>" )
                .data( "item.autocomplete", item )
                .append( "<a>"+ item.nrodocumento +" - " + item.nombre + "</a>" )
                .appendTo( ul );
        };
}
function save_venta()
{
    var str = $("#frmventa").serialize();    
    $.post('index.php','controller=venta&action=genVenta&'+str,function(data)
    {
        if(data[0]=='1')
        {
            $("#venta").dialog('close');
            idventa = parseInt(data[2]);
            $("#printv").empty().append('<div style="text-align:center;padding:10px;">'+data[3]+'</div>');
            $("#printv").dialog('open');
        }
        else 
        {
            alert("Lo sentimos ha ocurrido un error, porfavor actualize la pagina (F5)");
        }
    },'json');
}
function validMoney($obj)
{
    var v = $obj.val();
    v = parseFloat(v);
    if(v=="")
    {
        $obj.val(0.00);
    }
    else 
    {        
        $obj.val(v.toFixed(2));
    }
}
function calcTotales()
{
    var cant = $("#cantidad").val(),
        precio = $("#precio").val(),
        precioc = $("#precioc").val();
        
    if(isNaN(precioc)) presioc = 0;
    if(isNaN(precio)) precio = 0;
    if(isNaN(cant)) cant = 0;
    
    cant = parseFloat(cant);
    precio = parseFloat(precio);
    precioc = parseFloat(precioc);
    var t1 = precio*cant;
    var t2 = precioc*cant;
    $("#stt").val(t1.toFixed(2));
    $("#sttc").val(t2.toFixed(2));
    
    $("#precioc").val(precioc.toFixed(2));
}
function validarPriceCaja()
{
    var p = $("#precioc").val(),precio = $("#precio").val();
    p = parseFloat(p);
    precio = parseFloat(precio);
    if(p>precio)
    {
        alert("El ingreso a caja no puede superar al monto del comprobante");
        $("#precioc").val(precio.toFixed(2));
        calcTotales();
        $("#precioc").focus();
        return 0;
    }
}
function loadSalidas(idd)
{
    if(idd!="")
       {
            $.get('index.php','controller=itinerario&action=getPriceEncomienda&idd='+idd,function(p){
                p = parseFloat(p);
                $("#precio").val(p.toFixed(2));
                calcTotales();
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
function changeTipoProceso()
{
    var t = $("#tipo_pro").val();
    if(t==1)
    {
        $("#descripcion").attr("placeholder","Descripcion del objeto a enviar.");
        $("#legend-detalle").html("Detalle de la Encomienda");
    }
    else
    {
        $("#descripcion").attr("placeholder","Ingrese la descripcion del Telegiro");
        $("#legend-detalle").html("Detalle de Telegiro");
    }
}
