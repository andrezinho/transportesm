<?php
include_once("Main.php");
class oficina extends Main
{
   function index($query , $p, $c ) 
   {
        $sql = "SELECT o.idoficina,
                       o.descripcion,                       
                       s.descripcion,
                       case o.caja when 0 then 'No' else 'Si' end
                       from oficina as o inner join destino as s on o.idsucursal = s.iddestino                       
                       where {$c} like :query
                       order by o.idoficina asc";
        $param = array(array('key'=>':query' , 'value'=>"%$query%" , 'type'=>'STR' ));
        $data['total'] = $this->getTotal( $sql, $param );
        $data['rows'] =  $this->getRow($sql, $param , $p );
        $data['rowspag'] =  $this->getRowPag($data['total'], $p );
        return $data;
    }
    function edit($id ) 
    {
        $stmt = $this->db->prepare("SELECT * FROM oficina WHERE idoficina = :id");
        $stmt->bindParam(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchObject();
    }
    function insert($_P ) 
    {
        $caja = 0;
        if(isset($_P['caja']))
        {
            $caja = 1;
        }
        $v = $this->Validar($_P);
        if($v[0])
        {
            $stmt = $this->db->prepare("INSERT into oficina (descripcion, idsucursal, direccion, telefono, caja) 
                                        values(:p1,:p2,:p3,:p4,:p5)");
            $stmt->bindParam(':p1', $_P['descripcion'] , PDO::PARAM_STR);
            $stmt->bindParam(':p2', $_P['idsucursal'] , PDO::PARAM_INT);
            $stmt->bindParam(':p3', $_P['direccion'] , PDO::PARAM_STR);
            $stmt->bindParam(':p4', $_P['telefono'] , PDO::PARAM_STR);
            $stmt->bindParam(':p5', $caja , PDO::PARAM_INT);
            $p1 = $stmt->execute();
            $p2 = $stmt->errorInfo();
            return array($p1 , $p2[2]);
        }
        else 
        {
            return array(false,$v[1]);
        }
    }
    function update($_P ) 
    {    
        $caja = 0;
        if(isset($_P['caja']))
        {
            $caja = 1;
        }
        $v = $this->Validar($_P);
        if($v[0])
        {
            $stmt = $this->db->prepare("UPDATE oficina set descripcion = :p1, idsucursal = :p2, direccion=:p3, telefono=:p4 , caja = :p5 where idoficina = :idoficina");
            $stmt->bindParam(':p1', $_P['descripcion'] , PDO::PARAM_STR);
            $stmt->bindParam(':p2', $_P['idsucursal'] , PDO::PARAM_INT);
            $stmt->bindParam(':p3', $_P['direccion'] , PDO::PARAM_STR);
            $stmt->bindParam(':p4', $_P['telefono'] , PDO::PARAM_STR);        
            $stmt->bindParam(':idoficina', $_P['idoficina'] , PDO::PARAM_INT);
            $stmt->bindParam(':p5', $caja , PDO::PARAM_INT);
            $p1 = $stmt->execute();
            $p2 = $stmt->errorInfo();
            return array($p1 , $p2[2]);
        }
        else 
        {
            return array(false,$v[1]);
        }
    }
    function delete($_P ) {
        $stmt = $this->db->prepare("DELETE FROM oficina WHERE idoficina = :p1");
        $stmt->bindParam(':p1', $_P , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    function validar($_P)
    {
        $bval = true;
        $msg = "";
        if($this->isText($_P['descripcion'])=="")
        {
            $bval = false;
            $msg = "Ingrese la descripcion";            
            return array($bval,$msg);
        }
        if($this->isNum($_P['idsucursal'])=="")
        {
            $bval = false;
            $msg = "Seleccione un Sucursal";
            return array($bval,$msg);
        }
        return array($bval,"");
    }
}
?>