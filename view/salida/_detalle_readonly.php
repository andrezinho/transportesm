<div>
<table class=" ui-widget ui-widget-content" style="margin: 0 auto; " >
    <thead class="ui-widget ui-widget-content" >
        <tr class="ui-widget-header" style="height: 23px">
            <th width="60px">ITEM</th>
            <th >DESCRIPCION</th>            
            <th width="80px">PRECIO S/.</th>            
            <th width="80px">CANTIDAD</th>
            <th width="80px">IMPORTE S/.</th>            
         </tr>
         </thead>  
         <tbody>
            <?php 
                $c = 0;
                $t = 0;
                $obj = $_SESSION['envios'];
                for($i=0;$i<$obj->item;$i++)
                {   
                    if($obj->estado[$i])
                    {
                        $c +=1;
                        $t += $obj->precio[$i]*$obj->cantidad[$i];
                    ?>
                    <tr id="<?php echo $i; ?>">
                    <td align="center" ><?php echo $c; ?></td>
                    <td><?php echo $obj->descripcion[$i]; ?></td>                    
                    <td align="center" ><?php echo $obj->precio[$i]; ?></td>            
                    <td align="right" >
                        <?php echo $obj->cantidad[$i]; ?>
                    </td>
                    <td align="right" ><?php echo number_format($obj->precio[$i]*$obj->cantidad[$i],2); ?></td>                                        
                    </tr>
                    <?php
                    }
                }                
                for($i=0;$i<(3-$c);$i++)
                {
                    ?>
                    <tr >
                        <td align="center" >&nbsp;</td>
                        <td>&nbsp;</td>
                        <td align="center" >&nbsp;</td>                                    
                        <td align="right" >&nbsp;</td>
                        <td align="right" >&nbsp;</td>                                            
                    </tr>
                    <?php
                }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" align="right"><b>TOTAL S/.</b></td>
                <td align="right"><b><?php echo number_format($t, 2); ?></b></td>                
            </tr>
        </tfoot>
</table>
</div>