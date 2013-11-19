<?php  include("../lib/helpers.php"); ?>
<script type="text/javascript" src="js/app/evt_form_unidad.js" ></script>
<script type="text/javascript" src="js/validateradiobutton.js"></script>
<div class="div_container">
<h6 class="ui-widget-header">Registro de unidad</h6>
<?php echo $more_options; ?>     
<div class="contain" style="width: 812px; float: right; height:auto"> 
<?php include("../view/header_form.php"); ?> 
<form id="frm" action="index.php" method="POST">
    <input type="hidden" name="controller" value="unidad" />
    <input type="hidden" name="action" value="save" />
    <div class="contFrm">
        <div class="contenido" >                
                <label for="idunidad" class="labels">Codigo:</label>
                <input type="text" id="idunidad" name="idunidad" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->idunidad; ?>" readonly="" />
                <br/>
                <label for="descripcion" class="labels">Descripcion:</label>
                <input type="text" id="descripcion" name="descripcion" value="<?php echo $obj->descripcion; ?>" style="width:300px" class="ui-widget-content ui-corner-all text" />
                <br/>
                <label for="abreviado" class="labels">Abreviado:</label>
                <input type="text" id="abreviado" name="abreviado" value="<?php echo $obj->abreviado; ?>" style="width:300px" class="ui-widget-content ui-corner-all text" />
                <br/>
                
                <div  style="clear: both; padding: 5px; width: auto;text-align: center">
                    <a href="#" id="save" class="button">GRABAR</a>
                    <a href="index.php?controller=<?php echo $_GET['controller'] ?>" class="button">ATRAS</a>
                </div>
        </div>        
    </div>
    
</form>
</div>    
</div>