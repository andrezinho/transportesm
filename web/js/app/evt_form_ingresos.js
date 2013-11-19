$(function() {   
    $("#tipoi").change(function()
    {
        if($(this).val()==1)
            $("#tipo-2").hide("slow");
        else
            $("#tipo-1").hide("slow");
        
        $("#tipo-"+$(this).val()).show("slow");
    });
    $("#fecha").datepicker({
                            'dateFormat':'dd/mm/yy',
                             showOn: 'both',                                         
                             buttonImageOnly: true,
                             buttonImage: "images/calendar.png"
                            });
    $( "#nombre" ).focus();
    $( "#idempleado" ).autocomplete({
            minLength: 0,
            source: "index.php?controller=propietario&action=search_autocomplete&tipo=1",
            focus: function( event, ui ) {
                $( "#idempleado" ).val( ui.item.id );                      
                return false;
            },
            select: function( event, ui ) {
                $( "#nombre" ).val( ui.item.name );                
                $( "#idempleado" ).val(ui.item.id);
                $("#chofer").focus();
                load_vechiculo(ui.item.id);
                return false;
            },
            change: function(event, ui) {                 
                
            }
        }).data( "autocomplete" )._renderItem = function( ul, item ) {
            return $( "<li></li>" )
                .data( "item.autocomplete", item )
                .append( "<a>"+ item.id +"-" + item.name + "</a>" )
                .appendTo( ul );
        };
        
        
        $( "#nombre" ).autocomplete({
            minLength: 0,
            source: "index.php?controller=propietario&action=search_autocomplete&tipo=2",
            focus: function( event, ui ) {
                $( "#nombre" ).val( ui.item.name );                
                return false;
            },
            select: function( event, ui ) {
                $( "#nombre" ).val( ui.item.name );                
                $( "#idempleado" ).val(ui.item.id);
                $("#chofer").focus();
                load_vechiculo(ui.item.id);
                return false;
            },
            change: function(event, ui) { 
                //$("#idempleado").val('');
            }
        }).data( "autocomplete" )._renderItem = function( ul, item ) {
            return $( "<li></li>" )
                .data( "item.autocomplete", item )
                .append( "<a>" +item.name + "</a>" )
                .appendTo( ul );
        };

        $( "#idconcepto_movimiento" ).autocomplete({
            minLength: 0,
            source: "index.php?controller=concepto_movimiento&action=search_autocompletei&tipo=1",
            focus: function( event, ui ) {
                $( "#idconcepto_movimiento" ).val( ui.item.id );                
                return false;
            },
            select: function( event, ui ) {
                $( "#concepto" ).val( ui.item.name );
                $( "#idconcepto_movimiento" ).val(ui.item.id);
                $("#cantidad").focus();
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
            source: "index.php?controller=concepto_movimiento&action=search_autocompletei&tipo=2",
            focus: function( event, ui ) {
                $( "#concepto" ).val( ui.item.name );                
                return false;
            },
            select: function( event, ui ) {
                $( "#concepto" ).val( ui.item.name );
                $( "#idconcepto_movimiento" ).val(ui.item.id);$("#cantidad").focus();
                return false;
            }
        }).data( "autocomplete" )._renderItem = function( ul, item ) {
            return $( "<li></li>" )
                .data( "item.autocomplete", item )
                .append( "<a>" + item.name + "</a>" )
                .appendTo( ul );
        };
        
        $( "#chofer" ).autocomplete({
            minLength: 0,
            source: "index.php?controller=chofer&action=search_autocomplete&tipo=2",
            focus: function( event, ui ) {
                $( "#chofer" ).val( ui.item.name );                
                return false;
            },
            select: function( event, ui ) {
                $( "#chofer" ).val( ui.item.name );
                $("#placa").focus();
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
        //bval = bval && $( "#idempleado" ).required();                
        //bval = bval && $( "#chofer" ).required();                
        //bval = bval && $( "#placa" ).required();                        
        if ( bval ) 
        {
            var ht = $(this).html();
            if(ht=="GRABAR")
            {
                var str = $("#frm").serialize();                
                $.post('index.php',str,function(result)
                {
                    var html_printer = "";                    
                    if(result[0]=='1')
                    {
                        html_printer = '<a class="lnk-results" target="_blank" href="index.php?controller=ingreso&action=printer&iv='+result[2]+'">Imprimir</a>';                       
                        html_printer += '<a class="lnk-results" href="javascript:" id="re-new">Registrar Nuevo</a>';
                        if(result[3]=="1")
                        {
                            html_printer += '<a class="lnk-results" href="javascript:" id="re-genv">Generar Comprobante</a>';
                        }                        
                        if(idmovimiento=="")
                        {
                            $("#save").empty().append("Ingreso Guardado.");
                        }
                        else {
                            $("#save").empty().append("Ingreso Actualizado.");
                        }
                        $("#idenvio").val(result[2]);
                    }
                    else {
                        $("#save").empty().append("GRABAR");
                    }
                    showboxmsg(result[1]+' '+html_printer,result[0]);
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
                
                $.post('index.php','controller=ingreso&action=add&'+str,function(resp)
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
            $.post('index.php','controller=ingreso&action=quit&i='+item,function(resp){                     
                 $("#div-detalle").empty().append(resp);
        });
    }    
}

function load_vechiculo(idpropietario)
{
    $.get('index.php?controller=vehiculo&action=getv&idpropietario='+idpropietario,function(rows){        
        var html = "<option value=''>::Seleccione::</option>";
        $.each(rows, function(i,j){            
            html += "<option value='"+j+"'>"+j+"</option>";            
        });
        $("#placa").empty().append(html);
    },'json');
}