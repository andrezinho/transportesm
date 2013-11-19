<div>
<table class=" ui-widget ui-widget-content" style="margin: 0 auto; " >
    <thead class="ui-widget ui-widget-content" >
        <tr class="ui-widget-header" style="height: 23px">
            <th width="50px">ITEM</th>
            <th width="100px">PROPIETARIO</th>
            <th width="100px">CHOFER</th>
            <th width="100px">VEHICULO</th>
            <th width="30px">&nbsp;</th>
         </tr>
    </thead>  
    <tbody>
        <?php 
            $n = count($rows);
            if($n>0)
            {
                foreach($rows as $k => $r)
                {
                    ?>
                    <tr>
                        <td align="center"><?php echo str_pad(($k+1),2,'0',0) ?></td>
                        <td><?php echo $r[1]; ?></td>
                        <td><?php echo $r[2]; ?></td>
                        <td><?php echo $r[3]; ?></td>
                        <td align="center"><a class="quit-a" href="javascript:" id="<?php echo $r[4]; ?>"><img src="images/delete.png" /></a></td>
                    </tr>
                    <?php
                }
            }
        ?>
    </tbody>
</table>
</div>