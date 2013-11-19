<?php include('../lib/helpers.php'); ?>
<div id="head-kardex" style="padding: 10px; ">
    <h2>REPORTE DE CUMPLEAÑOS DE LOS COLABORADORES</h2><br/>
</div>
<div class="contain" style="width:100%;  ">
<table class=" ui-widget ui-widget-content" style="width:100%" >
    <thead class="ui-widget ui-widget-content" >
        <tr class="ui-widget-header" style="height: 23px">
            <th >ITEM</th>
            <th >COLABORADOR</th>
            <th >TIPO DE COLABORADOR</th>            
            <th >OFICINA</th>
            <th >FECHA DE NACIMIENTO</th>
         </tr>
   </thead>
   <tbody>
       <?php         
       foreach($rowsi as $r)
       {
           $i += 1;
            ?>
            <tr>
                <td align="center"><?php echo str_pad($i, 3, '0', 0); ?></td>
                <td align="center"><?php echo $r['empleado']; ?></td>
                <td align="center"><?php echo $r['tipo']; ?></td>
                <td align="center"><?php echo $r['oficina']; ?></td>
                <td align="center"><?php echo ffecha($r['fecha_nacimiento']); ?></td>
            </tr>
             <?php
            }
           ?>
   </tbody>
</table>      
<div style="clear: both"></div>    
</div>    