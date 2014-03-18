<?php
require_once '../lib/controller.php';
require_once '../lib/view.php';
require_once '../model/salida.php';
require_once '../model/tipo_pasajero.php';
require_once '../model/destino.php';
class salidaController extends Controller
{
   public function index() {
        if (!isset($_GET['p'])){$_GET['p']=1;}
        if(!isset($_GET['q'])){$_GET['q']="";} 
        if(!isset($_GET['criterio'])){$_GET['criterio']="chofer.nombre";} 
        $obj = new salida();
        $data = array();
        $data['data'] = $obj->index($_GET['q'],$_GET['p'],$_GET['criterio']);
        $data['query'] = $_GET['q'];
        $data['pag'] = $this->Pagination(array('rows'=>$data['data']['rowspag'],'url'=>'index.php?controller=salida&action=index','query'=>$_GET['q'],'trows'=>$data['data']['total']));
        $this->registros = $data['data']['rows'];
        $this->columnas = array("ID"=>array('ancho'=>'5','align'=>'center','titulo'=>'Codigo de salida'),
                                "<p style='font-size:9px'>FECHA REGISTRO</p>"=>array('ancho'=>'8','align'=>'center'),
                                "<p style='font-size:9px'>HORA REGIST.</p>"=>array('ancho'=>'4','align'=>'center'),
                                "CHOFER"=>array(),
                                "VEHICULO"=>array('ancho'=>9,'align'=>'center'),
                                "DESTINO"=>array('ancho'=>13,'align'=>'center'),
                                "TICKET"=>array('ancho'=>9,'align'=>'center','colspan'=>1),
                                "TIPO"=>array('ancho'=>4,'align'=>'center'),
                                "ESTADO"=>array('ancho'=>'10','align'=>'center'),
                                "USER"=>array('ancho'=>7,'align'=>'center'),
                                "&nbsp;"=>array('ancho'=>3,'align'=>'center'),
                                "<p style='font-size:9px'>&nbsp;</p>"=>array('ancho'=>3,'align'=>'center','titulo'=>'Confirmar Salida'),
                                "<p style='font-size:5px'>&nbsp;</p>"=>array('ancho'=>3,'align'=>'center','titulo'=>'Anular')
                                );         
        $this->busqueda = array("chofer.nombre"=>"Chofer",
                                "v.placa"=>"Placa de Vehiculo",
                                "s.numero"=>"Numero de Ticket");
        $this->asignarAccion('eliminar',false);
        $this->asignarAccion('editar',false);
        $this->asignarAccion('ver',true);
        $data['grilla'] = $this->grilla("salida",$data['pag']);
        $view = new View();
        $view->setData($data);
        $view->setTemplate( '../view/salida/_index.php' );
        $view->setlayout( '../template/layout.php' );
        $view->render();
    }
   public function create() 
   {
        $data = array();
        $view = new View();  
        $obj = new destino();
        $data['itinerario'] = $this->Select(
                                            array(
                                                    'id'=>'iditinerario',
                                                    'name'=>'iditinerario',
                                                    'table'=>'vitinerario2'
                                                    )
                                                 );
        $data['chofer'] = $this->Select(
                                            array(
                                                    'id'=>'idchofer',
                                                    'name'=>'idchofer',
                                                    'table'=>'vchofer'
                                                    )
                                                 );
        $data['vehiculo'] = $this->Select(
                                            array(
                                                    'id'=>'idvehiculo',
                                                    'name'=>'idvehiculo',
                                                    'table'=>'vvehiculo'
                                                    )
                                                 );
        $destinos = $obj->getDDestinos();
        $data['destino'] = $this->Select(
                                            array(
                                                    'id'=>'iddestino',
                                                    'name'=>'iddestino',
                                                    'table'=>$destinos
                                                    )
                                                 );
        $data['more_options'] = $this->more_options('salida');        
        $view->setData($data);
        $view->setTemplate( '../view/salida/_form.php' );
        $view->setlayout( '../template/layout.php' );
        $view->render();
    }   
    public function payticket() 
    {
        $obj = new salida();
        $id = (int)$_POST['i'];
        $r = $obj->payticket($id);
        if($r['res']=="1")
        {
            print_r(json_encode(array('1',$r['msg'])));
        }
        else 
        {
            print_r(json_encode(array('0',$r['msg'])));
        }
        
    }
    public function ticket($id,$n)
    {
        //Funcion para obtener
        $view = new View();
        $data = array();
        $data['id']=$id;
        $data['n']=$n;
        $view->setData($data);
        $view->setTemplate( '../view/salida/_ticket.php');
        return $view->renderPartial();
    }
    public function despachar()
    {
        $obj = new salida();
        $id = (int)$_POST['i'];
        $r = $obj->despachar($id);
        if($r['res']=="1")
        {
            print_r(json_encode(array('1',substr($r['msg'],0,5))));
        }
        else 
        {
            print_r(json_encode(array('0',$r['msg'])));
        }
    }
    public function vtipo_pasajero()
    {
        $data = array();
        $view = new View(); 
        $otp = new tipo_pasajero();
        $data['rows'] = $otp->gettipos();
        $view->setData($data);
        $view->setTemplate( '../view/tipo_pasajero/_tipos.php' );
        return $view->renderPartial();        
    }
    public function show() 
    {        
        $obj = new salida();
        $objd = new destino();
        $obj = $obj->edit($_GET['id']);
        $data = array();
        $data['more_options'] = $this->more_options('salida');
        $data['itinerario'] = $this->Select(
                                            array(
                                                    'id'=>'iditinerario',
                                                    'name'=>'iditinerario',
                                                    'table'=>'vitinerario2',
                                                    'disabled'=>'disabled',
                                                    'code'=>$obj->iditinerario
                                                    )
                                                 );
        $data['chofer'] = $this->Select(
                                            array(
                                                    'id'=>'idchofer',
                                                    'name'=>'idchofer',
                                                    'table'=>'vchofer',
                                                    'disabled'=>'disabled',
                                                    'code'=>$obj->idchofer
                                                    )
                                                 );
        $data['vehiculo'] = $this->Select(
                                            array(
                                                    'id'=>'idvehiculo',
                                                    'name'=>'idvehiculo',
                                                    'table'=>'vvehiculo',
                                                    'disabled'=>'disabled',
                                                    'code' => $obj->idvehiculo
                                                    )
                                                 );
        $destinos = $objd->getDDestinos();
        $data['destino'] = $this->Select(
                                            array(
                                                    'id'=>'iddestino',
                                                    'name'=>'iddestino',
                                                    'table'=>$destinos,
                                                    'code'=>$obj->iddestino,
                                                    'disabled'=>'disabled'
                                                    )
                                                 );
        $view = new View();        
        $data['obj'] = $obj;
        $view->setData($data);
        $view->setTemplate( '../view/salida/_form.php' );
        $view->setlayout( '../template/layout.php' );
        $view->render();
    }
    public function result()
    {
        $data = array();
        $view = new View();        
        $data['more_options'] = $this->more_options('salida');        
        $data['idsalida'] = (int)$_GET['is'];
        $view->setData($data);
        $view->setTemplate( '../view/salida/_result.php' );
        $view->setlayout( '../template/layout.php' );
        $view->render();
    }    
    public function save()
    {   
        $obj = new salida();
        if ($_POST['idsalida']=='') 
        {
            $p = $obj->insert($_POST);
            if ($p['res']=='1')
            {
                $result = array(1,'SE HA REGISTRADO CORRECTAMENTE EL TICKET DE SALIDA',$p['ids']);
            } 
            else 
            {
                $result = array(2,'HA OCURRIDO UN ERROR, FAVOR DE ACTUALIZAR LA PAGINA (F5) Y VOLVER A INTENTARLO. '.$p['msg'],'');
            }
            print_r(json_encode($result));
        }
    }
    public function anular()
    {        
        $obj = new salida();
        $id = (int)$_POST['id'];
        $p = $obj->anular($id);
        if ($p[0])
        {
            print_r(json_encode(array('1','oki')));
        }
        else 
        {
            print_r(json_encode(array('0',$r['msg'])));
        }
    }
   
    public function printer()
    {
        $data = array();
        $view = new View();                
        $obj = new salida();
        $result = $obj->getdata((int)$_GET['ie']);
        if($result[0])
        {
            $data['head'] = $result[1];
            $view->setData($data);
            $view->setTemplate( '../view/salida/_print.php');
            $view->setlayout( '../template/empty.php' );
            $view->render();
        }
         else 
        {
            $data = array();
            $view = new View();
            $data['msg'] = 'No se ha podido encontrar el ticket solicitado a imprimir.';
            $data['url'] =  'index.php?controller=salida';
            $view->setData($data);
            $view->setTemplate( '../view/_error_app.php' );
            $view->setlayout( '../template/layout.php' );
            $view->render();
        }
        
    }
    public function getSalidasOk()
    {
        $obj = new salida();        
        if(isset($_GET['fechasalida']))
        {
            $fechasalida = $_GET['fechasalida'];
        }
        else 
        {
            $fechasalida = date('Y-m-d');
        }
        $row = $obj->getSalidasOk($_GET['idd'],$fechasalida);
        print_r(json_encode($row));
    }
   
}
?>