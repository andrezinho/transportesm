$(function()
{
    $("#fecha").datepicker({'dateFormat':'dd/mm/yy'});
    $( "#save" ).click(function(){
        bval = true;
        bval = bval && $( "#fecha" ).required();
        bval = bval && $( "#monto" ).required();
        if ( bval ) 
        {
            var monto = $("#monto").val();
            monto = parseFloat(monto);
            if(monto>0)
            {
                if(confirm("Desea confirmar este registro en caja banco?"))                    
                    $("#frm").submit();                
            }
            else
            {
                alert("El monto debe ser mayor a cero (0)");
                $("#monto").focus();
            }            
        }
        return false;
    });
});