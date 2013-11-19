<?php
include_once("Main.php");
class periodo extends Main
{
   function index($query , $p ) {
        $sql = "select idperiodo,
                       concat(cast(anio as char),'-',cast(mes as char)),
                       case estado when 1 then '<a href=\"javascript:\" style=\"color:green\" >ACTIVO</a>' 
                                else concat('<a href=\"javascript:\" id=\"',idperiodo,'\" style=\"color:red\" class=\"activar\">ACTIVAR</a>') end
                from periodo  
                where concat(cast(anio as char),'-',cast(mes as char)) like :query
                order by anio,mes desc";
        $param = array(array('key'=>':query' , 'value'=>"%$query%" , 'type'=>'STR' ));
        $data['total'] = $this->getTotal( $sql, $param );
        $data['rows'] =  $this->getRow($sql, $param , $p );
        $data['rowspag'] =  $this->getRowPag($data['total'], $p );
        return $data;
    }
    function getPeriodo()
    {
        $stmt = $this->db->prepare("SELECT idperiodo,anio,mes FROM periodo WHERE estado = 1");        
        $stmt->execute();
        return $stmt->fetchObject();
    }
    function change($id)
    {
        $stmt = $this->db->prepare("UPDATE periodo set estado = 0");
        $stmt->execute();
        $stmt = $this->db->prepare("UPDATE periodo set estado = 1 where idperiodo = :id");
        $stmt->bindParam(':id',$id,PDO::PARAM_INT);
        $stmt->execute();
        return $this->getPeriodo();
    }
    function edit($id ) 
    {
        $stmt = $this->db->prepare("SELECT * FROM periodo WHERE idperiodo = :id");
        $stmt->bindParam(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchObject();
    }
    function insert($_P ) {
        $stmt = $this->db->prepare("insert into periodo (descripcion, estado) values(:p1,:p2)");
        $stmt->bindParam(':p1', $_P['descripcion'] , PDO::PARAM_STR);
        $stmt->bindParam(':p2', $_P['activo'] , PDO::PARAM_BOOL);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    function update($_P ) {
        $stmt = $this->db->prepare("update periodo set descripcion = :p1, estado = :p2 where idperiodo = :idperiodo");
        $stmt->bindParam(':p1', $_P['descripcion'] , PDO::PARAM_STR);
        $stmt->bindParam(':p2', $_P['activo'] , PDO::PARAM_BOOL);
        $stmt->bindParam(':idperiodo', $_P['idperiodo'] , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    function delete($_P ) {
        $stmt = $this->db->prepare("DELETE FROM periodo WHERE idperiodo = :p1");
        $stmt->bindParam(':p1', $_P , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
}
?>