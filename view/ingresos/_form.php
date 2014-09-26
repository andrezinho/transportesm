<?php  
        include("../lib/helpers.php"); 
        include("../view/header_form.php");
?>
<script type="text/javascript" src="js/app/evt_form_ingresos.js" ></script>
<script type="text/javascript" src="js/validateradiobutton.js"></script>
<div class="div_container">
<h6 class="ui-widget-header">&nbsp;</h6>
<?php echo $more_options; ?>     
<div class="contain2"> 
<?php header_form('Registro de ingresos'); ?> 
<form id="frm" action="index.php" method="POST">
    <input type="hidden" name="controller" value="ingresos" />
    <input type="hidden" name="action" value="save" />
    <div class="box-msg" style="display:none"></div>
    <div class="contFrm">
        <div class="contenido" > 
        <div style="background:#fafafa; border:1px solid #dadada; padding:3px 0; text-align:right" class="ui-corner-all">
                <label>CAJA: </label>
                <?php 
                    $readonly = "";
                    $s = ""; $s1 = "";
                    switch ($obj->tipo_pro) {
                        case 1:
                            $s = "selected"; $s1 = "";
                            $readonly="disabled='disabled'";
                            break;
                        case 2: 
                            $s = ""; $s1 = "selected";
                            $readonly="disabled='disabled'";
                            break;
                        default:                            
                            break;
                    }
                ?>
                <select name="caja" id="caja" style="background:#2C99D0; color:#FFFFFF;" <?php echo $readonly; ?> title="Seleccione la caja que será afecta">
                    <option value="">-Seleccione-</option>
                    <option value="1" <?php echo $s; ?>>CAJA DIARIA</option>
                    <option value="2" <?php echo $s1; ?>>CAJA CHICA (Ingresos)</option>
                </select>
            </div>               
            <fieldset class="ui-corner-all">
                <legend>Datos Basicos</legend>            
                <label for="idmovimiento" class="labels" style="width:130px">N°:</label>
                <input type="text" id="idmovimiento" name="idmovimiento" class="text ui-widget-content ui-corner-all" style=" text-align: center;" value="<?php if($obj->idmovimiento!=""){ echo str_pad($obj->idmovimiento,8,'0',0); }?>" readonly="" size="10"  />
                <label for="tipoingreso" class="labels" style="width:130px">Tipo de Ingreso:</label>
                <?php 
                $s1 = "selected"; $s2 = ""; $d2 = "none"; $d1 = "block";
                if($obj->tipo_ingreso==1) {$s1 = "selected"; $s2 = ""; $d2 = "none"; $d1 = "block";}
                if($obj->tipo_ingreso==2) {$s1 = ""; $s2 = "selected"; $d2 = "block"; $d1 = "none";}
                ?>
                <select name="tipoi" id="tipoi" style="background: green; color:#ffffff">
                    <option value="1" <?php echo $s1; ?> >Ingreso por Papeleta</option>
                    <option value="2" <?php echo $s2; ?> >Ingreso Comun
                    </option>
                </select>
                <br/>
                <?php if($obj->ruc!="00000000") 
                        { $display = "inline"; $ck = ""; } 
                       else {$display = "none"; $ck = "checked"; }
                ?>
                <div id="tipo-2" style="display: <?php echo $d2; ?>;">                    
                    <label for="recibi" class="labels" style="width:130px">Recibi de:</label>               
                    <input type="hidden" name="idproveedor" id="idproveedor" value="" class="ui-widget-content ui-corner-all text" />
                    <input type="text" name="ruc" id="ruc" value="<?php echo $obj->ruc; ?>" maxlength="11" class="ui-widget-content ui-corner-all text" onkeypress="return permite(event,'num')" size="10" title="Ruc o Dni del Proveedor" placeholder="DNI y/o RUC" style="display:<?php echo $display; ?>" />
                    <input type="text" name="razonsocial" id="razonsocial" maxlength="100" value="<?php echo $obj->razonsocial; ?>" class="ui-widget-content ui-corner-all text" title="Razon Social del Proveedor" style="width:400px" placeholder="Nombres y/o Razon Social"  />
                    <span style="margin-left: 10px; padding: 2px 5px; background: #dadada;">
                        <input type="checkbox" name="sdni" id="sdni" value="1" <?php echo $ck; ?> />
                        <label for="sdni" style="color:blue; cursor: pointer">Sin DNI/RUC</label>
                    </span>
                </div>
                <div id="tipo-1" style="display: <?php echo $d1; ?>;">
                <label for="idempleado" class="labels" style="width:130px">Empleado/Accionista:</label>
                <input type="text" name="idempleado" id="idempleado" maxlength="8" value="<?php echo $obj->idempleado; ?>" class="ui-widget-content ui-corner-all text" onkeypress="return permite(event,'num')" placeholder="Nro Documento" />                
                <input type="text" name="nombre" id="nombre" value="<?php echo $obj->nombre; ?>" class="ui-widget-content ui-corner-all text" title="Nombre del Propietario" style="width:400px" placeholder="Nombres y Apellidos" />
                <br/>
                <label for="chofer" class="labels" style="width:130px">Chofer:</label>
                <input type="text" name="chofer" id="chofer" value="<?php echo $obj->nombre; ?>" class="ui-widget-content ui-corner-all text" title="Nombre del Chofer" style="width:350px" placeholder="Nombres y Apellidos"/>
                <label for="placa" class="labels" style="width:53px">Placa:</label>
                <?php if($_GET['action']!="show"){ ?>
                <select name="placa" id="placa" class="ui-widget-content ui-corner-all text">
                    <option value="">::Seleccione::</option>
                </select>                
                <?php }
                else {
                    echo $obj->placa;
                } ?>
                <br/>
                </div>
                <label for="fecha" class="labels" style="width:130px">Fecha:</label>
                <input type="text" name="fecha" id="fecha" maxlength="10" value="<?php if($obj->fecha!=""){echo fdate($obj->fecha,"ES");} else {echo date('d/m/Y');} ?>" class="ui-widget-content ui-corner-all text" size="10" style="text-align: center" title="Fecha del Ingreso" />                
                <br/>                
                <label for="observacion" class="labels" style="width:130px">Ref/Obs:</label>
                <input type="text" id="observacion" name="observacion" value="<?php echo $obj->observacion; ?>" style="width:500px" class="ui-widget-content ui-corner-all text" title="Referencia y/o Observacion del Ingreso" placeholder="Observaciones.." /> (* Opcional)
                <br/>
                <br/>
          </fieldset>
          <?php if($_GET['action']!="show") { ?>
          <fieldset class="ui-corner-all">
            <legend>Conceptos</legend>             
            <label for="idconcepto_movimiento" class="labels" style="width:60px">Concepto</label>
            <input type="text" name="idconcepto_movimiento" id="idconcepto_movimiento" value="" class="ui-widget-content ui-corner-all text" title="Codigo del Concepto" style="width:50px" placeholder="Codigo" />
            <input type="text" name="concepto" id="concepto" value="" class="ui-widget-content ui-corner-all text" title="Descripcion del Concepto" style="width:350px" placeholder="Descripcion del concepto" />
            <!-- <a href="javascript:popup('index.php?controller=Concepto_Movimiento&action=search',500,400)" id="buscarconcepto" style="border:0" title="Buscar Conceptos"><img src="images/lupa.gif" style="border:0" /></a> -->
            <label for="cantidad" class="labels" style="width:45px">Cant.</label>
            <input type="text" name="cantidad" id="cantidad" value="1" class="ui-widget-content ui-corner-all text" onkeypress="return permite(event,'num')" title="Cantidad del Concepto de ingreso" style="width:20px" />
            <label for="monto" class="labels" style="width:110px">Monto Unitario</label>
            <input type="text" name="monto" id="monto" class="ui-widget-content ui-corner-all text" onkeypress="return permite(event,'num')" title="Monto del Concepto de ingreso" style="width:50px;text-align:right" value="0.00" /> S/.
            <a href="javascript:" id="adddetalle" style="border:0" title="Agregar Conceptos" class="box-boton boton-new"></a>
               &nbsp;&nbsp;Agregar            
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
                <a href="index.php?controller=ingresos&action=anular&id=<?php echo $_GET['id']; ?>" class="button">ANULAR</a>
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