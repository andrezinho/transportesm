<?php
require_once '../lib/controller.php';
require_once '../lib/view.php';
require_once '../model/modulo.php';

class ModuloController extends Controller {    
    public function index() 
    {
        if(!isset($_GET['p'])){$_GET['p']=1;}
        if(!isset($_GET['q'])){$_GET['q']="";}        
        if(!isset($_GET['criterio'])){$_GET['criterio']="m.descripcion";}        
        $obj = new Modulo();
        $data = array();
        $data['data'] = $obj->index($_GET['q'],$_GET['p'],$_GET['criterio']);
        $data['query'] = $_GET['q'];
        $data['pag'] = $this->Pagination(array('rows'=>$data['data']['rowspag'],'url'=>'index.php?controller=modulo&action=index','query'=>$_GET['q'],'trows'=>$data['data']['total']));
        
        $this->registros = $data['data']['rows'];
        
        $this->columnas = array("ID"=>array('titulo'=>'Codigo','align'=>'center','ancho'=>'5'),
                                "DESCRIPCION" => array(),
                                "PRINCIPAL" => array(),
                                "URL" => array(),
                                "CONTROLADOR"=>array(),
                                "ACCION"=>array(),
                                "ESTADO" => array('align'=>'center'),
                                "ORDEN" => array('align'=>'center')
                                );                
        $this->busqueda = array("m.descripcion"=>"descripcion",
                                "mm.descripcion"=>"principal");           
        
        
        $data['grilla'] = $this->grilla("Modulo",$data['pag']);
        
        $view = new View();
        $view->setData($data);
        $view->setTemplate( '../view/modulo/_index.php' );
        $view->setlayout( '../template/layout.php' );
        $view->render();
    }
    public function create() 
    {
        $data = array();
        $view = new View();
        $data['ModulosPadres'] = $this->Select(array('id'=>'idpadre','name'=>'idpadre','table'=>'vista_modulo'));
        $data['more_options'] = $this->more_options('Modulo');
        $view->setData($data);
        $view->setTemplate( '../view/modulo/_form.php' );
        $view->setlayout( '../template/layout.php' );
        $view->render();
    }
    public function edit() {
        $obj = new Modulo();
        $data = array();
        $view = new View();
        $obj = $obj->edit($_GET['id']);
        $data['obj'] = $obj;
        $data['ModulosPadres'] = $this->Select(array('id'=>'idpadre','name'=>'idpadre','table'=>'vista_modulo','code'=>$obj->idpadre));
        $data['more_options'] = $this->more_options('Modulo');
        $view->setData($data);
        $view->setTemplate( '../view/modulo/_form.php' );
        $view->setlayout( '../template/layout.php' );
        $view->render();
    }
    public function save()
    {
        $obj = new Modulo();
        if ($_POST['idmodulo']=='') {
            $p = $obj->insert($_POST);
            if ($p[0]){
                header('Location: index.php?controller=modulo');
            } else {
            $data = array();
            $view = new View();
            $data['msg'] = $p[1];
            $data['url'] =  'index.php?controller=modulo';
            $view->setData($data);
            $view->setTemplate( '../view/_error_app.php' );
            $view->setlayout( '../template/layout.php' );
            $view->render();
            }
        } else {
            $p = $obj->update($_POST);
            if ($p[0]){
                header('Location: index.php?controller=modulo');
            } else {
            $data = array();
            $view = new View();
            $data['msg'] = $p[1];
            $data['url'] =  'index.php?controller=modulo';
            $view->setData($data);
            $view->setTemplate( '../view/_error_app.php' );
            $view->setlayout( '../template/layout.php' );
            $view->render();
            }
        }
    }
    public function delete(){
        $obj = new Modulo();
        $p = $obj->delete($_GET['id']);
        if ($p[0]){
            header('Location: index.php?controller=modulo');
        } else {
        $data = array();
        $view = new View();
        $data['msg'] = $p[1];
        $data['url'] =  'index.php?controller=modulo';
        $view->setData($data);
        $view->setTemplate( '../view/_error_app.php' );
        $view->setlayout( '../template/layout.php' );
        $view->render();
        }
    }
 
}
?>