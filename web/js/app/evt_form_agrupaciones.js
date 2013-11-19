$(function() {
    $("#idgrupo").css("width","auto");
    $("#idpropietario,#idchofer").css("width","550px");
    $("#idgrupo").change(function(){
      var i = $(this).val();                    
      getDetalle(i);
    });
    $("#idpropietario").change(function(){
        load_vechiculo($(this).val());
    })
    
    $( "#add" ).click(function(){
        bval = true;
        bval = bval && $( "#idpropietario" ).required();
        bval = bval && $( "#idchofer" ).required();
        bval = bval && $( "#idvehiculo" ).required();
        if ( bval ) 
        {
            var str = $("#frm").serialize();
            $.post('index.php',str,function(r){
                if(r[0]==1)
                    {
                        showboxmsg('SE HA UNIDO CORRECTAMENTE AL GRUPO',1);
                        $("#detalle").empty().append(r[1]);
                    }
                else {
                    showboxmsg(r[1],2);
                }
            },'json');
        }
        return false;
    });
    
    $(".quit-a").live('click',function(){
        var i = $(this).attr("id"),
            ig = $("#idgrupo").val();        
        $.post('index.php','controller=agrupaciones&action=quit&i='+i+'&ig='+ig,function(r){
            if(r[0]==1)
                    {                        
                        showboxmsg('SE HA QUITADO DEL GRUPO',1);
                        $("#detalle").empty().append(r[1]);
                    }
                else {
                    showboxmsg(r[1],2);
                }            
        },'json');
    });

    $( "#delete" ).click(function(){
          if(confirm("Confirmar Eliminacion de Registro"))
              {
                  $("#frm").submit();
              }
    });
});
function getDetalle(g)
{
  $.get('index.php','controller=agrupaciones&action=getDetail&g='+g,function(r){
    $("#detalle").empty().append(r);
  });
}
function load_vechiculo(idpropietario)
{
    $.get('index.php?controller=vehiculo&action=getv2&idpropietario='+idpropietario,function(rows){
        var html = "<option value=''>::Seleccione::</option>";
        $.each(rows, function(i,j){
            html += "<option value='"+j[0]+"'>"+j[1]+"</option>";            
        });
        $("#idvehiculo").empty().append(html);
    },'json');
}