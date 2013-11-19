<?php  include("../lib/helpers.php");  ?>
<script type="text/javascript">
    $(document).ready(function(){
        $("#si-ap").live('click',function(){
            $("#box-apertura").fadeIn(1000,function(){
                $("#saldo").focus();
            });
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
                                        marginTop:'20px',
                                        height:'320px',
                                        backgroundColor:"#FAFAFA",
                                        fontSize:"14px",
                                        padding:"20px"
                                    }, 700, function() {
                                        $("#box-apertura").append(d[1]);
                                    });
                        }
                    else 
                    {
                        alert("A ocurrido un error, intentelo nuevamente.");
                    }
                },'json');
               }           
        });
    })
</script>
<h6 class="ui-widget-header">&nbsp;</h6>
<div id="box-msg" style="text-align: justify; width:500px; margin: 20px auto;  display: block; font-size: 14px; color:red">
    <b>Mensaje del Sistema</b>: Se ha encontrado que para este usuario, turno y oficina tiene una caja que aún no a sido cerrada, porfavor cerrar para 
    poder aperturar una nueva. 
    <div style="text-align:center; margin-top:0px">
        <a href="javascript:" id="si-ap" class="links">Ver Caja Aperturada</a> 
    </div>
</div>
<div id="box-apertura" style=" display: none; width: 800px; margin: 0 auto;">
    <div style="width:470px; margin:10px auto;background:#FDF8D6;padding:20px 10px; border:1px solid #dadada">
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