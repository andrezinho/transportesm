<?php
require_once '../lib/controller.php';
require_once '../lib/view.php';
require_once '../model/articulo.php';

class articuloController extends Controller {    
    public function index() 
    {
        if(!isset($_GET['p'])){$_GET['p']=1;}
        if(!isset($_GET['q'])){$_GET['q']="";}        
        if(!isset($_GET['criterio'])){$_GET['criterio']="a.descripcion";}        
        $obj = new articulo();
        $data = array();
        $data['data'] = $obj->index($_GET['q'],$_GET['p'],$_GET['criterio']);
        $data['query'] = $_GET['q'];
        $data['pag'] = $this->Pagination(array('rows'=>$data['data']['rowspag'],'url'=>'index.php?controller=articulo&action=index','query'=>$_GET['q'],'trows'=>$data['data']['total']));
        
        $this->registros = $data['data']['rows'];
        
        $this->columnas = array("ID"=>array('titulo'=>'Codigo','align'=>'center','ancho'=>'5'),
                                "DESCRIPCION" => array(),                                
                                "UNIDAD" => array('align'=>'center','ancho'=>'10'),
                                "STOCK" => array('align'=>'right','ancho'=>'10'),
                                "PRECIO" => array('ancho'=>'15','align'=>'right'),
                                "ESTADO" => array('align'=>'center','ancho'=>'10')
                                );                
        $this->busqueda = array("a.descripcion"=>"descripcion",
                                "u.abreviado"=>"unidad",
                                "a.serie"=>"serie");           
        $this->asignarAccion("eliminar", false);        
        $data['grilla'] = $this->grilla("articulo",$data['pag']);        
        $view = new View();
        $view->setData($data);
        $view->setTemplate( '../view/articulo/_index.php' );
        $view->setlayout( '../template/layout.php' );
        $view->render();
    }
    public function create() 
    {
        $data = array();
        $view = new View();   
        $data['unidad'] = $this->Select(array('id'=>'idunidad','name'=>'idunidad','table'=>'unidad'));
        $data['more_options'] = $this->more_options('articulo');
        $view->setData($data);
        $view->setTemplate( '../view/articulo/_form.php' );
        $view->setlayout( '../template/layout.php' );
        $view->render();
    }
    public function edit() 
    {
        $obj = new articulo();
        $obj = $obj->edit($_GET['id']);
        $data = array();
        $data['more_options'] = $this->more_options('articulo');
        $data['unidad'] = $this->Select(array('id'=>'idunidad','name'=>'idunidad','table'=>'unidad','code'=>$obj->idunidad));
        $view = new View();
        
        $data['obj'] = $obj;        
        $view->setData($data);
        $view->setTemplate( '../view/articulo/_form.php' );
        $view->setlayout( '../template/layout.php' );
        $view->render();
    }
    public function save()
    {
        $obj = new articulo();
        if ($_POST['idarticulo']=='') {
            $p = $obj->insert($_POST);
            if ($p[0]){
                header('Location: index.php?controller=articulo');
            } else {
            $data = array();
            $view = new View();
            $data['msg'] = $p[1];
            $data['url'] =  'index.php?controller=articulo';
            $view->setData($data);
            $view->setTemplate( '../view/_error_app.php' );
            $view->setlayout( '../template/layout.php' );
            $view->render();
            }
        } else {
            $p = $obj->update($_POST);
            if ($p[0]){
                header('Location: index.php?controller=articulo');
            } else {
            $data = array();
            $view = new View();
            $data['msg'] = $p[1];
            $data['url'] =  'index.php?controller=articulo';
            $view->setData($data);
            $view->setTemplate( '../view/_error_app.php' );
            $view->setlayout( '../template/layout.php' );
            $view->render();
            }
        }
    }
    public function delete(){
        $obj = new articulo();
        $p = $obj->delete($_GET['id']);
        if ($p[0]){
            header('Location: index.php?controller=articulo');
        } else {
        $data = array();
        $view = new View();
        $data['msg'] = $p[1];
        $data['url'] =  'index.php?controller=articulo';
        $view->setData($data);
        $view->setTemplate( '../view/_error_app.php' );
        $view->setlayout( '../template/layout.php' );
        $view->render();
        }
    }
    public function search_autocomplete()
    {
        $obj = new articulo();
        $data = array();
        $view = new View();
        $data['value'] = $obj->getarticulos($_GET["term"]);
        $view->setData( $data );
        $view->setTemplate( '../view/articulo/_json.php' );
        echo $view->renderPartial();
    }
 
}
?>