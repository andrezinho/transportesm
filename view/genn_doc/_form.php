<?php  include("../lib/helpers.php"); 
       include("../view/header_form.php");
?>
<script type="text/javascript" src="js/app/evt_form_genn_doc.js" ></script>
<script type="text/javascript" src="js/validateradiobutton.js"></script>
<div class="div_container">
<h6 class="ui-widget-header">&nbsp;</h6>
<?php echo $more_options; ?>     
<div class="contain2"> 
<?php header_form('Mantenimiento de genn_doc'); ?>  
<form id="frm" action="index.php" method="POST">
    <input type="hidden" name="controller" value="genn_doc" />
    <input type="hidden" name="action" value="save" />
    <div class="contFrm ui-corner-all" style="background: #fff;">
        
                
                <label for="idgenn_doc" class="labels">Codigo:</label>
                <input id="idgenn_doc" name="idgenn_doc" class="text ui-widget-content ui-corner-all" style=" width: 100px; text-align: left;" value="<?php echo $obj->idgenn_doc; ?>" readonly />
                <label for="oficina" class="labels" style="width: 113px">Oficina.:</label>
                <?php echo $oficina; ?>
                <br/>
                <label for="tipo_documento" class="labels">Tipo de Doc.:</label>
                <?php echo $tipo_documento; ?>
                <label for="serie" class="labels" style="width: 60px">Serie:</label>
                <input id="serie" maxlength="100" name="serie" class="text ui-widget-content ui-corner-all" style=" width: 100px; text-align: left;" value="<?php echo $obj->serie; ?>" />
                <br/>
                <label for="numi" class="labels">Nro Inicial:</label>
                <input id="numi" maxlength="100" name="numi" class="text ui-widget-content ui-corner-all" style=" width: 100px; text-align: left;" value="<?php echo $obj->numi; ?>" />
                <label for="numf" class="labels"style="width: 113px">Nro Final:</label>
                <input id="numf" maxlength="100" name="numf" class="text ui-widget-content ui-corner-all" style=" width: 100px; text-align: left;" value="<?php echo $obj->numf; ?>" />    
                <br/>
                <label for="current" class="labels">Nro Actual:</label>
                <input id="current" maxlength="100" name="current" class="text ui-widget-content ui-corner-all" style=" width: 100px; text-align: left;" value="<?php echo $obj->current; ?>" />
                <div  style="clear: both; padding: 10px; width: auto;text-align: center">
                    <a href="#" id="save" class="button">GRABAR</a>
                    <a href="index.php?controller=genn_doc" class="button">ATRAS</a>
                </div>
        
    </div>
</form>
</div>
</div> 