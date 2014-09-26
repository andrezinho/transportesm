<?php include('../lib/helpers.php'); ?>
<div id="head-kardex" style="padding: 10px; ">
    <h2>REPORTE DE MENSUALIDADES POR FECHAS</h2><br/>
</div>
<div class="contain" style="width:100%;  ">
<table class=" ui-widget ui-widget-content" style="width:100%" >
    <thead class="ui-widget ui-widget-content" >
        <tr class="ui-widget-header" style="height: 23px">
            <th >ITEM</th>
            <th >RECIBI DE</th>            
            <th >CONCEPTO</th>
            
            <th >CHOFER</th>
            <th >PLACA</th>
            <th >FECHA</th>                        
            <th >OBSERVACION</th>
            <th>MONTO</th>
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
                <td align="center"><?php echo str_pad($i, 2, '0', 0); ?></td>
                <td align="left"><?php echo $r['remitente']; ?></td>
                <td align="left"><?php echo $r['concepto']; ?></td>                
                <td align="left"><?php echo $r['chofer']; ?></td>
                <td align="center"><?php echo $r['placa']; ?></td>
                <td align="center"><?php echo ffecha($r['fecha']); ?></td>
                <td align="left"><?php echo $r['observacion']; ?></td>
                <td align="center"><?php echo number_format($r['total'],2); ?></td>
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