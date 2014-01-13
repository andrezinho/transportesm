<?php
include_once("Main.php");
class ingresos extends Main
{
   protected $tipo_documento = 6;
   function index($query , $p ) 
   {
       
        $sql = "SELECT  distinct 
                        m.idmovimiento,
                        case tipo_ingreso when 1 then concat(coalesce(e.nombre,' '),' ',coalesce(e.apellidos,' '))
                                            else 
                                                case pro.ruc 
                                                when '00000000' then m.recibi 
                                                else pro.razonsocial  end                                                
                                            end as remitente,
                        m.chofer,
                        m.fecha,                        
                        m.observacion,
                        case m.estado when 1 then 'ACTIVO'                                      
                                    when 0 then 'ANULADO'
                            end as estado,
                        case m.tipo_ingreso when 1 then 'POR PAPELETA' else 'COMUN' end,
                        users.login,
                        case m.estado when 1 then 
                        case users.idempleado when ".$_SESSION['idempleado']." then 
                                        concat('<a class=\"anular box-boton boton-anular\" id=\"m-',m.idmovimiento,'\" href=\"#\" title=\"Anular\"></a>')
                                        else 
                                                case ".$_SESSION['id_perfil']." when 1 then 
                                                concat('<a class=\"anular box-boton boton-anular\" id=\"m-',m.idmovimiento,'\" href=\"#\" title=\"Anular\"></a>')
                                                else '&nbsp;'
                                                end
                                        end
                        else '&nbsp;'
                    end,
                    case m.estado when 0 then '&nbsp;'
                    else 
                    concat('<a target=\"_blank\" href=\"index.php?controller=ingresos&action=printer&iv=',m.idmovimiento,'\" title=\"Imprimir\" class=\"box-boton boton-print\" ></a>')
                    end
                from movimiento as m                 
                inner join empleado as users on users.idempleado = m.idempleado
                left outer join empleado as e on e.idempleado = m.idpropietario  and e.idtipo_empleado = 3
                left outer join proveedor as pro on pro.idproveedor = m.idproveedor
                where case tipo_ingreso when 1 then concat(coalesce(e.nombre,' '),' ',coalesce(e.apellidos,' '))
                            else pro.razonsocial end like :query and  m.idoficina = ".$_SESSION['idoficina']." and m.tipo=1 and users.idtipo_empleado = 1
                    and 
                    case tipo_ingreso when 1 then concat(coalesce(e.nombre,' '),' ',coalesce(e.apellidos,' '))
                            else pro.razonsocial end <> ''
                    and m.serie is not null
                order by idmovimiento desc";
        //echo $sql;
        $param = array(array('key'=>':query' , 'value'=>"%$query%" , 'type'=>'STR' ));
        $data['total'] = $this->getTotal( $sql, $param );
        $data['rows'] =  $this->getRow($sql, $param , $p );
        $data['rowspag'] =  $this->getRowPag($data['total'], $p );
        unset($_SESSION['conceptos']);
        return $data;
    }
    function edit($id ) {
        
        $stmt = $this->db->prepare("SELECT distinct m.*,
                                           e.idempleado,
                                           concat(coalesce(e.nombre,' '),' ',coalesce(e.apellidos,' ')) as nombre,                                           
                                           m.placa,
                                           case pro.ruc 
                                                when '00000000' then m.recibi 
                                                else pro.razonsocial  end as razonsocial,
                                           pro.ruc,
                                           pro.idproveedor
                                    from movimiento as m 
                                    inner join empleado as users on users.idempleado = m.idempleado
                                    left outer join proveedor as pro on pro.idproveedor = m.idproveedor
                                    left outer join empleado as e on e.idempleado = m.idpropietario  and e.idtipo_empleado = 3                                    
                                    where m.idmovimiento = :id ");
        $stmt->bindParam(':id', $id , PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetchObject();
        
        $stmt = $this->db->prepare("SELECT  m.idmovimiento,
                                            cm.descripcion,
                                            md.cantidad,
                                            md.monto
                                    FROM movimiento_detalle as md inner join movimiento as m on m.idmovimiento = md.idmovimiento
                                            inner join concepto_movimiento as cm on md.idconcepto_movimiento = cm.idconcepto_movimiento
                                    WHERE m.idmovimiento = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        unset($_SESSION['conceptos']);
        $_SESSION['conceptos'] = new conceptos();
        
        foreach($stmt->fetchAll() as $rows)
        {
            $r = $_SESSION['conceptos']->add($rows['idmovimiento'],$rows[1],$rows['cantidad'],$rows['monto']);
        }
        return $row;        
    }

    function insert($_P ) 
    {
         
        $idperiodo = $_SESSION['idperiodo'];
        $idempleado = $_SESSION['idempleado'];  
        $idoficina = $_SESSION['idoficina'];
        $tipo = 1;
        $estado = 1;
        $hora = date('h:i:s');
        $gr = '';
        $stmt = $this->db->prepare("SELECT f_insert_movimiento (:p1, :p2, :p3, :p4,:p5, :p6, :p7, :p8, :p9, :p10, :p11, :rs,:ruc,:p12,:p13,:p14)");
        try 
        { 
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->beginTransaction();
                
                $stmt->bindParam(':p1', $idempleado , PDO::PARAM_INT); //empleado que realiza el registro
                $stmt->bindParam(':p2', $idoficina , PDO::PARAM_INT);
                $stmt->bindParam(':p3', $idperiodo , PDO::PARAM_INT);
                $stmt->bindParam(':p4', $_P['idproveedor'] , PDO::PARAM_INT);
                $stmt->bindParam(':p5', $this->fdate($_P['fecha'],'EN') , PDO::PARAM_STR);
                $stmt->bindParam(':p6', $estado , PDO::PARAM_INT);
                $stmt->bindParam(':p7', $_P['observacion'] , PDO::PARAM_STR);
                $stmt->bindParam(':p8', $tipo , PDO::PARAM_INT);
                $stmt->bindParam(':p9', $_P['idempleado'] , PDO::PARAM_STR); //empleado que representa al propietario
                $stmt->bindParam(':p10', $_P['chofer'] , PDO::PARAM_STR); //empleado que representa al chofer
                $stmt->bindParam(':p11', $_P['placa'] , PDO::PARAM_STR); //                
                $stmt->bindParam(':rs', $_P['razonsocial'] , PDO::PARAM_STR); //
                $stmt->bindParam(':ruc', $_P['ruc'] , PDO::PARAM_STR); //
                $stmt->bindParam(':p12', $_P['tipoi'] , PDO::PARAM_INT);
                $stmt->bindParam(':p13', $_P['razonsocial'] , PDO::PARAM_STR);
                $stmt->bindParam(':p14', $this->tipo_documento,PDO::PARAM_INT);
                $stmt->execute();
                $row = $stmt->fetchAll();
                $idmovimiento = $row[0][0];
                
                $stmt2  = $this->db->prepare('INSERT INTO movimiento_detalle (idmovimiento,idconcepto_movimiento,monto,cantidad,descripcion) values(:p1,:p2,:p3,:p4,:p5)');
                $obj    = $_SESSION['conceptos'];
                $estado = 1;
                for($i=0;$i<$obj->item;$i++)
                { 
                    if($obj->estado[$i])
                    {
                        $stmt2->bindParam(':p1',$idmovimiento,PDO::PARAM_INT);
                        $stmt2->bindParam(':p2',$obj->idconcepto_movimiento[$i],PDO::PARAM_INT);
                        $stmt2->bindParam(':p3',$obj->monto[$i],PDO::PARAM_INT);
                        $stmt2->bindParam(':p4',$obj->cantidad[$i],PDO::PARAM_INT);
                        $stmt2->bindParam(':p5',$obj->concepto[$i],PDO::PARAM_INT);
                        $stmt2->execute();
                    }
                }
                
            $this->db->commit();
            unset($_SESSION['conceptos']);
            return array('res'=>"1",'msg'=>'Bien!','idm'=>$idmovimiento);
        }
        catch(PDOException $e) 
        {
            $this->db->rollBack();
            return array('res'=>"2",'msg'=>'Error : '.$e->getMessage() . $str);
        }
           
    }
    function anular($p) 
    {
        $stmt = $this->db->prepare("UPDATE movimiento set estado = 0 WHERE idmovimiento = :p1");
        $stmt->bindParam(':p1', $p, PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    
    function update($_P ) {
        $stmt = $this->db->prepare("update movimiento set idempleado = :p1,
                                                          idproveedor = :p2,
                                                          idperiodo = :p3,
                                                          fecha = :p4,
                                                          estado = :p5,
                                                          observacion = :p6,
                                                          recibi = :p7
                                    where idmovimiento = :idmovimiento");
        $stmt->bindParam(':p1', $_P['idempleado'] , PDO::PARAM_STR);
        $stmt->bindParam(':p2', $_P['idproveedor'] , PDO::PARAM_STR);
        $stmt->bindParam(':p3', $_P['idperiodo'] , PDO::PARAM_STR);
        $stmt->bindParam(':p4', $_P['fecha'] , PDO::PARAM_STR);
        $stmt->bindParam(':p5', $_P['estado'] , PDO::PARAM_STR);
        $stmt->bindParam(':p6', $_P['observacion'] , PDO::PARAM_STR);
        $stmt->bindParam(':p7', $_P['recibi'] , PDO::PARAM_STR);
        $stmt->bindParam(':idmovimiento', $_P['idmovimiento'] , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    function delete($_P ) {
        $stmt = $this->db->prepare("DELETE FROM movimiento WHERE idmovimiento = :p1");
        $stmt->bindParam(':p1', $_P , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    function getdata($ide)
    {
        $stmt = $this->db->prepare("SELECT distinct  
                                            case tipo_ingreso when 1 then concat(coalesce(e.nombre,' '),' ',coalesce(e.apellidos,' '))
                                            else 
                                                case pro.ruc 
                                                when '00000000' then m.recibi 
                                                else pro.razonsocial  end                                                
                                            end as remitente,                                            
                                            m.fecha, 
                                            o.descripcion as oficina,
                                            o.direccion,
                                            o.telefono,
                                            m.observacion,
                                            m.placa,
                                            m.serie,
                                            m.numero
                                   from movimiento as m                                         
                                        inner join empleado as users on users.idempleado = m.idempleado                                             
                                            inner join oficina as o on m.idoficina = o.idoficina                                            
                                            left outer join empleado as e on e.idempleado = m.idpropietario  and e.idtipo_empleado = 3
                                        left outer join proveedor as pro on pro.idproveedor = m.idproveedor
                                    where m.estado <> 0  and m.idmovimiento= :id");
        $stmt->bindParam(':id',$ide,PDO::PARAM_INT);
        $stmt->execute();
        $n = $stmt->rowCount();
        if($n>0)
        {
            $head = $stmt->fetchObject();
            $stmt2 = $this->db->prepare("SELECT  md.descripcion,
                                                monto as precio,
                                                cantidad
                                        FROM movimiento_detalle as md inner join concepto_movimiento as cm
                                        on cm.idconcepto_movimiento = md.idconcepto_movimiento
                                        WHERE idmovimiento = :id ");
            $stmt2->bindParam(':id',$ide,PDO::PARAM_INT);
            $stmt2->execute();
            $detalle = $stmt2->fetchAll();
            return array(true,$head,$detalle);
        }
        else 
        {
            return array(false,'','');
        }
    }
}
?>