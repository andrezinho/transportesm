<?php
include_once("Main.php");
class caja_banco extends Main
{
   function index($query , $p ) {
        $sql = "select c.idcaja_banco,
                        c.fecha,
                        case c.tipo when 1 then 'DEPOSITO' else 'RETIRO' end,
                        c.monto,
                        o.descripcion,
                        concat('<p style=\"font-size:9px; font-style:italic; text-transform:uppercase\">',c.observacion,'</p>'),
                        case c.estado when 1 then 'REGISTRADO' else 'ANULADO' END,
                        case c.estado when 1 then                        
                            concat('<a class=\"anular box-boton boton-anular\" id=\"e-',c.idcaja_banco,'\" href=\"#\" title=\"Anular\" ></a>')                        
                        else '&nbsp;'
                        end
                 from caja_banco as c inner join oficina as o on o.idoficina = c.idoficina
                 where cast(fecha as char) like :query and c.idoficina = ".$_SESSION['idoficina']."
                 order by idcaja_banco desc";
        $param = array(array('key'=>':query' , 'value'=>"%$query%" , 'type'=>'STR' ));
        $data['total'] = $this->getTotal( $sql, $param );
        $data['rows'] =  $this->getRow($sql, $param , $p );
        $data['rowspag'] =  $this->getRowPag($data['total'], $p );
        return $data;
    }
    function edit($id ) {
        $stmt = $this->db->prepare("SELECT * FROM caja_banco WHERE idcaja_banco = :id");
        $stmt->bindParam(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchObject();
    }
    function insert($_P ) 
    {
        $total = 0;        
        //Obtenemos el total de caja
        $stmt = $this->db->prepare("SELECT total from caja_banco where  estado = 1 
                                    order by idcaja_banco desc limit 1");
        $stmt->execute();
        $r = $stmt->fetchObject();
        $total = (float)$r->total;
        
        if($_P['tipo']==1)
            $total += $_P['monto'];
        else
            $total -= $_P['monto'];
        
        $fecha = $this->fdate($_P['fecha'], 'EN');
        $stmt = $this->db->prepare("insert into caja_banco (idoficina,fecha,tipo,monto,total,idusuario,observacion) 
                                    values(:p1,:p2,:p3,:p4,:p5,:p6,:p7)");
        $stmt->bindParam(':p1', $_SESSION['idoficina'] , PDO::PARAM_INT);
        $stmt->bindParam(':p2', $fecha , PDO::PARAM_STR);
        $stmt->bindParam(':p3', $_P['tipo'] , PDO::PARAM_INT);
        $stmt->bindParam(':p4', $_P['monto'] , PDO::PARAM_INT);
        $stmt->bindParam(':p5', $total , PDO::PARAM_INT);
        $stmt->bindParam(':p6', $_SESSION['idempleado'] , PDO::PARAM_STR);
        $stmt->bindParam(':p7', $_P['observacion'] , PDO::PARAM_STR);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }   
    function dep_caja($_P ) 
    {
        
        //falta validar que el monto a depositar no sea mayor al monto total en caja
        
        $total = 0;
        //Obtenemos el total de caja
        $stmt = $this->db->prepare("SELECT total from caja_banco where  estado = 1 
                                    order by idcaja_banco desc limit 1");
        $stmt->execute();
        $r = $stmt->fetchObject();
        $total = (float)$r->total;
        
        $_P['tipo']=1;
        
        $total += $_P['monto'];
        $obs = "POR EL CIERRE DE CAJA ".$_P['idc'];
        $fecha = date('Y-m-d');
        $stmt = $this->db->prepare("insert into caja_banco (idoficina,fecha,tipo,monto,total,idusuario,observacion) 
                                    values(:p1,:p2,:p3,:p4,:p5,:p6,:p7)");
        $stmt->bindParam(':p1', $_SESSION['idof'] , PDO::PARAM_INT);
        $stmt->bindParam(':p2', $fecha , PDO::PARAM_STR);
        $stmt->bindParam(':p3', $_P['tipo'] , PDO::PARAM_INT);
        $stmt->bindParam(':p4', $_P['monto'] , PDO::PARAM_INT);
        $stmt->bindParam(':p5', $total , PDO::PARAM_INT);
        $stmt->bindParam(':p6', $_SESSION['idem'] , PDO::PARAM_STR);
        $stmt->bindParam(':p7', $obs , PDO::PARAM_STR);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        
        
        //actualizamos caja
        $s = $this->db->prepare("UPDATE caja set deposito = 1 where idcaja = ".$_P['idc']);
        $s->execute();
        
        
        return array("1" , $p2[2]);
    }   
    function anular($_P ) 
    {
        $stmt = $this->db->prepare("SELECT monto,tipo from caja_banco 
                                    where idcaja_banco = ".$_P);        
        $stmt->execute();
        $r = $stmt->fetchObject();
        $monto = $r->monto;
        $tipo = $r->tipo;
        
        //Obtenemos el total de caja
        $stmt = $this->db->prepare("SELECT total from caja_banco where  estado = 1 
                                    order by idcaja_banco desc limit 1");
        $stmt->execute();
        $r = $stmt->fetchObject();
        $total = (float)$r->total;
        
        if($tipo==1)
        {
            $total -= $_P['monto'];
            $tipo = 2;
        }
        else
        {
            $total += $_P['monto'];
            $tipo=1;
        }
        
        $fecha = date('Y-m-d');
        $obs = "POR ANULACION DEL MOVIMIENTO ".$_P;
        $stmt = $this->db->prepare("insert into caja_banco (idoficina,fecha,tipo,monto,total,idusuario,observacion) 
                                    values(:p1,:p2,:p3,:p4,:p5,:p6,:p7)");
        $stmt->bindParam(':p1', $_SESSION['idoficina'] , PDO::PARAM_INT);
        $stmt->bindParam(':p2', $fecha , PDO::PARAM_STR);
        $stmt->bindParam(':p3', $tipo , PDO::PARAM_INT);
        $stmt->bindParam(':p4', $monto , PDO::PARAM_INT);
        $stmt->bindParam(':p5', $total , PDO::PARAM_INT);
        $stmt->bindParam(':p6', $_SESSION['idempleado'] , PDO::PARAM_STR);
        $stmt->bindParam(':p7', $obs , PDO::PARAM_STR);
        $stmt->execute();
        
        $stmt = $this->db->prepare("UPDATE caja_banco set estado = 0 WHERE idcaja_banco = :p1");
        $stmt->bindParam(':p1', $_P , PDO::PARAM_INT);        
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }

}
?>