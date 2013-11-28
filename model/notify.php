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
                                         and (s.estado = 3 or s.estado = 4)
                                        and s.fecha = now()
                                    order by s.idsalida desc");
        
        $s->execute();
        $row = $s->fetchObject();
        $n1 = $row->n;
        //Buscamos si hay encomiendas que vienen
        $s = "";
        //Buscamos si tenemos telegiros pendientes
        $s = "";
        
        return array('entrada'=>array($n1,'controller=entrada'),
                     'encomienda'=>array(3,'controller=envio&action=indexe'),
                     'telegiro'=>array(2,'controller=telegiro&action=index&op=1')
                    );
    }    
}
?>
