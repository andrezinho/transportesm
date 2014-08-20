<?php
include_once("Main.php");
class reclamos extends Main
{
    /*
        Estados:
            1: Registrado
            2: Respondido
            3: Anulado
    */
    function index($query , $p ) 
    {
        $sql = "select r.idreclamos,
                        r.fecha,
                        r.nombres,
                        r.dni,
                        concat(ts.descripcion,' ',case ts.idtipo_servicio when 4 then concat('(',r.otros,')') else '' end),
                        case r.tipo when 1 then 'RECLAMO' else 'QUEJA' end,
                        case r.estado when 1 then 'PENDIENTE' else 'ATENDIDO' end
                 from reclamos as r inner join tipo_servicio as ts on ts.idtipo_servicio = r.idtipo_servicio
                 where r.nombres like :query
                 order by r.idreclamos desc";
        $param = array(array('key'=>':query' , 'value'=>"%$query%" , 'type'=>'STR' ));
        $data['total'] = $this->getTotal( $sql, $param );
        $data['rows'] =  $this->getRow($sql, $param , $p );
        $data['rowspag'] = $this->getRowPag($data['total'], $p );
        return $data;
    }

    function insert($_P ) 
    {
        $fecha = date('Y-m-d');
        $anio = date('Y');
        $acciones="";
        $estado = 1;
        try
        {
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->beginTransaction();                
            $stmt = $this->db->prepare("insert into reclamos (fecha,anio,nombres,domicilio,dni,telefono,email,
                                                          idtipo_servicio,tipo,detalle,acciones,estado,otros) 
                                    values(:p1,:p2,:p3,:p4,:p5,:p6,:p7,:p8,:p9,:p10,:p11,:p12,:p13)");
            $stmt->bindParam(':p1', $fecha , PDO::PARAM_STR);
            $stmt->bindParam(':p2', $anio , PDO::PARAM_INT);
            $stmt->bindParam(':p3', $_P['nombres'] , PDO::PARAM_STR);
            $stmt->bindParam(':p4', $_P['domicilio'] , PDO::PARAM_STR);
            $stmt->bindParam(':p5', $_P['dni'] , PDO::PARAM_STR);
            $stmt->bindParam(':p6', $_P['telefono'] , PDO::PARAM_STR);
            $stmt->bindParam(':p7', $_P['email'] , PDO::PARAM_STR);
            $stmt->bindParam(':p8', $_P['idtipo_servicio'] , PDO::PARAM_INT);
            $stmt->bindParam(':p9', $_P['idtipo_reclamo'] , PDO::PARAM_INT);
            $stmt->bindParam(':p10', $_P['detalle'] , PDO::PARAM_STR);
            $stmt->bindParam(':p11', $acciones , PDO::PARAM_STR);
            $stmt->bindParam(':p12', $estado , PDO::PARAM_INT);
            $stmt->bindParam(':p13', $_P['otro'] , PDO::PARAM_STR);
            $stmt->execute();            

            //Obtenemos el ultimo reclamo generado
            $stmt2 = $this->db->prepare("select max(idreclamos) as idreclamo from reclamos limit 1");
            $stmt2->execute();
            $row = $stmt2->fetchObject();
            $idreclamo = $row->idreclamo;

            //Enviamos un correo de confirmacion al reclamante
            $this->enviar_email($idreclamo);
            $idreclamo = str_pad($idreclamo, 5, '0',0);
            $this->db->commit();            
            return array('res'=>"1",'msg'=>'Bien!','idr'=>$idreclamo);
        }
        catch(PDOException $e) 
        {
            $this->db->rollBack();
            return array('res'=>"2",'msg'=>'Error : '.$e->getMessage() . $str);
        }        
    }
    function enviar_email($idreclamo)
    {
        $stmt = $this->db->prepare("select * from reclamos where idreclamos = ".$idreclamo);
        $stmt->execute();
        $r = $stmt->fetchObject();
        $email_from = "admin@empresasanmartin.com";
        
        $email_to = $r->email;        
        $email_subject = "Libro de Reclamaciones - Empresa SanMartin";

        $email_messaje = "<b>".$obj->nombres.",</b><br/>";
        $email_messaje .= "Su reclamo fue registrado satisfactoriamente, el cual sera atendido lo mas pronto posible.<br/>";
        $email_messaje .= "Para que usted pueda hacer seguimiento de su Reclamo puede hacerlo a traves de nuestras oficinas o desde nuestra pagina web.<br/>";
        $email_messaje .= "Descripcion del Reclamo: <br/>";
        $email_messaje .= "<i>".$obj->detalle."</i>";

        $headers = 'From: '.$email_from."\r\n".
        'Reply-To: '.$email_from."\r\n" .
        'X-Mailer: PHP/' . phpversion();
        @mail($email_to, $email_subject, $email_message, $headers);

    }
    function edit($id)
    {
        $id = (int)$id;
        $stmt = $this->db->prepare(" SELECT * 
                                    FROM reclamos
                                     WHERE idreclamos = :id");
        $stmt->bindParam(':id', $id , PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetchObject();       
        //Retornando cabecera
        return $row;
    }

    function update($_P ) {
        
        $_P['activo']=2;
        $stmt = $this->db->prepare("update reclamos set acciones = :p1, estado = :p2 where idreclamos = :idreclamos");
        $stmt->bindParam(':p1', $_P['acciones'] , PDO::PARAM_STR);
        $stmt->bindParam(':p2', $_P['activo'] , PDO::PARAM_INT);
        $stmt->bindParam(':idreclamos', $_P['idreclamos'] , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    function delete($_P ) {
        $stmt = $this->db->prepare("DELETE FROM reclamos WHERE idreclamos = :p1");
        $stmt->bindParam(':p1', $_P , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
}
?>