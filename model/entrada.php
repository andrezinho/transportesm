<?php
include_once("Main.php");
class entrada extends Main
{    
    protected $tipo_documento = 4;    
    function index($query,$p,$c) 
    {
        $sql = "SELECT s.idsalida,
                       concat(substring(s.fecha_sal,9,2),'/',substring(s.fecha_sal,6,2),'/',substring(s.fecha_sal,1,4)),
                       SUBSTRING(s.hora_sal,1,5),
                       concat(chofer.nombre,' ',chofer.apellidos),
                       v.placa,    
                       do.descripcion,
                       concat(s.serie,' ',s.numero),     
                       case s.tipo when 0 then 'I' else 'I&V' end,
                       case s.estado WHEN 3 THEN 'EN CURSO'
                                     WHEN 4 then 'CONCLUIDO'
                            end as estado,
                        e.login,
                        case s.estado when 3 then 
                        concat('<a class=\"confirm box-boton boton-hand\" id=\"cf-',s.idsalida,'\" href=\"#\" title=\"Confirmar Llegada\"></a>')
                        when 4 then SUBSTRING(s.hora_llegada,1,5)
                        else '&nbsp;' end                        
                FROM salida as s inner join empleado as chofer on chofer.idempleado = s.idchofer
                        inner join vehiculo as v on v.idvehiculo = s.idvehiculo
                        inner join destino as d on d.iddestino = s.iddestino
                        inner join empleado as e on e.idempleado = s.idempleado and e.idtipo_empleado=1
                        inner join oficina as o on s.idoficina = o.idoficina 
                        inner join destino as do on do.iddestino = o.idsucursal ";
                        
                switch ($c) 
                {
                    case 1: $c="s.numero";break;
                    case 2: $c="concat(chofer.nombre,' ',chofer.apellidos)";break;
                    case 3: $c="v.placa";break;                   
                    default:break;
                } 

               $sql .= " where ".$c." like :query 
                        and chofer.idtipo_empleado = 2 
                        and s.iddestino = ".$_SESSION['idsucursal']."
                        and (s.estado = 3 or s.estado = 4)
                order by s.idsalida desc ";

        $param = array(array('key'=>':query' , 'value'=>"%$query%" , 'type'=>'STR' ));
        $data['total'] = $this->getTotal( $sql, $param );
        $data['rows'] =  $this->getRow($sql, $param , $p );        
        $data['rowspag'] =  $this->getRowPag($data['total'], $p );        
        return $data;
    }    
    function llegada($id)
    {
        $estado = 4;
        $hora = date('h:i:s');
        $fecha = date('Y-m-d');          
        try 
        { 
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->beginTransaction();
 
            //Recuperamos los datos la salida
            $sql = "SELECT s.*,o.idsucursal as origen from salida as s inner join oficina as o on o.idoficina = s.idoficina
                    where idsalida = :id";
            $stmt2 = $this->db->prepare($sql);
            $stmt2->bindParam('id',$id,PDO::PARAM_INT);
            $stmt2->execute();
            $row  = $stmt2->fetchObject();

            //Si el ticket es de ida y vuelta 
            //Hacemos la apertura de un nuevo ticket pero con el mismo correlativo
            //este no afectará la caja y no creará nuevo movimiento
            if($row->tipo==1)
            {

                $sql = "INSERT INTO salida
                    (idtipo_documento,
                    idchofer,
                    idvehiculo,
                    numero,
                    serie,
                    fecha,
                    hora,
                    monto,
                    estado,
                    idempleado,
                    idoficina,
                    idperiodo,
                    num_mov,
                    iddestino,
                    tipo)
                    VALUES
                    (
                    ".$row->idtipo_documento.",
                    '".$row->idchofer."',
                    ".$row->idvehiculo.",
                    '".$row->numero."',
                    '".$row->serie."',
                    '".$fecha."',
                    '".$hora."',
                    0,
                    2,
                    '".$_SESSION['idempleado']."',
                    ".$_SESSION['idoficina'].",
                    ".$_SESSION['idempleado'].",
                    '".$row->num_mov."',
                    ".$row->origen.",
                    0
                    )";
                
                $estado = 5;                
                $stmt2 = $this->db->prepare($sql);                
                $stmt2->execute();
            }
            else 
            {
                //Verificamos si hay mas de dos registro con este numero de ticket
                //para obtener el id del primero registro y actualizar su estado a concluido
                $stmt = $this->db->prepare("SELECT idsalida from salida where idsalida <> :id and num_mov = '".$row->num_mov."'");
                $stmt->bindParam(':id',$id,PDO::PARAM_INT);
                $stmt->execute();
                $r = $stmt->fetchObject();
                $n = $stmt->rowCount();
                if($n==1)
                {
                    $stmt1 = $this->db->prepare("UPDATE salida set estado = 4 WHERE idsalida = ".$r->idsalida);
                    $stmt1->execute();                    
                }

            }
            $stmt = $this->db->prepare("UPDATE salida set estado = ".$estado.", fecha_llegada = :fs, hora_llegada = :hs 
                                    where idsalida = :id ");
            $stmt->bindParam(':id',$id,PDO::PARAM_INT);
            $stmt->bindParam(':fs',$fecha,PDO::PARAM_STR);
            $stmt->bindParam(':hs',$hora,PDO::PARAM_STR);                
            $stmt->execute();
            $this->db->commit();
            return array('res'=>'1','msg'=>$hora);
        }
        catch(PDOException $e) 
        {
            $this->db->rollBack();
            return array('res'=>'2','msg'=>'Error : '.$e->getMessage() . $str);
        }
    }
}
?>