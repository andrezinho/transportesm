$(function() 
{
    $("#box-msg-result").dialog({
        autoOpen:false,
        title: 'Mensaje',
        modal: true,
        resizable: false
        
    });
    $("#idtipo_documento").change(function(){
        $("#serie_numero").focus();
    });
    $("#fecha,#fechad").datepicker({
                                        'dateFormat':'dd/mm/yy',
                                         showOn: 'both',                                         
                                         buttonImageOnly: true,
                                         buttonImage: "images/calendar.png"
                                    });
    $( "#ruc" ).focus();    
    $( "#ruc" ).autocomplete({
            minLength: 0,
            source: "index.php?controller=Proveedor&action=search_autocomplete&tipo=1",
            focus: function( event, ui ) {
                $( "#ruc" ).val( ui.item.ruc );
                return false;
            },
            select: function( event, ui ) 
            {
                $( "#idproveedor" ).val(ui.item.id);
                $( "#razonsocial" ).val(ui.item.name);
                $( "#ruc" ).val(ui.item.ruc);
                $("#idtipo_documento").focus();
                return false;
            },
            change: function(event, ui) { 
                clear_proveedor();
                habilitar(0);
                return false;
            }
        }).data( "autocomplete" )._renderItem = function( ul, item ) {
            return $( "<li></li>" )
                .data( "item.autocomplete", item )
                .append( "<a>"+ item.ruc +"-" + item.name + "</a>" )
                .appendTo( ul );
        };
        $( "#idconcepto_movimiento" ).autocomplete({
            minLength: 0,
            source: "index.php?controller=Concepto_Movimiento&action=search_autocompletee&tipo=1",
            focus: function( event, ui ) {
                $( "#idconcepto_movimiento" ).val( ui.item.id );                
                return false;
            },
            select: function( event, ui ) {
                $( "#concepto" ).val( ui.item.name );
                $( "#idconcepto_movimiento" ).val(ui.item.id);
                return false;
            }
        }).data( "autocomplete" )._renderItem = function( ul, item ) {
            return $( "<li></li>" )
                .data( "item.autocomplete", item )
                .append( "<a>"+ item.id +"-" + item.name + "</a>" )
                .appendTo( ul );
        };
        $( "#concepto" ).autocomplete({
            minLength: 0,
            source: "index.php?controller=Concepto_Movimiento&action=search_autocompletee&tipo=2",
            focus: function( event, ui ) {
                $( "#concepto" ).val( ui.item.name );                
                return false;
            },
            select: function( event, ui ) {
                $( "#concepto" ).val( ui.item.name );
                $( "#idconcepto_movimiento" ).val(ui.item.id);
                return false;
            }
        }).data( "autocomplete" )._renderItem = function( ul, item ) {
            return $( "<li></li>" )
                .data( "item.autocomplete", item )
                .append( "<a>" + item.name + "</a>" )
                .appendTo( ul );
        };
    $("#adddetalle").click(function(){add();});
    $( "#save" ).click(function()
    {
        bval = true;                
        bval = bval && $("#caja").required();
        bval = bval && $( "#fecha" ).required();
        bval = bval && $( "#ruc" ).required();
        bval = bval && $( "#razonsocial" ).required();

        if ( bval )
        {
            var ht = $(this).html();
            if(ht=="GRABAR")
            {
                var str = $("#frm").serialize(),
                    comp = $('#idtipo_documento option:selected').html();
                    str += '&comprobante='+comp;
                showMensaje('Procesando su solicitud...');
                $.post('index.php',str,function(result)
                {
                    var html_printer = "";                    
                    if(result[0]=='1')
                    {
                        html_printer = '<a class="lnk-results" target="_blank" href="index.php?controller=egreso&action=printer&iv='+result[2]+'">Imprimir</a>';                       
                        html_printer += '<a class="lnk-results" href="index.php?controller=ingresos&action=create" id="">Registrar Nuevo</a>';                       
                        if(idmovimiento=="")
                        {
                            $("#save").empty().append("Egreso Guardado.");
                        }
                        else 
                        {
                            $("#save").empty().append("Egreso Actualizado.");
                        }
                        $("#idmovimiento").val(result[2]);
                    }
                    else {
                        $("#save").empty().append("GRABAR");
                    }
                    showMensaje(result[1]+' '+html_printer,result[0]);
                },'json');
            }    
        }
        return false;
    });

    $( "#delete" ).click(function(){
          if(confirm("Confirmar Eliminacion de Registro"))
              {
                  $("#frm").submit();
              }
    });
    
     $(".quit").live('click',function(){
        var item = $(this).parent().parent().attr("id");
        quit(item);
    });
    
});

function add()
{
        
    
    if(validard())
        {
            var idconcepto_movimiento = $("#idconcepto_movimiento").val(),
                concepto   = $("#concepto").val(),
                cantidad   = $("#cantidad").val(),
                monto      = $("#monto").val();
                
                //var pos = concepto.lastIndexOf('(');                
                //concepto = concepto.substring(1,pos);        
                
                var parametros = {idconcepto_movimiento:idconcepto_movimiento,
                                  concepto:concepto,
                                  cantidad:cantidad,
                                  monto:monto}
                
                var str = jQuery.param(parametros);
                
                $.post('index.php','controller=egreso&action=add&'+str,function(resp)
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
            bval = bval && $("#idconcepto_movimiento").required();
            bval = bval && $("#cantidad").required();
            bval = bval && $("#monto").required();
        return bval;
    }
    function clear_frm_detalle()
    {
        $("#idconcepto_movimiento").val('');
        $("#cantidad").val('1');
        $("#monto").val('0.00');
        $("#concepto").val('');
        $("#idconcepto_movimiento").focus();
    }
    function quit(item)
    {
       
        if(confirm("Realmente deseas quitar este Item?"))
        {
            $.post('index.php','controller=egreso&action=quit&i='+item,function(resp){                     
                 $("#div-detalle").empty().append(resp);
        });
    }    
}
function clear_proveedor()
{
    $("#razonsocial").val('');    
}

function habilitar(b)
{
    if(b==0)
        {
            $("#razonsocial").removeAttr("readonly");
        }
      else {
          $("#razonsocial").attr("readonly",true);
      }
}