$(function() {        
    $("#idchofer,#idvehiculo").css("width","400px");
    $("#iddestino").css("width","150px;")
    $("#idchofer").focus();
  
    $("#iddestino").change(function(){
        var i = $(this).val();
        if(i!="")
        {
            $.get('index.php','controller=itinerario&action=getPricet&idd='+i,function(price){
                $("#precio").val(price);
                $("#precio").focus();
            })            
        }        
    });
    $("#idchofer").change(function(){
       $("#idvehiculo").focus(); 
    });
    $("#idvehiculo").change(function(){
        $("#nrodocumentor").focus();
    });
    
    $( "#save" ).click(function(){
        var ht = $(this).html();
        if(ht=="GRABAR")
        {
            bval = true;        
            bval = bval && $( "#idchofer" ).required();
            bval = bval && $( "#idvehiculo" ).required();
            if ( bval ) {
                //$("#frm").submit();           
                $("#save").empty().append("Grabando...");
                    showboxmsg('Registrando Ticket de Salida...',3);
                    var str = $("#frm").serialize();            
                    $.post('index.php',str,function(result){
                        var html_printer = "";
                        if(result[0]==1)
                            {
                                html_printer = '<a class="lnk-results" target="_blank" href="index.php?controller=salida&action=printer&ie='+result[2]+'">Imprimir</a>';                       
                                html_printer += '<a class="lnk-results" href="javascript:" id="re-new">Registrar Nuevo</a>';
                                $("#save").empty().append("Ticket Generado");
                                $("#idsalida").val(result[2]);
                            }
                        showboxmsg(result[1]+' '+html_printer,result[0]);
                    },'json'); 
            }
            return false;
        }
    }); 
    $("#re-new").live('click',function(){
        clear_frm();
        hideboxmsg();
    })   
});
function load_sernum(idtd)
{   
    $("#idtipo_documento").val(idtd);
    $.get('index.php','controller=genn_doc&action=getcurrent&idtd='+idtd,function(r){        
        $("#serie").val(r.serie);
        $("#numero").val(r.numero);
    },'json');
    //$("#nrodocumento").focus();
}

function venter(evt)
{
    var keyPressed = (evt.which) ? evt.which : event.keyCode
    if (keyPressed==13)
    {
      
    }
}

function overlay()
{    
    var h = $("#div-more-options").height();       
    h = h - 5;    
    var os = $(".contain").offset();
    var w = $(".contain").width();
    w = w - 6;
    $("#div-msg").css({"left":os.left+"px","top":os.top+"px","width":w+"px","height":h+"px"});    
    $("#div-msg").fadeIn();
}

function clear_frm()
{
    var form =  document.forms.frm;
    $(form).find(':input').each(function() {
        nam = this.name;
        id = this.id;            
        if(nam!="fecha"&&nam!="hora"&&nam!="controller"&&nam!="action"&&nam!="origen")
        {            
            this.value = "";
        }
    });          
    $("#save").empty().append("GRABAR");
    $("#idchofer").focus();
}