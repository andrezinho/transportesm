<?php  include("../lib/helpers.php"); 
       include("../view/header_form.php");
?>
<script type="text/javascript" src="js/app/evt_form_articulo.js" ></script>
<script type="text/javascript" src="js/validateradiobutton.js"></script>
<div class="div_container">
<h6 class="ui-widget-header">&nbsp;</h6>
<?php echo $more_options; ?>     
<div class="contain" style="width: 812px; float: right; height:auto"> 
<?php header_form('Registro de articulo'); ?>    
<form id="frm" action="index.php" method="POST">
    <input type="hidden" name="controller" value="articulo" />
    <input type="hidden" name="action" value="save" />
    <div class="contFrm">
        <div class="contenido" >                
                <label for="idarticulo" class="labels">Codigo:</label>
                <input type="text" id="idarticulo" name="idarticulo" class="text ui-widget-content ui-corner-all" style=" width: 150px; text-align: left;" value="<?php if($obj->idarticulo!=""){ echo str_pad($obj->idarticulo,8,'0',0); }?>" readonly="" />
                <br/>
                <label for="idunidad" class="labels">Unidad:</label>
                <?php echo $unidad; ?>
                <br/>
                <label for="descripcion" class="labels">Descripcion:</label>
                <input type="text" id="descripcion" name="descripcion" value="<?php echo $obj->descripcion; ?>" style="width:350px" class="ui-widget-content ui-corner-all text" />                
                <br/>                
                <label for="abreviado" class="labels" >Stock:</label>
                <input type="text" id="stock" name="stock" value="<?php echo $obj->stock; ?>" style="width:100px" class="ui-widget-content ui-corner-all text" />
                <br/>
                <label for="stock_minimo" class="labels">Stock Min:</label>
                <input type="text" name="stock_minimo" id="stock_minimo" value="<?php echo $obj->stock_minimo; ?>" style="width:100px" class="ui-widget-content ui-corner-all text" />
                <br/>
                <label for="precio" class="labels">Precio:</label>
                <input type="text" name="precio" id="precio" value="<?php echo $obj->precio; ?>" style="width:100px" class="ui-widget-content ui-corner-all text" />
                <br/>
                <label for="estado" class="labels">Activo:<?php echo $obj->estado; ?></label>
                <?php                   
                    if($obj->estado==1 || $obj->estado==0)
                            {
                             if($obj->estado==1){$rep=1;}
                                else {$rep=0;}
                            }
                     else {$rep = 1;}                    
                     activo('activo',$rep);
                ?>
                <div  style="clear: both; padding: 5px; width: auto;text-align: center">
                    <a href="#" id="save" class="button">GRABAR</a>
                    <a href="index.php?controller=<?php echo $_GET['controller'] ?>" class="button">ATRAS</a>
                </div>
        </div>        
    </div>
    
</form>
</div>    
</div>