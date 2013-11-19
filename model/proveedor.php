<?php
include_once("Main.php");
class proveedor extends Main
{
   function index($query , $p ) {
        $sql = "select idproveedor,
                       razonsocial,
                       ruc
                       from proveedor  where razonsocial like :query
                       order by idproveedor asc";
        $param = array(array('key'=>':query' , 'value'=>"%$query%" , 'type'=>'STR' ));
        $data['total'] = $this->getTotal( $sql, $param );
        $data['rows'] =  $this->getRow($sql, $param , $p );
        $data['rowspag'] =  $this->getRowPag($data['total'], $p );
        return $data;
    }
    function edit($id ) {
        $stmt = $this->db->prepare("SELECT * FROM proveedor WHERE idproveedor = :id");
        $stmt->bindParam(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchObject();
    }
    function insert($_P ) {
        $stmt = $this->db->prepare("insert into proveedor (razonsocial, ruc, direccion, telefonos) 
                                    values(:p1, :p2, :p3, :p4)");
        $stmt->bindParam(':p1', $_P['razonsocial'] , PDO::PARAM_STR);
        $stmt->bindParam(':p2', $_P['ruc'] , PDO::PARAM_STR);
        $stmt->bindParam(':p3', $_P['direccion'] , PDO::PARAM_STR);
        $stmt->bindParam(':p4', $_P['telefonos'] , PDO::PARAM_STR);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    function update($_P ) {
        $stmt = $this->db->prepare("update proveedor set razonsocial = :p1, ruc ) :p2, direccion = :p3, telefonos = :p4
                                    where idproveedor = :idproveedor");
        $stmt->bindParam(':p1', $_P['razonsocial'] , PDO::PARAM_STR);
        $stmt->bindParam(':p2', $_P['ruc'] , PDO::PARAM_STR);
        $stmt->bindParam(':p3', $_P['direccion'] , PDO::PARAM_STR);
        $stmt->bindParam(':p4', $_P['telefonos'] , PDO::PARAM_STR);
        $stmt->bindParam(':idproveedor', $_P['idproveedor'] , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    function delete($_P ) {
        $stmt = $this->db->prepare("DELETE FROM proveedor WHERE idproveedor = :p1");
        $stmt->bindParam(':p1', $_P , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    
    function getproveedor($query,$field)
    {
        $query = "%".$query."%";
        $statement = $this->db->prepare("SELECT idproveedor, 
                                                razonsocial,
                                                ruc
                                         FROM proveedor
                                         WHERE {$field} like :query and ruc <> ''
                                         limit 10");
        $statement->bindParam (":query", $query , PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetchAll();
    }
    
}
?>