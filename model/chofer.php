<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include_once("Main.php");
class chofer extends Main {

    function Verichofer($pw,$id)
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

    
    function index($query , $p ,$c) {
        $sql = "SELECT empleado.idempleado,                        
                       concat(empleado.nombre,' ',empleado.apellidos) as nombres,
                       empleado.aleas,
                       concat(o.descripcion,' (',s.descripcion,') '),
                       case empleado.estado when 1 then '<p style=\"color:green\">ACTIVO</p>' else '<p style=\"color:red\">INACTIVO</p>' end                       
                    FROM tipo_empleado as te inner join empleado on te.idtipo_empleado = empleado.idtipo_empleado
                            inner join oficina as o on o.idoficina = empleado.idoficina
                            inner join destino as s on s.iddestino = o.idsucursal
             where {$c} like :query and empleado.idtipo_empleado = 2
             order by empleado.nombre, empleado.apellidos";
             
        $param = array(array('key'=>':query' , 'value'=>"%$query%" , 'type'=>'STR' ));
        $data['total'] = $this->getTotal( $sql, $param );
        $data['rows'] =  $this->getRow($sql, $param , $p );
        $data['rowspag'] =  $this->getRowPag($data['total'], $p );
        return $data;
    }
    
    function edit($id ) {
        $stmt = $this->db->prepare("SELECT * FROM empleado WHERE idempleado = :id and idtipo_empleado = 2");
        $stmt->bindParam(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchObject();
    }
    function insert($_P ) 
    {
        $idtipo_empleado = 2;
        $fechae = $this->fdate($_P['fecha_egreso'],'EN');
        $fechav = $this->fdate($_P['fecha_v_dni'],'EN');
        $fechan = $this->fdate($_P['fecha_nacimiento'],'EN');
        $fechar = $this->fdate($_P['fecha_registro'],'EN');
        $fechal = $this->fdate($_P['fecha_v_licencia'],'EN');
        
        if($_P['fecha_v_capacitacion']!="")
            $fechac = $this->fdate($_P['fecha_v_capacitacion'],'EN');
        else
            $fechac = NULL;
        
        $stmt = $this->db->prepare('insert into empleado (  idempleado,
                                                            idtipo_empleado,
                                                            idoficina,
                                                            nombre,
                                                            apellidos,
                                                            aleas,
                                                            ruc,
                                                            fecha_nacimiento,
                                                            estado,
                                                            celular,
                                                            fecha_registro,
                                                            turno,
                                                            fecha_egreso,
                                                            fecha_v_dni,
                                                            direccion,
                                                            fecha_v_licencia,
                                                            categoria,
                                                            fecha_v_capacitacion,record)
                                    values(:p1,:p2,:p3,:p4,:p5,:p6,:p7,:p8,:p9,:p10,:p11,:p12,:p13,:p14,:p15,:p16,:p17,:p18,:p19)');
        $stmt->bindParam(':p1', $_P['idempleado'] , PDO::PARAM_STR);
        $stmt->bindParam(':p2', $idtipo_empleado , PDO::PARAM_INT);
        $stmt->bindParam(':p3', $_P['idoficina'] , PDO::PARAM_INT);
        $stmt->bindParam(':p4', $_P['nombre'] , PDO::PARAM_STR);
        $stmt->bindParam(':p5', $_P['apellidos'] , PDO::PARAM_STR);
        $stmt->bindParam(':p6', $_P['aleas'] , PDO::PARAM_STR);
        $stmt->bindParam(':p7', $_P['ruc'] , PDO::PARAM_STR);        
        $stmt->bindParam(':p8', $fechan , PDO::PARAM_STR);
        $stmt->bindParam(':p9', $_P['activo'] , PDO::PARAM_BOOL);
        $stmt->bindParam(':p10', $_P['celular'] , PDO::PARAM_STR);
        $stmt->bindParam(':p11', $fechar , PDO::PARAM_STR);
        $stmt->bindParam(':p12', $_P['turno'] , PDO::PARAM_INT);
        $stmt->bindParam(':p13', $fechae , PDO::PARAM_STR);
        $stmt->bindParam(':p14', $fechav , PDO::PARAM_STR);
        $stmt->bindParam(':p15', $_P['direccion'] , PDO::PARAM_STR);
        $stmt->bindParam(':p16', $fechal , PDO::PARAM_STR);
        $stmt->bindParam(':p17', $_P['categoria'] , PDO::PARAM_STR);
        $stmt->bindParam(':p18', $fechac , PDO::PARAM_STR);
        $stmt->bindParam(':p19', $_P['record'] , PDO::PARAM_STR);
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
        $fechal = $this->fdate($_P['fecha_v_licencia'],'EN');
        
        $record = $_POST['record'];
        //echo $record;
        if($_P['fecha_v_capacitacion']!="")
            $fechac = $this->fdate($_P['fecha_v_capacitacion'],'EN');
        else
            $fechac = NULL;
        $stmt = $this->db->prepare('UPDATE empleado
                                   SET  idoficina=:p1,
                                        nombre=:p2,
                                        apellidos=:p3,
                                        aleas=:p4,
                                        ruc=:p5,
                                        fecha_nacimiento=:p6,
                                        estado=:p7,
                                        celular=:p8,
                                        fecha_registro=:p9,
                                        turno=:p10,
                                        fecha_egreso=:p11,
                                        fecha_v_dni=:p12,
                                        direccion=:p13,
                                        fecha_v_licencia=:p14,
                                        categoria=:p15,
                                        fecha_v_capacitacion=:p16,
                                        record=:p17
                                 WHERE idempleado = :idempleado');       
        $stmt->bindParam(':p1', $_P['idoficina'] , PDO::PARAM_INT);
        $stmt->bindParam(':p2', $_P['nombre'] , PDO::PARAM_STR);
        $stmt->bindParam(':p3', $_P['apellidos'] , PDO::PARAM_STR);
        $stmt->bindParam(':p4', $_P['aleas'] , PDO::PARAM_STR);
        $stmt->bindParam(':p5', $_P['ruc'] , PDO::PARAM_STR);        
        $stmt->bindParam(':p6', $fechan , PDO::PARAM_STR);
        $stmt->bindParam(':p7', $_P['activo'] , PDO::PARAM_BOOL);
        $stmt->bindParam(':p8', $_P['celular'] , PDO::PARAM_STR);
        $stmt->bindParam(':p9', $fechar , PDO::PARAM_STR);
        $stmt->bindParam(':p10', $_P['turno'] , PDO::PARAM_INT);
        $stmt->bindParam(':idempleado', $_P['idempleado'] , PDO::PARAM_STR);
        $stmt->bindParam(':p11', $fechae , PDO::PARAM_STR);
        $stmt->bindParam(':p12', $fechav , PDO::PARAM_STR);
        $stmt->bindParam(':p13', $_P['direccion'] , PDO::PARAM_STR);
        $stmt->bindParam(':p14', $fechal , PDO::PARAM_STR);
        $stmt->bindParam(':p15', $_P['categoria'] , PDO::PARAM_STR);
        $stmt->bindParam(':p16', $fechac , PDO::PARAM_STR);
        $stmt->bindParam(':p17', $record , PDO::PARAM_STR);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }

    function getchofer($query,$field)
    {
        $query = "%".$query."%";
        $statement = $this->db->prepare("SELECT concat(nombre,' ',apellidos) as nombre
                                         FROM empleado
                                         WHERE {$field} like :query and idtipo_empleado = 2
                                         limit 10");
        $statement->bindParam (":query", $query , PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetchAll();
    }
}
?>