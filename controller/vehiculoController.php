<?php
require_once '../lib/controller.php';
require_once '../lib/view.php';
require_once '../model/vehiculo.php';
class vehiculoController extends Controller
{
   public function index() {
        if (!isset($_GET['p'])){$_GET['p']=1;}
        if(!isset($_GET['q'])){$_GET['q']="";}        
        $obj = new vehiculo();
        $data = array();
        $data['data'] = $obj->index($_GET['q'],$_GET['p']);
        $data['query'] = $_GET['q'];
        $data['pag'] = $this->Pagination(array('rows'=>$data['data']['rowspag'],'url'=>'index.php?controller=vehiculo&action=index','query'=>$_GET['q'],'trows'=>$data['data']['total']));
        $this->registros = $data['data']['rows'];
        $this->columnas = array("CODIGO"=>array('ancho'=>'5','align'=>'center','title'=>'Codigo'),
                      "MARCA"=>array(),
                      "MODELO"=>array(),
                      "PLACA"=>array(),
                      "PROPIETARIO"=>array(),
                       "ESTADO"=>  array()
                    );         
        $this->busqueda = array("placa"=>"PLACA");                
        $data['grilla'] = $this->grilla("vehiculo",$data['pag']);
        
        $view = new View();
        $view->setData($data);
        $view->setTemplate( '../view/vehiculo/_index.php' );
        $view->setlayout( '../template/layout.php' );
        $view->render();
    }     
    public function create()
    {
        $data = array();
        $view = new View();        
        $data['more_options'] = $this->more_options('vehiculo');
        $data['estado'] = $this->Select(array('id'=>'idestado','name'=>'idestado','table'=>'estado'));
        $view->setData($data);
        $view->setTemplate( '../view/vehiculo/_form.php' );        
        $view->setlayout( '../template/layout.php' );
        $view->render();
    }
    public function edit() {
        $obj = new vehiculo();
        $obj = $obj->edit($_GET['id']);
        $data = array();
        $data['more_options'] = $this->more_options('vehiculo');
        $data['estado'] = $this->Select(array('id'=>'idestado','name'=>'idestado','table'=>'estado','code'=>$obj->idestado));
        $view = new View();
        
        $data['obj'] = $obj;      
        $view->setData($data);
        $view->setTemplate( '../view/vehiculo/_form.php' );
        $view->setlayout( '../template/layout.php' );
        
        $view->render();
    }
    public function getv()
    {
        $obj = new vehiculo();
        $idp = substr($_GET['idpropietario'], 0, 8);
        $rows = $obj->getv($_GET['idpropietario']);
        print_r(json_encode($rows));
    }
     public function getv2()
    {
        $obj = new vehiculo();
        $idp = substr($_GET['idpropietario'], 0, 8);
        $rows = $obj->getv2($_GET['idpropietario']);
        print_r(json_encode($rows));
    }
   public function save()
   {
        $obj = new vehiculo();
        if ($_POST['idvehiculo']=='') {
            $p = $obj->insert($_POST);
            if ($p[0]){
                header('Location: index.php?controller=vehiculo');
            } else {
            $data = array();
            $view = new View();
            $data['msg'] = $p[1];
            $data['url'] =  'index.php?controller=vehiculo';
            $view->setData($data);
            $view->setTemplate( '../view/_error_app.php' );
            $view->setlayout( '../template/layout.php' );
            $view->render();
            }
        } else {
            $p = $obj->update($_POST);
            if ($p[0]){
                header('Location: index.php?controller=vehiculo');
            } else {
            $data = array();
            $view = new View();
            $data['msg'] = $p[1];
            $data['url'] =  'index.php?controller=vehiculo';
            $view->setData($data);
            $view->setTemplate( '../view/_error_app.php' );
            $view->setlayout( '../template/layout.php' );
            $view->render();
            }
        }
    }
    public function delete()
    {
        $obj = new vehiculo();
        $p = $obj->delete($_GET['id']);
        if ($p[0]){
            header('Location: index.php?controller=vehiculo');
        } 
        else {
            $data = array();
            $view = new View();
            $data['msg'] = $p[1];
            $data['url'] =  'index.php?controller=vehiculo';
            $view->setData($data);
            $view->setTemplate( '../view/_error_app.php' );
            $view->setlayout( '../template/layout.php' );
            $view->render();
        }
    }
   
   
}
?>