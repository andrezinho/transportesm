<?php
require_once '../lib/controller.php';
require_once '../lib/view.php';
require_once '../model/oficina.php';
class oficinaController extends Controller
{
   public function index() {
        if (!isset($_GET['p'])){$_GET['p']=1;}
        if(!isset($_GET['q'])){$_GET['q']="";}     
        if(!isset($_GET['criterio'])){$_GET['criterio']="o.descripcion";}        
        $obj = new oficina();
        $data = array();
        $data['data'] = $obj->index($_GET['q'],$_GET['p'],$_GET['criterio']);
        $data['query'] = $_GET['q'];
        $data['pag'] = $this->Pagination(array('rows'=>$data['data']['rowspag'],'url'=>'index.php?controller=oficina&action=index','query'=>$_GET['q'],'trows'=>$data['data']['total']));
        $this->registros = $data['data']['rows'];
        $this->columnas = array("CODIGO"=>array('ancho'=>'10','align'=>'center','title'=>'Codigo'),
                                "DESCRIPCION"=>array(),
                                "SUCURSAL"=>array('align'=>'center'),
                                "CAJA"=>array('ancho'=>'10','align'=>'center')
                                );
        $this->busqueda = array("o.descripcion"=>"DESCRIPCION",
                                "s.descripcion"=>"SUCURSAL");                
        $data['grilla'] = $this->grilla("oficina",$data['pag']);
        
        $view = new View();
        $view->setData($data);
        $view->setTemplate( '../view/oficina/_index.php' );
        $view->setlayout( '../template/layout.php' );
        $view->render();
    }
     
    public function create()
    {
        $data = array();
        $view = new View();        
        $data['more_options'] = $this->more_options('oficina');
        $data['sucursal'] = $this->Select(array('name'=>'idsucursal','id'=>'idsucursal','table'=>'destino'));
        $view->setData($data);
        $view->setTemplate( '../view/oficina/_form.php' );        
        $view->setlayout( '../template/layout.php' );
        $view->render();
    }
    public function edit() {
        $obj = new oficina();
        $data = array();
        $obj = $obj->edit($_GET['id']);
        $data['obj'] = $obj;              
        $data['more_options'] = $this->more_options('oficina');
        $data['sucursal'] = $this->Select(array('name'=>'idsucursal','id'=>'idsucursal','table'=>'destino','code'=>$obj->idsucursal));
        $view = new View();        
        $view->setData($data);
        $view->setTemplate( '../view/oficina/_form.php' );
        $view->setlayout( '../template/layout.php' );
        
        $view->render();
    }
   public function save()
   {
        $obj = new oficina();
        if ($_POST['idoficina']=='') {
            $p = $obj->insert($_POST);
            if ($p[0]){
                header('Location: index.php?controller=oficina');
            } else {
            $data = array();
            $view = new View();
            $data['msg'] = $p[1];
            $data['url'] =  'index.php?controller=oficina';
            $view->setData($data);
            $view->setTemplate( '../view/_error_app.php' );
            $view->setlayout( '../template/layout.php' );
            $view->render();
            }
        } else {
            $p = $obj->update($_POST);
            if ($p[0]){
                header('Location: index.php?controller=oficina');
            } else {
            $data = array();
            $view = new View();
            $data['msg'] = $p[1];
            $data['url'] =  'index.php?controller=oficina';
            $view->setData($data);
            $view->setTemplate( '../view/_error_app.php' );
            $view->setlayout( '../template/layout.php' );
            $view->render();
            }
        }
    }
    public function delete()
      {
        $obj = new oficina();
        $p = $obj->delete($_GET['id']);
        if ($p[0]){
            header('Location: index.php?controller=oficina');
        } 
        else {
            $data = array();
            $view = new View();
            $data['msg'] = $p[1];
            $data['url'] =  'index.php?controller=oficina';
            $view->setData($data);
            $view->setTemplate( '../view/_error_app.php' );
            $view->setlayout( '../template/layout.php' );
            $view->render();
        }
      }
   
   
}
?>