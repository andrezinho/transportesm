<?php
require_once '../lib/controller.php';
require_once '../lib/view.php';
require_once '../model/tipo_concepto.php';
class tipo_conceptoController extends Controller
{
   public function index() {
        if (!isset($_GET['p'])){$_GET['p']=1;}
        if(!isset($_GET['q'])){$_GET['q']="";}        
        $obj = new tipo_concepto();
        $data = array();
        $data['data'] = $obj->index($_GET['q'],$_GET['p']);
        $data['query'] = $_GET['q'];
        $data['pag'] = $this->Pagination(array('rows'=>$data['data']['rowspag'],'url'=>'index.php?controller=tipo_concepto&action=index','query'=>$_GET['q'],'trows'=>$data['data']['total']));
        $this->registros = $data['data']['rows'];
        $this->columnas = array("CODIGO"=>array('ancho'=>'10','align'=>'center','title'=>'Codigo'),
                      "DESCRIPCION"=>array(),
                      "SIGLAS"=>array());         
        $this->busqueda = array("descripcion"=>"DESCRIPCION");                
        $data['grilla'] = $this->grilla("tipo_concepto",$data['pag']);
        
        $view = new View();
        $view->setData($data);
        $view->setTemplate( '../view/tipo_concepto/_index.php' );
        $view->setlayout( '../template/layout.php' );
        $view->render();
    }
     
    public function create()
    {
        $data = array();
        $view = new View();        
        $data['more_options'] = $this->more_options('tipo_concepto');
        $view->setData($data);
        $view->setTemplate( '../view/tipo_concepto/_form.php' );
        
        $view->setlayout( '../template/layout.php' );
        $view->render();
    }
    public function edit() {
        $obj = new tipo_concepto();
        $data = array();
        $data['more_options'] = $this->more_options('tipo_concepto');
        $view = new View();
        $obj = $obj->edit($_GET['id']);
        $data['obj'] = $obj;      
        $view->setData($data);
        $view->setTemplate( '../view/tipo_concepto/_form.php' );
        $view->setlayout( '../template/layout.php' );
        
        $view->render();
    }
   public function save()
   {
        $obj = new tipo_concepto();
        if ($_POST['idtipo_concepto']=='') {
            $p = $obj->insert($_POST);
            if ($p[0]){
                header('Location: index.php?controller=tipo_concepto');
            } else {
            $data = array();
            $view = new View();
            $data['msg'] = $p[1];
            $data['url'] =  'index.php?controller=tipo_concepto';
            $view->setData($data);
            $view->setTemplate( '../view/_error_app.php' );
            $view->setlayout( '../template/layout.php' );
            $view->render();
            }
        } else {
            $p = $obj->update($_POST);
            if ($p[0]){
                header('Location: index.php?controller=tipo_concepto');
            } else {
            $data = array();
            $view = new View();
            $data['msg'] = $p[1];
            $data['url'] =  'index.php?controller=tipo_concepto';
            $view->setData($data);
            $view->setTemplate( '../view/_error_app.php' );
            $view->setlayout( '../template/layout.php' );
            $view->render();
            }
        }
    }
    public function delete()
      {
        $obj = new tipo_concepto();
        $p = $obj->delete($_GET['id']);
        if ($p[0]){
            header('Location: index.php?controller=tipo_concepto');
        } 
        else {
            $data = array();
            $view = new View();
            $data['msg'] = $p[1];
            $data['url'] =  'index.php?controller=tipo_concepto';
            $view->setData($data);
            $view->setTemplate( '../view/_error_app.php' );
            $view->setlayout( '../template/layout.php' );
            $view->render();
        }
      }
   
   
}
?>