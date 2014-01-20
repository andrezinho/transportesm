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
		font-size:20px;

    }
	.Detalle{
        font-family:"arial";
		font-size:20px;

    }
    .Total{
        font-family:"arial";
    font-size:20px;

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
    <td colspan="3" align="center" class="Cabecera">GUIA DE CORRESPONDENCIA</td>
  </tr>  
  <tr>
      <td colspan="3" align="center" class="Cabecera"><?php echo $head->serie." - ".$head->numero?></td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
  <tr>
      <td colspan="3" align="center" class="Cabecera">
      <?php 
        if($head->cpago==1)
          echo "CONTRA ENTREGA";
        else 
          echo "CANCELADO";
      ?>
      </td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
   <tr>
    <td align="left" class="Cabecera" colspan="2">
        Fecha de Emision :   <?php echo Separar($head->fecha); ?> &nbsp;&nbsp; Hora: <?php echo Separar($head->hora); ?>
        
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
        Remitente :   <?php echo Separar($head->remitente); ?> 
    </td>
  </tr>
  <tr>
    <td align="left" class="Cabecera" colspan="3">
        Consignado :   <?php echo Separar($head->consignado); ?> 
    </td>
  </tr>
  <tr>
    <td align="left" class="Cabecera" colspan="3">
        Atentamente :   <?php echo Separar($head->atentamente); ?> 
    </td>
  </tr>
  <tr>
    <td align="left" class="Cabecera" colspan="3">
        Destino :   <?php echo Separar($head->destino); ?> 
    </td>
  </tr>
  <tr>
    <td align="left" class="Cabecera" colspan="3">
        Direccion :   <?php echo Separar($head->dir); ?> 
    </td>
  </tr>
  <tr>
  <td colspan="3" valign="top">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td colspan="2" align="center" class="Detalle">Descripcion</td>
        <td width="50" align="center" class="Detalle">Cantidad</td>
        <td width="80" align="right" class="Detalle">Total S/.</td>
      </tr>
      <?php 
        $c = 0;
        $total = 0;
        foreach($detalle as $r)
        {
            $c = $c+1;
            $total += $r['precio'];
            ?>
            <tr>                
                <td class="Detalle" colspan="2"><?php echo $r['descripcion']; ?></td>
                <td align="center" class="Detalle"><?php echo $r['cantidad']; ?></td>
                <td align="right" class="Detalle"><?php echo $r['precio']; ?></td>
            </tr>
            <?php
        }
       ?>
    </table>
  </td>
  </tr>
  <tr><td colspan="4"><hr></td></tr>
  <tr>
    <td colspan="3" align="center" class="InfoVenta"><?php echo $_SESSION['IdUsuario']; ?></td>
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
    <td align="left" class="Cabecera" colspan="3">
        &nbsp; 
    </td>
  </tr>
  <tr>
    <td align="center" class="Cabecera" colspan="3">
        _______________________
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
  
</table>
</body>
