<?php
require_once '../lib/controller.php';
require_once '../lib/view.php';
require_once '../model/periodo.php';
class periodoController extends Controller
{
   public function index() 
   {
        if (!isset($_GET['p'])){$_GET['p']=1;}
        if(!isset($_GET['q'])){$_GET['q']="";}
        $obj = new periodo();
        $data = array();
        $data['data'] = $obj->index($_GET['q'],$_GET['p']);
        $data['query'] = $_GET['q'];
        $data['pag'] = $this->Pagination(array('rows'=>$data['data']['rowspag'],'url'=>'index.php?controller=periodo&action=index','query'=>$_GET['q'],'trows'=>$data['data']['total']));
        $this->registros = $data['data']['rows'];
        $this->columnas = array(
                                "ITEM"=>array('ancho'=>'10','align'=>'center','title'=>'Codigo'),
                                "PERIODO"=>array('align'=>'center'),
                                "ESTADO"=>array('ancho'=>'10','align'=>'center')
                                );
        $this->busqueda = array("anio"=>"AÑO");        
        $data['grilla'] = $this->grilla("periodo",$data['pag']);
        $view = new View();
        $view->setData($data);
        $view->setTemplate( '../view/periodo/_index.php' );
        $view->setlayout( '../template/layout.php' );
        $view->render();
    }
    public function change()
    {
        $obj = new periodo();
        $r = $obj->change($_GET['id']);
        $_SESSION['idperiodo'] = $r->idperiodo;
        $_SESSION['name_periodo'] = $r->anio."-".$r->mes;
    }
    public function create()
    {
        $data = array();
        $view = new View();        
        $data['more_options'] = $this->more_options('periodo');
        $view->setData($data);
        $view->setTemplate( '../view/periodo/_form.php' );
        
        $view->setlayout( '../template/layout.php' );
        $view->render();
    }
    public function edit() {
        $obj = new periodo();
        $data = array();
        $data['more_options'] = $this->more_options('periodo');
        $view = new View();
        $obj = $obj->edit($_GET['id']);
        $data['obj'] = $obj;      
        $view->setData($data);
        $view->setTemplate( '../view/periodo/_form.php' );
        $view->setlayout( '../template/layout.php' );
        
        $view->render();
    }
   public function save()
   {
        $obj = new periodo();
        if ($_POST['idperiodo']=='') {
            $p = $obj->insert($_POST);
            if ($p[0]){
                header('Location: index.php?controller=periodo');
            } else {
            $data = array();
            $view = new View();
            $data['msg'] = $p[1];
            $data['url'] =  'index.php?controller=periodo';
            $view->setData($data);
            $view->setTemplate( '../view/_error_app.php' );
            $view->setlayout( '../template/layout.php' );
            $view->render();
            }
        } else {
            $p = $obj->update($_POST);
            if ($p[0]){
                header('Location: index.php?controller=periodo');
            } else {
            $data = array();
            $view = new View();
            $data['msg'] = $p[1];
            $data['url'] =  'index.php?controller=periodo';
            $view->setData($data);
            $view->setTemplate( '../view/_error_app.php' );
            $view->setlayout( '../template/layout.php' );
            $view->render();
            }
        }
    }
    public function delete()
      {
        $obj = new periodo();
        $p = $obj->delete($_GET['id']);
        if ($p[0]){
            header('Location: index.php?controller=periodo');
        } 
        else {
            $data = array();
            $view = new View();
            $data['msg'] = $p[1];
            $data['url'] =  'index.php?controller=periodo';
            $view->setData($data);
            $view->setTemplate( '../view/_error_app.php' );
            $view->setlayout( '../template/layout.php' );
            $view->render();
        }
      }
   
   
}
?>