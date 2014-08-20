<form name="frm" id="frm" action="" method="post">
<div class="ui-widget-header ui-corner-all" style="padding:5px">
                Busqueda de Reclamos: <input type="text" name="nro_reclamo" id="nro_reclamo"  value="" placeholder="Ingrese el Numero de Reclamo" class="ui-widget-content ui-corner-all text" style="width:200px;" />
                <input type="button" name="buscar" id="buscar" value="Buscar" />
            </div>
            <div class="full_width" style="margin-top:10px;">            
            	<div style="width:720px; margin:0 auto;">
                    <table width="700" border="0" cellpadding="3" cellspacing="0" class="table ui-widget-content ui-corner-all" style="padding:10px">
                      <tr>
                        <td colspan="4" align="center"><strong>LIBRO DE RECLAMACIONES</strong></td>
                        <td colspan="4" align="center"><strong>Hoja de Reclamacion</strong></td>
                      </tr>
                      <tr>
                        <td width="110">Fecha:</td>
                        <td colspan="3"><b><?php echo date('d/m/Y'); ?></b></td>
                        <td colspan="4" align="center"><b>N° --</b></td>
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
                            <input type="text" name="nombres" id="nombres" value="" class="ui-widget-content ui-corner-all text" style="width:98%; margin-left:1px;" onkeypress="return permite(event,'num_car')">
                        </td>
                      </tr>
                      <tr>
                        <td>Domicilio:<br /></td>
                        <td colspan="7">
                            <input type="text" name="domicilio" id="domicilio" value="" class="ui-widget-content ui-corner-all text" style="width:98%; margin-left:1px;" onkeypress="return permite(event,'num_car')">
                        </td>
                      </tr>
                      <tr>
                        <td>DNI / CE:</td>
                        <td colspan="2">
                            <input type="text" name="dni" id="dni" value="" class="ui-widget-content ui-corner-all text" style="width:98%; margin-left:1px;" onkeypress="return permite(event,'num')" maxlength="9">
                        </td>
                        <td width="111" align="right">Telefono: </td>
                        <td colspan="4" align="left">
                            <input type="text" name="telefono" id="telefono" value="" class="ui-widget-content ui-corner-all text" style="width:96%; margin-left:1px;" onkeypress="return permite(event,'num')">
                        </td>
                      </tr>
                      <tr>
                        <td>E-mail:</td>
                        <td colspan="7">
                            <input type="text" name="email" id="email" value="" class="ui-widget-content ui-corner-all text" style="width:98%; margin-left:1px;">
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
                        <td width="30" align="center">
                            <input type="radio" name="idtipo_reclamo" id="idtipo_reclamo_1" value="1" checked="" />
                        </td>
                        <td width="37" align="right">
                            <label for="idtipo_reclamo_2">Queja:</label>
                        </td>
                        <td width="30" align="center">
                            <input type="radio" name="idtipo_reclamo" id="idtipo_reclamo_2" value="2" />
                        </td>
                      </tr>
                      <tr>
                        <td colspan="8">Detalle:</td>
                      </tr>
                      <tr>
                        <td colspan="8">
                            <textarea name="detalle" id="detalle" rows="5" cols="83" placeholder="Describa el reclamo o queja..."></textarea>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="3" style="font-size:9px;" valign="top"><b>Reclamo</b>: Disconformidad relacionada a los productos o servicios.</td>
                        <td colspan="5" style="font-size:9px;" valign="top"><b>Queja</b>: Disconformidad no relacionada a los productos o servicios; o, malestar o descontento respecto a la atención al público.</td>
                      </tr>
                    </table>
                </div>
            <div class="cleaner"></div>
        </div>
        <div style="text-align:center">
          <input type="button" name="clear" id="clear" value="Limpiar Formulario" />
          <input type="button" name="enviar" id="enviar" value="Enviar Reclamo" />
        </div>
</form>        