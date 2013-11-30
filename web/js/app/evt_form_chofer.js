$(function() {    
    $("#div_activo").buttonset();
    $("#fecha_registro,#fecha_nacimiento,#fecha_egreso,#fecha_v_dni,#fecha_v_licencia,#fecha_v_capacitacion").datepicker({dateFormat:'dd/mm/yy',changeYear:true,changeMonth:true});
    $("#idoficina","#idgrupo").css("width","auto");
    $( "#save" ).click(function(){
        bval = true;
        bval = bval && $( "#idempleado" ).required();
        bval = bval && $( "#idoficina" ).required();
        bval = bval && $( "#idgrupo" ).required();
        bval = bval && $( "#nombre" ).required();
        bval = bval && $( "#apellidos" ).required();
        if ( bval ) 
        {
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