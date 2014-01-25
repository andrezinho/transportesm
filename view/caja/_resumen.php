<?php
include_once("../lib/helpers.php");
function turno($t)
{
    if($t==1)
    { return "NORMAL";}
    else { return "GUARDIANIA";}
}
?>
<style type="text/css">
    table tr td { background: #fff;}
    .box-saldos { width: 142px; text-align: center; float: left; margin-left: 10px; padding:4px; margin-bottom: 10px;}
    .box-result { width: 470px; float: left; text-align: center; margin-left: 10px; margin-bottom: 10px;}
    .f {background: #EA5246; color: #FFF;} 
    .r { background: #81CB7F; color: #333; }
    .m { background:#FEF5CE }
</style>

<h2 style="text-align:center">REPORTE RESUMEN DE CIERRE DE CAJA</h2>
<br/>
<h4>FECHA: <?php echo fdate($fecha,'ES'); ?><br/> TURNO: <?php echo turno($turno) ?></h4>
<h4>USUARIO: <?php echo $idusuario; ?></h4>
<h4>OFICINA: <?php echo $oficina; ?></h4>
<div style="margin-top:20px;">
    <div class="box-saldos" style="background:#FEF5CE">
        Saldo Inicial <br/>
        <?php echo number_format($saldo_inicial,2); ?> S/.
    </div>
    <div class="box-saldos" style="background:#BDCCD3">
        Saldo Sistema <br/>
        <?php echo number_format($saldo_real,2); ?> S/.
    </div>
    <div class="box-saldos" style="background:#FFFFFF">
        Saldo Declarado<br/>
        <?php echo number_format($saldo_declarado,2); ?> S/.
    </div>
    
    <?php 
    $r = $saldo_declarado-$saldo_real;
    if($r<0)
        $class = "f";
    else 
        $class = "r";
    
    ?>
    <div class="box-result <?php echo $class; ?>">
        <div style="padding:10px;" >
            <?php if($class=="f"){
                ?>
                Falta en caja : <?php echo $r; ?> S/.
                <?php
            }
            else
            {
                if($r>0)
                {
                    ?>
                    Caja Cuadrada correctamente, y sobra <?php echo $r; ?> S/.
                    <?php
                }                
                else
                {
                    ?>
                        Caja Cuadrada correctamente.
                    <?php 
                }
            }
            ?>
        </div>
        
    </div>
    <div class="box-result m">
            <div style="padding:10px;" >
                <b>Saldo total en Caja : <?php echo number_format($saldo_real+$saldo_inicial,2); ?> S/.                </b>
            </div>
            <div style="padding:10px;" >
                Deseas hacer el deposito de este monto en la cuenta bancaria?
                <br/>
                <a id="rdcb" href="#" class="button">Realizar el Deposito en Cuenta Bancaria</a>
            </div>
    </div>
</div>
<a href="index.php?controller=user&action=logout" style="display: block; width: 100%; text-align: center; margin-top: 10px;">Cerrar</a>