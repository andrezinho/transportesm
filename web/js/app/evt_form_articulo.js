$(function() {
    $( "#idunidad" ).focus();    
    $("#div_activo").buttonset();
    $( "#save" ).click(function(){
        bval = true;        
        bval = bval && $( "#idunidad" ).required();                
        bval = bval && $( "#descripcion" ).required();                
        bval = bval && $( "#stock" ).required();                        
        bval = bval && $("#div_activo").validateradiobutton();
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