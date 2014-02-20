<?php include('../lib/helpers.php'); ?>
<div id="head-kardex" style="padding: 10px; ">
    <h2>REPORTE DE EGRESOS POR FECHAS</h2><br/>
</div>
<div class="contain" style="width:100%;  ">
<table class=" ui-widget ui-widget-content" style="width:100%" >
    <thead class="ui-widget ui-widget-content" >
        <tr class="ui-widget-header" style="height: 23px">
            <th >ITEM</th>
            <th >CONCEPTO</th>
            <th >PROVEEDOR</th>            
            <th >FECHA</th>            
            <th >OBSERVACION</th>
            <th >MONTO</th>                        
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
                <td align="center"><?php echo $r['concepto']; ?></td>
                <td align="center"><?php echo $r['proveedor']; ?></td>
                <td align="center"><?php echo ffecha($r['fecha']); ?></td>
                <td align="center"><?php echo $r['observacion']; ?></td>
                <td align="center"><?php echo number_format($r['monto'],2); ?></td>
            </tr>
           <?php
		   $to= $to+$r['monto'];
            }
           ?>
            
   </tbody>
   <tfoot>
       <tr>
           <td colspan="5" align="right" bgcolor="#fafafa"><b>TOTAL:&nbsp;</b></td>           
           <td align="center" bgcolor="#fafafa"><b><?php echo number_format($to,2); ?></b></td>
       </tr>
   </tfoot>
</table>      
<div style="clear: both"></div>    
</div>    