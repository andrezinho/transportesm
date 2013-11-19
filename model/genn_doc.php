<?php
include_once("Main.php");
class genn_doc extends Main
{
   function index($query , $p ) {
        $sql = "select g.idgenn_doc,
                       concat(o.descripcion,' (',s.descripcion,') '),
                       td.descripcion,
                       g.serie,
                       g.numi,
                       g.numf,
                       g.current
                       from genn_doc as g inner join tipo_documento as td on g.idtipo_documento = td.idtipo_documento
                       inner join oficina as o on g.idoficina = o.idoficina inner join sucursal as s on o.idsucursal = s.idsucursal
                       where td.descripcion like :query
                       order by g.idgenn_doc asc";
        $param = array(array('key'=>':query' , 'value'=>"%$query%" , 'type'=>'STR' ));
        $data['total'] = $this->getTotal( $sql, $param );
        $data['rows'] =  $this->getRow($sql, $param , $p );
        $data['rowspag'] =  $this->getRowPag($data['total'], $p );
        return $data;
    }
    function getcurrent($idtipodoc) 
    {
        //die($_SESSION['idoficina']);
        $stmt = $this->db->prepare("SELECT serie, current FROM genn_doc WHERE idtipo_documento = :id and idoficina = :idof");
        $stmt->bindParam(':id', $idtipodoc , PDO::PARAM_INT);
        $stmt->bindParam(':idof', $_SESSION['idoficina'] , PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchObject();
    }
    function insert($_P ) {
        //$idoficina = $_SESSION['idoficina'];
        $stmt = $this->db->prepare("insert into genn_doc (idoficina, idtipo_documento, serie, numi, numf, current) 
                                    values(:p1,:p2,:p3,:p4,:p5,:p6)");
        $stmt->bindParam(':p1',$_P['idoficina'],PDO::PARAM_INT);
        $stmt->bindParam(':p2', $_P['idtipo_documento'] , PDO::PARAM_INT);
        $stmt->bindParam(':p3', $_P['serie'] , PDO::PARAM_INT);
        $stmt->bindParam(':p4', $_P['numi'] , PDO::PARAM_INT);
        $stmt->bindParam(':p5', $_P['numf'] , PDO::PARAM_INT);
        $stmt->bindParam(':p6', $_P['current'] , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    function edit($id ) {
        $stmt = $this->db->prepare("SELECT * FROM genn_doc WHERE idgenn_doc = :id");
        $stmt->bindParam(':id', $id , PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchObject();
    }
    function update($_P ) {
        $stmt = $this->db->prepare("update genn_doc set serie = :p1, numi = :p2,
                                    numf = :p3, current = :p4 where idgenn_doc = :idgenn_doc");
        $stmt->bindParam(':p1', $_P['serie'] , PDO::PARAM_INT);
        $stmt->bindParam(':p2', $_P['numi'] , PDO::PARAM_INT);
        $stmt->bindParam(':p3', $_P['numf'] , PDO::PARAM_INT);
        $stmt->bindParam(':p4', $_P['current'] , PDO::PARAM_INT);
        $stmt->bindParam(':idgenn_doc', $_P['idgenn_doc'] , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    function delete($_P ) {
        $stmt = $this->db->prepare("DELETE FROM genn_doc WHERE idgenn_doc = :p1");
        $stmt->bindParam(':p1', $_P , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
}
?>