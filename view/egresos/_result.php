<?php  include("../lib/helpers.php"); ?>
<script type="text/javascript" src="js/app/evt_form_venta.js" ></script>
<script type="text/javascript" src="js/validateradiobutton.js"></script>
<div class="div_container">
<h6 class="ui-widget-header">REGISTRO DE EGRESOS</h6>
<style type="text/css">
    .img-btn { padding: 5px; border: 0; margin-left: 10px;}
</style>
<div class="ui-widget-content ui-state-active ui-corner-all" style="width:300px; margin: 100px auto; padding: 40px 50px 30px 50px; text-align: center;">
    ¡ SE HA REGISTRADO CORRECTAMENTE !
    <br/><br/>
    <a target="_blank" href="index.php?controller=egreso&action=printer&im=<?php echo $idmovimiento; ?>" class="img-btn" title="Imprimir"><img src="images/print.png" /></a>
    <a href="index.php?controller=egreso&action=create" class="img-btn" title="Registrar Nuevo"><img src="images/copy.png" /></a>
    <a href="index.php?controller=egreso" class="img-btn" title="Volver a Inicio"><img src="images/home.png" /></a>
</div>
</div>