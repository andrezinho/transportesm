$(function() {    
    $("#razonsocial").focus();
    $( "#save" ).click(function(){
        bval = true;
        bval = bval && $( "#razonsocial" ).required();        
        bval = bval && $( "#ruc" ).required();        
        
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