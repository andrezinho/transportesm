$(function() {    
    $( "#save" ).click(function(){
        bval = true;
        bval = bval && $( "#idorigen" ).required();
        bval = bval && $( "#iddestino" ).required();
        bval = bval && $( "#precio" ).required();
        if ( bval ) {
            if(validar())
                {
                    $("#frm").submit();
                }
            else {alert("El origen no puede ser igual al destino"); return 0;}
            
            
        }
        
        return false;
    });

    $( "#delete" ).click(function(){
          if(confirm("Confirmar Eliminacion de Registro"))
              {
                  $("#frm").submit();
              }
    });
    
    function validar()
    {
        var d = $("#iddestino").val(),
            o = $("#idorigen").val();
        if(d==o)
            {                
                return false;
            }
         else { return true;}
        
    }
});