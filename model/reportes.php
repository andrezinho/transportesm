<?php
include_once("Main.php");
class reportes extends Main
{    
    
    function data_cumpleanos($g)
    {
        $sql = "SELECT concat(e.idempleado,' - ',e.nombre,' ',e.apellidos) as empleado,
				        te.descripcion as tipo,
                                        o.descripcion as oficina,
                                        e.fecha_nacimiento
				FROM empleado as e inner join tipo_empleado as te on e.idtipo_empleado = te.idtipo_empleado
                                     inner join oficina as o on e.idoficina = o.idoficina
				WHERE month(e.fecha_nacimiento)=:mes
				ORDER by e.fecha_nacimiento";
		    $stmt = $this->db->prepare($sql);
		    $stmt->bindParam(':mes',$g,PDO::PARAM_STR);
        
    	  $stmt->execute();
       	$r2 = $stmt->fetchAll();        
        return array($r2);
    }
    
    function data_fec_ven_rev($g)
    {
        $sql = "SELECT distinct concat(propietario.idempleado,' - ',propietario.nombre,' ',propietario.apellidos) as propietario,
				        concat(v.marca,' - ',v.modelo,' - ',v.placa) as vehiculo,
				        v.fec_ven_rev as fecha
				FROM vehiculo as v left outer join empleado as propietario on propietario.idempleado = v.idpropietario and propietario.idtipo_empleado = 3
				WHERE v.fec_ven_rev is not null and v.fec_ven_rev <> '0000-00-00' ";
        if($g!="")
        {
          $sql .= " and month(v.fec_ven_rev)=:mes ";
        }
        else
        {
          $sql .= " and v.fec_ven_rev < CURDATE() ";
        }
        
				$sql .= " ORDER by concat(v.marca,' - ',v.modelo,' - ',v.placa),v.fec_ven_rev";

    		$stmt = $this->db->prepare($sql);

        if($g!="")
        {
          $stmt->bindParam(':mes',$g,PDO::PARAM_STR);
        }
    		
    	  $stmt->execute();
       	$r2 = $stmt->fetchAll();        
        return array($r2);
    }
    
    function data_fec_ven_soat($g)
    {
        $anio = date('Y');
        $sql = "SELECT concat(propietario.idempleado,' - ',propietario.nombre,' ',propietario.apellidos) as propietario,
  				        concat(v.marca,' - ',v.modelo,' - ',v.placa) as vehiculo,
  				        v.fec_ven_soat as fecha
        				FROM vehiculo as v left outer join empleado as propietario on propietario.idempleado = v.idpropietario and propietario.idtipo_empleado = 3 
        				 ";
        
        if($g!="")      
          $sql .= " WHERE year(v.fec_ven_soat)=:anio and month(v.fec_ven_soat)=:mes ";
        else
          $sql .= " where v.fec_ven_soat < CURDATE() ";

        $sql .= " ORDER by v.fec_ven_soat";
		    $stmt = $this->db->prepare($sql);
        
        if($g!="")          
		      $stmt->bindParam(':mes',$g,PDO::PARAM_INT);

        $stmt->bindParam(':anio',$anio,PDO::PARAM_INT);
    	  $stmt->execute();
       	$r2 = $stmt->fetchAll();        
        return array($r2);
    }

