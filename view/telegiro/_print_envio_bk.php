<style>
    table td { font-size: 8px !important; font-family: sans-serif;}    
</style>
<div style="padding: 25px 25px 25px 0; width: 610px;">
    <div style="width: 250px; height: 25px; float: right; padding-right: 20px">
<!--        <pre style="font-size:15px; float: right; margin-top: 1px"><?php //echo $head->numero; ?></pre>-->
    </div>    
    <div style="clear: both;"></div>
<table style="width:600px;" border="0" cellpading="0" cellspacing ="0">
    <tr>
        <td style="width:40px;"></td>
        <td style="width:25px;"></td>
        <td style="width:75px;"></td>
        <td style="width:25px;"></td>
        <td style="width:25px;"></td>
        <td style="width:60px;"></td>
        <td style="width:110px;"></td>
        <td style="width:50px;"></td>
        <td></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td colspan="2"><?php echo $head->fecha; ?></td>
        <td>&nbsp;</td>
        <td colspan="5"><?php echo $head->hora; ?></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td colspan="4"><?php echo $head->destino; ?></td>
        <td>&nbsp;</td>
        <td colspan="3"><?php echo utf8_decode($head->chofer); ?></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td colspan="6"><?php echo utf8_decode($head->remitente); ?></td>
        <td>&nbsp;</td>
        <td><?php echo $head->placa; ?></td>
    </tr>
    <tr>
        <td colspan="2">&nbsp;</td>
        <td colspan="7"><?php echo utf8_decode($head->consignado) ?></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td colspan="8"><?php echo utf8_decode($head->direccion); ?></td>
    </tr>
</table>
<?php //print_r($detalle); ?>
<table style="width:600px;" border="0">
    <tr>
        <td style="width:40px;"></td>
        <td></td>
        <td style="width:95px;"></td>
    </tr>
    <?php 
        $c = 0;
        $total = 0;
        foreach($detalle as $r)
        {
            $c = $c+1;
            $total += $r['precio'];
            ?>
            <tr>
                <td ><?php echo $r['cantidad']; ?></td>
                <td><?php echo $r['descripcion']; ?></td>
                <td align="right"><?php echo $r['precio']; ?></td>
            </tr>
            <?php
        }
        for($i=$c;$i<3;$i++)
        {
            ?>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <?php
        }
    ?>
            <tr>
                <td></td>
                <td></td>
                <td align="right"><?php echo number_format($total,2); ?></td>
            </tr>
</table>
</div>