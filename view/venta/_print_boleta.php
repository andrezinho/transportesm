<?php 
function ffecha($f)
{
    $nf = explode("-", $f);
    return "&nbsp;".$nf[2]."&nbsp;&nbsp;&nbsp;".$nf[1]."&nbsp;&nbsp;&nbsp;".$nf[0];
}
?>
<style>
    table td { font-size: 12px !important; font-family: sans-serif; letter-spacing: 5px}    
</style>
<div style="padding: 25px 25px 25px 20px; ">
    <div style="width: 250px; height: 70px; float: right; padding-right: 20px">
        
    </div>    
    <div style="clear: both;"></div>
<table style="width:850px;" border="0">
    <tr>
        <td style="width:100px;">&nbsp;</td>
        <td style="width:445px;">&nbsp;</td>
        <td style="width:100px;">&nbsp;</td>
        <td style="width:25px;">&nbsp;</td>
        <td style="">&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td><?php echo utf8_decode($head->nombre); ?></td>
        <td>&nbsp;</td>
        <td colspan="2" align="center"><?php echo ffecha($head->fecha); ?></td>
    </tr>    
    <tr>
        <td>&nbsp;</td>
        <td><?php echo utf8_decode($head->direccion); ?></td>
        <td colspan="2">&nbsp;</td>
        <td>&nbsp;&nbsp;<?php echo $head->nrodoc; ?></td>
    </tr>
</table>
<?php //print_r($detalle); ?>
<table style="width:850px;" border="0">
    <tr>
        <td style="width:85px;">&nbsp;</td>
        <td>&nbsp;</td>
        <td style="width:65px;">&nbsp;</td>
        <td style="width:75px;">&nbsp;</td>
    </tr>
    <?php 
        $c = 0;
        $total = 0;
        foreach($detalle as $r)
        {
            $c = $c+1;
            $total += $r['precio']*$r['cantidad'];
            ?>
            <tr>
                <td align="center"><?php echo $r['cantidad']; ?></td>
                <td><?php echo $r['itinerario']; ?></td>                
                <td align="right"><?php echo $r['precio']; ?></td>
                <td align="right"><?php echo number_format($r['precio']*$r['cantidad'],2); ?></td>
            </tr>
            <?php
        }
        for($i=$c;$i<6;$i++)
        {
            ?>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <?php
        }
    ?>
            
            <tr style="height: 40px">
                <td></td>
                <td></td>
                <td></td>
                <td align="right"><b><?php echo number_format($total,2); ?></b></td>
            </tr>
</table>
</div>