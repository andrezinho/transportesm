<?php
require_once '../lib/controller.php';
require_once '../lib/view.php';
require_once '../model/unidad.php';

class unidadController extends Controller {    
    public function index() 
    {
        if(!isset($_GET['p'])){$_GET['p']=1;}
        if(!isset($_GET['q'])){$_GET['q']="";}        
        if(!isset($_GET['criterio'])){$_GET['criterio']="descripcion";}        
        $obj = new unidad();
        $data = array();
        $data['data'] = $obj->index($_GET['q'],$_GET['p'],$_GET['criterio']);
        $data['query'] = $_GET['q'];
        $data['pag'] = $this->Pagination(array('rows'=>$data['data']['rowspag'],'url'=>'index.php?controller=unidad&action=index','query'=>$_GET['q'],'trows'=>$data['data']['total']));
        
        $this->registros = $data['data']['rows'];
        
        $this->columnas = array("ID"=>array('titulo'=>'Codigo','align'=>'center','ancho'=>'5'),
                                "DESCRIPCION" => array(),
                                "ABREVIADO" => array('align'=>'center','ancho'=>'10')                                
                                );                
        $this->busqueda = array("descripcion"=>"descripcion",
                                "abreviado"=>"abreviado");           
        //$this->asignarAccion("ver", true);        
        $data['grilla'] = $this->grilla("unidad",$data['pag']);        
        $view = new View();
        $view->setData($data);
        $view->setTemplate( '../view/unidad/_index.php' );
        $view->setlayout( '../template/layout.php' );
        $view->render();
    }
    public function create() {
        $data = array();
        $view = new View();   
        $data['more_options'] = $this->more_options('unidad');
        $view->setData($data);
        $view->setTemplate( '../view/unidad/_form.php' );
        $view->setlayout( '../template/layout.php' );
        $view->render();
    }
    public function edit() {
        $obj = new unidad();
        $data = array();
        $data['more_options'] = $this->more_options('unidad');
        $view = new View();
        $obj = $obj->edit($_GET['id']);
        $data['obj'] = $obj;        
        $view->setData($data);
        $view->setTemplate( '../view/unidad/_form.php' );
        $view->setlayout( '../template/layout.php' );
        $view->render();
    }
    public function save()
    {
        $obj = new unidad();
        if ($_POST['idunidad']=='') {
            $p = $obj->insert($_POST);
            if ($p[0]){
                header('Location: index.php?controller=unidad');
            } else {
            $data = array();
            $view = new View();
            $data['msg'] = $p[1];
            $data['url'] =  'index.php?controller=unidad';
            $view->setData($data);
            $view->setTemplate( '../view/_error_app.php' );
            $view->setlayout( '../template/layout.php' );
            $view->render();
            }
        } else {
            $p = $obj->update($_POST);
            if ($p[0]){
                header('Location: index.php?controller=unidad');
            } else {
            $data = array();
            $view = new View();
            $data['msg'] = $p[1];
            $data['url'] =  'index.php?controller=unidad';
            $view->setData($data);
            $view->setTemplate( '../view/_error_app.php' );
            $view->setlayout( '../template/layout.php' );
            $view->render();
            }
        }
    }
    public function delete(){
        $obj = new unidad();
        $p = $obj->delete($_GET['id']);
        if ($p[0]){
            header('Location: index.php?controller=unidad');
        } else {
        $data = array();
        $view = new View();
        $data['msg'] = $p[1];
        $data['url'] =  'index.php?controller=unidad';
        $view->setData($data);
        $view->setTemplate( '../view/_error_app.php' );
        $view->setlayout( '../template/layout.php' );
        $view->render();
        }
    }
 
}
?>