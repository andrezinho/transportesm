$(function() {
    $("#fecha_inscripcion,#fec_ven_soat,#fec_ven_rev,#fecha_ingreso,#fecha_egreso").datepicker({
                            'dateFormat':'dd/mm/yy',
                             showOn: 'both',                                         
                             buttonImageOnly: true,
                             buttonImage: "images/calendar.png",
                             changeMonth:true,
                             changeYear:true
                            });    
    $("#idestado").css("width","205px");
    $( "#marca" ).focus();
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
                return false;
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
                return false;
            }
        }).data( "autocomplete" )._renderItem = function( ul, item ) {
            return $( "<li></li>" )
                .data( "item.autocomplete", item )
                .append( "<a>" + item.name + "</a>" )
                .appendTo( ul );
        };
    $( "#save" ).click(function(){
        bval = true;
        bval = bval && $( "#marca" ).required();
        bval = bval && $( "#modelo" ).required();
        bval = bval && $( "#placa" ).required();
        bval = bval && $( "#color" ).required();
        bval = bval && $( "#idestado" ).required();       
        bval = bval && $( "#idempleado" ).required();       
        
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
});