<?php  include("../lib/helpers.php"); 
       include("../view/header_form.php");
?>
<script type="text/javascript" src="js/app/evt_form_propietario.js" ></script>
<script type="text/javascript" src="js/validateradiobutton.js"></script>
<style>
    .labels { width: 130px;}
</style>
<?php 
    $readonly = "";
    $op=0;
    if($obj->idempleado!="")
        {
            $readonly="readonly";
            $op=1;
        }
?>
<div class="div_container">
<h6 class="ui-widget-header">&nbsp;</h6>
<?php echo $more_options; ?>     
<div class="contain2"> 
<?php header_form('Mantenimiento de propietario'); ?>   
    <form id="frm" action="index.php" method="POST">
    <input type="hidden" name="controller" value="propietario" />
    <input type="hidden" name="action" value="save" />
    <div class="contFrm" style="background: #fff;">
        <div style="margin:0 auto; ">                
                <label for="idpropietario" class="labels">DNI:</label>
                <input type="text" id="idempleado" maxlength="8" name="idempleado" class="text ui-widget-content ui-corner-all" style=" width: 100px; text-align: left;" value="<?php echo $obj->idempleado; ?>" <?php echo $readonly; ?> title="Ingrese su DNI" maxlength="8" onkeypress="return permite(event,'num')" />
                <br/>
                <label for="idoficina" class="labels">Oficina:</label>
                <?php echo $oficina; ?>
                <br/>
                <label for="nombre" class="labels">Nombres:</label>
                <input type="text" id="nombre" maxlength="100" name="nombre" class="text ui-widget-content ui-corner-all" style=" width: 300px; text-align: left;" value="<?php echo $obj->nombre; ?>" />
                <br/>
                <label for="apellidos" class="labels">Apellidos:</label>
                <input type="text" id="apellidos" maxlength="100" name="apellidos" class="text ui-widget-content ui-corner-all" style=" width: 300px; text-align: left;" value="<?php echo $obj->apellidos; ?>" />
                <br/>               
                <label for="ruc" class="labels">RUC:</label>
                <input type="text" id="ruc" maxlength="11" name="ruc" class="text ui-widget-content ui-corner-all" onkeypress="return permite(event,'num')" style=" width: 300px; text-align: left;" value="<?php echo $obj->ruc; ?>" />
                <br/>                
                <label for="fecha_nacimiento" class="labels">Fecha Nacimiento:</label>
                <input type="text" id="fecha_nacimiento" maxlength="10" name="fecha_nacimiento" class="text ui-widget-content ui-corner-all" style=" width: 100px; text-align: left;" value="<?php if($obj->fecha_nacimiento!="") {echo fdate($obj->fecha_nacimiento,'ES');} else {echo date('d/m/Y');} ?>" />
                <br/>
                <label for="fecha_v_dni" class="labels">F. Vencimiento DNI:</label>
                <input type="text" id="fecha_v_dni" maxlength="10" name="fecha_v_dni" class="text ui-widget-content ui-corner-all" style=" width: 100px; text-align: left;" value="<?php if($obj->fecha_v_dni!="") {echo fdate($obj->fecha_v_dni,'ES');} else {echo date('d/m/Y');} ?>" />
                <br/>
                <label for="fecha_registro" class="labels">Fecha Ingreso:</label>
                <input type="text" id="fecha_registro" maxlength="10" name="fecha_registro" class="text ui-widget-content ui-corner-all" style=" width: 100px; text-align: left;" value="<?php if($obj->fecha_registro!="") {echo fdate($obj->fecha_registro,'ES');} else {echo date('d/m/Y');} ?>" />
                <br/>
                <label for="fecha_nacimiento" class="labels">Fecha Egreso:</label>
                <input type="text" id="fecha_egreso" maxlength="10" name="fecha_egreso" class="text ui-widget-content ui-corner-all" style=" width: 100px; text-align: left;" value="<?php if($obj->fecha_egreso!="") {echo fdate($obj->fecha_egreso,'ES');} else {echo date('d/m/Y');} ?>" />
                <br/>
                <label for="celular" class="labels">Celular:</label>
                <input type="text" id="celular" maxlength="100" name="celular" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->celular; ?>" />                                
                <br/> 
                <label for="direccion" class="labels">Direccion:</label>
                <input type="text" id="direccion" maxlength="200" name="direccion" class="text ui-widget-content ui-corner-all" style=" width: 300px; text-align: left;" value="<?php echo $obj->direccion; ?>" />
                <br/>  
                <input type="hidden" name="oper" id="oper" value="<?php echo $op; ?>"/>
                <label for="tipo" class="labels">Tipo:</label>   
                
                <label for="accionista" style="margin-left:5px;font-size:10px; color:#333;">ACCIONISTA</label>
                <?php 
                      $cka = ""; $cki = "";
                      if($obj->accionista==1) $cka = "checked"; 
                      if($obj->inquilino==1) $cki = "checked";
                ?>
                <input type="checkbox" name="accionista" id="accionista" value="1" <?php echo $cka; ?> />
                <label for="inquilino" style="margin-left:15px;font-size:10px; color:#333;">INQUILINO</label>
                <input type="checkbox" name="inquilino" id="inquilino" value="1" <?php echo $cki; ?> />
                <br/><br/>
                <label for="estado" class="labels">Activo:</label>                                
                <?php                   
                    if($obj->estado==true || $obj->estado==false)
                            {
                             if($obj->estado==true){$rep=1;}
                                else {$rep=0;}
                            }
                     else {$rep = 1;}                    
                     activo('activo',$rep);
                ?>
                
                <div style="clear: both; padding: 10px; width: auto;text-align: center">
                    <a href="#" id="save" class="button">GRABAR</a>
                    <a href="index.php?controller=propietario" class="button">ATRAS</a>
                </div>
            </div>
        </div>
    </form>
</div>    
</div>