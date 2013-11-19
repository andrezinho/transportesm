<?php
require_once '../lib/controller.php';
require_once '../lib/view.php';
require_once '../model/venta.php';
require_once '../model/tipo_pasajero.php';
require_once '../model/itinerario.php';
class ventaController extends Controller
{
   public function index() {
        if(!isset($_GET['p'])){$_GET['p']=1;}
        if(!isset($_GET['q'])){$_GET['q']="";} 
        if(!isset($_GET['criterio'])){$_GET['criterio']="p.nombre";} 
        $obj = new venta();
        $data = array();
        $data['data'] = $obj->index($_GET['q'],$_GET['p'],$_GET['criterio']);
        $data['query'] = $_GET['q'];
        $data['pag'] = $this->Pagination(array('rows'=>$data['data']['rowspag'],'url'=>'index.php?controller=venta&action=index','query'=>$_GET['q'],'trows'=>$data['data']['total']));
        $this->registros = $data['data']['rows'];
        $this->columnas = array("ID"=>array('ancho'=>'5','align'=>'center','title'=>'Codigo'),
                                "FECHA"=>array('ancho'=>'10','align'=>'center'),
                                "PASAJERO"=>array(),
                                "DOCUMENTO"=>array('ancho'=>'20'),
                                "ESTADO"=>array('ancho'=>'10','align'=>'center'),
                                "USUARIO"=>array('ancho'=>'10','align'=>'center'),
                                "&nbsp;"=>array('ancho'=>'3','align'=>'center'),
                                "-"=>array('ancho'=>'3','align'=>'center')
                                );         
        $this->busqueda = array("p.nombre"=>"Pasajero",
                                "v.fecha"=>"Fecha",
                                "v.serie"=>"Nro Serie",
                                "v.numero"=>"Numero");
        $this->asignarAccion('eliminar',false);
        $this->asignarAccion('editar',false);
        $this->asignarAccion('ver',true);
        $data['grilla'] = $this->grilla("venta",$data['pag']);
        $view = new View();
        $view->setData($data);
        $view->setTemplate( '../view/venta/_index.php' );
        $view->setlayout( '../template/layout.php' );
        $view->render();
    }
   public function create() 
    {
        $data = array();
        $view = new View();  
        $obji = new itinerario();
        $datai = $obji->getItinerariosDif();
        
        $data['tipo_documento'] = $this->Select(
                                            array(
                                                    'id'=>'idtipo_documento',
                                                    'name'=>'idtipo_documento',
                                                    'table'=>'tipodoc'
                                                    )
                                                 );
        $data['itinerario'] = $this->Select(
                                            array(
                                                    'id'=>'iditinerario',
                                                    'name'=>'iditinerario',
                                                    'table'=>$datai
                                                    )
                                                 );
        $data['tipos'] = $this->vtipo_pasajero();
        $data['more_options'] = $this->more_options('venta');
        $data['detalle'] = $this->viewDetalle();
        $view->setData($data);
        $view->setTemplate( '../view/venta/_form.php' );
        $view->setlayout( '../template/layout.php' );
        $view->render();
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
        
        $obj = new venta();
        $obj = $obj->edit($_GET['id']);
        $data = array();
        $data['more_options'] = $this->more_options('venta');
        $data['tipo_documento'] = $this->Select(
                                            array(
                                                    'id'=>'idtipo_documento',
                                                    'name'=>'idtipo_documento',
                                                    'table'=>'tipodoc',
                                                    'code'=>$obj->idtipo_documento,
                                                    'disabled'=>'disabled'
                                                    )
                                                 );
        $data['itinerario'] = $this->Select(
                                            array(
                                                    'id'=>'iditinerario',
                                                    'name'=>'iditinerario',
                                                    'table'=>'vitinerario',
                                                    'code'=>$obj->iditinerario,
                                                    'disabled'=>'disabled'
                                                    )
                                                 );
        $data['detalle'] = $this->viewDetalle('readonly');
        $view = new View();        
        $data['obj'] = $obj;
        $view->setData($data);
        $view->setTemplate( '../view/venta/_form.php' );
        $view->setlayout( '../template/layout.php' );
        $view->render();
    }
    public function result()
    {
        $data = array();
        $view = new View();        
        $data['more_options'] = $this->more_options('venta');        
        $data['idventa'] = (int)$_GET['iv'];
        $view->setData($data);
        $view->setTemplate( '../view/venta/_result.php' );
        $view->setlayout( '../template/layout.php' );
        $view->render();
    }    
    public function save()
    {      
        $obj = new venta();
        if ($_POST['idventa']=='') 
        {
            $p = $obj->insert($_POST);
            if ($p['res']=='1')
            {
                $result = array(1,'SE HA REGISTRADO CORRECTAMENTE LA VENTA',$p['idv']);
            } 
            else 
            {
                $result = array(2,$p['msg'],'');
            }
            print_r(json_encode($result));
        }
        else 
        {
            $result = array(2,'Ha ocurrido un error, porfavor actualize la pagina y vuelve a intentarlo','');
        }
    }
    public function genVenta()
    {
        $obj = new venta();                
        $p = $obj->insertGVenta($_POST);
        if ($p['res']=='1')
        {
            $result = array(1,'SE HA REGISTRADO CORRECTAMENTE LA FACTURACION',$p['idv'],$p['ndoc']);
        } 
        else 
        {
            $result = array(2,'HA OCURRIDO UN ERROR, FAVOR DE ACTUALIZAR LA PAGINA (F5) Y VOLVER A INTENTARLO. '.$p['msg'],'');
        }
        print_r(json_encode($result));        
    }
    public function anular()
    {
        $obj = new venta();
        $p = $obj->anular($_GET['id']);
        if ($p[0])
        {
            header('Location: index.php?controller=venta');
        } else {
        $data = array();
        $view = new View();
        $data['msg'] = $p[1];
        $data['url'] =  'index.php?controller=venta';
        $view->setData($data);
        $view->setTemplate( '../view/_error_app.php' );
        $view->setlayout( '../template/layout.php' );
        $view->render();
        }
    }
    public function add()
    {   
        $r = $_SESSION['ventad']->add($_POST['iditinerario'],$_POST['itinerario'],$_POST['precio'],$_POST['cantidad']);
        if($r){print_r(json_encode(array("resp"=>"1","data"=>$this->viewDetalle())));}
            else{print_r(json_encode(array("resp"=>"0","data"=>"ESTE ITINERARIO YA FUE AGREGADO AL DETALLE")));}
    }    
    public function quit()
    {
        $_SESSION['ventad']->quit($_POST['i']);
        echo $this->viewDetalle();
    }    
    public function viewDetalle($type=null)
    {        
        $view = new View();
        $data = array();        
        $view->setData($data);
        if($type!="readonly")
        {
            $view->setTemplate('../view/venta/_detalle.php');
        }
        else 
        {
            $view->setTemplate('../view/venta/_detalle_readonly.php');
        }
        
        $view->setlayout( '../template/layout.php' );
        return $view->renderPartial();        
    }
    public function getDetalle()
    {
        echo $this->viewDetalle();
    }
    public function printer()
    {
        $data = array();
        $view = new View();                
        $obj = new venta();
        $result = $obj->getdata((int)$_GET['iv']);
        if($result[0])
        {
            $data['head'] = $result[1]; 
            $data['detalle'] = $result[2];
            $view->setData($data);
            $view->setTemplate( '../view/venta/_print_'.$result[3].'.php');
            $view->setlayout( '../template/empty.php' );
            $view->render();
        }
        else 
        {
            $data = array();
            $view = new View();
            $data['msg'] = 'No se ha podido encontrar la venta solicitada.';
            $data['url'] =  'index.php?controller=venta';
            $view->setData($data);
            $view->setTemplate( '../view/_error_app.php' );
            $view->setlayout( '../template/layout.php' );
            $view->render();
        }
        
    }
}
?>