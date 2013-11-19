<?php
include_once("Main.php");
class agrupaciones extends Main
{
   function index($query , $p ) 
   {
        $sql = "select idagrupaciones,
                       descripcion,
                       case estado when true then 'ACTIVO' else 'INCANTIVO' end
                       from agrupaciones  where descripcion like :query
                       order by idagrupaciones asc";
        $param = array(array('key'=>':query' , 'value'=>"%$query%" , 'type'=>'STR' ));
        $data['total'] = $this->getTotal( $sql, $param );
        $data['rows'] =  $this->getRow($sql, $param , $p );
        $data['rowspag'] =  $this->getRowPag($data['total'], $p );
        return $data;
    }
    function getDetalle($g)
    {
        $stmt = $this->db->prepare("SELECT  a.idgrupo,
                                            concat(prop.nombre,' ',prop.apellidos),
                                            concat(chof.nombre,' ',chof.apellidos),
                                            v.placa,
                                            a.idagrupacion
                                    FROM    agrupaciones as a inner join empleado as prop on prop.idempleado = a.idpropietario and prop.idtipo_empleado = 3
                                            inner join empleado as chof on chof.idempleado = a.idchofer and chof.idtipo_empleado = 2
                                            inner join vehiculo as v on v.idvehiculo = a.idvehiculo
                                    WHERE a.idgrupo = :g");
        $stmt->bindParam(':g',$g,PDO::PARAM_INT);        
        $stmt->execute();
        return $stmt->fetchAll();
    }
    function edit($id ) 
    {
        $stmt = $this->db->prepare("SELECT * FROM agrupaciones WHERE idagrupaciones = :id");
        $stmt->bindParam(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchObject();
    }
    function insert($_P ) {
        
        //Verificar si el chofer ya fue agregado al grupo enviado
        $stmt = $this->db->prepare("select count(*) from agrupaciones where idchofer = :p1 and idgrupo = :p2");
        $stmt->bindParam(':p1',$_P['idchofer'],PDO::PARAM_STR);
        $stmt->bindParam(':p2',$_P['idgrupo'],PDO::PARAM_INT);
        $stmt->execute();
        $r = $stmt->fetchAll();
        $n = $r[0][0];
        
        if($n==0)
        {
            //Verificar si está en el mismo destino en algun otra agrupacion
            $stmt = $this->db->prepare("select verif_grupo(:p1,:p2)");
            $stmt->bindParam(':p1',$_P['idchofer'],PDO::PARAM_STR);
            $stmt->bindParam(':p2',$_P['idgrupo'],PDO::PARAM_INT);
            $stmt->execute();
            $r = $stmt->fetchAll();
            $n = $r[0][0];
            if($n==0)
            {
                //Apto para ser agregado al grupo
                $stmt = $this->db->prepare("insert into agrupaciones (idgrupo,idpropietario,idchofer,idvehiculo) 
                                            values(:p1,:p2,:p3,:p4);");
                $stmt->bindParam(':p1', $_P['idgrupo'] , PDO::PARAM_INT);
                $stmt->bindParam(':p2', $_P['idpropietario'] , PDO::PARAM_STR);
                $stmt->bindParam(':p3', $_P['idchofer'] , PDO::PARAM_STR);
                $stmt->bindParam(':p4', $_P['idvehiculo'] , PDO::PARAM_INT);
                $p1 = $stmt->execute();
                $p2 = $stmt->errorInfo();            
                return array($p1 , $p2[2]);
            }
            else 
            {
                return array(2,'ESTE CHOFER YA ESTA ASIGNADO A UN MISMO DESTINO');
            }
        }        
        else 
        {
            return array(2,'ESTE CHOFER YA ESTA AGREGADO A ESTE GRUPO');
        }
    }

    function quit($_P ) {
        $stmt = $this->db->prepare("DELETE FROM agrupaciones WHERE idagrupacion = :p1");
        $stmt->bindParam(':p1', $_P , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
}
?>