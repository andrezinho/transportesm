<?php include('../lib/helpers.php'); ?>
<div id="head-kardex" style="padding: 10px; ">
    <h2>REPORTE DE VENTAS POR FECHAS</h2><br/>
</div>
<div class="contain" style="width:100%;  ">
<table class=" ui-widget ui-widget-content" style="width:100%" >
    <thead class="ui-widget ui-widget-content" >
        <tr class="ui-widget-header" style="height: 23px">
            <th >ITEM</th>
            <th >FECHA</th>
            <th >HORA</th>            
            <th >DESCRIPCION</th>            
            <th >SERIE</th>
            <th >NUMERO</th>                        
            <th >NOMBRE</th>
            <th>TOTAL</th>
            <th>&nbsp;</th>
         </tr>
   </thead>
   <tbody>
       <?php         
       $i = 0;
	   $to=0;
       foreach($rowsi as $r)
       {
           $i += 1;
            ?>
            <tr>
                <td align="center"><?php echo str_pad($i, 3, '0', 0); ?></td>
                <td align="center"><?php echo ffecha($r['fecha']); ?></td>
                <td align="center"><?php echo $r['hora']; ?></td>
                <td align="center"><?php echo $r['descripcion']; ?></td>
                <td align="center"><?php echo $r['serie']; ?></td>
                <td align="center"><?php echo $r['numero']; ?></td>
                <td align="center"><?php echo $r['nombre']; ?></td>
                <td align="center"><?php echo $r['total']; ?></td>
                <td align="center"><a target="_blank" href="index.php?controller=venta&action=printer&iv=<?php echo $r['idventa'] ?>">Imprimir</a></td>
            </tr>
           <?php
		   $to= $to+$r['total'];
            }
           ?>
            
   </tbody>
   <tfoot>
       <tr>
           <td colspan="7" align="right" bgcolor="#fafafa"><b>TOTAL:&nbsp;</b></td>           
           <td align="center" bgcolor="#fafafa"><b><?php echo number_format($to,2); ?></b></td>
       </tr>
   </tfoot>
</table>      
<div style="clear: both"></div>    
</div>    