<?php
include_once("Main.php");
class notify extends Main
{
    function getData()
    {
        //Buscamos si hay vehiculos que vienen
        $s = $this->db->prepare("SELECT count(s.idsalida) as n
                                 FROM salida as s inner join empleado as chofer on chofer.idempleado = s.idchofer
                                            inner join vehiculo as v on v.idvehiculo = s.idvehiculo
                                            inner join destino as d on d.iddestino = s.iddestino
                                            inner join empleado as e on e.idempleado = s.idempleado
                                            inner join oficina as o on s.idoficina = o.idoficina 
                                            inner join destino as do on do.iddestino = o.idsucursal
                                 where chofer.idtipo_empleado = 2 
                                        and s.iddestino = ".$_SESSION['idsucursal']."
                                         and s.estado = 3
                                        and s.fecha = now()
                                    order by s.idsalida desc");
        $s->execute();
        $row = $s->fetchObject();
        $n1 = $row->n;
        
        //Buscamos si hay encomiendas que vienen
        $s = $this->db->prepare("SELECT count(e.idenvio) as n
                                    from envio as e inner join pasajero as remitente on remitente.idpasajero = e.idremitente                  
                                        inner join empleado as em on e.idempleado = em.idempleado                    
                                        inner join oficina as o on o.idoficina = e.idoficina     
                                        INNER JOIN destino as d on d.iddestino = o.idsucursal
                                    where e.iddestino = ".$_SESSION['idsucursal']." and e.estado in (2)
                                    order by e.idenvio desc ");        
        $s->execute();
        $row = $s->fetchObject();
        $n2 = $row->n;
        
        //Buscamos si tenemos telegiros pendientes
        $s = $this->db->prepare("SELECT count(t.idtelegiro) as n
                                from telegiro as t inner join pasajero as remitente on remitente.idpasajero = t.idremitente 
                                where  t.iddestino = ".$_SESSION['idsucursal']." and t.estado = 2
                                order by t.idtelegiro desc");
        $s->execute();
        $row = $s->fetchObject();
        $n3 = $row->n;
        
        return array('entrada'=>array($n1,'controller=entrada'),
                     'encomienda'=>array($n2,'controller=envio&action=indexe'),
                     'telegiro'=>array($n3,'controller=telegiro&action=index&op=1')
                    );
    }
}
?>