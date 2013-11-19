<?php
include_once("Main.php");
class pasajero extends Main
{
   function index($query , $p ) {
        $sql = "select idpasajero,
                       descripcion,
                       case estado when true then 'ACTIVO' else 'INCANTIVO' end
                       from pasajero  where descripcion like :query
                       order by idpasajero asc";
        $param = array(array('key'=>':query' , 'value'=>"%$query%" , 'type'=>'STR' ));
        $data['total'] = $this->getTotal( $sql, $param );
        $data['rows'] =  $this->getRow($sql, $param , $p );
        $data['rowspag'] =  $this->getRowPag($data['total'], $p );
        return $data;
    }
    function edit($id ) {
        $stmt = $this->db->prepare("SELECT * FROM pasajero WHERE idpasajero = :id");
        $stmt->bindParam(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchObject();
    }
    function insert($_P ) {
        $stmt = $this->db->prepare("insert into pasajero (descripcion, estado) values(:p1,:p2)");
        $stmt->bindParam(':p1', $_P['descripcion'] , PDO::PARAM_STR);
        $stmt->bindParam(':p2', $_P['activo'] , PDO::PARAM_BOOL);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    function update($_P ) {
        $stmt = $this->db->prepare("update pasajero set descripcion = :p1, estado = :p2 where idpasajero = :idpasajero");
        $stmt->bindParam(':p1', $_P['descripcion'] , PDO::PARAM_STR);
        $stmt->bindParam(':p2', $_P['activo'] , PDO::PARAM_BOOL);
        $stmt->bindParam(':idpasajero', $_P['idpasajero'] , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    function delete($_P ) {
        $stmt = $this->db->prepare("DELETE FROM pasajero WHERE idpasajero = :p1");
        $stmt->bindParam(':p1', $_P , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    function getpasajero($query,$field,$t)
    {
        $query = "%".$query."%";
        if($t==0)
        {
            $sql = "";
        }
        else {
            $sql = " and idtipo_pasajero = {$t} ";
        }
        $statement = $this->db->prepare("SELECT idpasajero, nrodocumento, nombre,direccion
                                         FROM pasajero
                                         WHERE {$field} like :query ".$sql."
                                         limit 10");
        
        $statement->bindParam (":query", $query , PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetchAll();
    }
}
?>