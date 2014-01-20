<?php 
 function Separar($texto)
 {
     return mb_strtoupper(trim($texto));
 }
?>
<style>
    body
    {
        margin-left:0px;
    }
    .Cabecera{
        font-family:"arial";
		font-size:24px;

    }
    .InfoVenta{
        font-family:"arial";
		font-size:18px;

    }
	.Detalle{
        font-family:"arial";
		font-size:18px;

    }
    .Total{
        font-family:"arial";
    font-size:18px;

    }
</style>
<script language="javascript">
<!--
function printThis() {
//window.print();
//self.close();
}
//-->
</script>
<body onLoad="printThis();">
  <table width="550" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="3" align="center" class="Cabecera" ><?php echo Separar("EMPRESA SAN MARTIN S.A.")?></td>
  </tr>
  <tr>
    <td colspan="3" align="center" class="Cabecera" ><?php echo Separar($head->oficina)?></td>
  </tr>
  <tr>
    <td colspan="3" align="center" class="Cabecera"><?php echo Separar($head->direccion)?>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="center" class="Cabecera"><?php echo Separar("RUC: 20531409478".$Ruc)?></td>
  </tr>
  <tr>
    <td colspan="3" align="center" class="Cabecera"><?php echo Separar($head->telefono)?></td>
  </tr>
  <tr><td colspan="4"><hr></td></tr>
    <tr>
    <td colspan="3" align="center" class="Cabecera">TELEGIRO:&nbsp;<?php echo $head->numero?>&nbsp;</td>
  </tr>  
   <tr>
    <td align="left" class="Cabecera" colspan="2">
        Fecha de Emision :   <?php echo Separar($head->fecha); ?> &nbsp; <?php echo Separar($head->hora); ?>
    </td>
    <td align="right" class="Cabecera" >
    
    </td>
  </tr>
  <tr>
    <td align="left" class="Cabecera" colspan="3">
        Remitente :   <?php echo Separar($head->remitente); ?> 
    </td>
  </tr>
  <tr>
    <td align="left" class="Cabecera" colspan="3">
        Consignado :   <?php echo $head->idconsignado." - ".Separar($head->consignado); ?> 
    </td>
  </tr>
  <tr>
    <td align="left" class="Cabecera" colspan="3">
        Destino :   <?php echo Separar($head->destino); ?> 
    </td>
  </tr>
  <tr>
    <td align="left" class="Cabecera" colspan="3">
        Monto Tel. (S/.):   <?php echo Separar(number_format($head->monto,2)); ?>  
    </td>
  </tr> 
  <tr>
    <td align="left" class="Cabecera" colspan="3">
        Precio (S/.):   <?php echo Separar(number_format($head->monto_caja,2)); ?>
    </td>
  </tr>
  <?php if($head->observacion!="") 
  { 
  ?>
  <tr>
    <td align="left" class="Cabecera" colspan="3">
        Observacion:   <?php echo Separar($head->observacion); ?>
    </td>
  </tr>
  <?php } ?>
   <tr>
    <td align="left" class="Cabecera" colspan="3">
        &nbsp; 
    </td>
  </tr>
  <tr>
    <td align="left" class="Cabecera" colspan="3">
        &nbsp; 
    </td>
  </tr>
  <tr>
    <td align="left" class="Cabecera" colspan="3">
        &nbsp; 
    </td>
  </tr>
  <tr>
    <td align="left" class="Cabecera" colspan="3">
        &nbsp; 
    </td>
  </tr>
  <tr>
    <td align="center" class="Cabecera" colspan="3">
        _____________________
    </td>
  </tr>
  <tr>
    <td align="left" class="Cabecera" colspan="3">
        &nbsp; 
    </td>
  </tr>
  <tr>
    <td align="left" class="Cabecera" colspan="3">
        &nbsp; 
    </td>
  </tr>
  <tr><td colspan="4"><hr></td></tr>
  <tr>
    <td colspan="3" align="center" class="InfoVenta"><?php echo $_SESSION['IdUsuario']; ?></td>
  </tr> 
  
</table>
</body>