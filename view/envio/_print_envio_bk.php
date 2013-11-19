<style>
    table td { font-size: 12px !important; font-family: sans-serif; letter-spacing: 5px}    
    #table-h td {padding: 1px !important;}
</style>
<div style="padding: 25px 25px 25px 20px;">
    <div style="width: 250px; height: 73px; float: right; padding-right: 20px"></div>    
<div style="clear: both;"></div>
<table  border="0" cellpading="0" cellspacing ="0" id="table-h">
    <tr>
        <td style="width:90px;"></td>
        <td style="width:40px;"></td>
        <td style="width:120px;"></td>
        <td style="width:40px;"></td>
        <td style="width:115px;"></td>
        <td style="width:100px;"></td>
        <td style="width:110px;"></td>
        <td style="width:50px;"></td>
        <td></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td colspan="8"><?php echo utf8_decode($head->remitente); ?><?php //echo $head->fecha; ?></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td colspan="6"><?php echo utf8_decode($head->consignado) ?></td>
        <td>&nbsp;</td>
        <td align="right"><?php echo str_replace("/","&nbsp;",$head->fecha); ?></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td colspan="6"><?php echo utf8_decode($head->direccion); ?></td>             
        <td>&nbsp;</td>
        <td align="right"><?php echo substr($head->hora,0,5); ?></td>        
    </tr>    
    <tr>
        <td>&nbsp;</td>
        <td colspan="6"><?php echo utf8_decode($head->chofer); ?></td>
        <td>&nbsp;</td>
        <td align="right"><?php echo $head->placa; ?></td>        
    </tr>
</table>
<?php //print_r($detalle); ?>
<table border="0">
    <tr>
        <td style="width:70px;">&nbsp;</td>
        <td style="width:620px">&nbsp;</td>
        <td style="width:95px;">&nbsp;</td>
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
                <td align="center" ><?php echo $r['cantidad']; ?></td>
                <td>&nbsp;&nbsp;&nbsp;<?php echo $r['descripcion']; ?></td>
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