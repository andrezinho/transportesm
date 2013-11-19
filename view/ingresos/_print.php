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
    <td colspan="3" align="center" class="Cabecera"><?php echo Separar("RUC: 20531409478")?></td>
  </tr>
  <tr>
    <td colspan="3" align="center" class="Cabecera"><?php echo Separar($head->telefono)?></td>
  </tr>
  <tr><td colspan="4"><hr></td></tr>
    <tr>
    <td colspan="3" align="center" class="Cabecera">INGRESO:&nbsp;<?php echo $head->numero?>&nbsp;</td>
  </tr>  
   <tr>
    <td align="left" class="Cabecera" colspan="2">
        Fecha de Emision :   <?php echo Separar($head->fecha); ?> &nbsp;&nbsp; 
    </td>
    <td align="right" class="Cabecera" >
    
    </td>
  </tr>
  <tr>
    <td align="left" class="Cabecera" colspan="3">
        Recibi de :   <?php echo Separar($head->remitente); ?> 
    </td>
  </tr>  
  <tr>
  <td colspan="3" valign="top">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="center" class="Detalle">Descripcion</td>
        <td width="50" align="center" class="Detalle">Cantidad</td>
        <td width="50" align="right" class="Detalle">Monto</td>
        <td width="80" align="right" class="Detalle">Total S/.</td>
      </tr>
      <?php 
        $c = 0;
        $total = 0;
        foreach($detalle as $r)
        {
            $c = $c+1;
            $ttotal = $r['precio']*$r['cantidad'];
            $total += $ttotal;
            ?>
            <tr>                
                <td class="Detalle"><?php echo $r['descripcion']; ?></td>
                <td align="center" class="Detalle"><?php echo $r['cantidad']; ?></td>
                <td align="right" class="Detalle"><?php echo $r['precio']; ?></td>                
                <td align="right" class="Detalle"><?php echo number_format($ttotal,2); ?></td>
            </tr>
            <?php
        }
       ?>
       <tr>
           <td colspan="4"><hr></td>
       </tr>
       <tr>
           <td colspan="3">&nbsp;</td>
           <td align="right" class="Detalle"><?php echo number_format($total,2); ?></td>
       </tr>
    </table>
  </td>
  </tr>
  <tr>
      <td colspan="4"><hr></td>
  </tr>
  <tr>
    <td colspan="3" align="center" class="InfoVenta"><?php echo $_SESSION['IdUsuario']; ?></td>
  </tr> 
  
</table>
</body>