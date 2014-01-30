<?php 
session_start();
?>
<div>
<p>Se muestra la lista de salidas que se asignan a este envio, si no existe alguno disponible lo pueden registrar desde 
aqui.</p>
<?php if($permiso==1) { ?>
<a href="#" class="conp-envio" id="cpe-<?php echo $idenvio; ?>" style="float:right; color:green;">[+]Nueva Asginacion de Salida</a>
<?php } ?>
<br/>
<br/>
<table border="1" cellpadding="0" cellspacing="0" width="100%">
	<thead class="ui-widget-header">
		<tr style="height:20px;">
		<th>ITEM</th>
		<th>CHOFER</th>
		<th>VEHICULO</th>
		<th>DESTINO</th>
		<th>ESTADO</th>
		<th>&nbsp;</th>
		<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
	<?php 
		$c = 1;
		foreach($rows as $k => $v)
		{
			?>
			<tr style="height:21px;">
				<td align="center"><?php echo $c; ?></td>
				<td><?php echo $v['chofer'] ?></td>
				<td><?php echo $v['vehiculo'] ?></td>
				<td><?php echo $v['origen']." - ".$v['destino']; ?></td>
				<td><?php echo $v['estado'] ?></td>
				<td align="center">
					<?php if($v['idestado']==1&&$_SESSION['idoficina']==$v['idoficina']) { ?>
						<a href="#" class="conf-envio" id="ides-<?php echo $v['idenvio_salidas'] ?>" style="color:green">[/]ENVIAR</a>
					<?php } ?>
					<?php if($v['idestado']==2&&$_SESSION['idsucursal']==$v['iddestino']) { ?>
						<a href="#" class="conf-envio-llegada" id="ides-<?php echo $v['idenvio_salidas'] ?>" style="color:green">[/]Conf. Llegada</a>
					<?php } ?>	
					<?php if($v['idestado']==3&&$_SESSION['idsucursal']==$v['iddestino']) { 

						if($v['cpago']==1)
						{
							?>
							<a class="recepcion-ce" href="index.php?controller=envio&action=contrae&id=<?php echo $v['idenvio'] ?>" title="Confirmar la entrega del envio" style="color:green" >[*]ENTREGAR</a>
							<?php
						}

						else
						{
							?>
							<a class="recepcion" id="recep-<?php echo $v['idenvio_salidas'] ?>" href="#" title="Confirmar la entrega del envio" style="color:green" >[*]ENTREGAR</a>
							<?php
						}

						?>
					<?php } ?>				
				</td>
				<td align="center">
					<?php if($v['idestado']==1&&$_SESSION['idoficina']==$v['idoficina']) { ?>
					<a href="#" style="color:red;">[X]Anular</a>
					<?php } ?>
				</td>
			</tr>
			<?php
			$c ++;
		}
	?>
	</tbody>
</table>
</div>