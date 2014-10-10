<?php
include_once("Main.php");
class salida extends Main
{    
    protected $tipo_documento = 4;    
    function index($query,$p,$c) 
    {
        $sql = "SELECT s.idsalida,
                       concat(substring(s.fecha,9,2),'/',substring(s.fecha,6,2),'/',substring(s.fecha,1,4)),
                       SUBSTRING(s.hora,1,5),
                       concat(chofer.nombre,' ',chofer.apellidos),
                       v.placa,    
                       d.descripcion,
                       concat(s.serie,'-',s.numero),
                       case s.tipo when 0 then 'I' else 'I&V' end,                       
                       case s.estado when 0 then 'ANULADO'
                                     when 1 then 'RESERVADO'
                                     WHEN 2 THEN 'DISPONIBLE'
                                     WHEN 3 THEN 'EN CURSO'
                                     WHEN 4 then 'CONCLUIDO'
                                     WHEN 5 THEN 'CONCLUIDO (ida)'
                            end as estado,
                        e.login,

                        -- Imprimir o Comprar ticket
                        case s.estado
                           when 1 then 
                           concat('<a class=\"pay-ticket box-boton boton-pay\" title=\"Comprar Ticket\" id=\"pay-',s.idsalida,'\"></a>')
                           else 
                                case s.estado when 0 then '&nbsp;'
                                else concat('<a  target=\"_blank\" href=\"index.php?controller=salida&action=printer&ie=',s.idsalida,'\" title=\"Imprimir\" class=\"box-boton boton-print\"></a>')
                                end                            
                           end,

                        -- Confirmar Salida o Hora salida
                        case s.estado when 2 then concat('<a class=\"confirm box-boton boton-hand\" id=\"cf-',s.idsalida,'\" href=\"#\" title=\"Confirmar Salida\"></a>')
                                      when 3 then '<span class=\"box-boton boton-ok\"></span>'
                                      when 4 then '<span class=\"box-boton boton-ok\"></span>'
                        else '&nbsp;' end,   

                        -- Anular Ticket
                        case s.estado when 1 then 
                           case s.idempleado when ".$_SESSION['idempleado']." then 
                            concat('<a class=\"anular box-boton boton-anular\" id=\"as-',s.idsalida,'\" href=\"#\" title=\"Anular\"></a>')
                           else 
                                case ".$_SESSION['id_perfil']." when 1 then 
                                concat('<a class=\"anular box-boton boton-anular\" id=\"as-',s.idsalida,'\" href=\"#\" title=\"Anular\"></a>')
                                else '&nbsp;'
                                end
                           end
                           when 2 then 
                           case s.idempleado when ".$_SESSION['idempleado']." then 
                           concat('<a class=\"anular box-boton boton-anular\" id=\"as-',s.idsalida,'\" href=\"#\" title=\"Anular\"></a>')
                           else 
                                case ".$_SESSION['id_perfil']." when 1 then 
                                concat('<a class=\"anular box-boton boton-anular\" id=\"as-',s.idsalida,'\" href=\"#\" title=\"Anular\"></a>')
                                else '&nbsp;'
                                end
                           end
                        else '&nbsp;'                        
                        end
                FROM salida as s inner join empleado as chofer on chofer.idempleado = s.idchofer
                        inner join vehiculo as v on v.idvehiculo = s.idvehiculo
                        inner join destino as d on d.iddestino = s.iddestino
                        inner join empleado as e on e.idempleado = s.idempleado and e.idtipo_empleado=1
                where cast(".$c." as char) like :query and chofer.idtipo_empleado = 2 
                        and s.idoficina = ".$_SESSION['idoficina']."
                order by s.estado,s.idsalida desc";
        
        $param = array(array('key'=>':query' , 'value'=>"%$query%" , 'type'=>'STR' ));
        $data['total'] = $this->getTotal( $sql, $param );
        $data['rows'] =  $this->getRow($sql, $param , $p );        
        $data['rowspag'] =  $this->getRowPag($data['total'], $p );        
        return $data;
    }
    function edit($id)
    {
        $stmt = $this->db->prepare(" SELECT * 
                                    FROM salida
                                     WHERE idsalida = :id");
        $stmt->bindParam(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        $row = $stmt->fetchObject();       
        //Retornando cabecera
        return $row;
    }
    function insert($_P ) 
    {
        $idperiodo  = $_SESSION['idperiodo'];
        $idempleado = $_SESSION['idempleado'];    
        $idoficina = $_SESSION['idoficina'];                
      
        $generar = null;
        if(isset($_P['gticket']))
        {
            $generar = 1;
            $monto = $_P['precio'];
            $estado = 2;         
        }
        else 
        {
            $generar = 0;
            $monto = 0;
            $estado = 1;
            $serie = '';
            $numero = '';            
        }
        $iyv=0;
        if(isset($_P['iyv']))
        {
            $iyv=1;
        }   
        $hora = date('h:i:s');
        $fecha = $this->fdate($_P['fecha'],'EN');
        $stmt = $this->db->prepare("SELECT f_insert_salida (:p1,:p2,:p3,:p4,:p7,:p8,:p9,:p10,:p11,:p12,:p13,:p14,:p15); ");
        try 
        { 
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->beginTransaction();                
            $stmt->bindParam(':p1',$this->tipo_documento,PDO::PARAM_INT);    
            $stmt->bindParam(':p2',$generar,PDO::PARAM_INT);  
            $stmt->bindParam(':p3',$_P['idchofer'],PDO::PARAM_STR);
            $stmt->bindParam(':p4',$_P['idvehiculo'],PDO::PARAM_INT);            
            $stmt->bindParam(':p7',$fecha,PDO::PARAM_STR);
            $stmt->bindParam(':p8',$hora,PDO::PARAM_STR);
            $stmt->bindParam(':p9',$monto,PDO::PARAM_INT);
            $stmt->bindParam(':p10',$estado,PDO::PARAM_INT);
            $stmt->bindParam(':p11',$idempleado,PDO::PARAM_STR);
            $stmt->bindParam(':p12',$idoficina,PDO::PARAM_INT);
            $stmt->bindParam(':p13',$idperiodo,PDO::PARAM_INT);                      
            $stmt->bindParam(':p14',$_P['iddestino'],PDO::PARAM_INT);
            $stmt->bindParam(':p15',$iyv,PDO::PARAM_INT);

            $stmt->execute();
            $row = $stmt->fetchAll();
            $idsalida = $row[0][0];
            $this->db->commit();            
            return array('res'=>"1",'msg'=>'Bien!','ids'=>$idsalida);
        }
        catch(PDOException $e) 
        {
            $this->db->rollBack();
            return array('res'=>"2",'msg'=>'Error : '.$e->getMessage() . $str);
        }        
    }
    function anular($p) 
    {
        $stmt = $this->db->prepare("CALL anular_salida(:p1)");
        $stmt->bindParam(':p1', $p, PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    function payticket($id)
    {
        $idoficina = $_SESSION['idoficina'];
        $idperiodo  = $_SESSION['idperiodo'];
        $idempleado = $_SESSION['idempleado']; 
        $estado = 1;
        $hora = date('h:i:s');
        $fecha = date('Y-m-d');      
        $stmt = $this->db->prepare("SELECT f_pay_ticket (:p1,:p4,:p5,:p6,:p7,:p8,:p9); ");
        try 
        {
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->beginTransaction();
                $stmt->bindParam(':p1',$id,PDO::PARAM_INT);                
                $stmt->bindParam(':p4',$this->tipo_documento,PDO::PARAM_INT);
                $stmt->bindParam(':p5',$idoficina,PDO::PARAM_INT);
                $stmt->bindParam(':p6',$fecha,PDO::PARAM_STR);
                $stmt->bindParam(':p7',$hora,PDO::PARAM_STR);
                $stmt->bindParam(':p8',$idperiodo,PDO::PARAM_INT);
                $stmt->bindParam(':p9',$idempleado,PDO::PARAM_INT);
                $stmt->execute();
                $ro = $stmt->fetchAll();
            $this->db->commit();
            return array('res'=>"1",'msg'=>$ro[0][0]);
        }
        catch(PDOException $e) 
        {
            $this->db->rollBack();
            return array('res'=>"2",'msg'=>'Error : '.$e->getMessage() . $str);
        }
    }
    function despachar($id)
    {        
        $estado = 1;
        $hora = date('H:i:s');
        $fecha = date('Y-m-d');      
        $stmt = $this->db->prepare("UPDATE salida set estado = 3, fecha_sal = :fs, hora_sal = :hs 
                                    where idsalida = :id ");
        try 
        { 
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->beginTransaction();                
            $stmt->bindParam(':id',$id,PDO::PARAM_INT);
            $stmt->bindParam(':fs',$fecha,PDO::PARAM_STR);
            $stmt->bindParam(':hs',$hora,PDO::PARAM_STR);                
            $stmt->execute();

            //Actualizamos todos los envios que estan relacionados a esta salida
            //a un estado de enviados
            $stmt = $this->db->prepare("UPDATE envio_salidas 
                                                    set estado = 2,
                                                        fecha_salida = :fs,
                                                        hora_salida = :hs
                                        where idsalida = :p2 and estado = 1 ");                
            $stmt->bindParam(':p2',$id,PDO::PARAM_INT);
            $stmt->bindParam(':fs',$fecha,PDO::PARAM_STR);
            $stmt->bindParam(':hs',$hora,PDO::PARAM_STR);  
            $q = $stmt->execute();

            $sql = "SELECT idenvio from envio_salidas where idsalida = :p2 and estado in (1,2)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':p2',$id,PDO::PARAM_INT);
            $q = $stmt->execute();
            $r = $stmt->fetchAll();

            foreach($r as $key => $v)
            {
                $id = $v['idenvio'];
                $stmt2 = $this->db->prepare("UPDATE envio set estado = 2  
                                            where idenvio = :id and estado <> 0");
                $stmt2->bindParam(':id',$id,PDO::PARAM_INT);
                $stmt2->execute();
            }

            

            $this->db->commit();            
            return array('res'=>'1','msg'=>$hora);
        }
        catch(PDOException $e) 
        {
            $this->db->rollBack();
            return array('res'=>'2','msg'=>'Error : '.$e->getMessage() . $str);
        }
    }
    function getdata($idv)
    {
        $stmt = $this->db->prepare("select  s.idsalida,
                                            td.descripcion,
                                            concat(chofer.nombre,' ',chofer.apellidos) as chofer,
                                            concat(substring(s.fecha,9,2),'/',substring(s.fecha,6,2),'/',substring(s.fecha,1,4)) as fecha,
                                            SUBSTRING(s.hora,1,5) as hora,
                                            v.placa,
                                            s.numero,
                                            s.serie,
                                            d.descripcion as destino,
                                            o.descripcion as oficina,
                                            o.direccion,
                                            o.telefono,
                                            s.monto
                                    from salida as s inner join tipo_documento as td on td.idtipo_documento = s.idtipo_documento
                                        inner join vehiculo as v on v.idvehiculo = s.idvehiculo
                                        inner join destino as d on d.iddestino = s.iddestino
                                        inner join empleado as chofer on chofer.idempleado = s.idchofer
                                        inner join oficina as o on s.idoficina = o.idoficina
                                    where s.idsalida = :id and chofer.idtipo_empleado = 2");
        $stmt->bindParam(':id',$idv,PDO::PARAM_INT);
        $stmt->execute();
        $n = $stmt->rowCount();
        
        if($n>0)
        {
            $head = $stmt->fetchObject();                        
            return array(true,$head);
        }
        else 
        {
            return array(false,'','');
        }
    }
    function getSalidasOk($idd,$fecha)
    {
        $fecha = $this->fdate($fecha,'EN');
        $data = array();
        $stmt = $this->db->prepare("SELECT fecha, COUNT( idsalida ) 
                                    FROM salida
                                    WHERE estado
                                    IN ( 1, 2, 3 )  and idoficina = ".$_SESSION['idoficina']." and iddestino <> ".$_SESSION['idsucursal']."
                                    GROUP BY fecha
                                    having count(idsalida)>0
                                    ORDER BY fecha DESC ");
        $stmt->execute();
        $c = 0;
        foreach ($stmt->fetchAll() as $f)
        {
            if($f[0]==$fecha)
            {
                $ff = "Hoy día";
                $data[$c] = array('fecha'=>$ff,'salidas'=>array());
            }
            else 
            {
                $data[$c] = array('fecha'=>$this->fdate($f[0],'ES'),'salidas'=>array());
            }
            
            
            $stmt2 = $this->db->prepare("SELECT distinct s.idsalida,
                                            concat('(A ',d.descripcion,') ',coalesce(chofer.nombre,''),' ',coalesce(chofer.apellidos,''),' - ',v.placa) as descripcion,
                                            s.fecha
                                    FROM salida as s inner join empleado as chofer on chofer.idempleado = s.idchofer
                                            inner join vehiculo as v on v.idvehiculo = s.idvehiculo
                                            inner join destino as d on d.iddestino = s.iddestino
                                            inner join empleado as e on e.idempleado = s.idempleado
                                    where s.idoficina = ".$_SESSION['idoficina']." 
                                            and s.iddestino <> ".$_SESSION['idsucursal']."
                                            and s.fecha = '".$f[0]."'  
                                    ORDER BY fecha,descripcion,idsalida asc  ");
            $stmt2->execute();
            $n = $stmt2->rowCount();
            if($c==0){$data[$c]['salidas'][] = array('idsalida'=>'','descripcion'=>'-Seleccione-');}
            if($n>0)
            {                
                foreach($stmt2->fetchAll() as $r)
                {
                    $data[$c]['salidas'][] = array('idsalida'=>$r[0],'descripcion'=>$r[1]);
                }                
            }
            $c += 1;
        }
        
        return $data;

    }
}
?>