    //Data vencimiento de capasitaciones
    function data_fec_ven_cap($g)
    {
        $anio = date('Y');
        $sql = "SELECT nombre, apellidos, fecha_v_capacitacion as fecha
                from empleado as chofer 
                where chofer.idtipo_empleado = 2 and fecha_v_capacitacion is not null and fecha_v_capacitacion <> '0000-00-00'  ";

        if($g!="")
        {
          $sql .= " and month(fecha_v_capacitacion)=:mes and year(fecha_v_capacitacion)=:anio  ";
        }
        else
        {
          $sql .= " and fecha_v_capacitacion < CURDATE() ";
        }

        $sql .= " ORDER by fecha_v_capacitacion";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':mes',$g,PDO::PARAM_INT);
        $stmt->bindParam(':anio',$anio,PDO::PARAM_INT);
        $stmt->execute();
        $r2 = $stmt->fetchAll();        
        return array($r2);
    }
    //

    function data_fec_ven_lic($g)
    {
        $anio = date('Y');
        $sql = "SELECT nombre, apellidos, fecha_v_licencia as fecha
                from empleado as chofer 
                where chofer.idtipo_empleado = 2 and fecha_v_licencia is not null and fecha_v_licencia <> '0000-00-00' ";
        if($g!="")
        {
          $sql .= " and month(fecha_v_licencia)=:mes and year(fecha_v_licencia)=:anio ";
        }
        else
        {
          $sql .= " and fecha_v_licencia < CURDATE() ";
        }
                
        $sql .= " ORDER by fecha_v_licencia";
        $stmt = $this->db->prepare($sql);
        if($g!="")
        {
          $stmt->bindParam(':mes',$g,PDO::PARAM_INT);
          $stmt->bindParam(':anio',$anio,PDO::PARAM_INT);
        }
        $stmt->execute();
        $r2 = $stmt->fetchAll();        
        return array($r2);
    }
    
    function data_ingresos($g)
    {
        $sql = "SELECT  cm.descripcion as concepto,
				        case tipo_ingreso when 1 then concat(coalesce(propietario.nombre,' '),' ',coalesce(propietario.apellidos,' '))
                                            else 
                                                case pro.ruc 
                                                when '00000000' then m.recibi 
                                                else pro.razonsocial  end                                                
                                            end as remitente,
				        m.chofer,
				        m.placa,
				        m.fecha,
				        m.observacion,
				        md.cantidad*md.monto as total
				FROM movimiento as m inner join movimiento_detalle as md on m.idmovimiento = md.idmovimiento
				        inner join concepto_movimiento as cm on cm.idconcepto_movimiento = md.idconcepto_movimiento                                        
                left outer join proveedor as pro on pro.idproveedor = m.idproveedor
				        left join empleado as propietario on propietario.idempleado = m.idpropietario and propietario.idtipo_empleado = 3                                        
				WHERE m.tipo = 1 AND m.estado = 1 and m.caja = 1 and m.fecha between :f1 and :f2 and m.idoficina = ".$_SESSION['idoficina']."
              and m.serie is not null ";

        if($g['idconcepto']!="")
        {
           $sql .= " and md.idconcepto_movimiento = ".(int)$g['idconcepto'];
        }

				$sql .= " ORDER by m.idmovimiento desc";
        
        $fechai = $this->fdate($g['fechai'],'EN');
        $fechaf = $this->fdate($g['fechaf'],'EN');
		    $stmt = $this->db->prepare($sql);
		    $stmt->bindParam(':f1',$fechai,PDO::PARAM_STR);
        $stmt->bindParam(':f2',$fechaf,PDO::PARAM_STR);
    	  $stmt->execute();
       	$r2 = $stmt->fetchAll();        
        return array($r2);
    }
    function data_ingresosc($g)
    {
        $sql = "SELECT  cm.descripcion as concepto,
                case tipo_ingreso when 1 then concat(coalesce(propietario.nombre,' '),' ',coalesce(propietario.apellidos,' '))
                                            else 
                                                case pro.ruc 
                                                when '00000000' then m.recibi 
                                                else pro.razonsocial  end                                                
                                            end as remitente,
                m.chofer,
                m.placa,
                m.fecha,
                m.observacion,
                md.cantidad*md.monto as total
        FROM movimiento as m inner join movimiento_detalle as md on m.idmovimiento = md.idmovimiento
                inner join concepto_movimiento as cm on cm.idconcepto_movimiento = md.idconcepto_movimiento                                        
                left outer join proveedor as pro on pro.idproveedor = m.idproveedor
                left join empleado as propietario on propietario.idempleado = m.idpropietario and propietario.idtipo_empleado = 3                                        
        WHERE m.tipo = 1 AND m.estado = 1 and m.caja = 2 and m.fecha between :f1 and :f2 and m.idoficina = ".$_SESSION['idoficina']."
              and m.serie is not null ";

        if($g['idconcepto']!="")
        {
           $sql .= " and md.idconcepto_movimiento = ".(int)$g['idconcepto'];
        }

        $sql .= " ORDER by m.idmovimiento desc";
        
        $fechai = $this->fdate($g['fechai'],'EN');
        $fechaf = $this->fdate($g['fechaf'],'EN');
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':f1',$fechai,PDO::PARAM_STR);
        $stmt->bindParam(':f2',$fechaf,PDO::PARAM_STR);
        $stmt->execute();
        $r2 = $stmt->fetchAll();        
        return array($r2);
    }
   function data_egresos($g)
   {
       $sql = "SELECT cm.descripcion as concepto, concat(p.ruc,'-',p.razonsocial) as proveedor, 
                      m.fecha, m.observacion, md.cantidad*md.monto as monto
               FROM movimiento as m inner join movimiento_detalle as md
                    on m.idmovimiento = md.idmovimiento inner join  proveedor as p 
                    on p.idproveedor = m.idproveedor inner join concepto_movimiento as cm
                    on cm.idconcepto_movimiento = md.idconcepto_movimiento 
               WHERE m.tipo = 2 and m.estado = 1 and m.fecha between :f1 and :f2
                and m.idoficina = ".$_SESSION['idoficina']."
                and m.serie is not null
                and m.caja = 1
               ORDER BY m.fecha";
       $stmt = $this->db->prepare($sql);
       $fechai = $this->fdate($g['fechai'],'EN');
       $fechaf = $this->fdate($g['fechaf'],'EN');
       $stmt = $this->db->prepare($sql);
       $stmt->bindParam(':f1',$fechai,PDO::PARAM_STR);
       $stmt->bindParam(':f2',$fechaf,PDO::PARAM_STR);
       $stmt->execute();
       $r2 = $stmt->fetchAll();
       //var_dump($r2);die;
       return array($r2);
   }
   function data_egresosc($g)
   {
       $sql = "SELECT cm.descripcion as concepto, concat(p.ruc,'-',p.razonsocial) as proveedor, 
                      m.fecha, m.observacion, md.cantidad*md.monto as monto, m.comprobante, m.serie_numero
               FROM movimiento as m inner join movimiento_detalle as md
                    on m.idmovimiento = md.idmovimiento inner join  proveedor as p 
                    on p.idproveedor = m.idproveedor inner join concepto_movimiento as cm
                    on cm.idconcepto_movimiento = md.idconcepto_movimiento 
               WHERE m.tipo = 2 and m.estado = 1 and m.fecha between :f1 and :f2
                and m.idoficina = ".$_SESSION['idoficina']."
                and m.serie is not null
                and m.caja = 2
               ORDER BY m.fecha";
       $stmt = $this->db->prepare($sql);
       $fechai = $this->fdate($g['fechai'],'EN');
       $fechaf = $this->fdate($g['fechaf'],'EN');
       $stmt = $this->db->prepare($sql);
       $stmt->bindParam(':f1',$fechai,PDO::PARAM_STR);
       $stmt->bindParam(':f2',$fechaf,PDO::PARAM_STR);
       $stmt->execute();
       $r2 = $stmt->fetchAll();
       //var_dump($r2);die;
       return array($r2);
   }
    function data_ventas($g)
   {
       $sql = "SELECT
				venta.fecha,
				venta.hora,
				tipo_documento.descripcion,
				venta.serie,
				venta.numero,
				pasajero.nombre,
				sum(venta_detalle.cantidad *  venta_detalle.precio) as total,
        venta.idventa
			   FROM
				venta
				Inner Join venta_detalle ON venta.idventa = venta_detalle.idventa
				Inner Join pasajero ON pasajero.idpasajero = venta.idpasajero
				Inner Join tipo_documento ON tipo_documento.idtipo_documento = venta.idtipo_documento
				WHERE venta.estado=1 and venta.fecha between :p2 and :p3
              and v.idoficina = ".$_SESSION['idoficina']."
				GROUP BY 
				venta.fecha,
				venta.hora,
				tipo_documento.descripcion,
				venta.serie,
				venta.numero,
				pasajero.nombre,
				venta.idventa";
       $stmt = $this->db->prepare($sql);
       $fechai = $this->fdate($g['fechai'],'EN');
       $fechaf = $this->fdate($g['fechaf'],'EN');
       $stmt = $this->db->prepare($sql);
       $stmt->bindParam(':p2',$fechai,PDO::PARAM_STR);
       $stmt->bindParam(':p3',$fechaf,PDO::PARAM_STR);
       $stmt->execute();
       $r2 = $stmt->fetchAll();
       //var_dump($r2);die;
       return array($r2);
      }
   
      function data_envio($g)
      {

       $sql = "SELECT   distinct concat(substring(e.fecha,9,2),'/',substring(e.fecha,6,2),'/',substring(e.fecha,1,4)) as fecha,
                        e.hora,
                        concat(chofer.nombre,' ',coalesce(chofer.apellidos,'')) as chofer,
                        v.placa as vechiulos,
                        case remitente.nrodocumento when '00000000' then e.remitente else remitente.nombre end,
                        e.consignado,
                        concat(e.serie,'-',e.numero),
                        case e.cpago when 0 then e.monto_caja else 0 end as total,
                        e.cpago,
                        0 as tipo,
                        d.descripcion as destino
                        from envio as e inner join pasajero as remitente on remitente.idpasajero = e.idremitente                                              
                            inner join empleado as em on e.idempleado = em.idempleado and em.idtipo_empleado = 1
                            INNER JOIN destino as d on d.iddestino = e.iddestino
                            left outer join envio_salidas as es on es.idenvio = e.idenvio and (es.idoficina = ".$_SESSION['idoficina']." and es.estado <> 0)
                            left outer join salida as s on s.idsalida = es.idsalida
                            left outer join vehiculo as v on v.idvehiculo = s.idvehiculo
                            left outer join empleado as chofer on chofer.idempleado = s.idchofer and chofer.idtipo_empleado = 2
			         WHERE  e.fecha between :p2 and :p3 and e.tipo_pro = 1 and e.estado <> 0 and e.idoficina = ".$_SESSION['idoficina']; 

        $sql_2 = "SELECT  distinct concat(substring(e.fecha,9,2),'/',substring(e.fecha,6,2),'/',substring(e.fecha,1,4)) as fecha,
                                e.hora,
                                chofer.nombre as chofer,
                                v.placa as vechiulos,
                                case remitente.nrodocumento when '00000000' then e.remitente else remitente.nombre end,
                                e.consignado,
                                concat(e.serie,'-',e.numero),
                                case e.cpago when 0 then 0 else e.monto_caja end as total,
                                e.cpago,
                                1 as tipo,
                                e.direccion as destino
                                from envio as e inner join pasajero as remitente on remitente.idpasajero = e.idremitente                                                      
                                    inner join empleado as em on e.idempleado = em.idempleado and em.idtipo_empleado = 1
                                    INNER JOIN destino as d on d.iddestino = e.iddestino
                                    left outer join envio_salidas as es on es.idenvio = e.idenvio and es.estado <> 0
                                    inner join salida as s on s.idsalida = es.idsalida and s.iddestino = ".$_SESSION['idsucursal']." 
                                    left outer join vehiculo as v on v.idvehiculo = s.idvehiculo
                                    left outer join empleado as chofer on chofer.idempleado = s.idchofer and chofer.idtipo_empleado = 2                             
                    WHERE e.num_mov in 
                                ((    SELECT  mv.num_mov
                                      FROM movimiento as mv inner join envio as em on 
                                        em.num_mov = mv.num_mov
                                      WHERE mv.fecha BETWEEN  :p2 and :p3
                                        AND mv.observacion 
                                        LIKE  '%ENCOM%'
                                       and em.cpago = 1
                                       and mv.idoficina = ".$_SESSION['idoficina']."
                                ))  or 
                        e.tipo_pro = 1 and  e.fecha between :p2 and :p3 and e.iddestino = ".$_SESSION['idsucursal']." and e.estado = 3 ";        
        $sql_union .= " UNION ALL ";

        $sqlw="";        
        switch ($g['filtro']) 
                {
                  case 0: $sql = $sql.$sql_union.$sql_2;
                          break;
                  case 1: $sql = $sql;
                          break;
                  case 2: $sqlw = " and e.cpago = 1 "; 
                          $sql = $sql.$sqlw;
                          break;
                  case 3: $sqlw = " and e.adomicilio = 1 "; 
                          $sql = $sql.$sqlw;
                          break;
                  case 4: $sql = $sql_2;                           
                          break;                    
                  case 5: $sqlw = " and e.cpago = 1 "; 
                          $sql = $sql_2.$sqlw;
                          break;                    
                  case 6: $sqlw = " and e.adomicilio = 1 "; 
                          $sql = $sql_2.$sqlw;
                          break;
                  default: break;
                } 
       $sql .= " ORDER BY 7 ";
       //echo $sql;
       $stmt = $this->db->prepare($sql);
       $fechai = $this->fdate($g['fechai'],'EN');
       $fechaf = $this->fdate($g['fechaf'],'EN');
       $stmt = $this->db->prepare($sql);
       $stmt->bindParam(':p2',$fechai,PDO::PARAM_STR);
       $stmt->bindParam(':p3',$fechaf,PDO::PARAM_STR);
       $stmt->execute();
       $r2 = $stmt->fetchAll();
       
       return array($r2);
     }
     function data_telegiro($g)
     {

        $sql = "SELECT   distinct concat(substring(e.fecha,9,2),'/',substring(e.fecha,6,2),'/',substring(e.fecha,1,4)) as fecha,
                        e.hora,
                        concat(chofer.nombre,' ',coalesce(chofer.apellidos,'')) as chofer,
                        v.placa as vechiulos,
                        case remitente.nrodocumento when '00000000' then e.remitente else remitente.nombre end,
                        e.consignado,
                        e.numero,
                        case e.cpago when 0 then e.monto_caja else 0 end as total,
                        e.cpago,
                        0 as tipo,
                        d.descripcion as destino
                        from envio as e left outer join pasajero as remitente on remitente.idpasajero = e.idremitente                                              
                            left outer join empleado as em on e.idempleado = em.idempleado and em.idtipo_empleado = 1
                            left outer join destino as d on d.iddestino = e.iddestino
                            left outer join envio_salidas as es on es.idenvio = e.idenvio and es.idoficina = ".$_SESSION['idoficina']."
                            left outer join salida as s on s.idsalida = es.idsalida
                            left outer join vehiculo as v on v.idvehiculo = s.idvehiculo
                            left outer join empleado as chofer on chofer.idempleado = s.idchofer and chofer.idtipo_empleado = 2
               WHERE  e.tipo_pro = 2 and e.estado <> 0 and  e.fecha between :p2 and :p3 and e.idoficina = ".$_SESSION['idoficina']; 

        $sql_2 = "SELECT  distinct concat(substring(e.fecha,9,2),'/',substring(e.fecha,6,2),'/',substring(e.fecha,1,4)) as fecha,
                                e.hora,
                                chofer.nombre as chofer,
                                v.placa as vechiulos,
                                case remitente.nrodocumento when '00000000' then e.remitente else remitente.nombre end,
                                e.consignado,
                                e.numero ,
                                case e.cpago when 0 then 0 else e.monto_caja end as total,
                                e.cpago,
                                1 as tipo,
                                e.direccion as destino
                                from envio as e inner join pasajero as remitente on remitente.idpasajero = e.idremitente                                                      
                                    inner join empleado as em on e.idempleado = em.idempleado and em.idtipo_empleado = 1
                                    INNER JOIN destino as d on d.iddestino = e.iddestino
                                    left outer join envio_salidas as es on es.idenvio = e.idenvio 
                                    left outer join salida as s on s.idsalida = es.idsalida
                                    left outer join vehiculo as v on v.idvehiculo = s.idvehiculo
                                    left outer join empleado as chofer on chofer.idempleado = s.idchofer and chofer.idtipo_empleado = 2                             
                WHERE e.tipo_pro = 2 and  e.fecha between :p2 and :p3 and e.iddestino = ".$_SESSION['idsucursal']." and e.estado = 3 ";

        $sql_union .= " UNION ALL ";

        $sqlw="";        
        switch ($g['filtro']) 
                {
                  case 0: $sql = $sql.$sql_union.$sql_2;
                          break;
                  case 1: $sql = $sql;
                          break;
                  case 2: $sqlw = " and e.cpago = 1 "; 
                          $sql = $sql.$sqlw;
                          break;
                  case 3: $sqlw = " and e.adomicilio = 1 "; 
                          $sql = $sql.$sqlw;
                          break;
                  case 4: $sql = $sql_2;                           
                          break;                    
                  case 5: $sqlw = " and e.cpago = 1 "; 
                          $sql = $sql_2.$sqlw;
                          break;                    
                  case 6: $sqlw = " and e.adomicilio = 1 "; 
                          $sql = $sql_2.$sqlw;
                          break;
                  default: break;
                } 
       $sql .= " ORDER BY 7 ";
       //echo $sql;
       $stmt = $this->db->prepare($sql);
       $fechai = $this->fdate($g['fechai'],'EN');
       $fechaf = $this->fdate($g['fechaf'],'EN');
       $stmt = $this->db->prepare($sql);
       $stmt->bindParam(':p2',$fechai,PDO::PARAM_STR);
       $stmt->bindParam(':p3',$fechaf,PDO::PARAM_STR);
       $stmt->execute();
       $r2 = $stmt->fetchAll();       
       return array($r2);
   }
    function data_salida($g)
   {
       $sql = "SELECT
                  distinct 
          				salida.fecha_pay,
          				salida.hora_pay,
          				concat(chofer.nombre,' ',chofer.apellidos) as nombre,
          				concat(vehiculo.marca,' - ',vehiculo.placa),
          				concat(salida.serie,'-',salida.numero) as numero,
                  salida.monto,
                  d.descripcion as destino
          				FROM
          				salida inner join empleado as chofer on chofer.idempleado = salida.idchofer
          				Inner Join empleado ON empleado.idempleado = salida.idempleado and empleado.idtipo_empleado=1                  
          				Inner Join vehiculo ON vehiculo.idvehiculo = salida.idvehiculo
                  left outer join destino as d on d.iddestino = salida.iddestino
          			  WHERE salida.estado <> 0 and salida.fecha_pay between :p2 and :p3 and salida.idoficina = ".$_SESSION['idoficina']." 
                        and chofer.idtipo_empleado = 2 and salida.iddestino = :iddes ";
       $stmt = $this->db->prepare($sql);
       $fechai = $this->fdate($g['fechai'],'EN');
       $fechaf = $this->fdate($g['fechaf'],'EN');
       $stmt = $this->db->prepare($sql);
       $stmt->bindParam(':p2',$fechai,PDO::PARAM_STR);
       $stmt->bindParam(':p3',$fechaf,PDO::PARAM_STR);
       $stmt->bindParam(':iddes',$g['iddestino'],PDO::PARAM_INT);       
       $stmt->execute();
       $r2 = $stmt->fetchAll();
       //var_dump($g['fechai']);die;
       return array($r2);
   }
   
   function data_mensualidades($g)
    {
      
        $sql = "SELECT  cm.idtipo_concepto,
                      cm.descripcion as concepto,
                      m.tipo_ingreso,
                      concat(coalesce(propietario.nombre,' '),' ',coalesce(propietario.apellidos,' ')) as remitente,
                          propietario.idempleado,
                      m.chofer,
                      m.placa,
                      m.fecha,
                      m.observacion,
                      md.cantidad*md.monto as total
                  FROM movimiento as m inner join movimiento_detalle as md on m.idmovimiento = md.idmovimiento
                      inner join concepto_movimiento as cm on cm.idconcepto_movimiento = md.idconcepto_movimiento                                        
                      left outer join proveedor as pro on pro.idproveedor = m.idproveedor
                      left join empleado as propietario on propietario.idempleado = m.idpropietario and propietario.idtipo_empleado = 3   
        WHERE m.tipo = 1 AND m.estado = 1 and m.fecha between :f1 and :f2 and m.idoficina = ".$_SESSION['idoficina']."
              and m.serie is not null 
        and md.idconcepto_movimiento in (11,12,69)
        ORDER by m.idmovimiento desc";
        
        $fechai = $this->fdate($g['fechai'],'EN');
        $fechaf = $this->fdate($g['fechaf'],'EN');
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':f1',$fechai,PDO::PARAM_STR);
        $stmt->bindParam(':f2',$fechaf,PDO::PARAM_STR);
        $stmt->execute();
        $data = array();        
        foreach ($stmt->fetchAll() as $row) 
        {
            $data[] = array($row['concepto'],$row['remitente'],$row['idempleado'],$row['chofer'],$row['placa'],$row['fecha'],$row['observacion'],$row['total']);
        }

        $sql = "SELECT idempleado,concat(nombre,' ',apellidos),estado 
                from empleado where idtipo_empleado = 3 and estado = 1
                order by concat(nombre,' ',apellidos) asc";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $records = array();
        foreach ($stmt->fetchAll() as $r) 
        {
            $s = $this->search($r['idempleado'],$data);
            $n = count($s);
            if($n>0)
            {
                foreach ($s as $k) {
                  $records[] = array('concepto'=>$k[0],
                                    'remitente'=>$k[1],                                
                                    'idempleado'=>$k[2],
                                    'chofer'=>$k[3],
                                    'placa'=>$k[4],
                                    'fecha'=>$k[5],
                                    'observacion'=>$k[6],
                                    'total'=>$k[7]);
                }
            }
            else
            {
              $records[] = array('concepto'=>'',
                                'remitente'=>$r[1],                                
                                'idempleado'=>$r[0],
                                'chofer'=>'',
                                'placa'=>'',
                                'fecha'=>'',
                                'observacion'=>'',
                                'total'=>'0.00');
            }
        }
        return array($records);
    }
    //Functions ultilities
    function search($buscar,$en)
    {
      $result = array();
      foreach($en as $k)
      {
          if($k[2]==$buscar)          
            {$result[] = array($k[0],$k[1],$k[2],$k[3],$k[4],$k[5],$k[6],$k[7]);}
      }
      return $result;
    }
}

?>