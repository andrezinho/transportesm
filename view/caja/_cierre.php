<?php  include("../lib/helpers.php");  ?>
<script type="text/javascript">
    $(document).ready(function(){    
        $("#saldo").focus();
        $("#pop").dialog({
            title:'Ingrese el monto a depositar',
            modal:true,
            autoOpen:false,
            buttons: {
                    'Depositar':function(){ 
                        if(confirm('Realmente deseas realizar el deposito en la cuenta bancaria?'))
                            {
                                var monto = parseFloat($("#monto_dep").val()),
                                    idof = $("#idof").val(),
                                    idc  = $("#idc").val();
                                if(monto>0)
                                    {
                                        $.post('index.php','controller=caja_banco&action=dep_caja&monto='+monto+'&idof='+idof+'&idc='+idc,function(data){
                                            if(data[0]==1)
                                            {
                                                alert("Se ha registrado el deposito correctamente.");
                                                $("#pop").dialog('close');
                                                window.location = "index.php?controller=user&action=logout";
                                            }
                                            else
                                            {
                                                alert(data[1]);
                                            }
                                        },'json');
                                    }
                                 else
                                     {
                                         alert("El monto a depositar debe ser mayor que cero (0)");
                                         $("#monto_dep").focus();
                                     }
                            }
                    }
            }
        });
        $("#aperturar").live('click',function(){           
           var s = $("#saldo").val();
           if(confirm('Esta realmente seguro que el monto total en caja es S/. '+s+' ?'))
               {
                    $.post('index.php','controller=caja&action=cerrar&s='+s,function(d){
                        if(d[0]==1)
                            {
                                    $("#box-msg").hide("slow");
                                    $("#box-apertura").empty();
                                    $('#box-apertura').animate({
                                            width: '500px',                                
                                            height:'320px',
                                            backgroundColor:"#FAFAFA",
                                            fontSize:"14px"
                                        }, 700, function() {
                                            $("#box-apertura").append(d[1]);
                                        });
                                    $("#monto_dep").val(d[2]);
                                    $("#idof").val(d[3]);
                                    $("#idc").val(d[4]);
                            }
                        else 
                        {
                            alert("A ocurrido un error, intentelo nuevamente.");
                        }
                    },'json');
               }           
        });
        $("#rdcb").live('click',function(){
            $("#pop").dialog('open');
            
        })
    })
</script>
<h6 class="ui-widget-header">CIERRE DE CAJA</h6>
<div id="box-apertura" style="margin:20px auto; padding:10px;">
    <div style="width:470px; margin:40px auto;background:#FDF8D6;padding:20px 10px; border:1px solid #dadada">
        <p style="text-align: justify">
            <b>NOTA:</b><br/>
            Ingrese el monto total en Soles (S/.) que se recaudaron en el transcurso de este periodo diario, 
            una vez confirmada el cierre de caja ya no podrá modificar este valor, tenga cuidado.<br/><br/>
        </p>
    <label class="labels" >USUARIO:</label> <?php echo $_SESSION['name']; ?>
    <br/>
    <label class="labels" >TURNO: </label> <?php echo $_SESSION['name_turno']; ?>
    <br/>
    <label class="labels" >FECHA :</label> <?php echo fdate($_SESSION['fecha_caja'],'ES'); ?>
    <br/>    
    <label class="labels" >OFICINA: </label><?php echo $_SESSION['oficina']; ?>
    <br/><br/>
    <label class="labels"><b>SALDO CAJA: </b></label>
    <input type="text" name="saldo" id="saldo" class="ui-widget-content ui-corner-all text" size="5" maxlength="8" onkeypress="return permite(event,'num')" value="0.00" style="text-align: right" /> S/.
    <br/>
    <div style="text-align:center; margin-top:10px">
    <a href="javascript:" id="aperturar" class="button">Cerrar Caja</a>    
    </div>
</div>
</div>
<div id="pop">
    Monto a Depositar en Cta.: <input type="text" name="monto_dep" id="monto_dep" value="0.00" class="ui-widget-content ui-corner-all text" style="text-align: right; width: 50px;" />
    <input type="hidden" name="idof" id="idof" value="" />
    <input type="hidden" name="idc" id="idc" value="" />
</div>