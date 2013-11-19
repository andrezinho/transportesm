// JavaScript Document
$(function() {
    $("#cerrarP").click(function(){
			if(confirm("Confirmar el Cierre del Periodo"))
              {
                  $("#frm").submit();
              }
		 });
	
});