<?php  
       include("../lib/helpers.php");
       include("../view/header_form.php");
?>
<script type="text/javascript" src="js/app/evt_form_reclamos.js" ></script>
<script type="text/javascript" src="js/validateradiobutton.js"></script>
<div class="div_container">
<h6 class="ui-widget-header">&nbsp;</h6>
<?php echo $more_options; ?>     
<div class="contain2"> 
<?php header_form('Mantenimiento de Reclamos'); ?>   

<form name="frm" id="frm" action="" method="post">
<input type="hidden" name="controller" value="reclamos" />
    <input type="hidden" name="action" value="save" />
            <div class="full_width" style="margin-top:10px;">            
              <div style="width:720px; margin:0 auto;">
                    <table width="700" border="0" cellpadding="3" cellspacing="0" class="table ui-widget-content ui-corner-all" style="padding:10px">
                        <input type="hidden" name="idreclamos" id="idreclamos" value="<?php echo $obj->idreclamos ?>" />
                      <tr>
                        <td colspan="4" align="center"><strong>LIBRO DE RECLAMACIONES</strong></td>
                        <td colspan="4" align="center"><strong>Hoja de Reclamacion</strong></td>
                      </tr>
                      <tr>
                        <td width="110">Fecha:</td>
                        <td colspan="3"><b><?php echo $obj->fecha; ?></b></td>
                        <td colspan="4" align="center"><b>N° <?php echo str_pad($obj->idreclamos, 5,'0',0)." - ".$obj->anio; ?></b></td>
                      </tr>
                      <tr>
                        <td colspan="8"><strong>EMPRESA SAN MARTÍN</strong></td>
                      </tr>
                      <tr>
                        <td colspan="8"><b>1.  IDENTIFICACIÓN DEL CONSUMIDOR RECLAMANTE</b></td>
                      </tr>
                      <tr>
                        <td>Nombre y Apellidos:<br /></td>
                        <td colspan="7">
                            <input type="text" readonly="" name="nombres" id="nombres" value="<?php echo $obj->nombres ?>" class="ui-widget-content ui-corner-all text" style="width:98%; margin-left:1px;" onkeypress="return permite(event,'num_car')">
                        </td>
                      </tr>
                      <tr>
                        <td>Domicilio:<br /></td>
                        <td colspan="7">
                            <input type="text" name="domicilio" id="domicilio" readonly="" value="<?php echo $obj->domicilio; ?>" class="ui-widget-content ui-corner-all text" style="width:98%; margin-left:1px;" onkeypress="return permite(event,'num_car')">
                        </td>
                      </tr>
                      <tr>
                        <td>DNI / CE:</td>
                        <td colspan="2">
                            <input type="text" name="dni" id="dni" readonly="" value="<?php echo $obj->dni; ?>" class="ui-widget-content ui-corner-all text" style="width:98%; margin-left:1px;" onkeypress="return permite(event,'num')" maxlength="9">
                        </td>
                        <td width="111" align="right">Telefono: </td>
                        <td colspan="4" align="left">
                            <input type="text" name="telefono" id="telefono" readonly="" value="<?php echo $obj->telefono; ?>" class="ui-widget-content ui-corner-all text" style="width:96%; margin-left:1px;" onkeypress="return permite(event,'num')">
                        </td>
                      </tr>
                      <tr>
                        <td>E-mail:</td>
                        <td colspan="7">
                            <input type="text" name="email" id="email" readonly="" value="<?php echo $obj->email; ?>" class="ui-widget-content ui-corner-all text" style="width:98%; margin-left:1px;">
                        </td>
                      </tr>
                      <tr>
                        <td colspan="8"><b>2. IDENTIFICACIÓN DEL BIEN CONTRATADO</b></td>
                      </tr>
                      <tr>
                        <td align="center">Producto</td>
                        <td width="13" align="left"><b>[&nbsp;&nbsp;]</b></td>
                        <td width="75" align="right">Descripcion:</td>
                        <td colspan="5" rowspan="1" valign="top">
                           <?php echo $tipo_servicio; ?>
                        </td>
                      </tr>
                      <tr>
                        <td align="center">Servicio</td>
                        <td align="left"><b>[X]</b></td>
                        <td colspan="6">
                            <input type="text" name="otro" id="otro" value="" style="width:98%; margin-left:1px;display:none;" placeholder="Ingrese la descripcion del Servicio Contratado" />
                        </td>
                      </tr>
                      <tr>
                        <td colspan="4"><b>3. DETALLE DE LA RECLAMACIÓN</b></td>
                        <td width="50" align="right"><label for="idtipo_reclamo_1">Reclamo:</label></td>
                        <?php 
                         
                         if($obj->idtipo_reclamo==1)
                         {
                            $chk = "checked";
                            $chk2 = "";
                         }
                         elseif($obj->idtipo_reclamo==2)
                         {
                            $chk = "";
                            $chk2 = "checked";
                         }
                         else
                         {$chk = "checked";
                         $chk2 = "";}
                        ?>
                        <td width="30" align="center">
                            <input type="radio" name="idtipo_reclamo" id="idtipo_reclamo_1" value="1" <?php echo $chk; ?>/>
                        </td>
                        <td width="37" align="right">
                            <label for="idtipo_reclamo_2">Queja:</label>
                        </td>
                        <td width="30" align="center">
                            <input type="radio" name="idtipo_reclamo" id="idtipo_reclamo_2" value="2" <?php echo $chk2; ?> />
                        </td>
                      </tr>
                      <tr>
                        <td colspan="8">Detalle:</td>
                      </tr>
                      <tr>
                        <td colspan="8">
                            <textarea name="detalle" id="detalle" rows="5" cols="83" placeholder="Describa el reclamo o queja..." readonly=""><?php echo $obj->detalle; ?></textarea>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="8">Acciones:</td>
                      </tr>
                      <tr>
                        <td colspan="8">
                            <textarea name="acciones" id="acciones" rows="5" cols="83" placeholder="" ><?php echo $obj->acciones; ?></textarea>
                        </td>
                      </tr>
                      
                    </table>
                </div>
                <div style="text-align:center">                  
                  <a href="#" id="save" class="button">GRABAR</a>
                    <a href="index.php?controller=reclamos" class="button">ATRAS</a>
                </div>
            <div class="cleaner"></div>
        </div>        
</form>        
</div>
</div> 