<?php  include("../lib/helpers.php"); 
       include("../view/header_form.php");  ?>
<script type="text/javascript" src="js/app/evt_form_egresos.js" ></script>
<script type="text/javascript" src="js/validateradiobutton.js"></script>
<div class="div_container">
<h6 class="ui-widget-header">&nbsp;</h6>
<?php echo $more_options; ?>     
<div class="contain2"> 
<?php header_form('Registro de Egresos'); ?> 
<form id="frm" action="index.php" method="POST">
    <input type="hidden" name="controller" value="egreso" />
    <input type="hidden" name="action" value="save" />
    <div class="contFrm">
        <div class="contenido" >                
            <fieldset class="ui-corner-all">
                <legend>Datos Basicos</legend>            
                <label for="idmovimiento" class="labels" style="width:130px">N°:</label>
                <input type="text" id="idmovimiento" name="idmovimiento" class="text ui-widget-content ui-corner-all" style=" text-align: center;" value="<?php if($obj->idmovimiento!=""){ echo str_pad($obj->idmovimiento,8,'0',0); }?>" readonly="" />
                <br/>
                <label for="idproveedor" class="labels" style="width:130px">Páguese a:</label>
                <input type="hidden" name="idproveedor" id="idproveedor" value="" class="ui-widget-content ui-corner-all text" />
                <input type="text" name="ruc" id="ruc" value="<?php echo $obj->ruc; ?>" maxlength="11" class="ui-widget-content ui-corner-all text" onkeypress="return permite(event,'num')" size="10" title="Ruc o Dni del Proveedor" placeholder="DNI y/o RUC" />
                <input type="text" name="razonsocial" id="razonsocial" maxlength="100" value="<?php echo $obj->razonsocial; ?>" class="ui-widget-content ui-corner-all text" title="Razon Social del Proveedor" readonly="" style="width:400px" placeholder="Nombres y/o Razon Social"  />
                <br/> 
                <label for="fecha" class="labels" style="width:130px">Fecha:</label>
                <input type="text" name="fecha" id="fecha" maxlength ="10" value="<?php if($obj->fecha!=""){echo fdate($obj->fecha,"ES");} else {echo date('d/m/Y');} ?>" class="ui-widget-content ui-corner-all text" size="10" style="text-align: center" title="Fecha del Movimiento" />                
                <br/>                
                <label for="observacion" class="labels" style="width:130px">Ref/Obs:</label>
                <input type="text" id="observacion" name="observacion" value="<?php echo $obj->observacion; ?>" style="width:510px" class="ui-widget-content ui-corner-all text" title="Referencia y/o Observacion del Movimiento" placeholder="Observacion..." />  (* Opcional)                            
                <br/>
                <br/>
          </fieldset>
          <?php if($_GET['action']!="show") { ?>
          <fieldset class="ui-corner-all">
            <legend>Conceptos</legend>             
            <label for="idconcepto_movimiento" class="labels" style="width:60px">Concepto</label>
            <input type="text" name="idconcepto_movimiento" id="idconcepto_movimiento" value="" class="ui-widget-content ui-corner-all text" title="Codigo del Concepto" style="width:50px" placeholder="Codigo" />
            <input type="text" name="concepto" id="concepto" value="" class="ui-widget-content ui-corner-all text" title="Descripcion del Concepto" style="width:350px;" placeholder="Descripcion del Concepto" />            
            <label for="cantidad" class="labels" style="width:45px">Cant.</label>
            <input type="text" name="cantidad" id="cantidad" value="1" class="ui-widget-content ui-corner-all text" onkeypress="return permite(event,'num')" title="Cantidad del Concepto de Egreso" style="width:30px" />
            <label for="monto" class="labels" style="width:40px">Monto</label>
            <input type="text" name="monto" id="monto" value="0.00" class="ui-widget-content ui-corner-all text" onkeypress="return permite(event,'num')" title="Monto del Concepto de Egreso" style="width:50px; text-align: right"  /> S/.
            <a href="javascript:" id="adddetalle"  title="Agregar Conceptos" class="box-boton boton-add">&nbsp;</a>
          </fieldset>
          <?php } ?>
          <div id="div-detalle">
            <?php echo $detalle; ?>
          </div>
          <div  style="clear: both; padding: 5px; width: auto;text-align: center">
            <?php if($_GET['action']!="show") { ?>
            <a href="#" id="save" class="button">GRABAR</a>
            <?php } 
            else {
                if($obj->estado=="1")
                {
                ?>
                <a href="index.php?controller=egreso&action=anular&id=<?php echo $_GET['id']; ?>" class="button">ANULAR</a>
                <?php
            }
            }
            ?>
            <a href="index.php?controller=<?php echo $_GET['controller'] ?>" class="button">ATRAS</a>
                </div>
        </div>        
    </div>    
</form>
</div>    
</div>
<div id="box-msg-result"></div>