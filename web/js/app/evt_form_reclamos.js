$(function() {
    $("#acciones").focus();
    $("#idtipo_servicio").css("width","99%");
    $( "#save" ).click(function(){
        bval = true;
        bval = bval && $( "#acciones" ).required();
        if ( bval ) 
        {
            var str = $("#frm").serialize();
            $.post('index.php','controller=reclamos&action=save&'+str,function(d){
                if(d[0]=="1")
                {
                    alert(d[1]);
                }
                else
                {
                    $("#enviar").attr("disabled",false);
                    $("#enviar").val("Enviar");
                }
            },'json')
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