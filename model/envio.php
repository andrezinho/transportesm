<?php
include_once("Main.php");
class envio extends Main
{    
    protected $tipo_documento = 3;
    function index($query,$p,$c) 
    {
        $sql = "SELECT e.idenvio,
                       concat(substring(e.fecha,9,2),'/',substring(e.fecha,6,2),'/',substring(e.fecha,1,4)),
                       case e.tipo_pro when 1 then '<span class=\"box-encomienda\">ENC</span>' else '<span class=\"box-telegiro\">TEL</span>' end,
                       case remitente.nrodocumento when '00000000' then e.remitente else remitente.nombre end,
                       e.consignado,
                       e.numero,
                       d.descripcion,
                       case e.cpago when 1 then 'CE' else '-' end,
                       case e.estado when 1 then '<p style=\"font-size:9px; font-style:italic\">EN ESPERA...</p>'
                                     when 2 then '<p style=\"font-size:9px; font-style:italic\">EN PROCESO</p>'
                                     when 3 then '<p style=\"font-size:9px; font-style:italic\">FINALIZADO</p>'
                                     WHEN 0 THEN '<p style=\"font-size:9px; font-style:italic\">ANULADA</p>'
                            end as estado,
                        em.login,
                        case e.estado 
                            when 1 then                             
                                    concat('<a class=\"get-salidas box-boton boton-settings\" id=\"cpe-',e.idenvio,'\" href=\"#\" title=\"Procesar Encomienda-Telegiro\" ></a>')
                            when 2 then 
                                concat('<a class=\"get-salidas box-boton boton-settings\" id=\"cpe-',e.idenvio,'\" href=\"#\" title=\"Procesar Encomienda-Telegiro\" ></a>')
                            when 3 then 
                                '<span class=\"box-boton boton-ok\"></span>'
                        else 
                            '&nbsp;'
                            
                        end,
                       case e.estado when 1 then
                        case em.idempleado when ".$_SESSION['idempleado']." then
                            concat('<a class=\"anular box-boton boton-anular\" id=\"e-',e.idenvio,'\" href=\"#\" title=\"Anular\" ></a>')
                        else '&nbsp;'                            
                        end
                       else '&nbsp;'
                       end,
                       case e.estado when 0 then '&nbsp;'
                       else 
                       concat('<a target=\"_blank\" href=\"index.php?controller=envio&action=printer&iv=',e.idenvio,'\" title=\"Imprimir\" class=\"box-boton boton-print\" ></a>')
                       end
                from envio as e inner join pasajero as remitente on remitente.idpasajero = e.idremitente
                    inner join empleado as em on e.idempleado = em.idempleado and em.idtipo_empleado = 1
                    left outer JOIN destino as d on d.iddestino = e.iddestino ";

                switch ($c) 
                {
                    case 1: $c="e.numero";break;
                    case 2: $c="case remitente.nrodocumento when '00000000' then e.remitente else remitente.nombre end";break;
                    case 3: $c="e.consignado";break;
                    case 4: $c="d.descripcion";break;
                    default:break;
                } 
                
                $sql .= " where ".$c." like :query and e.idoficina = ".$_SESSION['idoficina']." 
                order by e.idenvio desc ";

        $param = array(array('key'=>':query' , 'value'=>"%$query%" , 'type'=>'STR' ));
        $data['total'] = $this->getTotal( $sql, $param );
        $data['rows'] =  $this->getRow($sql, $param , $p );        
        $data['rowspag'] =  $this->getRowPag($data['total'], $p );        
        unset($_SESSION['envios']);
        return $data;
    }
    function indexe($query,$p,$c) 
    {
        $sql = "SELECT e.idenvio,
                       concat(substring(e.fecha,9,2),'/',substring(e.fecha,6,2),'/',substring(e.fecha,1,4)),
                       case e.tipo_pro when 1 then '<span class=\"box-encomienda\">ENC</span>' else '<span class=\"box-telegiro\">TEL</span>' end,
                       case remitente.nrodocumento when '00000000' then e.remitente else remitente.nombre end,
                       e.consignado,
                       e.numero,
                       d.descripcion,
                       d2.descripcion,
                       case e.cpago when 1 then 'CE' else '-' end,
                       case e.estado when 1 then '<p style=\"font-size:9px; font-style:italic\">EN ESPERA...</p>'
                                     when 2 then '<p style=\"font-size:9px; font-style:italic\">EN PROCESO</p>'
                                     when 3 then '<p style=\"font-size:9px; font-style:italic\">FINALIZADO</p>'
                                     WHEN 0 THEN '<p style=\"font-size:9px; font-style:italic\">ANULADA</p>'
                            end as estado,
                         em.login,
                        case e.estado when 0 then ''
                        else 
                        concat('<a target=\"_blank\" href=\"index.php?controller=envio&action=printer&iv=',e.idenvio,'\" title=\"Imprimir\" class=\"box-boton boton-print\" ></a>')
                         end,
                       case e.estado when 0 then ''
                        when 2 then 
                            case e.cpago when 0 then
                            concat('<a class=\"get-salidas box-boton boton-settings\" id=\"cpe-',e.idenvio,'\" href=\"#\" title=\"Confirmar Envio de la Encomienda\" ></a>')
                            else 
                            concat('<a class=\"get-salidas box-boton boton-settings\" id=\"cpe-',e.idenvio,'\" href=\"#\" title=\"Confirmar Envio de la Encomienda\" ></a>')
                            end
                       else '<span class=\"box-boton boton-ok\"></span>'
                       end
                from envio as e inner join pasajero as remitente on remitente.idpasajero = e.idremitente                  
                    inner join empleado as em on e.idempleado = em.idempleado and em.idtipo_empleado = 1
                    inner join oficina as o on o.idoficina = e.idoficina     
                    INNER JOIN destino as d on d.iddestino = o.idsucursal 
                    inner join destino as d2 on d2.iddestino = e.iddestino
                    inner join envio_salidas as es on es.idenvio = e.idenvio 
                    inner join salida as s on s.idsalida = es.idsalida ";

            switch ($c) 
               {
                    case 1: $c="e.numero";break;
                    case 2: $c="case remitente.nrodocumento when '00000000' then e.remitente else remitente.nombre end";break;
                    case 3: $c="e.consignado";break;                    
                    default:break;
                }

            $sql .= " where es.estado in (2,3,4) and ".$c." like :query and s.iddestino = ".$_SESSION['idsucursal']." and e.estado in (2,3)
                order by e.idenvio desc ";
        
        $param = array(array('key'=>':query' , 'value'=>"%$query%" , 'type'=>'STR' ));
        $data['total'] = $this->getTotal( $sql, $param );
        $data['rows'] =  $this->getRow($sql, $param , $p );        
        $data['rowspag'] =  $this->getRowPag($data['total'], $p );        
        unset($_SESSION['envios']);
        return $data;
    }
    /*
        Type: Function
        name: edit
        descripcion: Permite optener los datos de un envio especifico
        Parametros: 
            $id -> Primary Key del envio a obtener los datos
            $tipo -> 0 (default) Para cargar los detalles en la session de envios
                     1 Para cargar los detalles en la session de venta (Esto se produce cuando se genera 
                        un comprobante de pago a raiz de una encomienda)
    */
    function edit($id,$tipo=0)
    {
        $stmt = $this->db->prepare("SELECT e.*,
                                        remitente.nrodocumento as nrodocumentor,
                                        case remitente.nrodocumento when '00000000' then e.remitente else remitente.nombre end as remitente,                                        
                                        e.consignado as consignado,
                                        concat(coalesce(chofer.nombre,''),' ',coalesce(chofer.apellidos,''),' - ',v.placa) as salida
                                     FROM envio as e 
                                      inner join pasajero as remitente on remitente.idpasajero = e.idremitente 
                                      LEFT OUTER JOIN envio_salidas as es on es.idenvio = e.idenvio
                                      left outer join salida as s on s.idsalida = es.idsalida
                                      left outer join empleado as chofer on chofer.idempleado = s.idchofer
                                      left outer join vehiculo as v on v.idvehiculo = s.idvehiculo
                                     WHERE e.idenvio = :id");        
        $stmt->bindParam(':id', $id , PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetchObject();
        //Obteniendo los detalles
        $stmt = $this->db->prepare("SELECT  descripcion,
                                            precio,
                                            cantidad,
                                            precio_caja
                                    FROM envio_detalle 
                                    WHERE idenvio = :id and estado = 1");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        if($tipo==0)
        {
            unset($_SESSION['envios']);
            $_SESSION['envios'] = new envios();
            foreach($stmt->fetchAll() as $rows)
            {
                $_SESSION['envios']->add($rows['descripcion'],$rows['precio'],$rows['cantidad'],$rows['precio_caja']);
            }
        }
        elseif($tipo==1) 
        {
            unset($_SESSION['ventad']);
            $_SESSION['ventad'] = new ventad();
            foreach($stmt->fetchAll() as $rows)
            {
                $_SESSION['ventad']->add(0,$rows['descripcion'],$rows['precio'],$rows['cantidad']);
            }
        }        
        //Retornando cabecera
        return $row;
    }
    function insert($_P ) 
    {

        $idperiodo  = $_SESSION['idperiodo'];
        $idempleado = $_SESSION['idempleado'];    
        $idoficina = $_SESSION['idoficina'];
        $obj    = $_SESSION['envios'];

        /*
            //Validaciones
        */
        $bval = true;
        if($_P['idremitente']=="")
        {$_P['idremitente']=0;}
        $dni_ruc = $_P['nrodocumentor'];
        $t = strlen($dni_ruc);
        if($dni_ruc!="00000000"&&$_P['idremitente']!=0)
        {
            if($t==8||$t==11)
            { 
                if($t == 8) 
                {
                    $bval = $this->isDNI($dni_ruc);
                } 
                else 
                {
                    $bval = $this->isRUC($dni_ruc);
                }
                if(!$bval) {return array('res'=>'2','msg'=>'Error : El numero de documento del remitente es invalido');}
            }
            else 
            {
                if($_P['idremitente']==0)
                {
                    return array('res'=>'2','msg'=>'Error : El numero de documento del remitente es invalido');
                }
                
            }
        }
        
        
        
        //Validando consignado
        $_P['consignado'] = trim($_P['consignado']);
        $t = strlen($_P['consignado']);
        if($t==0) return array('res'=>'2','msg'=>'Error : No a definido a un consignado, porfavor ingrese el nombre completo');
        //Verificando numero de items en el detalle
        if($obj->count_items()==0)  
        {
            return array('res'=>'2','msg'=>'Mensaje : No se agregado ninguna encomienda al detalle.');
        }

        $estado = 1;
        $hora = date('H:i:s');
        $fecha = $this->fdate($_P['fecha'],'EN');
        
        if($_P['salidas']=='')        
            $_P['salidas']=0;   
        
        $cp = 0;
        if(isset($_P['cp']))        
            $cp=1;

        $ad = 0;
        if(isset($_P['adomicilio']))
            $ad=1;
        
        $stmt = $this->db->prepare("SELECT f_insert_envio (:p1,:p2,:p3,:p4,:p6,:p7,:p8,:p11,:p12,:p13,:p14,:p15,:p18,:p19,:p20,:p21,:p22, :p23, :p24); ");
        try 
        { 
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->beginTransaction();                
            
            
                $stmt->bindParam(':p1',$idperiodo,PDO::PARAM_INT);
                $stmt->bindParam(':p2',$idempleado,PDO::PARAM_INT);
                $stmt->bindParam(':p3',$_P['iddestino'],PDO::PARAM_INT);

                $stmt->bindParam(':p4',$_P['salidas'],PDO::PARAM_INT);                

                $stmt->bindParam(':p6',$_P['idremitente'],PDO::PARAM_INT);
                $stmt->bindParam(':p7',$_P['nrodocumentor'],PDO::PARAM_STR);
                $stmt->bindParam(':p8',$_P['remitente'],PDO::PARAM_STR);
                
                $stmt->bindParam(':p11',$_P['consignado'],PDO::PARAM_STR);
                
                $stmt->bindParam(':p12',$_P['direccion'],PDO::PARAM_STR);
                $stmt->bindParam(':p13',$fecha,PDO::PARAM_STR);
                $stmt->bindParam(':p14',$hora,PDO::PARAM_STR);      
                $stmt->bindParam(':p15',$this->tipo_documento,PDO::PARAM_INT);
                               
                $stmt->bindParam(':p18',$estado,PDO::PARAM_INT);
                $stmt->bindParam(':p19',$idoficina,PDO::PARAM_INT);
                $stmt->bindParam(':p20',$cp,PDO::PARAM_INT);
                $stmt->bindParam(':p21',$_P['atentamente'],PDO::PARAM_STR);
                $stmt->bindParam(':p22',$ad,PDO::PARAM_INT);

                $stmt->bindParam(':p23',$_P['monto_caja'],PDO::PARAM_INT);
                $stmt->bindParam(':p24',$_P['tipo_pro'],PDO::PARAM_INT);
                

                $stmt->execute();
                $row = $stmt->fetchAll();
                $idenvio = $row[0][0];                
                //$stmt2  = $this->db->prepare('INSERT INTO envio_detalle (idenvio,descripcion,precio,cantidad,estado) values(:p1,:p2,:p3,:p4,:p5)');
                $stmt2 = $this->db->prepare('CALL insert_envio_detalle(:p1,:p2,:p3,:p4,:p5,:p6,:p7)');
                
                $estado = 1;
                
                for($i=0;$i<$obj->item;$i++)
                { 
                    if($obj->estado[$i])
                    {
                        $stmt2->bindParam(':p1',$idenvio,PDO::PARAM_INT);
                        $stmt2->bindParam(':p2',$obj->descripcion[$i],PDO::PARAM_INT);
                        $stmt2->bindParam(':p3',$obj->precio[$i],PDO::PARAM_INT);
                        $stmt2->bindParam(':p4',$obj->cantidad[$i],PDO::PARAM_INT);
                        $stmt2->bindParam(':p5',$estado,PDO::PARAM_INT);
                        $stmt2->bindParam(':p6',$cp,PDO::PARAM_INT);
                        $stmt2->bindParam(':p7',$obj->precioc[$i],PDO::PARAM_INT);
                        $stmt2->execute();
                    }
                }                
            $this->db->commit();
            unset($_SESSION['envios']);            
            return array('res'=>'1','msg'=>'Bien!','ide'=>$idenvio,'ce'=>$cp);
        }
        catch(PDOException $e) 
        {
            $this->db->rollBack();
            return array('res'=>'2','msg'=>'Error : '.$e->getMessage() . $str);
        }        
    }   

    function save_ce($p) 
    {
        $id = $p['id'];
        $monto_caja = $p['mont_c'];
        $idperiodo  = $_SESSION['idperiodo'];
        $idempleado = $_SESSION['idempleado'];    
        $idoficina = $_SESSION['idoficina'];
        $fecha = date('Y-m-d');
        $idenvio  = (int)$id;        
        try 
        { 
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->beginTransaction();   

            $sql = "SELECT * FROM envio WHERE idenvio = :id ";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id',$idenvio,PDO::PARAM_INT);
            $stmt->execute();
            $texto = "";
            foreach($stmt->fetchAll() as $row )
            {
                if($row['cpago']=="1")
                {
                    if($row['tipo_pro']=="1")
                        $texto = "MOVIMIENTO POR LA ENCOMIENDA ";
                    else 
                        $texto = "MOVIMIENTO POR EL TELEGIRO";
                    //Cambiando el estado a entregado
                    $update = $this->db->prepare("UPDATE envio set  estado = 3, 
                                                                    monto_caja =  :monto,
                                                        fecha_pago = '".$fecha."'
                                                  where idenvio = :id");
                    $update->bindParam(':id',$idenvio,PDO::PARAM_INT);
                    $update->bindParam(':monto',$monto_caja,PDO::PARAM_INT);
                    $update->execute();

                    //Generando los ingresos a caja y movimientos
                    $sql = "INSERT INTO movimiento(idempleado, idperiodo, fecha, estado, observacion, idproveedor, idoficina, tipo, idpropietario,num_mov)
                                                            values ('".$idempleado."',
                                                                    ".$idperiodo.", 
                                                                    '".$fecha."', 
                                                                    1 , 
                                                                    concat('".$texto." Nro ','".$row['numero']."'), 
                                                                    null, 
                                                                    ".$idoficina.", 
                                                                    1, 
                                                                    null, 
                                                                    '".$row['num_mov']."')";
                    
                    $genmov = $this->db->prepare($sql);
                    $genmov->execute();
                    $query = $this->db->prepare("call genn_tmov(".$idoficina.",1)");
                    $query->execute();


                    //Generando los movimientos detalles
                    $movimiento = $this->db->prepare("SELECT idmovimiento FROM movimiento WHERE num_mov = '".$row['num_mov']."' and idoficina = ".$idoficina);
                    $movimiento->execute();
                    $movs = $movimiento->fetchObject();
                    $idmov = $movs->idmovimiento;

                    //Elimino porsiaca hay duplicados
                    $del = $this->db->prepare("DELETE FROM movimiento_detalle where idmovimiento = ".$idmov);
                    $del->execute();

                    $sql = "INSERT INTO movimiento_detalle(idmovimiento,idconcepto_movimiento,monto,cantidad,descripcion) 
                            VALUES(".$idmov.",6,".$monto_caja.",1,'* ".$texto." ".$row['serie']." - ".$row['numero']."')";
                        $detallemov = $this->db->prepare($sql);
                        $detallemov->execute();
                    //}                
                }
            }
            $this->db->commit();
            return array('res'=>'1','msg'=>'Bien!','ide'=>$idenvio,'ce'=>0);
        }
        catch(PDOException $e) 
        {
            $this->db->rollBack();
            return array('res'=>'2','msg'=>'Error : '.$e->getMessage() . $str);
        }
    }
    function verifRemitente($nrodoc,$nombre)
    {
        $stmt = $this->db->prepare("SELECT count(*) as cant from pasajero where nrodocumento = :p");
        $stmt->bindParam(':p',$nrodoc,PDO::PARAM_STR);
        $stmt->execute();
        $r = $stmt->fetchObject();
        $flag = true;
        if($r->cant==0)
        {
            $stmt = $this->db->prepare("INSERT into pasajero(idtipo_pasajero,nombre,nrodocumento,direccion) 
                                        values(1,:p1,:p2,'')");
            $stmt->bindParam(':p1',$nombre,PDO::PARAM_STR);
            $stmt->bindParam(':p2',$nrodoc,PDO::PARAM_STR);
            $stmt->execute();

            $stmt = $this->db->prepare("SELECT MAX(idpasajero) from pasajero");
            $stmt->execute();
            $ro = $stmt->fetchAll();
            $idpasajero = $ro[0][0];
        }
        else 
        {
            $stmt = $this->db->prepare("SELECT idpasajero from pasajero where nrodocumento = :p");
            $stmt->bindParam(':p',$nrodoc,PDO::PARAM_STR);
            $stmt->execute();
            $ro = $stmt->fetchObject();
            $idpasajero = $ro->idpasajero;
            $flag = false;
        }
        return array($flag,$idpasajero);
    }
    function update($_P ) 
    {
        $idperiodo  = $_SESSION['idperiodo'];
        $idempleado = $_SESSION['idempleado'];    
        $idoficina = $_SESSION['idoficina'];
        $estado = 1;
        $hora = date('h:i:s');
        $fecha = $this->fdate($_P['fecha'],'EN');
        
        if($_P['salidas']=='')
        {
            $_P['salidas']=0;   
        }
        $cp = 0;
        if(isset($_P['cp']))
        {
            $cp=1;
        }
        
        $ad = 0;
        if(isset($_P['adomicilio']))
            $ad=1;
        $bval = true;

        $dni_ruc = $_P['nrodocumentor'];
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

        $remi = $this->verifRemitente($_P['nrodocumentor'],$_P['remitente']);
        $_P['idremitente'] = $remi[1];

        $stmt = $this->db->prepare("UPDATE envio set 
                                            iddestino = :p1,                                            
                                            idremitente = :p3,
                                            consignado = :p4,
                                            direccion = :p5,
                                            atentamente = :p6,
                                            adomicilio = :p7,
                                            monto_caja = :p8
                                    where idenvio = :idenvio ");


        try 
        { 
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->beginTransaction();                              

                $stmt->bindParam(':p1',$_P['iddestino'],PDO::PARAM_INT);                
                $stmt->bindParam(':p3',$_P['idremitente'],PDO::PARAM_STR);                                
                $stmt->bindParam(':p4',$_P['consignado'],PDO::PARAM_STR);
                $stmt->bindParam(':p6',$_P['atentamente'],PDO::PARAM_STR);
                $stmt->bindParam(':p5',$_P['direccion'],PDO::PARAM_STR);                                
                $stmt->bindParam(':p7',$ad,PDO::PARAM_INT);
                $stmt->bindParam(':p8',$_P['monto_caja'],PDO::PARAM_INT);
                $stmt->bindParam(':idenvio',$_P['idenvio'],PDO::PARAM_INT);                                
                $stmt->execute();


                
                $stmt3 = $this->db->prepare('DELETE FROM envio_detalle where idenvio = :id');
                $stmt3->bindParam(':id',$_P['idenvio'],PDO::PARAM_INT);
                $stmt3->execute();
                
                //Actualizamos el monto caja del movimiento
                $stmt3 = $this->db->prepare("SELECT num_mov FROM envio WHERE idenvio = :id");
                $stmt3->bindParam(':id',$_P['idenvio'],PDO::PARAM_INT);
                $stmt3->execute();
                $row1 = $stmt3->fetchObject();
                $num_mov = $row1->num_mov;
                $stmt3 = $this->db->prepare("SELECT idmovimiento from movimiento where num_mov = '{$num_mov}' and idoficina = {$idoficina}");
                $stmt3->execute();
                $row1 = $stmt3->fetchObject();
                $idmov = $row1->idmovimiento;
                $stmt3 = $this->db->prepare("UPDATE movimiento_detalle SET monto = :montox  where idmovimiento = {$idmov}");
                $stmt3->bindParam(':montox',$_P['monto_caja'],PDO::PARAM_INT);
                $stmt3->execute();

                //Insertamos de nuevo los detalles
                $stmt2 = $this->db->prepare('CALL insert_envio_detalle(:p1,:p2,:p3,:p4,:p5,:p6,:p7)');
                $obj    = $_SESSION['envios'];
                $estado = 1;
                for($i=0;$i<$obj->item;$i++)
                { 
                    if($obj->estado[$i])
                    {
                        $obj->precioc[$i] = 0;
                        $stmt2->bindParam(':p1',$_P['idenvio'],PDO::PARAM_INT);
                        $stmt2->bindParam(':p2',$obj->descripcion[$i],PDO::PARAM_INT);
                        $stmt2->bindParam(':p3',$obj->precio[$i],PDO::PARAM_INT);
                        $stmt2->bindParam(':p4',$obj->cantidad[$i],PDO::PARAM_INT);
                        $stmt2->bindParam(':p5',$estado,PDO::PARAM_INT);
                        $stmt2->bindParam(':p6',$cp,PDO::PARAM_INT);
                        $stmt2->bindParam(':p7',$obj->precioc[$i],PDO::PARAM_INT);
                        $stmt2->execute();
                    }
                }
                
            $this->db->commit();
            unset($_SESSION['envios']);            
            return array('res'=>'1','msg'=>'Bien!','ide'=>$_P['idenvio']);
        }
        catch(PDOException $e) 
        {
            $this->db->rollBack();
            return array('res'=>'2','msg'=>'Error : '.$e->getMessage() . $str);
        }
        
    }   
    function updateInfo($p)
    {
        $idperiodo  = $_SESSION['idperiodo'];
        $idempleado = $_SESSION['idempleado'];    
        $idoficina = $_SESSION['idoficina'];

        $stmt = $this->db->prepare("update envio_salidas set estado = 4 where idenvio = :p2 and estado <> 0");
        $stmt->bindParam(':p2',$p['idenvio'],PDO::PARAM_INT);
        $q = $stmt->execute();

        $fecha = date('Y-m-d');
        $hora = date('H:i:s');
        $stmt = $this->db->prepare("CALL insert_e_s(:p2,:p1,:p3,:p4,:p5)");
        $stmt->bindParam(':p1',$p['salidas'],PDO::PARAM_INT);
        $stmt->bindParam(':p2',$p['idenvio'],PDO::PARAM_INT);
        $stmt->bindParam(':p3',$idoficina,PDO::PARAM_INT);
        $stmt->bindParam(':p4',$fecha,PDO::PARAM_STR);
        $stmt->bindParam(':p5',$hora,PDO::PARAM_STR);
        $q = $stmt->execute();
        if(!$q) return 0;
            else return 1;
    }
    function sending($id,$tipo)
    {
        $fecha = date('Y-m-d');
        $hora = date('H:i:s');

        if($tipo==1)
        {

            $stmt = $this->db->prepare("UPDATE envio_salidas 
                                                    set estado = 2,
                                                        fecha_salida = '".$fecha."',
                                                        hora_salida = '".$hora."'
                                        where idenvio_salidas = :p2 ");                
            $stmt->bindParam(':p2',$id,PDO::PARAM_INT);        
            $q = $stmt->execute();

            $sql = "SELECT idenvio from envio_salidas where idenvio_salidas = :p2";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':p2',$id,PDO::PARAM_INT);        
            $q = $stmt->execute();
            $r = $stmt->fetchObject();

            $id = $r->idenvio;


            $stmt = $this->db->prepare("UPDATE envio set estado = 2  where idenvio = :p2 ");
            $stmt->bindParam(':p2',$id,PDO::PARAM_INT);        
            $q = $stmt->execute();

        }
        else
        {
            $stmt = $this->db->prepare("UPDATE envio_salidas 
                                                set estado = 3,
                                                    fecha_llegada = '".$fecha."',
                                                    hora_llegada = '".$hora."'
                                    where idenvio_salidas = :p2 ");                
            $stmt->bindParam(':p2',$id,PDO::PARAM_INT);        
            $q = $stmt->execute();

            $sql = "SELECT idenvio from envio_salidas where idenvio_salidas = :p2";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':p2',$id,PDO::PARAM_INT);        
            $q = $stmt->execute();
            $r = $stmt->fetchObject();

            $id = $r->idenvio;


            $stmt = $this->db->prepare("UPDATE envio set estado = 2  where idenvio = :p2 ");
            $stmt->bindParam(':p2',$id,PDO::PARAM_INT);        
            $q = $stmt->execute();
        }
        if(!$q) return array(0,'Error,','');
            else return array(1,$hora,$id);
    }
    function confirmRecepcion($id)
    {        
        $fecha = date('Y-m-d');
        $hora = date('H:i:s');


        $stmt = $this->db->prepare("UPDATE envio_salidas 
                                                set estado = 4
                                    where idenvio_salidas = :p2 ");                
        $stmt->bindParam(':p2',$id,PDO::PARAM_INT);
        $q = $stmt->execute();

        $sql = "SELECT idenvio from envio_salidas where idenvio_salidas = :p2";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':p2',$id,PDO::PARAM_INT);        
        $q = $stmt->execute();
        $r = $stmt->fetchObject();

        $id = $r->idenvio;

        $stmt = $this->db->prepare("UPDATE envio set 
                                        fecha_recepcion = :fecha, 
                                        hora_recepcion = :hora, 
                                        estado = 3  
                                    where idenvio = :p2 ");
        $stmt->bindParam(':fecha',$fecha,PDO::PARAM_STR);
        $stmt->bindParam(':hora',$hora,PDO::PARAM_STR);
        $stmt->bindParam(':p2',$id,PDO::PARAM_INT);        
        $q = $stmt->execute();
        if(!$q) return array(0,'Error,','');
            else return array(1,$hora,$id);
    }
    function anular_es($id)
    {
        $fecha = date('Y-m-d');
        $hora = date('H:i:s');


        $stmt = $this->db->prepare("UPDATE envio_salidas 
                                                set estado = 0
                                    where idenvio_salidas = :p2 ");                
        $stmt->bindParam(':p2',$id,PDO::PARAM_INT);
        $q = $stmt->execute();

        $sql = "SELECT idenvio from envio_salidas where idenvio_salidas = :p2";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':p2',$id,PDO::PARAM_INT);        
        $q = $stmt->execute();
        $r = $stmt->fetchObject();

        $id = $r->idenvio;
        
        if(!$q) return array(0,'Error,','');
            else return array(1,$hora,$id);
    }
    function cancelar_es($id)
    {
        $fecha = date('Y-m-d');
        $hora = date('H:i:s');
        $stmt = $this->db->prepare("SELECT count(*) as num from envio_salidas 
                                    where estado = 2 
                                            and idenvio_salidas = :p2");
        $stmt->bindParam(':p2',$id,PDO::PARAM_INT);
        $q = $stmt->execute();        
        $r = $stmt->fetchObject();
        $num = $r->num;        

        if($num>0)
        {
            $stmt = $this->db->prepare("UPDATE envio_salidas 
                                                set estado = 1
                                    where idenvio_salidas = :p2 ");
            $stmt->bindParam(':p2',$id,PDO::PARAM_INT);
            $q = $stmt->execute();

            $sql = "SELECT idenvio from envio_salidas where idenvio_salidas = :p2";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':p2',$id,PDO::PARAM_INT);
            $q = $stmt->execute();
            $r = $stmt->fetchObject();
            $id = $r->idenvio;        
            if(!$q) return array(0,'Error,','');
                else return array(1,$hora,$id);
        }
        else
        {
            return array(0,'Error','No se puede cancelar este salida de la encomienda, ya que ya fue recibida. ');
        }
        
    }
    function anular($p) 
    {        
        $stmt = $this->db->prepare("CALL anular_envio(:p1)");
        $stmt->bindParam(':p1', $p, PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }    
    function getdata($ide)
    {
        $stmt = $this->db->prepare("SELECT  e.serie,
                                            e.numero,
                                            concat(substring(e.fecha,9,2),'/',substring(e.fecha,6,2),'/',substring(e.fecha,1,4)) as fecha,
                                            e.hora,
                                            concat(coalesce(chofer.nombre,''),' ',coalesce(chofer.apellidos,'')) as chofer,
                                            '' as campo,
                                            case remitente.nrodocumento 
                                                when '00000000' then e.remitente
                                                else remitente.nombre end AS remitente,
                                            e.consignado,
                                            e.direccion as dir,
                                            v.placa,
                                            o.descripcion as oficina,
                                            o.direccion,
                                            o.telefono,
                                            d.descripcion as destino,
                                            e.atentamente,
                                            e.cpago,
                                            e.tipo_pro
                                    from envio as e inner join pasajero as remitente on remitente.idpasajero = e.idremitente
                                            left outer join envio_salidas as es on es.idenvio = e.idenvio and es.estado <> 0
                                            left outer join salida as s on s.idsalida = es.idsalida
                                            left outer join empleado as chofer on chofer.idempleado = s.idchofer and chofer.idtipo_empleado = 2        
                                            left outer join vehiculo as v on v.idvehiculo = s.idvehiculo
                                            inner join oficina as o on e.idoficina = o.idoficina
                                            INNER JOIN destino as d on d.iddestino = e.iddestino
                                    where  e.estado <> 0 and e.idenvio = :id                                            
                                    order by es.idenvio_salidas desc ");
        $stmt->bindParam(':id',$ide,PDO::PARAM_INT);
        $stmt->execute();
        $n = $stmt->rowCount();
        if($n>0)
        {
            $head = $stmt->fetchObject();
            $stmt2 = $this->db->prepare("SELECT  descripcion,
                                                precio,
                                                cantidad
                                        FROM envio_detalle
                                        WHERE idenvio = :id ");
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
    function getEstado($id)
    {
        $stmt = $this->db->prepare("SELECT estado from envio where idenvio = ".$id);
        $stmt->execute();
        $row = $stmt->fetchObject();
        return $row->estado;
    }

    function getlistsalidas($id)
    {
        $sql = "SELECT es.idenvio_salidas,
                       concat(chofer.nombre,' ',chofer.apellidos) as chofer,
                       v.placa as vehiculo,
                       d.descripcion as destino,
                       d2.descripcion as origen,
                       case es.estado when 1 then 'REGISTRADO'
                        when 2 then 'ENVIADO'
                        when 3 then 'LLEGADO'
                        when 4 then 'FINALIZADO'
                        when 0 then 'ANULADO'
                       end as estado,
                       d.iddestino,
                       es.estado as idestado,
                       e.cpago,
                       e.idenvio,
                       es.idoficina
                from envio_salidas as es inner join salida as s on es.idsalida = s.idsalida
                    inner join empleado as chofer on chofer.idempleado = s.idchofer
                    inner join vehiculo as v on v.idvehiculo = s.idvehiculo
                    inner join destino as d on d.iddestino = s.iddestino
                    inner join oficina as o on o.idoficina = es.idoficina 
                    inner join destino as d2 on d2.iddestino = o.idsucursal
                    inner join envio as e on e.idenvio = es.idenvio
                where  chofer.idtipo_empleado = 2 and es.idenvio = :ide
                order by es.idenvio_salidas asc";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':ide',$id,PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    //Esta funcion va verificar si es posible que desde
    //si se puede agregar una nueva salida
    function getPermisoAddNewDestino($id)
    {
        $sql = "SELECT d.iddestino,
                       d.descripcion,
                       es.estado
                from envio_salidas as es inner join salida as s on es.idsalida = s.idsalida    
                    inner join destino as d on d.iddestino = s.iddestino
                    inner join oficina as o on o.idoficina = es.idoficina 
                    inner join destino as d2 on d2.iddestino = o.idsucursal
                where es.estado in (1,2,3) and es.idenvio = :ide
                order by es.idenvio desc
                limit 1;";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':ide',$id,PDO::PARAM_INT);
        $stmt->execute();
        $r = $stmt->fetchObject();
        $estado = $r->estado;
        $resp = 0;
        if($r->iddestino==$_SESSION['idsucursal'])
        {   
            if($estado==2)
                $resp = 0;
            else                
                $resp = 1;
        }
        else
        {       
            $sql = "SELECT idoficina
                    from envio
                    where idenvio = :ide";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':ide',$id,PDO::PARAM_INT);
            $stmt->execute();
            $r = $stmt->fetchObject();

            if($r->idoficina==$_SESSION['idoficina'])
                { 
                    //echo $estado."M";
                    if($estado!=0)
                        $resp = 0;
                    else
                        $resp = 1;                    
                }
            else
                { $resp=0; }
        }
        return $resp;
    }
}
?>
