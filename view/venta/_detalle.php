<div>
<table class=" ui-widget ui-widget-content" style="margin: 0 auto; " >
    <thead class="ui-widget ui-widget-content" >
        <tr class="ui-widget-header" style="height: 23px">            
            <th >DESCRIPCION</th>            
            <th width="80px">PRECIO S/.</th>            
            <th width="80px">CANTIDAD</th>
            <th width="80px">IMPORTE S/.</th>
            <th width="20px">&nbsp;</th>
         </tr>
         </thead>  
         <tbody>
            <?php 
                $c = 0;
                $t = 0;
                for($i=0;$i<$_SESSION['ventad']->item;$i++)
                {   
                    if($_SESSION['ventad']->estado[$i])
                    {
                        $c +=1;
                        $t += $_SESSION['ventad']->precio[$i]*$_SESSION['ventad']->cantidad[$i];
                    ?>
                    <tr id="<?php echo $i; ?>">
                    
                    <td><?php echo $_SESSION['ventad']->itinerario[$i]; ?></td>                    
                    <td align="center" ><?php echo $_SESSION['ventad']->precio[$i]; ?></td>            
                    <td align="center" >
                        <?php echo number_format($_SESSION['ventad']->cantidad[$i],2); ?>
                    </td>
                    <td align="right" ><?php echo number_format($_SESSION['ventad']->precio[$i]*$_SESSION['ventad']->cantidad[$i],2); ?></td>                    
                    <td width="20px" align="center"><a class="quit box-boton boton-anular" title="Eliminar item <?php echo ($c); ?>" href="javascript:"></a></td>
                    </tr>
                    <?php
                    }
                }                
                for($i=0;$i<(2-$c);$i++)
                {
                    ?>
                    <tr >
                        
                        <td>&nbsp;</td>
                        <td align="center" >&nbsp;</td>                                    
                        <td align="right" >&nbsp;</td>
                        <td align="right" >&nbsp;</td>                    
                        <td width="20px" align="center">&nbsp;</td>
                    </tr>
                    <?php
                }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" align="right"><b>TOTAL S/.</b></td>
                <td align="right"><b><?php echo number_format($t, 2); ?></b></td>
                <td>&nbsp;</td>
            </tr>
        </tfoot>
</table>
</div>