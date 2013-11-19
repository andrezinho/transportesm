<div style="width:100%">
<table class=" ui-widget ui-widget-content" style="margin: 0 auto; width:100%" >
    <thead class="ui-widget ui-widget-content" >
        <tr class="ui-widget-header" style="height: 23px">
            <th width="40px">ITEM</th>
            <th >DESCRIPCION</th>                        
            <th width="80px">IMPORTE S/.</th>            
         </tr>
         </thead>  
         <tbody>
            <?php 
                $c = 0;
                $t = 0;
                $obj = $_SESSION['ventad'];
                for($i=0;$i<$obj->item;$i++)
                {   
                    if($obj->estado[$i])
                    {
                        $c +=1;
                        $t += $obj->precio[$i]*$obj->cantidad[$i];
                        ?>
                        <tr id="<?php echo $i; ?>">
                        <td align="center" ><?php echo $c; ?></td>
                        <td>
                            <input type="text" name="concepto[]" class="descripcion-envio" value="<?php echo $obj->itinerario[$i]; ?>" class="ui-widget-content ui-corner-all text" style="width:95%; " />
                        </td>                                        
                        <td align="right" ><?php echo number_format($obj->precio[$i]*$obj->cantidad[$i],2); ?></td>                                                            
                        </tr>
                        <?php
                    }
                }                                
            ?>
        </tbody>
        <tfoot>
            <tr style="background:#dadada;">
                <td colspan="2" align="right"><b>TOTAL S/.</b></td>
                <td align="right"><b><?php echo number_format($t, 2); ?></b></td>                
            </tr>
        </tfoot>
</table>
</div>