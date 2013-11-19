<?php  include("../lib/helpers.php"); 
       include("../view/header_form.php"); ?>
<script type="text/javascript" src="js/app/evt_form_caja_banco.js" ></script>
<script type="text/javascript" src="js/validateradiobutton.js"></script>
<div class="div_container">
<h6 class="ui-widget-header">&nbsp;</h6>
<?php echo $more_options; ?>     
<div class="contain2"> 
<?php header_form('Registro de Caja Banco'); ?> 
<form id="frm" action="index.php" method="POST">
    <input type="hidden" name="controller" value="caja_banco" />
    <input type="hidden" name="action" value="save" />
    <div class="contFrm ui-corner-all" style="background: #fff;">                
        <label for="oficina" class="labels">Oficina:</label>
        <input id="oficina" name="oficina" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $_SESSION['oficina'] ?>" disabled="disabled" />
        <br/>
        <label for="fecha" class="labels">Fecha:</label>
        <input type="text" name="fecha" id="fecha" class="text ui-widget-content ui-corner-all" style="width:80px;" value="<?php echo date('d/m/Y') ?>" />
        <br/>
        <label for="tipo" class="labels">Mov.Tipo :</label>
        <?php
        $s1 = ""; $s2 = "";
        if($obj->tipo==1) { $s1 = "selected"; $s2 = ""; }
        if($obj->tipo==2) { $s1 = ""; $s2 = "selected"; }
        ?>
        <select name="tipo" id="tipo" class="ui-widget-content ui-corner-all text">
            <option value="1" <?php echo $s1; ?> >Depositos</option>
            <option value="2" <?php echo $s2; ?> >Retiros</option>
        </select>
        <br/>                
        <label for="monto" class="labels">Monto:</label>
        <input type="text" id="monto" name="monto" class="text ui-widget-content ui-corner-all" style=" width: 70px; text-align: right; font-weight: bold" value="<?php if($obj->monto!="") echo $obj->monto; else echo "0.00"; ?>" />
        <br>
        <label for="observacion" class="labels">Observacion:</label>
        <input type="text" id="observacion" name="observacion" class="text ui-widget-content ui-corner-all" style=" width: 500px; text-align: left; font-weight: normal; font-style: italic" value="<?php if($obj->observacion!="") echo $obj->observacion; else echo ""; ?>" />        
        <div  style="clear: both; padding: 10px; width: auto;text-align: center">
            <?php if($_GET['action']=="create"){ ?>
            <a href="#" id="save" class="button">GRABAR</a>
            <?php } ?>
            <a href="index.php?controller=caja_banco" class="button">ATRAS</a>
        </div>
        
    </div>
</form>
</div>
</div> 