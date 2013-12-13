<?php
include_once("Main.php");
class telegiro extends Main{    
    protected $tipo_documento = 5;    
    function index($query,$p,$c,$op) 
    {
        $sql = "SELECT t.idtelegiro,
                concat(substring(t.fecha,9,2),'/',substring(t.fecha,6,2),'/',substring(t.fecha,1,4)),
                case remitente.nrodocumento 
                when '00000000' then t.remitente                                                 
                else remitente.nombre end AS remitente,
                t.consignado,
                t.numero,
                cast(t.monto_telegiro as decimal(18,2)),
                case t.estado when 1 then 'REGISTRADO'
                                when 2 then 'ENTREGADO'
                                WHEN 3 THEN 'REEMBOLSADO'
                                WHEN 4 THEN 'ANULADO'
                    end as estado,
                case t.estado when 1 then 
                                concat('<a target=\"_PARENT\" href=\"index.php?controller=telegiro&action=printer&id=',t.idtelegiro,'\" title=\"Imprimir\" class=\"box-boton boton-print\"></a>')
                              when 2 then 
                                concat('<a target=\"_PARENT\" href=\"index.php?controller=telegiro&action=printer&id=',t.idtelegiro,'\" title=\"Imprimir\" class=\"box-boton boton-print\"></a>')
                              else    
                                concat('<a target=\"_PARENT\" href=\"index.php?controller=telegiro&action=printer&id=',t.idtelegiro,'\" title=\"Imprimir\" class=\"box-boton boton-print\"></a>')
                end, ";
                if($op == "0")
                {
                    $sql = $sql."'&nbsp;' as opcion from telegiro as t inner join pasajero as remitente on remitente.idpasajero = t.idremitente ";
                } 
                else 
                {
                    $sql = $sql." case t.estado when 1 then 
                        concat('<a class=\"lbooton desp\" target=\"_PARENT\" href=\"index.php?controller=telegiro&action=entregar&id=',t.idtelegiro,'\" title=\"Imprimir\">ENTREGAR</a>')
                        WHEN 2 then 
                        concat('<a id=\"',t.idtelegiro,'\" class=\"btnreembolso lbooton1 desp\" href=\"#\" title=\"Reembolsar\">REEMBOLSAR</a>')
                        ELSE '&nbsp;' END as opcion 
                        from telegiro as t inner join pasajero as remitente on remitente.idpasajero = t.idremitente ";
                }
                if($op == "0")
                {
                    $sql = $sql."where ".$c." like :query and (t.idoficina = ".$_SESSION['idoficina'].") 
                                order by t.idtelegiro desc ";
                } 
                else
                {
                    $sql = $sql."where ".$c." like :query and t.iddestino = ".$_SESSION['idoficina']." 
                                order by t.idtelegiro desc ";
                }
        //echo $sql;
        $param = array(array('key'=>':query' , 'value'=>"%$query%" , 'type'=>'STR' ));
        $data['total'] = $this->getTotal( $sql, $param );
        $data['rows'] =  $this->getRow($sql, $param , $p );        
        $data['rowspag'] =  $this->getRowPag($data['total'], $p );        
        // unset($_SESSION['envios']);
        return $data;
    }
    function edit($id)
    {
        $stmt = $this->db->prepare("SELECT t.*,
                                        remitente.nrodocumento as nrodocumentor,
                                        remitente.nombre as remitente
                                     FROM telegiro as t 
                                      inner join pasajero as remitente on remitente.idpasajero = t.idremitente 
                                     WHERE t.idtelegiro = :id");
        
        $stmt->bindParam(':id', $id , PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetchObject();        
        return $row;
    }
    function insert($_P ) 
    {
        $idperiodo  = $_SESSION['idperiodo'];
        $idempleado = $_SESSION['idempleado'];    
        $idoficina = $_SESSION['idoficina'];
        $estado = 1;
        $hora = date('h:i:s');
      
        $stmt = $this->db->prepare("SELECT f_insert_telegiro (:p1,:p2,:p3,:p4,:p5,:p6,:p7,:p8,:p9,:p10,:p11,:p12,:p13,:p14,:p15); ");
        try 
        {
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->beginTransaction();
                $stmt->bindParam(':p1',$idperiodo,PDO::PARAM_INT);
                $stmt->bindParam(':p2',$idempleado,PDO::PARAM_INT);
                $stmt->bindParam(':p3',$_P['iddestino'],PDO::PARAM_INT);
                $stmt->bindParam(':p4',$_P['idremitente'],PDO::PARAM_STR);
                $stmt->bindParam(':p5',$_P['nrodocumentor'],PDO::PARAM_STR);
                $stmt->bindParam(':p6',$_P['remitente'],PDO::PARAM_STR);
                $stmt->bindParam(':p7',$_P['idconsignado'],PDO::PARAM_INT);
                $stmt->bindParam(':p8',$_P['consignado'],PDO::PARAM_STR);
                $stmt->bindParam(':p9',$this->fdate($_P['fecha'],'EN'),PDO::PARAM_STR);
                $stmt->bindParam(':p10',$hora,PDO::PARAM_STR);
                $stmt->bindParam(':p11',$_P['monto_telegiro'],PDO::PARAM_INT);
                $stmt->bindParam(':p12',$_P['monto_caja'],PDO::PARAM_INT);
                $stmt->bindParam(':p13',$this->tipo_documento,PDO::PARAM_INT);
                $stmt->bindParam(':p14',$estado,PDO::PARAM_INT);
                $stmt->bindParam(':p15',$idoficina,PDO::PARAM_INT);
                $stmt->execute();
                $row = $stmt->fetchAll();
                $idtelegiro = $row[0][0];
                
            $this->db->commit();
            //unset($_SESSION['telegiros']);
            return array('res'=>"1",'msg'=>'Bien!','id'=>$idtelegiro);
        }
        catch(PDOException $e) 
        {
            $this->db->rollBack();
            return array('res'=>"2",'msg'=>'Error : '.$e->getMessage() . $str);
        }
        
    }    
    function update($_P ) 
    {
        $idperiodo  = $_SESSION['idperiodo'];
        $idempleado = $_SESSION['idempleado'];    
        $idoficina = $_SESSION['idoficina'];
        $estado = 1;
        $idtelegiro = (int) $_P['idtelegiro'];
        $stmt = $this->db->prepare("SELECT f_update_telegiro (:p0,:p1,:p2,:p3,:p4,:p5,:p6,:p7,:p8,:p11,:p12,:p13,:p14,:p15); ");
        try 
        { 
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->beginTransaction();
            $stmt->bindParam(':p0',$idtelegiro,PDO::PARAM_INT);
                $stmt->bindParam(':p1',$idperiodo,PDO::PARAM_INT);
                $stmt->bindParam(':p2',$idempleado,PDO::PARAM_INT);
                $stmt->bindParam(':p3',$_P['iddestino'],PDO::PARAM_INT);
                $stmt->bindParam(':p4',$_P['idremitente'],PDO::PARAM_STR);
                $stmt->bindParam(':p5',$_P['nrodocumentor'],PDO::PARAM_STR);
                $stmt->bindParam(':p6',$_P['remitente'],PDO::PARAM_STR);
                $stmt->bindParam(':p7',$_P['idconsignado'],PDO::PARAM_INT);
                $stmt->bindParam(':p8',$_P['consignado'],PDO::PARAM_STR);
                $stmt->bindParam(':p11',$_P['monto_telegiro'],PDO::PARAM_INT);
                $stmt->bindParam(':p12',$_P['monto_caja'],PDO::PARAM_INT);
                $stmt->bindParam(':p13',$this->tipo_documento,PDO::PARAM_INT);
                $stmt->bindParam(':p14',$estado,PDO::PARAM_INT);
                $stmt->bindParam(':p15',$idoficina,PDO::PARAM_INT);
                $stmt->execute();
                $row = $stmt->fetchAll();
                $idtelegiro = $row[0][0];
                
                
                
            $this->db->commit();
            //unset($_SESSION['telegiros']);
            return array('res'=>"1",'msg'=>'Bien!','idv'=>$idtelegiro);
            //return array('res'=>"1",'msg'=>$consulta,'idv'=>$idtelegiro);
        }
        catch(PDOException $e) 
        {
            $this->db->rollBack();
            return array('res'=>"2",'msg'=>'Error : '.$e->getMessage() . $str);
            //return array('res'=>"2",'msg'=>$consulta,'idv'=>$idtelegiro);
        }
        
    }   
    function entregar($id) 
    {
        
        $id=(int)$id;
        $stmt = $this->db->prepare("SELECT f_entregar_telegiro (:p1,:p2,:p3); ");
        try 
        { 
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->beginTransaction();
                $stmt->bindParam(':p1',$id,PDO::PARAM_INT);
                $stmt->bindParam(':p2',$_SESSION['idempleado'],PDO::PARAM_STR);
                $stmt->bindParam(':p3',$_SESSION['id_perfil'],PDO::PARAM_INT);
                $stmt->execute();
                               
            $this->db->commit();
            //unset($_SESSION['telegiros']);
            return array('res'=>"1",'msg'=>'Bien!');
        }
        catch(PDOException $e) 
        {
            $this->db->rollBack();
            return array('res'=>"2",'msg'=>'Error : '.$e->getMessage() . $str);
        }
        
    }    
    
    function anular($id) 
    {
        
        $id=(int)$id;
        $stmt = $this->db->prepare("SELECT f_anular_telegiro (:p1); ");
        try
        {
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->beginTransaction();
            $stmt->bindParam(':p1',$id,PDO::PARAM_INT);
            $stmt->execute();
            
            $row = $stmt->fetchAll();
                $rs = $row[0][0];
                $this->db->commit();
            //unset($_SESSION['telegiros']);
            return array('res'=>$rs,'msg'=>'Bien!');
        }
        catch(PDOException $e)
        {
            $this->db->rollBack();
            return array('res'=>"3",'msg'=>'Error : '.$e->getMessage() . $str);
        }
        
    }    
    
    function reembolsar($id) 
    {   
        $id=(int)$id;        
        $stmt = $this->db->prepare("SELECT f_reembolsar_telegiro (:p1,:p2,:p3); ");
        try 
        { 
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->beginTransaction();
                $stmt->bindParam(':p1',$id,PDO::PARAM_INT);
                $stmt->bindParam(':p2',$_SESSION['idempleado'],PDO::PARAM_STR);
                 $stmt->bindParam(':p3',$_SESSION['id_perfil'],PDO::PARAM_INT);
                $stmt->execute();
                
            $this->db->commit();
            //unset($_SESSION['telegiros']);
            return array('res'=>"1",'msg'=>'Bien!');
        }
        catch(PDOException $e) 
        {
            $this->db->rollBack();
            return array('res'=>"2",'msg'=>'Error : '.$e->getMessage() . $str);
        }
    }  
   
    function getdata($idv)
    {
        $stmt = $this->db->prepare("SELECT t.idtelegiro,
                                            concat(substring(t.fecha,9,2),'/',substring(t.fecha,6,2),'/',substring(t.fecha,1,4)) as fecha,
                                            case remitente.nrodocumento 
                                                when '00000000' then t.remitente                                                 
                                                else remitente.nombre end AS remitente,
                                            t.consignado,
                                            t.numero,
                                            t.monto_telegiro as monto,
                                            o.descripcion as oficina,
                                            o.direccion,
                                            o.telefono,
                                            d.descripcion as destino
                                    from telegiro as t inner join pasajero as remitente on remitente.idpasajero = t.idremitente
                                          inner join oficina as o on t.idoficina = o.idoficina
                                          INNER JOIN destino as d on d.iddestino = t.iddestino
                                        where t.idtelegiro = :id and t.estado <> 3;");
        $stmt->bindParam(':id',$idv,PDO::PARAM_INT);
        $stmt->execute();
        $n = $stmt->rowCount();
        $head = $stmt->fetchObject();
        if($n>0)
        {                       
            return array(true,$head);
        }
        else 
        {            
            return array(false,'','');
        }
    }
}
?>