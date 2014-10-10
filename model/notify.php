<?php
include_once("Main.php");
class notify extends Main
{
    function getData()
    {
        //Buscamos si hay vehiculos que vienen
        $s = $this->db->prepare("SELECT count(DISTINCT s.idsalida) as n
                                 FROM salida as s inner join empleado as chofer on chofer.idempleado = s.idchofer
                                            inner join vehiculo as v on v.idvehiculo = s.idvehiculo
                                            inner join destino as d on d.iddestino = s.iddestino
                                            inner join empleado as e on e.idempleado = s.idempleado
                                            inner join oficina as o on s.idoficina = o.idoficina 
                                            inner join destino as do on do.iddestino = o.idsucursal
                                 where chofer.idtipo_empleado = 2 
                                        and s.iddestino = ".$_SESSION['idsucursal']."
                                         and s.estado = 3
                                        and s.fecha = CURDATE()
                                    order by s.idsalida desc");
        $s->execute();
        $row = $s->fetchObject();
        $n1 = $row->n;
        
        //Buscamos si hay encomiendas que vienen
        $s = $this->db->prepare("SELECT count(es.idenvio) as n from envio_salidas as es 
                                        inner join salida as s on s.idsalida = es.idsalida
                                        inner join envio as e on e.idenvio = es.idenvio
                                where s.iddestino = ".$_SESSION['idsucursal']." and es.estado in (2) and e.estado in (2)");        
        $s->execute();
        $row = $s->fetchObject();
        $n2 = $row->n;
        
        //Buscamos si tenemos telegiros pendientes
        $s = $this->db->prepare("SELECT count(t.idtelegiro) as n
                                from telegiro as t inner join pasajero as remitente on remitente.idpasajero = t.idremitente 
                                where  t.iddestino = ".$_SESSION['idoficina']." and t.estado = 1
                                order by t.idtelegiro desc");
        $s->execute();
        $row = $s->fetchObject();
        $n3 = $row->n;
        
        return array('entrada'=>array($n1,'controller=entrada'),
                     'encomienda'=>array($n2,'controller=envio&action=indexe'),
                     'telegiro'=>array($n3,'controller=telegiro&action=index&op=1')
                    );
    }
    
    function getResumen()
    {
        $data = array();
        $sql = "SELECT count(id1) as c1,count(id2) as c2,count(id3) as c3
                                    from 
                                    (select distinct idvehiculo as id0
                                    from vehiculo) as t0 
                                    left join
                                    (
                                        select 
                                            distinct idvehiculo as id1
                                        from vehiculo
                                        where month(fec_ven_soat) = ".date('m')."  and year(fec_ven_soat)= ".date('Y')."
                                    ) as t1 on t0.id0 = t1.id1
                                    left join (
                                    select 
                                       distinct idvehiculo as id2
                                    from vehiculo
                                    where WEEKOFYEAR(fec_ven_soat) = WEEKOFYEAR(Now()) and year(fec_ven_soat)=".date('Y')." ) as t2 
                                    on t0.id0 = t2.id2
                                    left join (
                                    select
                                        distinct v.idvehiculo as id3
                                    from vehiculo as v left outer join empleado as propietario on propietario.idempleado = v.idpropietario and propietario.idtipo_empleado = 3
                                    where v.fec_ven_soat < CURDATE() 
                                    ) as t3 on t0.id0 = t3.id3";
        
        $s = $this->db->prepare($sql);
        $s->execute();
        $row = $s->fetchObject();
        $data['v1'] = $row->c3;
        $data['v2'] = $row->c1;
        $data['v3'] = $row->c2;
        
        
        $sql = "select count(id1) as c1,count(id2) as c2,count(id3) as c3
                                    from 
                                    (select idempleado as id0
                                    from empleado where idtipo_empleado=2) as t0 
                                    left join
                                    (
                                            select 
                                                idempleado as id1
                                            from empleado
                                            where idtipo_empleado = 2 and 
                                                month(fecha_v_licencia) = ".date('m')."  and year(fecha_v_licencia)= ".date('Y')." and fecha_v_licencia is not null and fecha_v_licencia <> '0000-00-00'
                                        ) as t1 on t0.id0 = t1.id1
                                    left join (
                                    select 
                                        idempleado as id2
                                    from empleado
                                    where  fecha_v_licencia is not null and fecha_v_licencia <> '0000-00-00' and idtipo_empleado=2 and WEEKOFYEAR(fecha_v_licencia) = WEEKOFYEAR(Now()) and year(fecha_v_licencia)=".date('Y')." ) as t2 
                                    on t0.id0 = t2.id2
                                    left join (
                                    select
                                        idempleado as id3
                                    from empleado
                                    where idtipo_empleado=2 and fecha_v_licencia < CURDATE()  and fecha_v_licencia is not null and fecha_v_licencia <> '0000-00-00'
                                    ) as t3 on t0.id0 = t3.id3";
        
        $s = $this->db->prepare($sql);
        $s->execute();
        $row = $s->fetchObject();
        $data['L1'] = $row->c3;
        $data['L2'] = $row->c1;
        $data['L3'] = $row->c2;
       
        
         //Venc. Capacitaciones
        $sql = "select count(id2) as c2,count(id3) as c3
                                    from 
                                    (
                                        select idempleado as id0
                                        from empleado where idtipo_empleado = 2
                                    ) as t0
                                    left join 
                                    (
                                        select 
                                            idempleado as id2
                                        from empleado
                                        where idtipo_empleado=2 and WEEKOFYEAR(fecha_v_capacitacion) = WEEKOFYEAR(Now()) and year(fecha_v_capacitacion)=".date('Y')." 
                                    ) as t2 
                                    on t0.id0 = t2.id2
                                    left join 
                                    (
                                        select
                                            idempleado as id3
                                        from empleado
                                        where idtipo_empleado=2 and fecha_v_capacitacion < CURDATE() 
                                    ) as t3 on t0.id0 = t3.id3";
        
        $s = $this->db->prepare($sql);
        $s->execute();
        $row = $s->fetchObject();
        $data['vc1'] = $row->c3;
        $data['vc2'] = $row->c2;
        
        //Revision Técnica
        $sql = "SELECT count(id2) as c2,count(id3) as c3
                from 
                (
                    select idvehiculo as id0
                    from vehiculo
                ) as t0
                left join 
                (
                    select 
                        distinct idvehiculo as id2
                    from vehiculo
                    where WEEKOFYEAR(fec_ven_rev) = WEEKOFYEAR(Now()) and year(fec_ven_rev)=".date('Y')."  and fec_ven_rev is not null and fec_ven_rev <> '0000-00-00' 
                ) as t2 
                on t0.id0 = t2.id2
                left join 
                (
                    select
                        distinct idvehiculo as id3
                    from vehiculo
                    where fec_ven_rev < CURDATE() and fec_ven_rev is not null and fec_ven_rev <> '0000-00-00'
                ) as t3 on t0.id0 = t3.id3";
        
        $s = $this->db->prepare($sql);
        $s->execute();
        $row = $s->fetchObject();
        $data['t1'] = $row->c3;
        $data['t2'] = $row->c2;
        
        
        //Cumpleaños
        //Hoy
        $sql = "select distinct nombre, apellidos, fecha_nacimiento,
                        (YEAR(CURDATE())-YEAR(fecha_nacimiento))- (RIGHT(CURDATE(),5)<RIGHT(fecha_nacimiento,5)) as edad
                from empleado
                where month(fecha_nacimiento)=".date('m')." and day(fecha_nacimiento)=".date('d')."
                order by idempleado";
        $s = $this->db->prepare($sql);
        $s->execute();
        $row = $s->fetchAll();
        $data['c1'] = $row;
        
        //Esta semana
        $sql = "select distinct nombre, apellidos, fecha_nacimiento,
                        (YEAR(CURDATE())-YEAR(fecha_nacimiento))- (RIGHT(CURDATE(),5)<RIGHT(fecha_nacimiento,5)) as edad
                from empleado
                where WEEKOFYEAR(cast(concat('".date('Y')."',LPAD(month(fecha_nacimiento),2,'0'),LPAD(day(fecha_nacimiento),2,'0')) as date)) = WEEKOFYEAR(Now())
                order by idempleado";
        $s = $this->db->prepare($sql);
        $s->execute();
        $row = $s->fetchAll();
        $data['c2'] = $row;
        
        return $data;
    }
}
?>