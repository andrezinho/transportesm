$(function() {    
    $( "#save" ).click(function(){
        bval = true;
        bval = bval && $( "#descripcion" ).required();
        bval = bval && $( "#idsucursal").required();
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