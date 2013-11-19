<?php
include_once("Main.php");
class caja extends Main
{
   
    function verifApertura($turno,$fecha,$idoficina,$idempleado)
    {        
        $query = "SELECT count(*) as numero,estado,idcaja
                                    FROM caja 
                                    WHERE  turno = {$turno} 
                                        and fecha = '{$fecha}' 
                                        and idusuario = '{$idempleado}' 
                                        and idoficina = {$idoficina}
                                    group by estado,idcaja";
        //echo $query;
        $stmt = $this->db->prepare($query);  
                                        
        $stmt->execute();
        $num = $stmt->rowCount();        
        $r = $stmt->fetchObject();
        $n = $r->numero;
        
        if($num==0)
        {
            return array(false,0);
        }
        else 
        {
            return array(true,$r->estado,$r->idcaja);
        }
    }

    function verifAperturaAll($turno,$idoficina,$idempleado)
    {
        $query = "SELECT fecha,idcaja 
                                    FROM caja 
                                    WHERE estado = 1 
                                        and turno = {$turno} 
                                        and idusuario = '{$idempleado}'
                                        and idoficina = {$idoficina}";
        
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $r = $stmt->fetchObject();
        $n = $stmt->rowCount();
        if($n>0) return array(true,$r->fecha,$r->idcaja);        
            else return array(false,'',''); 
    }
    function getCaja($turno,$fecha)
    {
        $stmt = $this->db->prepare("SELECT idcaja FROM caja WHERE estado = 1 and turno = {$turno} and fecha = '{$this->fdate($fecha,'EN')}' and idusuario = :idu ");
        $stmt->bindParam(':idu',$_SESSION['idempleado'],PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchObject();
    }
    function aperturar($fecha)
    {
        //Validar que la fecha y el turno no esten aperturados o ya esten cerrados
        //Verificamos si la caja en la fecha, turno y usuario ya estan aperturadas.
        $fecha = $this->fdate($fecha,'EN');
        $turno = $_SESSION['turno'];
        $idoficina = $_SESSION['idoficina'];
        $idempleado = $_SESSION['idempleado'];

        $verif = $this->verifApertura($turno,$fecha,$idoficina,$idempleado);
        if(!$verif[0])
        {
            $si = number_format($this->getSaldoInicial($turno,$idoficina,$idempleado),5);
            //aperturar caja
            $stmt = $this->db->prepare("INSERT into caja(idusuario,fecha,turno,estado,saldo_inicial,idoficina) 
                                        values(:p0,:p1,:p2,1,:si,:p3)");
            $stmt->bindParam(':p0',$idempleado,PDO::PARAM_STR);
            $stmt->bindParam(':p1',$fecha,PDO::PARAM_STR);
            $stmt->bindParam(':p2',$turno,PDO::PARAM_INT);
            $stmt->bindParam(':si',$si,PDO::PARAM_INT);
            $stmt->bindParam(':p3',$idoficina,PDO::PARAM_INT);
            $p1 = $stmt->execute();
            $p2 = $stmt->errorInfo();
            return array($p1 , $p2[2]);
        }
        else 
        {
            //Existe la caja
            if($verif[1]==1)
            {
                //Caja aperturada
                return array(false,"YA SE A APERTURADO UNA CAJA EN ESTA FECHA, TURNO Y USUARIO");                
            }
            else
            {
                //Caja cerrada
                return array(false,"YA SE A CERRADO LA CAJA EN ESTA FECHA, TURNO Y USUARIO");
            }
        }
    }    
    function cerrar($saldo,$turno,$idoficina,$fecha,$idempleado)
    {
        //Obtenemos el saldo del sistema
        $fechac = date('Y-m-d');
        $ssistema = $this->getSaldoSistema($turno,$fecha,$idoficina,$idempleado);
        $sdeclarado = $saldo;
        $fecha = $this->fdate($fecha,'EN');
        
        $stmt = $this->db->prepare("select idcaja from caja WHERE fecha = '{$fecha}' 
                                            and turno = {$turno}
                                            and idusuario = '{$idempleado}'
                                            and idoficina = {$idoficina}");
                                            
        $stmt->execute();
        $roww = $stmt->fetchObject();
        $idcaja = $roww->idcaja;
        $query = "UPDATE caja set saldo_declarado = {$sdeclarado}, 
                                                    saldo_real = {$ssistema}, 
                                                    estado = 2,
                                                    fechacierre = '{$fechac}'
                                    WHERE fecha = '{$fecha}' 
                                            and turno = {$turno}
                                            and idusuario = '{$idempleado}'
                                            and idoficina = {$idoficina}";
        
        $stmt = $this->db->prepare($query);        
        try 
        { 
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->beginTransaction();                                
                $stmt->execute();
             $this->db->commit();
             //Obtenemos los datos para el reporte cierre de caja
             $rows = $this->getDataCaja($fecha,$turno,$_SESSION['oficina']);
             $idusuario = $_SESSION['idempleado'];
             $idoficina = $_SESSION['idoficina'];
             //$_SESSION = array();
             //session_destroy();
             //session_start();
             $_SESSION['idemp'] = $idusuario;
             $_SESSION['idof'] = $idoficina;
             return array('res'=>"1",'rows'=>$rows,'idoficina'=>$idoficina,'idcaja'=>$idcaja);
        }
        catch(PDOException $e)
        {
            $this->db->rollBack();
            return array('res'=>"2",'msg'=>'Error : '.$e->getMessage());
        }        
    }
    function getSaldoInicial($turno,$idoficina,$idempleado)
    {
        $stmt = $this->db->prepare("SELECT coalesce(saldo_inicial+saldo_real,0),deposito
                                    from caja
                                    where estado=2 and turno = {$turno}  
                                          and idusuario = '{$idempleado}'
                                          and idoficina = {$idoficina}
                                    order by idcaja
                                    desc limit 1");        
        $stmt->execute();
        $r = $stmt->fetchAll();
        $si = $r[0][0];
        if($r[0][1]==1)
        {
           $stmt = $this->db->prepare("SELECT monto from caja_banco where idoficina = ".$_SESSION['idoficina']." and estado = 1 
                                    order by idcaja_banco desc limit 1");
           $stmt->execute();
           $r = $stmt->fetchObject();
           $monto = (float)$r->monto;
           $si -= $monto;
        }
        
        
        return $si;
    }
    function getSaldoSistema($turno,$fecha,$oficina,$idempleado)
    {        
        $fecha = $this->fdate($fecha,'EN');
        $query = "SELECT SUM(md.monto*md.cantidad) as saldo
                                    FROM movimiento as m inner join movimiento_detalle as md on 
                                        md.idmovimiento = m.idmovimiento inner join empleado as e on
                                        e.idempleado = m.idempleado
                                        and e.idtipo_empleado = 1
                                    WHERE m.estado = 1 and m.fecha = '{$fecha}' 
                                            and e.turno = {$turno}
                                            and m.idoficina = {$oficina}
                                         and m.idempleado = '{$idempleado}' ";
       // echo $query;
        $stmt = $this->db->prepare($query);      
        $stmt->execute();
        $r = $stmt->fetchObject();
        $saldo = (double)$r->saldo;
        return $saldo;
    }
    function getDataCaja($fecha,$turno,$oficina)
    {
        $stmt = $this->db->prepare("SELECT saldo_inicial,saldo_declarado,saldo_real,fecha,turno,idusuario
                                    from caja where fecha = '{$fecha}' and turno = {$turno} and idusuario = :idu ");
        $stmt->bindParam(':idu',$_SESSION['idempleado'],PDO::PARAM_STR);        
        $stmt->execute();
        $r = $stmt->fetchObject();
        return array($r->saldo_inicial,$r->saldo_declarado,$r->saldo_real,$r->fecha,$r->turno,$r->idusuario,$oficina);
    }        
}
?>