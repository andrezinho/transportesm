<?php
require_once '../lib/controller.php';
require_once '../lib/view.php';
require_once '../model/grupo.php';
class grupoController extends Controller
{
   public function index() {
        if (!isset($_GET['p'])){$_GET['p']=1;}
        if(!isset($_GET['q'])){$_GET['q']="";}        
        $obj = new grupo();
        $data = array();
        $data['data'] = $obj->index($_GET['q'],$_GET['p']);
        $data['query'] = $_GET['q'];
        $data['pag'] = $this->Pagination(array('rows'=>$data['data']['rowspag'],'url'=>'index.php?controller=grupo&action=index','query'=>$_GET['q'],'trows'=>$data['data']['total']));
        $this->registros = $data['data']['rows'];
        $this->columnas = array("CODIGO"=>array('ancho'=>'5','align'=>'center','title'=>'Codigo'),
                      "DESCRIPCION"=>array(),
                      "DESTINO"=>array()
                    );         
        $this->busqueda = array("descripcion"=>"DESCRIPCION");                
        $data['grilla'] = $this->grilla("grupo",$data['pag']);
        
        $view = new View();
        $view->setData($data);
        $view->setTemplate( '../view/grupo/_index.php' );
        $view->setlayout( '../template/layout.php' );
        $view->render();
    }
    public function getGrupos()
    {        
        $html = $this->Select_ajax(array(   'name'=>'idgrupo',
                                            'id'=>'idgrupo',
                                            'table'=>'vgrupos',
                                            'filtros'=>array('iddestino'=>$_GET['i'])
                                        )
                                );
        echo $html;
    }
    public function create()
    {
        $data = array();
        $view = new View();        
        $data['more_options'] = $this->more_options('grupo');
        $data['destino'] = $this->Select(array('id'=>'iddestino','name'=>'iddestino','table'=>'vdestino'));
        $view->setData($data);
        $view->setTemplate( '../view/grupo/_form.php' );
        $view->setlayout( '../template/layout.php' );
        $view->render();
    }
    public function edit() {
        $obj = new grupo();
        $obj = $obj->edit($_GET['id']);
        $data = array();
        $data['more_options'] = $this->more_options('grupo');
        $data['destino'] = $this->Select(array('id'=>'iddestino','name'=>'iddestino','table'=>'destino','code'=>$obj->iddestino));
        $view = new View();
        $data['obj'] = $obj;      
        $view->setData($data);
        $view->setTemplate( '../view/grupo/_form.php' );
        $view->setlayout( '../template/layout.php' );
        $view->render();
    }
   public function save()
   {
        $obj = new grupo();
        if ($_POST['idgrupo']=='') {
            $p = $obj->insert($_POST);
            if ($p[0]){
                header('Location: index.php?controller=grupo');
            } else {
            $data = array();
            $view = new View();
            $data['msg'] = $p[1];
            $data['url'] =  'index.php?controller=grupo';
            $view->setData($data);
            $view->setTemplate( '../view/_error_app.php' );
            $view->setlayout( '../template/layout.php' );
            $view->render();
            }
        } else {
            $p = $obj->update($_POST);
            if ($p[0]){
                header('Location: index.php?controller=grupo');
            } else {
            $data = array();
            $view = new View();
            $data['msg'] = $p[1];
            $data['url'] =  'index.php?controller=grupo';
            $view->setData($data);
            $view->setTemplate( '../view/_error_app.php' );
            $view->setlayout( '../template/layout.php' );
            $view->render();
            }
        }
    }
    public function delete()
      {
        $obj = new grupo();
        $p = $obj->delete($_GET['id']);
        if ($p[0]){
            header('Location: index.php?controller=grupo');
        } 
        else {
            $data = array();
            $view = new View();
            $data['msg'] = $p[1];
            $data['url'] =  'index.php?controller=grupo';
            $view->setData($data);
            $view->setTemplate( '../view/_error_app.php' );
            $view->setlayout( '../template/layout.php' );
            $view->render();
        }
      }
   
   
}
?>