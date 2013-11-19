<?php
include_once("Main.php");
class venta extends Main{    
    function index($query,$p,$c) 
    {
        $sql = "SELECT v.idventa,
                       concat(substring(v.fecha,9,2),'/',substring(v.fecha,6,2),'/',substring(v.fecha,1,4)),
                       p.nombre,
                       concat(td.descripcion,' ',v.serie,'-',v.numero),
                       case v.estado when 1 then 'PAGADO'                                      
                                     when 0 then 'ANULADO'
                            end as estado,                        
                       e.login,
                       case v.estado when 1 then                        
                       concat('<a target=\"_blank\" href=\"index.php?controller=venta&action=printer&iv=',v.idventa,'\" title=\"Imprimir\" class=\"box-boton boton-print\"></a>')
                       else '&nbsp;'
                       end,
                       case v.estado when 1 then
                           case v.idempleado when ".$_SESSION['idempleado']." then
                           concat('<a class=\"anular box-boton boton-anular\" id=\"v-',v.idventa,'\" href=\"#\" title=\"Anular\" ></a>')
                           else
                                case ".$_SESSION['id_perfil']." when 1 then
                                concat('<a class=\"anular box-boton boton-anular\" id=\"v-',v.idventa,'\" href=\"#\" title=\"Anular\" ></a>')
                                else '&nbsp;'
                                end
                           end
                        else '&nbsp;'
                       end
                FROM venta as v inner join pasajero as p on p.idpasajero = v.idpasajero inner join
                    tipo_documento as td on td.idtipo_documento = v.idtipo_documento
                    inner join empleado as e on v.idempleado = e.idempleado
                where ".$c." like :query and v.idoficina = ".$_SESSION['idoficina']."
                order by v.idventa desc";         
        $param = array(array('key'=>':query' , 'value'=>"%$query%" , 'type'=>'STR' ));
        $data['total'] = $this->getTotal( $sql, $param );
        $data['rows'] =  $this->getRow($sql, $param , $p );        
        $data['rowspag'] =  $this->getRowPag($data['total'], $p );        
        unset($_SESSION['ventad']);
        return $data;
    }
    function edit($id)
    {
        $stmt = $this->db->prepare("SELECT v.*,p.nrodocumento, p.nombre,p.direccion
                                    FROM venta as v inner join
                                        pasajero as p on p.idpasajero = v.idpasajero
                                    WHERE v.idventa = :id");
        $stmt->bindParam(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        $row = $stmt->fetchObject();

         //Obteniendo los detalles
        $stmt = $this->db->prepare("SELECT  vd.iditinerario,
                                            vd.descripcion as itinerario,
                                            vd.precio,
                                            vd.cantidad
                                    FROM venta_detalle as vd 
                                    WHERE vd.idventa = :id and vd.estado = 1");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        unset($_SESSION['ventad']);
        $_SESSION['ventad'] = new ventad();
        foreach($stmt->fetchAll() as $rows)
        {
            $_SESSION['ventad']->add($rows['iditinerario'],$rows['itinerario'],$rows['precio'],$rows['cantidad']);
        }
        return $row;
    }
    function insert($_P ) 
    {
        $idperiodo = $_SESSION['idperiodo'];
        $idempleado = $_SESSION['idempleado'];  
        $idoficina = $_SESSION['idoficina'];
        $estado = 1;
        $hora = date('h:i:s');
        $gr = $_P['guia_remision'];
        $obj    = $_SESSION['ventad'];
        $fecha = $this->fdate($_P['fecha'],'EN');

        //validando dni o ruc
        $bval = true;
        $dni_ruc = $_P['nrodocumento'];
        $t = strlen($dni_ruc);
        if($t==8||$t==11)
        { 
            if($t==8) $bval = $this->isDNI($dni_ruc);
                else $bval = $this->isRUC($dni_ruc);
            if(!$bval) return array('res'=>'2','msg'=>'Error : El numero de documento del remitente es invalido');
        }
        else 
        {
            return array('res'=>'2','msg'=>'Error : El numero de documento del remitente es invalido');
        }
        if($obj->count_items()==0)  
        {
            return array('res'=>'2','msg'=>'Mensaje : No se agregado ningun detalle de venta.');
        }
        $stmt = $this->db->prepare("SELECT f_insert_venta (:p1,:p2,:p3,:p4,:p7,:p8,:p9,:p10,:p11,:p12,:p13,:p14); ");
        try 
        { 
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->beginTransaction();
                
                $stmt->bindParam(':p1',$_P['idpasajero'],PDO::PARAM_INT);
                $stmt->bindParam(':p2',$idperiodo,PDO::PARAM_INT);
                $stmt->bindParam(':p3',$idempleado,PDO::PARAM_STR);
                $stmt->bindParam(':p4',$_P['idtipo_documento'],PDO::PARAM_INT);
                $stmt->bindParam(':p7',$fecha,PDO::PARAM_STR);
                $stmt->bindParam(':p8',$hora,PDO::PARAM_STR);
                $stmt->bindParam(':p9',$gr,PDO::PARAM_STR);
                $stmt->bindParam(':p10',$estado,PDO::PARAM_INT);
                $stmt->bindParam(':p11',$idoficina,PDO::PARAM_INT);
                $stmt->bindParam(':p12',$_P['nrodocumento'],PDO::PARAM_STR);
                $stmt->bindParam(':p13',$_P['nombre'],PDO::PARAM_STR);
                $stmt->bindParam(':p14',$_P['direccion'],PDO::PARAM_STR);                
                $stmt->execute();
                $row = $stmt->fetchAll();
                $idventa = $row[0][0];
                
                $stmt2  = $this->db->prepare('INSERT INTO venta_detalle (idventa,iditinerario,precio,cantidad,estado,descripcion) 
                                                values(:p1,:p2,:p3,:p4,:p5,:p6)');                
                $estado = 1;
                for($i=0;$i<$obj->item;$i++)
                { 
                    if($obj->estado[$i])
                    {
                        $stmt2->bindParam(':p1',$idventa,PDO::PARAM_INT);
                        $stmt2->bindParam(':p2',$obj->iditinerario[$i],PDO::PARAM_INT);
                        $stmt2->bindParam(':p3',$obj->precio[$i],PDO::PARAM_INT);
                        $stmt2->bindParam(':p4',$obj->cantidad[$i],PDO::PARAM_INT);
                        $stmt2->bindParam(':p5',$estado,PDO::PARAM_INT);
                        $stmt2->bindParam(':p6',$obj->itinerario[$i],PDO::PARAM_STR);
                        $stmt2->execute();
                    }
                }
                
            $this->db->commit();
            unset($_SESSION['ventad']);
            return array('res'=>"1",'msg'=>'Bien!','idv'=>$idventa);
        }
        catch(PDOException $e) 
        {
            $this->db->rollBack();
            return array('res'=>"2",'msg'=>'Error : '.$e->getMessage() . $str);
        }
        
    }
    function insertGVenta($_P)
    {
        $idperiodo = $_SESSION['idperiodo'];
        $idempleado = $_SESSION['idempleado'];  
        $idoficina = $_SESSION['idoficina'];
        $estado = 1;
        $hora = date('h:i:s');
        $gr = $_P['guia_remision'];
        $obj    = $_SESSION['ventad'];
        
        $bval = true;
        $dni_ruc = $_P['nrodocumentov'];
        $t = strlen($dni_ruc);
        if($t==8||$t==11)
        { 
            if($t==8) $bval = $this->isDNI($dni_ruc);
                else $bval = $this->isRUC($dni_ruc);
            if(!$bval) return array('res'=>'2','msg'=>'Error : El numero de documento del remitente es invalido');
        }
        else 
        {
            return array('res'=>'2','msg'=>'Error : El numero de documento del remitente es invalido');
        }        
        $fecha = date('Y-m-d');
        $stmt = $this->db->prepare("SELECT f_insert_venta (:p1,:p2,:p3,:p4,:p7,:p8,:p9,:p10,:p11,:p12,:p13,:p14); ");
        try 
        { 
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->beginTransaction();
                
                $stmt->bindParam(':p1',$_P['idremitentev'],PDO::PARAM_INT);
                $stmt->bindParam(':p2',$idperiodo,PDO::PARAM_INT);
                $stmt->bindParam(':p3',$idempleado,PDO::PARAM_STR);
                $stmt->bindParam(':p4',$_P['idtipo_documento'],PDO::PARAM_INT);
                $stmt->bindParam(':p7',$fecha,PDO::PARAM_STR);
                $stmt->bindParam(':p8',$hora,PDO::PARAM_STR);
                $stmt->bindParam(':p9',$gr,PDO::PARAM_STR);
                $stmt->bindParam(':p10',$estado,PDO::PARAM_INT);
                $stmt->bindParam(':p11',$idoficina,PDO::PARAM_INT);
                $stmt->bindParam(':p12',$_P['nrodocumentov'],PDO::PARAM_STR);
                $stmt->bindParam(':p13',$_P['remitentev'],PDO::PARAM_STR);
                $stmt->bindParam(':p14',$_P['direccionv'],PDO::PARAM_STR);                
                $stmt->execute();
                $row = $stmt->fetchAll();
                $idventa = $row[0][0];
                
                $stmt2  = $this->db->prepare('INSERT INTO venta_detalle (idventa,iditinerario,precio,cantidad,estado,descripcion) 
                                                values(:p1,:p2,:p3,:p4,:p5,:p6)');
                $estado = 1;
                for($i=0;$i<$obj->item;$i++)
                { 
                    
                    $stmt2->bindParam(':p1',$idventa,PDO::PARAM_INT);
                    $stmt2->bindParam(':p2',$obj->iditinerario[$i],PDO::PARAM_INT);
                    $stmt2->bindParam(':p3',$obj->precio[$i],PDO::PARAM_INT);
                    $stmt2->bindParam(':p4',$obj->cantidad[$i],PDO::PARAM_INT);
                    $stmt2->bindParam(':p5',$estado,PDO::PARAM_INT);
                    $stmt2->bindParam(':p6',$_P['concepto'][$i],PDO::PARAM_STR);
                    $stmt2->execute();                        
                    
                }                
                
            $this->db->commit();
            unset($_SESSION['ventad']);
            $stmt = $this->db->prepare("SELECT concat(td.descripcion,' ',v.serie,'-',v.numero) as doc
                                 FROM venta as v inner join tipo_documento as td on td.idtipo_documento = v.idtipo_documento 
                                 WHERE v.idventa = ".$idventa);
            $stmt->execute();
            $ro = $stmt->fetchObject();
            $doc = $ro->doc;
            return array('res'=>"1",'msg'=>'Bien!','idv'=>$idventa,'ndoc'=>$doc);
        }
        catch(PDOException $e) 
        {
            $this->db->rollBack();
            return array('res'=>"2",'msg'=>'Error : '.$e->getMessage() . $str);
        }
    }
    function anular($p) 
    {
        $stmt = $this->db->prepare("UPDATE venta set estado = 0 WHERE idventa = :p1");
        $stmt->bindParam(':p1', $p, PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    
    function getdata($idv)
    {
        $stmt = $this->db->prepare("SELECT  p.nrodocumento as nrodoc,
                                            p.nombre as nombre,        
                                            v.serie as serie,
                                            v.numero as numero,
                                            v.fecha as fecha,
                                            v.guia_remision as guia_remision,
                                            v.idtipo_documento,
                                            p.direccion
                                    from venta as v inner join pasajero as p on p.idpasajero = v.idpasajero
                                    inner join tipo_documento as td on td.idtipo_documento = v.idtipo_documento
                                    where v.idventa = :id and v.estado = 1;");
        $stmt->bindParam(':id',$idv,PDO::PARAM_INT);
        $stmt->execute();
        $n = $stmt->rowCount();
        if($n>0)
        {
            $head = $stmt->fetchObject();
            $type = "";
            if($head->idtipo_documento==1)
            {
                $type = "boleta";
            }
            else {
                $type = "factura";
            }
            $stmt = $this->db->prepare("SELECT vd.cantidad,
                                               vd.descripcion as itinerario,
                                               vd.precio
                                        from venta_detalle as vd inner join itinerario as it on it.iditinerario = vd.iditinerario
                                                inner join destino as d1 on d1.iddestino = it.origen 
                                                inner join destino as d2 on d2.iddestino = it.destino
                                        where vd.idventa = :id ");
            $stmt->bindParam(':id',$idv,PDO::PARAM_INT);
            $stmt->execute();
            $detalle = $stmt->fetchAll();
            return array(true,$head,$detalle,$type);
        }
        else 
        {
            return array(false,'','');
        }
    }
}
?>