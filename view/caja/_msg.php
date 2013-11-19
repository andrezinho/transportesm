<script type="text/javascript">
    $(document).ready(function(){
        $("#si-ap").live('click',function(){
            $("#box-apertura").show("slow");
        });
        $("#aperturar").live('click',function(){
            var f = $("#fecha").val();
           $.post('index.php','controller=caja&action=aperturar&fecha='+f,function(d){            
             if(d[0]==1)
             {
                alert('Se ha aperturado la caja para el dia '+f);
                window.location = "index.php";
             }
             else {
              alert(d[1]);
             }
               
           },'json');
        });
    })
</script>
<h6 class="ui-widget-header">&nbsp;</h6>
<div style="text-align: center; width:500px; margin: 30px auto; display: block; font-size:20px; color:#333">
    No se pudo encontrar ninguna caja aperturada para este dia,</br></br> ¿Desea Aperturarla?
    <br/>
    <a href="javascript:" id="si-ap" class="button" >Si</a> <a href="index.php?controller=User&action=logout" class="button">No</a>
</div>
<div id="box-apertura" style=" display: none; ">
    <div style="width:470px; margin:0 auto;background:#FEF8B6;padding:20px 10px; border:1px solid #dadada">
        <label><b>TURNO: <?php echo $_SESSION['name_turno']; ?></b></label>
        <br/>
        <label><b>OFICINA: <?php echo $_SESSION['oficina']; ?></b></label>
        <br/>
        <label><b>FECHA : <?php echo date('d/m/Y') ?></b></label>        
        <input type="hidden" name="fecha" id="fecha" value="<?php echo date('d/m/Y') ?>" size="10" class="ui-widget-content ui-corner-all text" readonly="true" />
        <br/>
        <div style="text-align:center; ">
            <a href="javascript:" id="aperturar" class="button">Aperturar</a>            
        </div>        
    </div>
</div>