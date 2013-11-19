<?php  include("../lib/helpers.php"); 
       include("../view/header_form.php");
?>
<script type="text/javascript" src="js/app/evt_form_personal.js" ></script>
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
<?php header_form('Mantenimiento de Personal'); ?>   
    <form id="frm" action="index.php" method="POST">
    <input type="hidden" name="controller" value="personal" />
    <input type="hidden" name="action" value="save" />
    <div class="contFrm" style="background: #fff;">
        <div style="margin:0 auto; ">                
                <label for="idpersonal" class="labels">DNI:</label>
                <input type="text" id="idempleado" name="idempleado" maxlength="8" class="text ui-widget-content ui-corner-all" onkeypress="return permite(event,'num')" style=" width: 100px; text-align: left;" value="<?php echo $obj->idempleado; ?>" <?php echo $readonly; ?> title="Ingrese su DNI o su codigo de Personal" />
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
                <input type="text" id="ruc" maxlength="11" name="ruc" class="text ui-widget-content ui-corner-all" style=" width: 300px; text-align: left;" value="<?php echo $obj->ruc; ?>" />
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
                <label for="turno" class="labels">Turno :</label>
                <?php
                    $turnos = array(1=>'NORMAL',2=>'GUARDIANIA');
                ?>
                <select name="turno" id="turno" class="ui-widget-content text ui-corner-all">
                    <?php 
                        foreach($turnos as $k => $t)
                        {
                            $s = "";
                          if($k == $obj->turno)  
                          {
                              $s = "selected";
                          }
                            ?>                
                            <option value="<?php echo $k; ?>" <?php echo $s; ?>><?php echo $t; ?></option>
                            <?php
                        }
                    ?>
                </select>
                <br/>
                <input type="hidden" name="oper" id="oper" value="<?php echo $op; ?>"/>
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
                    <a href="index.php?controller=personal" class="button">ATRAS</a>
                </div>
            </div>
        </div>
    </form>
</div>    
</div>