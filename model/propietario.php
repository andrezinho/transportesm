<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include_once("Main.php");
class propietario extends Main {
    function Start() 
    {

        $statement = $this->db->prepare("SELECT empleado.idempleado,
                                                empleado.idperfil,
                                                concat(empleado.nombre,' ',empleado.apellidos) as nombres,
                                                perfil.descripcion as perfil,
                                                empleado.login as login,
                                                o.descripcion as oficina,
                                                o.idoficina,
                                                s.descripcion as sucursal,
                                                s.idsucursal as idsucursal
                                         FROM empleado inner join perfil on empleado.idperfil = perfil.idperfil
                                                inner join oficina as o on o.idoficina = empleado.idoficina
                                                inner join destino as s on o.idsucursal = s.iddestino
                                         WHERE empleado.login = :propietario AND empleado.password = :password ");
        $statement->bindParam (":propietario", $_POST['usuario'] , PDO::PARAM_STR);
        $statement->bindParam (":password", $_POST['password'] , PDO::PARAM_STR);
        $statement->execute();                
        $obj = $statement->fetchObject();
        return array('flag'=>$statement->rowCount() , 'obj'=>$obj );
    }
    function getpropietario($id)
    {
        $stmt = $this->db->prepare("select idempleado,concat(empleado.nombres,' ',empleado.apellidos) as nombres 
                                    from empleado where idempleado = ? ");
        $stmt->bindParam(1,$id,PDO::PARAM_STR);
        $stmt->execute();
        $obj = $stmt->fetchObject();
        return $obj;
        
    }
    function Veripropietario($pw,$id)
    {
        if($id==$_SESSION['idempleado'])
        {
            $stmt = $this->db->prepare("select count(idempleado) as num from empleado where idempleado = ? and clave = ? ");
            $stmt->bindParam(1,$id,PDO::PARAM_STR);
            $stmt->bindParam(2,$pw,PDO::PARAM_STR);
            $stmt->execute();
            $obj = $stmt->fetchObject();
            return $obj->num;
        }
        else {
            return 0;
        }
    }
    function save_change_passw($pw,$id)
    {
       if($id==$_SESSION['idempleado'])
        {
           $stmt = $this->db->prepare("update empleado set clave = ? where idempleado = ?");
           $stmt->bindParam(1,$pw,PDO::PARAM_STR);
           $stmt->bindParam(2,$id,PDO::PARAM_STR);
           $r = $stmt->execute();
           return $r;
        } 
        else 
        {
           return false;
        }
    }
    
    function index($query , $p ,$c) {
        $sql = "SELECT empleado.idempleado,                        
                       concat(empleado.nombre,' ',empleado.apellidos) as nombres,
                       concat(o.descripcion,' (',s.descripcion,') '),
                       case empleado.estado when 1 then '<p style=\"color:green\">ACTIVO</p>' else '<p style=\"color:red\">INACTIVO</p>' end                       
                    FROM tipo_empleado as te inner join empleado on te.idtipo_empleado = empleado.idtipo_empleado
                            inner join oficina as o on o.idoficina = empleado.idoficina
                            inner join sucursal as s on s.idsucursal = o.idsucursal
             where {$c} like :query and empleado.idtipo_empleado = 3
             order by empleado.nombre, empleado.apellidos";
             
        $param = array(array('key'=>':query' , 'value'=>"%$query%" , 'type'=>'STR' ));
        $data['total'] = $this->getTotal( $sql, $param );
        $data['rows'] =  $this->getRow($sql, $param , $p );
        $data['rowspag'] =  $this->getRowPag($data['total'], $p );
        return $data;
    }
    
    function edit($id ) {
        $stmt = $this->db->prepare("SELECT * FROM empleado WHERE idempleado = :id and idtipo_empleado = 3");
        $stmt->bindParam(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchObject();
    }
    function insert($_P ) 
    {
        $idtipo_empleado = 3;
        $accionista = 0;
        $inquilino = 0;
        
        if(isset($_P['accionista'])&&$_P['accionista']!="")
        $accionista = $_P['accionista'];
        
        if(isset($_P['inquilino'])&&$_P['inquilino']!="")
        $inquilino = $_P['inquilino'];
        
        $fechan = $this->fdate($_P['fecha_nacimiento'],'EN');
        $fechar = $this->fdate($_P['fecha_registro'],'EN');
        $fechae = $this->fdate($_P['fecha_egreso'],'EN');
        $fechav = $this->fdate($_P['fecha_v_dni'],'EN');
        
        
        $stmt = $this->db->prepare('insert into empleado (  idempleado,
                                                            idtipo_empleado,
                                                            idoficina,
                                                            nombre,
                                                            apellidos,
                                                            ruc,
                                                            fecha_nacimiento,
                                                            estado,
                                                            celular,
                                                            fecha_registro,
                                                            accionista,
                                                            inquilino,
                                                            fecha_egreso,
                                                            fecha_v_dni,
                                                            direccion)
                                    values(:p1,:p2,:p3,:p4,:p5,:p6,:p7,:p8,:p9,:p10,:p11,:p12,:p13,:p14,:p15)');
        $stmt->bindParam(':p1', $_P['idempleado'] , PDO::PARAM_STR);
        $stmt->bindParam(':p2', $idtipo_empleado , PDO::PARAM_INT);
        $stmt->bindParam(':p3', $_P['idoficina'] , PDO::PARAM_INT);
        $stmt->bindParam(':p4', $_P['nombre'] , PDO::PARAM_STR);
        $stmt->bindParam(':p5', $_P['apellidos'] , PDO::PARAM_STR);
        $stmt->bindParam(':p6', $_P['ruc'] , PDO::PARAM_STR);        
        $stmt->bindParam(':p7', $fechan , PDO::PARAM_STR);
        $stmt->bindParam(':p8', $_P['activo'] , PDO::PARAM_BOOL);
        $stmt->bindParam(':p9', $_P['celular'] , PDO::PARAM_STR);
        $stmt->bindParam(':p10', $fechar , PDO::PARAM_STR);
        $stmt->bindParam(':p11', $accionista , PDO::PARAM_INT);
        $stmt->bindParam(':p12', $inquilino , PDO::PARAM_INT);
        $stmt->bindParam(':p13', $fechae , PDO::PARAM_STR);
        $stmt->bindParam(':p14', $fechav , PDO::PARAM_STR);
        $stmt->bindParam(':p15', $_P['direccion'] , PDO::PARAM_STR);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    
    function update($_P ) 
    {        
        $fechae = $this->fdate($_P['fecha_egreso'],'EN');
        $fechav = $this->fdate($_P['fecha_v_dni'],'EN');
        $fechan = $this->fdate($_P['fecha_nacimiento'],'EN');
        $fechar = $this->fdate($_P['fecha_registro'],'EN');
        $stmt = $this->db->prepare('UPDATE empleado
                                   SET  idoficina=:p1,
                                        nombre=:p2,
                                        apellidos=:p3, 
                                        ruc=:p4,
                                        fecha_nacimiento=:p5,
                                        estado=:p6,
                                        celular=:p7,
                                        fecha_registro=:p8,
                                        fecha_egreso=:p9,
                                        fecha_v_dni=:p10,
                                        direccion=:p11
                                 WHERE idempleado = :idempleado and idtipo_empleado = 3');       
        $stmt->bindParam(':p1', $_P['idoficina'] , PDO::PARAM_INT);
        $stmt->bindParam(':p2', $_P['nombre'] , PDO::PARAM_STR);
        $stmt->bindParam(':p3', $_P['apellidos'] , PDO::PARAM_STR);
        $stmt->bindParam(':p4', $_P['ruc'] , PDO::PARAM_STR);        
        $stmt->bindParam(':p5', $fechan , PDO::PARAM_STR);
        $stmt->bindParam(':p6', $_P['activo'] , PDO::PARAM_BOOL);
        $stmt->bindParam(':p7', $_P['celular'] , PDO::PARAM_STR);
        $stmt->bindParam(':p8', $fechar , PDO::PARAM_STR);
        $stmt->bindParam(':idempleado', $_P['idempleado'] , PDO::PARAM_STR);
        $stmt->bindParam(':p9', $fechae , PDO::PARAM_STR);
        $stmt->bindParam(':p10', $fechav , PDO::PARAM_STR);
        $stmt->bindParam(':p11', $_P['direccion'] , PDO::PARAM_STR);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
//    function delete($_P ) {
//        $stmt = $this->db->prepare("DELETE FROM perfil WHERE idperfil = :p1");
//        $stmt->bindParam(':p1', $_P['idperfil'] , PDO::PARAM_STR);
//        $p1 = $stmt->execute();
//        $p2 = $stmt->errorInfo();
//        return array($p1 , $p2[2]);
//    }
    function getchofer($query,$field)
    {
        $query = "%".$query."%";
        $statement = $this->db->prepare("SELECT idempleado, 
                                                concat(nombre,' ',apellidos) as nombre,
                                                aleas
                                         FROM empleado
                                         WHERE {$field} like :query and idtipo_empleado = 2
                                         limit 10");
        $statement->bindParam (":query", $query , PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetchAll();
    }
       function getpropietario1($query,$field)
    {
        $query = "%".$query."%";
        $statement = $this->db->prepare("SELECT idempleado, 
                                                concat(nombre,' ',apellidos) as nombre
                                         FROM empleado
                                         WHERE {$field} like :query and idtipo_empleado = 3
                                         limit 10");
        $statement->bindParam (":query", $query , PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetchAll();
    }
}
?>