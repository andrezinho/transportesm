<?php
include_once("Main.php");
class consultas extends Main
{    
    
    function data_reclamos($g)
    {
        $sql = "SELECT 
                        r.fecha,
                        r.nombres,
                        r.dni,
                        concat(ts.descripcion,' ',case ts.idtipo_servicio when 4 then concat('(',r.otros,')') else '' end),
                        case r.tipo when 1 then 'RECLAMO' else 'QUEJA' end,
                        case r.estado when 1 then 'PENDIENTE' else 'ATENDIDO' end
                 from reclamos as r inner join tipo_servicio as ts on ts.idtipo_servicio = r.idtipo_servicio
                WHERE   r.estado = :g and month(r.fecha) = :g2 and anio = :g3";
      $stmt = $this->db->prepare($sql);
      $stmt->bindParam(':g',$g['estado'],PDO::PARAM_INT);
      $stmt->bindParam(':g2',$g['mes'],PDO::PARAM_INT);
      $stmt->bindParam(':g3',$g['anio'],PDO::PARAM_INT);
      $stmt->execute();
        $r2 = $stmt->fetchAll();        
        return array($r2);
    }
    
    function data_grupos($g)
    {
        $sql = "SELECT concat(prop.nombre,' ',prop.apellidos) AS propietario,
                       concat(chof.nombre,' ',chof.apellidos) as chofer,
                       v.placa
                FROM   agrupaciones as a inner join empleado as prop on prop.idempleado = a.idpropietario and prop.idtipo_empleado = 3
                       inner join empleado as chof on chof.idempleado = a.idchofer and chof.idtipo_empleado = 2
                       inner join vehiculo as v on v.idvehiculo = a.idvehiculo
                WHERE 	a.idgrupo = :g";
		$stmt = $this->db->prepare($sql);
		$stmt->bindParam(':g',$g['idgrupo'],PDO::PARAM_INT);                
    	$stmt->execute();
       	$r2 = $stmt->fetchAll();        
        return array($r2);
    }
    
    function data_choferes($g)
    {
        $sql = "SELECT empleado.idempleado,                        
                       concat(empleado.nombre,' ',empleado.apellidos) as nombres,
                       empleado.aleas,
                       empleado.celular,
                       concat(o.descripcion,' (',s.descripcion,') '),
                       case empleado.estado when 1 then '<p style=\"color:green\">ACTIVO</p>' else '<p style=\"color:red\">INACTIVO</p>' end                       
                    FROM tipo_empleado as te inner join empleado on te.idtipo_empleado = empleado.idtipo_empleado
                            inner join oficina as o on o.idoficina = empleado.idoficina
                            inner join destino as s on s.iddestino = o.idsucursal
             where empleado.idtipo_empleado = 2 AND empleado.estado = :status
             order by empleado.nombre, empleado.apellidos";        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':status',$g['estado'],PDO::PARAM_INT);
        $stmt->execute();
       	$r2 = $stmt->fetchAll();        
        return array($r2);
    }
    
    function data_empleados($g)
    {
        $sql = "SELECT empleado.idempleado,                        
                       concat(empleado.nombre,' ',empleado.apellidos) as nombres,
                       empleado.aleas,
                       empleado.celular,
                       concat(o.descripcion,' (',s.descripcion,') '),
                       case empleado.estado when 1 then '<p style=\"color:green\">ACTIVO</p>' else '<p style=\"color:red\">INACTIVO</p>' end                       
                    FROM tipo_empleado as te inner join empleado on te.idtipo_empleado = empleado.idtipo_empleado
                            inner join oficina as o on o.idoficina = empleado.idoficina
                            inner join destino as s on s.iddestino = o.idsucursal
             where empleado.idtipo_empleado = 1 AND empleado.estado = :status and empleado.idoficina = :idoficina
             order by empleado.nombre, empleado.apellidos";        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':status',$g['estado'],PDO::PARAM_INT);
        $stmt->bindParam(':idoficina',$g['idoficina'],PDO::PARAM_INT);
        $stmt->execute();
       	$r2 = $stmt->fetchAll();        
        return array($r2);
    }
  }
?>