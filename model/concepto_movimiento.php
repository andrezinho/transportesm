<?php
include_once("Main.php");
class concepto_movimiento extends Main
{
   function index($query , $p ) {
        $sql = "select cm.idconcepto_movimiento,
                       cm.descripcion,
                       tc.descripcion
                       from concepto_movimiento as cm inner join tipo_concepto as tc on 
                       cm.idtipo_concepto = tc.idtipo_concepto 
                       where cm.descripcion like :query
                            AND cm.idconcepto_movimiento <> 5 and cm.idconcepto_movimiento <> 6 
                       order by cm.idconcepto_movimiento asc";
        $param = array(array('key'=>':query' , 'value'=>"%$query%" , 'type'=>'STR' ));
        $data['total'] = $this->getTotal( $sql, $param );
        $data['rows'] =  $this->getRow($sql, $param , $p );
        $data['rowspag'] =  $this->getRowPag($data['total'], $p );
        return $data;
    }
    function edit($id ) {
        $stmt = $this->db->prepare("SELECT * FROM concepto_movimiento WHERE idconcepto_movimiento = :id");
        $stmt->bindParam(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchObject();
    }
    function insert($_P ) {
        $stmt = $this->db->prepare("insert into concepto_movimiento (idtipo_concepto, descripcion) values(:p1, :p2)");
        $stmt->bindParam(':p1', $_P['idtipo_concepto'] , PDO::PARAM_INT);
        $stmt->bindParam(':p2', $_P['descripcion'] , PDO::PARAM_STR);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    function update($_P ) {
        $stmt = $this->db->prepare("update concepto_movimiento set idtipo_concepto = :p1, descripcion = :p2 where idconcepto_movimiento = :idconcepto_movimiento");
        $stmt->bindParam(':p1', $_P['tipo'] , PDO::PARAM_INT);
        $stmt->bindParam(':p2', $_P['descripcion'] , PDO::PARAM_STR);
        $stmt->bindParam(':idconcepto_movimiento', $_P['idconcepto_movimiento'] , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    function delete($_P ) {
        $stmt = $this->db->prepare("DELETE FROM concepto_movimiento WHERE idconcepto_movimiento = :p1");
        $stmt->bindParam(':p1', $_P , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    function getconceptoi($query,$field)
    {
        $query = "%".$query."%";
        $statement = $this->db->prepare("SELECT idconcepto_movimiento, 
                                                descripcion                                                
                                         FROM concepto_movimiento
                                         WHERE cast({$field} as nchar) like :query and idtipo_concepto = 1
                                         limit 10");
        $statement->bindParam (":query", $query , PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetchAll();
    }
    function getconceptoe($query,$field)
    {
        $query = "%".$query."%";
        $statement = $this->db->prepare("SELECT idconcepto_movimiento, 
                                                descripcion                                                
                                         FROM concepto_movimiento
                                         WHERE cast({$field} as nchar) like :query and idtipo_concepto = 2
                                         limit 10");
        $statement->bindParam (":query", $query , PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetchAll();
    }
    
}
?>