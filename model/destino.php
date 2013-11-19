<?php
include_once("Main.php");
class destino extends Main
{
   function index($query , $p ) {
        $sql = "select iddestino,
                       descripcion
                       from destino  where descripcion like :query and iddestino<>0
                       order by iddestino asc";
        $param = array(array('key'=>':query' , 'value'=>"%$query%" , 'type'=>'STR' ));
        $data['total'] = $this->getTotal( $sql, $param );
        $data['rows'] =  $this->getRow($sql, $param , $p );
        $data['rowspag'] =  $this->getRowPag($data['total'], $p );
        return $data;
    }
    function edit($id ) {
        $stmt = $this->db->prepare("SELECT * FROM destino WHERE iddestino = :id");
        $stmt->bindParam(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchObject();
    }
    function insert($_P ) {
        $stmt = $this->db->prepare("insert into destino (descripcion) values(:p1)");
        $stmt->bindParam(':p1', $_P['descripcion'] , PDO::PARAM_STR);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    function update($_P ) {
        $stmt = $this->db->prepare("update destino set descripcion = :p1 where iddestino = :iddestino");
        $stmt->bindParam(':p1', $_P['descripcion'] , PDO::PARAM_STR);
        $stmt->bindParam(':iddestino', $_P['iddestino'] , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    function delete($_P ) {
        $stmt = $this->db->prepare("DELETE FROM destino WHERE iddestino = :p1");
        $stmt->bindParam(':p1', $_P , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    /*
        # Funciones extras #
    */
    #Funcion que obtiene todos los destinos ecepto el destino de la session (idsucursal)
    function getDDestinos()
    {
        $sql = "SELECT iddestino, descripcion 
                from destino where iddestino <> ".$_SESSION['idsucursal']."
                order by descripcion";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $data = array();
        foreach($stmt->fetchAll() as $row)
        {
            $data[] = array($row[0],$row[1]);                                
        }
        return $data;        
    }
}
?>