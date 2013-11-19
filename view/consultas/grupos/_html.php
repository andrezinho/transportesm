<?php include('../lib/helpers.php'); ?>
<div id="head-kardex" style="padding: 10px; ">
    <h2>CONSULTAS DE GRUPOS POR DESTINO</h2><br/>
</div>
<div class="contain" style="width:100%;  ">
<table class=" ui-widget ui-widget-content" style="width:100%" >
    <thead class="ui-widget ui-widget-content" >
        <tr class="ui-widget-header" style="height: 23px">
            <th >ITEM</th>
            <th >PROPIETARIO</th>
            <th >CHOFER</th>            
            <th >VEHICULO (PLACA)</th>            
         </tr>
   </thead>
   <tbody>
       <?php         
       $i = 0;
       foreach($rowsi as $r)
       {
           $i += 1;
            ?>
            <tr>
                <td align="center"><?php echo str_pad($i, 2, '0', 0); ?></td>
                <td align="left"><?php echo $r[0]; ?></td>
                <td align="left"><?php echo $r[1]; ?></td>
                <td align="center"><?php echo $r[2]; ?></td>                
            </tr>
           <?php
		   $to= $to+$r['total'];
            }
           ?>
            
   </tbody>   
</table>      
<div style="clear: both"></div>    
</div>    