<?php
include_once("Main.php");
class grupo extends Main
{
   function index($query , $p ) 
   {
        $sql = "select g.idgrupo,
                       g.descripcion,
                       d.descripcion
                       from grupo as g inner join destino as d on g.iddestino = d.iddestino
                       where g.descripcion like :query
                       order by g.idgrupo asc";
        $param = array(array('key'=>':query' , 'value'=>"%$query%" , 'type'=>'STR' ));
        $data['total'] = $this->getTotal( $sql, $param );
        $data['rows'] =  $this->getRow($sql, $param , $p );
        $data['rowspag'] =  $this->getRowPag($data['total'], $p );
        return $data;
    }
    function edit($id ) 
    {
        $stmt = $this->db->prepare("SELECT * FROM grupo WHERE idgrupo = :id");
        $stmt->bindParam(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchObject();
    }
    function insert($_P ) 
    {
        $stmt = $this->db->prepare("insert into grupo (descripcion, iddestino) values(:p1,:p2)");
        $stmt->bindParam(':p1', $_P['descripcion'] , PDO::PARAM_STR);
        $stmt->bindParam(':p2', $_P['iddestino'] , PDO::PARAM_STR);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    function update($_P ) {
        $stmt = $this->db->prepare("update grupo set descripcion = :p1, iddestino = :p2 where idgrupo = :idgrupo");
        $stmt->bindParam(':p1', $_P['descripcion'] , PDO::PARAM_STR);
        $stmt->bindParam(':p2', $_P['iddestino'] , PDO::PARAM_STR);
        $stmt->bindParam(':idgrupo', $_P['idgrupo'] , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    function delete($_P ) {
        $stmt = $this->db->prepare("DELETE FROM grupo WHERE idgrupo = :p1");
        $stmt->bindParam(':p1', $_P , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
}
?>