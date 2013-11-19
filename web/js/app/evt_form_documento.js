$(function() {
    $("#corigen").buttonset();
    $( "#save" ).click(function(){
        bval = true;
        bval = bval && $( "#descripcion" ).required();
        bval = bval && $( "#abreviatura" ).required();
        bval = bval && $( "#tiempo" ).required();
        
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