<?php
include_once("Main.php");
class tipo_pasajero extends Main
{
   function index($query , $p ) {
        $sql = "select idtipo_pasajero,
                       descripcion
                       from tipo_pasajero  where descripcion like :query
                       order by idtipo_pasajero asc";
        $param = array(array('key'=>':query' , 'value'=>"%$query%" , 'type'=>'STR' ));
        $data['total'] = $this->getTotal( $sql, $param );
        $data['rows'] =  $this->getRow($sql, $param , $p );
        $data['rowspag'] =  $this->getRowPag($data['total'], $p );
        return $data;
    }
    function gettipos()
    {
        $stmt = $this->db->prepare("SELECT * FROM tipo_pasajero");        
        $stmt->execute();
        return $stmt->fetchAll();
    }
    function edit($id ) {
        $stmt = $this->db->prepare("SELECT * FROM tipo_pasajero WHERE idtipo_pasajero = :id");
        $stmt->bindParam(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchObject();
    }
    function insert($_P ) {
        $stmt = $this->db->prepare("insert into tipo_pasajero (descripcion) values(:p1)");
        $stmt->bindParam(':p1', $_P['descripcion'] , PDO::PARAM_STR);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    function update($_P ) {
        $stmt = $this->db->prepare("update tipo_pasajero set descripcion = :p1 where idtipo_pasajero = :idtipo_pasajero");
        $stmt->bindParam(':p1', $_P['descripcion'] , PDO::PARAM_STR);
        $stmt->bindParam(':idtipo_pasajero', $_P['idtipo_pasajero'] , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    function delete($_P ) {
        $stmt = $this->db->prepare("DELETE FROM tipo_pasajero WHERE idtipo_pasajero = :p1");
        $stmt->bindParam(':p1', $_P , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
}
?>