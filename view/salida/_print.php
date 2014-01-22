<?php 
 function Separar($texto)
 {
     return mb_strtoupper(trim($texto));
 }
?>
<style>
	body{
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
  <table width="450" border="0" cellspacing="0" cellpadding="0">
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
    <td colspan="3" align="center" class="Cabecera"><?php echo Separar("RUC: 20531409478")?></td>
  </tr>
  <tr>
    <td colspan="3" align="center" class="Cabecera"><?php echo Separar($head->telefono)?></td>
  </tr>
  <tr><td colspan="4"><hr></td></tr>
    <tr>
    <td colspan="3" align="center" class="Cabecera">Tiket Salida Nro: <?php echo $head->serie?> - <?php echo $head->numero?>&nbsp;</td>
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
        Chofer :   <?php echo Separar($head->chofer); ?> 
    </td>
  </tr>
  <tr>
    <td align="left" class="Cabecera" colspan="3">
        Vehiculo :   <?php echo Separar($head->placa); ?> 
    </td>
  </tr>
    <tr>
      <td align="left" class="Cabecera" colspan="3">
          Destino :   <?php echo Separar($head->destino); ?> 
      </td>
    </tr>

    <tr>
      <td align="left" class="Cabecera" colspan="3">
          Precio :  <?php echo number_format($head->monto,2); ?> 
      </td>
    </tr>
  <tr>
      
  </tr>
  <tr><td colspan="4"><hr></td></tr>
  <tr>
    <td colspan="3" align="center" class="InfoVenta"><?php echo $_SESSION['IdUsuario']; ?></td>
  </tr> 
  <!-- 
  <tr>
    <td colspan="3" align="center" class="InfoVenta">Nro. Serie: USAFFKA12120048</td>
  </tr>
  --> 
</table>
</body>