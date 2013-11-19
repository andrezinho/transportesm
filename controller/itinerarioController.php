<?php
require_once '../lib/controller.php';
require_once '../lib/view.php';
require_once '../model/itinerario.php';
class itinerarioController extends Controller
{
   public function index() {
        if (!isset($_GET['p'])){$_GET['p']=1;}
        if(!isset($_GET['q'])){$_GET['q']="";}  
        if(!isset($_GET['criterio'])){$_GET['criterio']="o.descripcion";}   
        $obj = new itinerario();
        $data = array();
        $data['data'] = $obj->index($_GET['q'],$_GET['p'],$_GET['criterio']);
        $data['query'] = $_GET['q'];
        $data['pag'] = $this->Pagination(array('rows'=>$data['data']['rowspag'],'url'=>'index.php?controller=itinerario&action=index','query'=>$_GET['q'],'trows'=>$data['data']['total']));
        $this->registros = $data['data']['rows'];
        $this->columnas = array("ID"=>array('titulo'=>'Codigo','align'=>'center','ancho'=>'5'),
                                "ORIGEN" => array(),
                                "DESTINO" => array(),
                                "PRECIO" => array('ancho'=>'10','align'=>'right'),
                                "PRECIO TICKET"=>array('ancho'=>'10','align'=>'right')
                                );                        
        $this->busqueda = array("o.descripcion"=>"ORIGEN",
                                "d.descripcion"=>"DESTINO"
                                );                
        $data['grilla'] = $this->grilla("itinerario",$data['pag']);
        
        $view = new View();
        $view->setData($data);
        $view->setTemplate( '../view/itinerario/_index.php' );
        $view->setlayout( '../template/layout.php' );
        $view->render();
    }
     
    public function create()
    {
        $data = array();
        $view = new View();        
        $obj = new destino();
        $data['more_options'] = $this->more_options('itinerario');
        $data['origen'] = $this->Select(array('name'=>'idorigen','id'=>'idorigen','table'=>'vdestino'));
        $data['destino'] = $this->Select(array('name'=>'iddestino','id'=>'iddestino','table'=>'vdestino'));        
        $view->setData($data);
        $view->setTemplate( '../view/itinerario/_form.php' );        
        $view->setlayout( '../template/layout.php' );
        $view->render();
    }
    public function edit() {
        $obj = new itinerario();
        $obj = $obj->edit($_GET['id']);
        $data = array();
        $data['more_options'] = $this->more_options('itinerario');
        $data['origen'] = $this->Select(array('name'=>'idorigen','id'=>'idorigen','table'=>'vdestino','code'=>$obj->origen));
        $data['destino'] = $this->Select(array('name'=>'iddestino','id'=>'iddestino','table'=>'vdestino','code'=>$obj->destino));
        $view = new View();
        
        $data['obj'] = $obj;      
        $view->setData($data);
        $view->setTemplate( '../view/itinerario/_form.php' );
        $view->setlayout( '../template/layout.php' );
        
        $view->render();
    }
   public function save()
   {
        $obj = new itinerario();
        if ($_POST['iditinerario']=='') {
            $p = $obj->insert($_POST);
            if ($p[0]){
                header('Location: index.php?controller=itinerario');
            } else {
            $data = array();
            $view = new View();
            $data['msg'] = $p[1];
            $data['url'] =  'index.php?controller=itinerario';
            $view->setData($data);
            $view->setTemplate( '../view/_error_app.php' );
            $view->setlayout( '../template/layout.php' );
            $view->render();
            }
        } else {
            $p = $obj->update($_POST);
            if ($p[0]){
                header('Location: index.php?controller=itinerario');
            } else {
            $data = array();
            $view = new View();
            $data['msg'] = $p[1];
            $data['url'] =  'index.php?controller=itinerario';
            $view->setData($data);
            $view->setTemplate( '../view/_error_app.php' );
            $view->setlayout( '../template/layout.php' );
            $view->render();
            }
        }
    }
    public function delete()
      {
        $obj = new itinerario();
        $p = $obj->delete($_GET['id']);
        if ($p[0]){
            header('Location: index.php?controller=itinerario');
        } 
        else {
            $data = array();
            $view = new View();
            $data['msg'] = $p[1];
            $data['url'] =  'index.php?controller=itinerario';
            $view->setData($data);
            $view->setTemplate( '../view/_error_app.php' );
            $view->setlayout( '../template/layout.php' );
            $view->render();
        }
      }
   public function getPricet()
   {
        $obj = new itinerario();
        $price = $obj->getPricet($_GET['idd']);
        echo number_format($price,2);
   }
   public function getPriceEncomienda()
   {
        $obj = new itinerario();
        $price = $obj->getPricetEncomienda($_GET['idd']);
        echo number_format($price,2);
   }
}
?>