<?php
include_once("Main.php");
class articulo extends Main
{
   function index($query , $p ,$c) 
   {
        $sql = "select a.idarticulo,
                       a.descripcion,                       
                       u.abreviado,
                       a.stock,
                       a.precio,
                       CASE a.estado WHEN 1 THEN '<p style=\"color:green\">ACTIVO</p>' ELSE '<p style=\"color:red\">INACTIVO</p>' END
                       from articulo as a inner join unidad as u on a.idunidad = u.idunidad
                       where {$c} like :query
                       order by a.idarticulo asc ";
        
        $param = array(array('key'=>':query' , 'value'=>"%$query%" , 'type'=>'STR' ));
        $data['total'] = $this->getTotal( $sql, $param );
        $data['rows'] =  $this->getRow($sql, $param , $p );
        $data['rowspag'] =  $this->getRowPag($data['total'], $p );
        return $data;
    }
    function edit($id ) {
        $stmt = $this->db->prepare("SELECT * FROM articulo WHERE idarticulo = :id");
        $stmt->bindParam(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchObject();
    }
    function insert($_P ) 
    {
        $stmt = $this->db->prepare("insert into articulo (idunidad, descripcion, stock, stock_minimo, precio, estado) 
                                    values(:p1,:p2,:p3,:p4,:p5,:p6)");
        $stmt->bindParam(':p1', $_P['idunidad'] , PDO::PARAM_INT);
        $stmt->bindParam(':p2', $_P['descripcion'] , PDO::PARAM_STR);
        $stmt->bindParam(':p3', $_P['stock'] , PDO::PARAM_INT);
        $stmt->bindParam(':p4', $_P['stock_minimo'] , PDO::PARAM_INT);
        $stmt->bindParam(':p5', $_P['precio'] , PDO::PARAM_INT);
        $stmt->bindParam(':p6', $_P['activo'] , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    function update($_P ) 
    {
        $stmt = $this->db->prepare("update articulo set idunidad = :p1,
                                                        descripcion = :p2,                                                         
                                                        stock = :p3,
                                                        stock_minimo = :p4,
                                                        precio = :p5,
                                                        estado = :p6
                                     where idarticulo = :idarticulo");
        $stmt->bindParam(':p1', $_P['idunidad'] , PDO::PARAM_INT);
        $stmt->bindParam(':p2', $_P['descripcion'] , PDO::PARAM_STR);
        $stmt->bindParam(':p3', $_P['stock'] , PDO::PARAM_INT);
        $stmt->bindParam(':p4', $_P['stock_minimo'] , PDO::PARAM_INT);
        $stmt->bindParam(':p5', $_P['precio'] , PDO::PARAM_INT);
        $stmt->bindParam(':p6', $_P['activo'] , PDO::PARAM_INT);
        $stmt->bindParam(':idarticulo', $_P['idarticulo'] , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    function delete($_P ) {
//        $stmt = $this->db->prepare("DELETE FROM articulo WHERE idarticulo = :p1");
//        $stmt->bindParam(':p1', $_P , PDO::PARAM_INT);
//        $p1 = $stmt->execute();
//        $p2 = $stmt->errorInfo();
//        return array($p1 , $p2[2]);
    }
    function getarticulos($query)
    {
        $query = "%".$query."%";
        $statement = $this->db->prepare("SELECT a.idarticulo,a.descripcion,a.precio,a.stock,u.abreviado as unidad 
                                        FROM articulo  as a
                                        inner join unidad as u on a.idunidad = u.idunidad 
                                        WHERE cast(a.idarticulo as char) like :query");
        $statement->bindParam (":query", $query , PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetchAll();
    }
}
?>