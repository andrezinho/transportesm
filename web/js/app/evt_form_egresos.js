$(function() {

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
            select: function( event, ui ) {
                $( "#idproveedor" ).val(ui.item.id);
                $( "#razonsocial" ).val( ui.item.name );
                $( "#ruc" ).val( ui.item.ruc );
                $("#observacion").focus();
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

    $("#adddetalle").click(function()
        {        
                add();
        }
    );

    $( "#save" ).click(function(){
        bval = true;                
        bval = bval && $( "#fecha" ).required();                
        bval = bval && $( "#ruc" ).required();                
        bval = bval && $( "#razonsocial" ).required();                
        
        if ( bval ) {
            $("#frm").submit();
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