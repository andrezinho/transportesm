<?php
include_once("Main.php");
class itinerario extends Main
{
   function index($query , $p, $c ) {
        $sql = "SELECT i.iditinerario,
                       o.descripcion as origen,
                       d.descripcion as destino,
                       i.precio,
                       i.precio_ticket
                       from itinerario as i inner join destino as d on d.iddestino = i.destino
                            inner join destino as o on o.iddestino = i.origen
                       where {$c} like :query and i.iditinerario <> 0
                       order by iditinerario asc";
        $param = array(array('key'=>':query' , 'value'=>"%$query%" , 'type'=>'STR' ));
        $data['total'] = $this->getTotal( $sql, $param );
        $data['rows'] =  $this->getRow($sql, $param , $p );
        $data['rowspag'] =  $this->getRowPag($data['total'], $p );
        return $data;
    }
    function edit($id ) {
        $stmt = $this->db->prepare("SELECT * FROM itinerario WHERE iditinerario = :id");
        $stmt->bindParam(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchObject();
    }
    function insert($_P ) {
        $stmt = $this->db->prepare("INSERT into itinerario (origen,destino, precio, precio_ticket,precio_encomienda) 
                                    values(:p1,:p2,:p3,:p4)");
        $stmt->bindParam(':p1', $_P['idorigen'] , PDO::PARAM_INT);
        $stmt->bindParam(':p2', $_P['iddestino'] , PDO::PARAM_INT);
        $stmt->bindParam(':p3', $_P['precio'] , PDO::PARAM_INT);
        $stmt->bindParam(':p4', $_P['precio_ticket'] , PDO::PARAM_INT);
        $stmt->bindParam(':p5', $_P['precio_encomienda'] , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    function update($_P ) {
        $stmt = $this->db->prepare("UPDATE itinerario set origen = :p1, 
                                                        destino = :p2, 
                                                        precio = :p3,
                                                        precio_ticket = :p4,
                                                        precio_encomienda = :p5
                                    where iditinerario = :iditinerario");
        $stmt->bindParam(':p1', $_P['idorigen'] , PDO::PARAM_INT);
        $stmt->bindParam(':p2', $_P['iddestino'] , PDO::PARAM_INT);
        $stmt->bindParam(':p3', $_P['precio'] , PDO::PARAM_INT);
        $stmt->bindParam(':p4', $_P['precio_ticket'] , PDO::PARAM_INT);
        $stmt->bindParam(':p5', $_P['precio_encomienda'] , PDO::PARAM_INT);
        $stmt->bindParam(':iditinerario', $_P['iditinerario'] , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    function delete($_P ) 
    {
        $stmt = $this->db->prepare("DELETE FROM itinerario WHERE iditinerario = :p1");
        $stmt->bindParam(':p1', $_P , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    function getPricet($idd)
    {

        $stmt = $this->db->prepare("SELECT precio_ticket 
                                    from itinerario 
                                    where destino = :p1 and origen = ".$_SESSION['idsucursal']);
        $stmt->bindParam(':p1', $idd , PDO::PARAM_INT);
        $stmt->execute();
        $r = $stmt->fetchObject();
        $price = 0;
        if($r->precio_ticket>0){$price=$r->precio_ticket;}
        return $price;
    }
    function getPricetEncomienda($idd)
    {
        $stmt = $this->db->prepare("SELECT precio_encomienda
                                    from itinerario 
                                    where destino = :p1 and origen = ".$_SESSION['idsucursal']);
        $stmt->bindParam(':p1', $idd , PDO::PARAM_INT);
        $stmt->execute();
        $r = $stmt->fetchObject();
        $price = 0;
        if($r->precio_encomienda>0){$price=$r->precio_encomienda;}
        return $price;
    }
    function getItinerariosDif()
    {
        $stmt = $this->db->prepare("SELECT i.iditinerario AS iditinerario, 
                                           CONCAT( o.descripcion,  ' - ', d.descripcion,  ' (', i.precio,  ')') 
                                    FROM                                     
                                        itinerario i
                                        JOIN destino d ON 
                                        d.iddestino = i.destino
                                    JOIN destino o ON 
                                    o.iddestino = i.origen
                                    where i.origen = ".$_SESSION['idsucursal']);                
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