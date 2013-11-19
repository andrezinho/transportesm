<?php 
 require("../lib/num2letra.php");
 $meses = array(1=>'ENERO',2=>'FEBRERO',3=>'MARZO',4=>'ABRIL',5=>'MAYO',6=>'JUNIO',7=>'JULIO',8=>'AGOSTO',9=>'SETIEMBRE',10=>'OCTUBRE',11=>'NOVIEMBRE',12=>'DICIEMBRE');
 $f = explode("-", $head->fecha);
 $dia = $f[2];
 $mes = $meses[(int)$f[1]];
 $year = substr($f[0],3);
?>
<style>
    table td { font-size: 12px !important; font-family: sans-serif; letter-spacing: 5px; }    
    table td { padding: 2.5px;}
    #table-h td {padding: 3px !important;}
    
</style>
<div style="padding: 25px 25px 25px 25px; ">
    <div style="width: 250px; height: 120px; float: right; padding-right: 20px">
        
    </div>    
    <div style="clear: both;"></div>
<table style="" border="0" id="table-h">
    <tr>
        <td style="width:100px;"></td>
        <td style="width:25px;"></td>
        <td style="width:550px;"></td>
        <td style="width:40px;"></td>
        <td style="width:115px;"></td>
        <td style="width:35px;"></td>
        <td style="width:50px;"></td>
        <td style="width:120px;"></td>
        <td style="width:45px;"></td>
        <td style=""></td>
    </tr>
    <tr>
        <td colspan="2">&nbsp;</td>
        <td colspan="8"><?php echo utf8_decode($head->nombre); ?></td>        
    </tr>    
    <tr>
        <td colspan="2">&nbsp;</td>
        <td colspan="5"><?php echo $head->nrodoc; ?></td>
        <td colspan="1">&nbsp;</td>
        <td colspan="2"><?php echo $head->guia_remision; ?></td>
    </tr>
    <tr>
        <td colspan="1">&nbsp;</td>
        <td colspan="2"><?php echo utf8_decode($head->direccion); ?></td>
        <td>&nbsp;</td>
        <td align="left">&nbsp;&nbsp;&nbsp;<?php echo $dia; ?></td>
        <td>&nbsp;</td>
        <td colspan="2" align="center"><?php echo $mes; ?></td>
        <td>&nbsp;</td>
        <td><?php echo $year; ?></td>
    </tr>
    
</table>
<?php //print_r($detalle); ?>    
<table style="margin-top:6px;" border="0">
    <tr style="" >
        <td style="width:100px;">&nbsp;</td>
        <td style="width:850px">&nbsp;</td>
        <td style="width:90px;">&nbsp;</td>
        <td style="width:115px;">&nbsp;</td>
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
        for($i=$c;$i<9;$i++)
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
            <tr>
                <td style="padding: 0px;">&nbsp;</td>
                <td style="padding: 0px;">
                    <?php 
                    
                        $con=substr(number_format($total,2), -2,2);
                        if($con!="00") {$con=" CON ".$con."/100";}
                        else { $con="CON 0/100"; }
                        echo num2letra(floor($total)).$con; 
                      ?>
                </td>
                <td style="padding: 0px;"></td>
                <td align="right" style="padding: 0px;"><b><?php echo number_format($total,2); ?></b></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td align="right"><b>0.00</b></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td align="right"><b><?php echo number_format($total,2); ?></b></td>
            </tr>
</table>
</div>