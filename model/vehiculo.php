<?php
include_once("Main.php");
class vehiculo extends Main
{
   function index($query , $p ) {
        $sql = "select v.idvehiculo,
                       v.marca,
                       v.modelo,
                       v.placa,
                       concat(em.nombre,' ',em.apellidos) as nombres,
                       e.descripcion
                       from vehiculo as v inner join estado as e on v.idestado = e.idestado inner join
                       empleado as em on v.idpropietario = em.idempleado inner join tipo_empleado as te on
                       te.idtipo_empleado = em.idtipo_empleado where v.placa like :query and
                       em.idtipo_empleado = 3 order by v.idvehiculo asc";
        $param = array(array('key'=>':query' , 'value'=>"%$query%" , 'type'=>'STR' ));
        $data['total'] = $this->getTotal( $sql, $param );
        $data['rows'] =  $this->getRow($sql, $param , $p );
        $data['rowspag'] =  $this->getRowPag($data['total'], $p );
        return $data;
    }
    function edit($id ) {
        $stmt = $this->db->prepare("SELECT v.*, concat(e.nombre,' ',e.apellidos) as propietario FROM vehiculo as v inner join empleado as e
                                                on e.idempleado = v.idpropietario
                                WHERE v.idvehiculo = :id");
        $stmt->bindParam(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchObject();
    }
    function getv($idp)
    {
        
        $stmt = $this->db->prepare("SELECT placa FROM vehiculo 
                                WHERE idpropietario = :idp");
        $stmt->bindParam(':idp', $idp , PDO::PARAM_STR);
        $stmt->execute();
        $data = array();
        foreach($stmt->fetchAll() as $row)
        {
            $data[] = $row[0];
        }
        return $data;
    }
    function getv2($idp)
    {
        
        $stmt = $this->db->prepare("SELECT idvehiculo,placa FROM vehiculo 
                                WHERE idpropietario = :idp");
        $stmt->bindParam(':idp', $idp , PDO::PARAM_STR);
        $stmt->execute();
        $data = array();
        foreach($stmt->fetchAll() as $row)
        {
            $data[] = array($row[0],$row[1]);
        }
        return $data;
    }
    function insert($_P ) {
        //die($_P['fecha_inscripcion']);

        $stmt = $this->db->prepare("insert into vehiculo (marca, modelo, placa, serie_motor,
                                    anio_fabricacion, serie_chasis, color, fecha_inscripcion, idestado, idpropietario,
                                    fec_ven_soat, fec_ven_rev)
                                    values(:p1, :p2, :p3, :p4, :p5, :p6, :p7, :p8, :p9, :p10, :p11, :p12)");
        $stmt->bindParam(':p1', $_P['marca'] , PDO::PARAM_STR);
        $stmt->bindParam(':p2', $_P['modelo'], PDO::PARAM_STR);
        $stmt->bindParam(':p3', $_P['placa'], PDO::PARAM_STR);
        $stmt->bindParam(':p4', $_P['serie_motor'], PDO::PARAM_STR);
        $stmt->bindParam(':p5', $_P['anio_fabricacion'], PDO::PARAM_INT);
        $stmt->bindParam(':p6', $_P['serie_chasis'], PDO::PARAM_STR);
        $stmt->bindParam(':p7', $_P['color'], PDO::PARAM_STR);
        $stmt->bindParam(':p8', $this->fdate($_P['fecha_inscripcion'],'EN'), PDO::PARAM_STR);
        $stmt->bindParam(':p9', $_P['idestado'], PDO::PARAM_INT);
        $stmt->bindParam(':p10', $_P['idempleado'], PDO::PARAM_STR);
        $stmt->bindParam(':p11', $this->fdate($_P['fec_ven_soat'],'EN'), PDO::PARAM_STR);
        $stmt->bindParam(':p12', $this->fdate($_P['fec_ven_rev'],'EN'), PDO::PARAM_STR);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    function update($_P ) {
        //die($_P['fecha_inscripcion']);
        $stmt = $this->db->prepare("update vehiculo set marca = :p1, modelo = :p2, placa = :p3, serie_motor = :p4,
                                    anio_fabricacion = :p5, serie_chasis = :p6, color = :p7, fecha_inscripcion = :p8,
                                    idestado = :p9, idpropietario = :p10, fec_ven_soat = :p11, fec_ven_rev = :p12
                                    where idvehiculo = :idvehiculo");
        $stmt->bindParam(':p1', $_P['marca'] , PDO::PARAM_STR);
        $stmt->bindParam(':p2', $_P['modelo'], PDO::PARAM_STR);
        $stmt->bindParam(':p3', $_P['placa'], PDO::PARAM_STR);
        $stmt->bindParam(':p4', $_P['serie_motor'], PDO::PARAM_STR);
        $stmt->bindParam(':p5', $_P['anio_fabricacion'], PDO::PARAM_INT);
        $stmt->bindParam(':p6', $_P['serie_chasis'], PDO::PARAM_STR);
        $stmt->bindParam(':p7', $_P['color'], PDO::PARAM_STR);
        $stmt->bindParam(':p8', $this->fdate($_P['fecha_inscripcion'],'EN'), PDO::PARAM_STR);
        $stmt->bindParam(':p9', $_P['idestado'], PDO::PARAM_INT);
        $stmt->bindParam(':p10', $_P['idempleado'], PDO::PARAM_STR);
        $stmt->bindParam(':p11', $this->fdate($_P['fec_ven_soat'],'EN'), PDO::PARAM_STR);
        $stmt->bindParam(':p12', $this->fdate($_P['fec_ven_rev'],'EN'), PDO::PARAM_STR);
        $stmt->bindParam(':idvehiculo', $_P['idvehiculo'] , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    function delete($_P ) {
        $stmt = $this->db->prepare("DELETE FROM vehiculo WHERE idvehiculo = :p1");
        $stmt->bindParam(':p1', $_P , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
}
?>