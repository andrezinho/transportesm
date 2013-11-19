<?php
include_once("Main.php");
class Modulo extends Main{    
    function index($query,$p,$c) 
    {        
        $sql = "select m.idmodulo,
                       m.descripcion,
                       mm.descripcion,
                       m.url,
                       m.controlador,
                       m.accion,
                       case m.estado when true then 'ACTIVO' else 'INCANTIVO' end,
                       m.orden
                from modulo as m left outer join modulo as mm on mm.idmodulo=m.idpadre
                where ".$c." like :query
                order by m.idmodulo"; 
        
        $param = array(array('key'=>':query' , 'value'=>"%$query%" , 'type'=>'STR' ));
        $data['total'] = $this->getTotal( $sql, $param );
        $data['rows'] =  $this->getRow($sql, $param , $p );        
        $data['rowspag'] =  $this->getRowPag($data['total'], $p );        
        return $data;
    }
    function edit($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM modulo WHERE idmodulo = :id");
        $stmt->bindParam(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchObject();
    }
    function insert($_P ) 
    {
        $stmt = $this->db->prepare("insert into modulo(idpadre,descripcion,url,estado,orden,controlador,accion,attrid,attrclass)
                                    values(:p1,:p2,:p3,:p5,:p6,:p7,:p8,:p9,:p10)");
        if($_P['idpadre']==""){$_P['idpadre']=null;}
        
        $stmt->bindParam(':p1', $_P['idpadre'] , PDO::PARAM_INT);
        $stmt->bindParam(':p2', $_P['descripcion'] , PDO::PARAM_STR);
        $stmt->bindParam(':p3', $_P['url'] , PDO::PARAM_STR);        
        $stmt->bindParam(':p5', $_P['activo'] , PDO::PARAM_BOOL);
        $stmt->bindParam(':p6', $_P['orden'] , PDO::PARAM_INT);
        $stmt->bindParam(':p7', $_P['controlador'] , PDO::PARAM_STR);
        $stmt->bindParam(':p8', $_P['accion'] , PDO::PARAM_STR);
        $stmt->bindParam(':p9', $_P['attrid'] , PDO::PARAM_STR);
        $stmt->bindParam(':p10', $_P['attrclass'] , PDO::PARAM_STR);
        
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        
        return array($p1 , $p2[2]);
        
    }
    function update($_P ) 
    {
        $sql = "update modulo set  idpadre=:p1,
                                   descripcion=:p2,
                                   url=:p3,
                                   estado=:p5,
                                   orden=:p6,
                                   controlador=:p7,
                                   accion=:p8,
                                   attrid=:p9,
                                   attrclass=:p10
                       where idmodulo = :idmodulo";
        $stmt = $this->db->prepare($sql);
        if($_P['idpadre']==""){$_P['idpadre']=null;}        
            $stmt->bindParam(':p1', $_P['idpadre'] , PDO::PARAM_INT);
            $stmt->bindParam(':p2', $_P['descripcion'] , PDO::PARAM_STR);
            $stmt->bindParam(':p3', $_P['url'] , PDO::PARAM_STR);
            $stmt->bindParam(':p5', $_P['activo'] , PDO::PARAM_BOOL);
            $stmt->bindParam(':p6', $_P['orden'] , PDO::PARAM_INT);
            $stmt->bindParam(':idmodulo', $_P['idmodulo'] , PDO::PARAM_INT);
            $stmt->bindParam(':p7', $_P['controlador'] , PDO::PARAM_STR);
            $stmt->bindParam(':p8', $_P['accion'] , PDO::PARAM_STR);   
            $stmt->bindParam(':p9', $_P['attrid'] , PDO::PARAM_STR);
        $stmt->bindParam(':p10', $_P['attrclass'] , PDO::PARAM_STR);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    function delete($p) 
    {
        $stmt = $this->db->prepare("DELETE FROM modulo WHERE idmodulo = :p1");
        $stmt->bindParam(':p1', $p, PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
}
?>