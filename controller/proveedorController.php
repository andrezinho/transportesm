<?php
require_once '../lib/controller.php';
require_once '../lib/view.php';
require_once '../model/proveedor.php';
class proveedorController extends Controller
{
   public function index() {
        if (!isset($_GET['p'])){$_GET['p']=1;}
        if(!isset($_GET['q'])){$_GET['q']="";}        
        $obj = new proveedor();
        $data = array();
        $data['data'] = $obj->index($_GET['q'],$_GET['p']);
        $data['query'] = $_GET['q'];
        $data['pag'] = $this->Pagination(array('rows'=>$data['data']['rowspag'],'url'=>'index.php?controller=proveedor&action=index','query'=>$_GET['q'],'trows'=>$data['data']['total']));
        $this->registros = $data['data']['rows'];
        $this->columnas = array("CODIGO"=>array('ancho'=>'10','align'=>'center','title'=>'Codigo'),
                      "RAZON SOCIAL"=>array(),
                       "RUC / DNI"=>array()
                    );         
        $this->busqueda = array("razonsocial"=>"RAZON SOCIAL");                
        $data['grilla'] = $this->grilla("proveedor",$data['pag']);
        
        $view = new View();
        $view->setData($data);
        $view->setTemplate( '../view/proveedor/_index.php' );
        $view->setlayout( '../template/layout.php' );
        $view->render();
    }
     
    public function create()
    {
        $data = array();
        $view = new View();        
        $data['more_options'] = $this->more_options('proveedor');
        $view->setData($data);
        $view->setTemplate( '../view/proveedor/_form.php' );
        
        $view->setlayout( '../template/layout.php' );
        $view->render();
    }
    public function edit() {
        $obj = new proveedor();
        $data = array();
        $data['more_options'] = $this->more_options('proveedor');
        $view = new View();
        $obj = $obj->edit($_GET['id']);
        $data['obj'] = $obj;      
        $view->setData($data);
        $view->setTemplate( '../view/proveedor/_form.php' );
        $view->setlayout( '../template/layout.php' );
        
        $view->render();
    }
   public function save()
   {
        $obj = new proveedor();
        if ($_POST['idproveedor']=='') {
            $p = $obj->insert($_POST);
            if ($p[0]){
                header('Location: index.php?controller=proveedor');
            } else {
            $data = array();
            $view = new View();
            $data['msg'] = $p[1];
            $data['url'] =  'index.php?controller=proveedor';
            $view->setData($data);
            $view->setTemplate( '../view/_error_app.php' );
            $view->setlayout( '../template/layout.php' );
            $view->render();
            }
        } else {
            $p = $obj->update($_POST);
            if ($p[0]){
                header('Location: index.php?controller=proveedor');
            } else {
            $data = array();
            $view = new View();
            $data['msg'] = $p[1];
            $data['url'] =  'index.php?controller=proveedor';
            $view->setData($data);
            $view->setTemplate( '../view/_error_app.php' );
            $view->setlayout( '../template/layout.php' );
            $view->render();
            }
        }
    }
    public function delete()
      {
        $obj = new proveedor();
        $p = $obj->delete($_GET['id']);
        if ($p[0]){
            header('Location: index.php?controller=proveedor');
        } 
        else {
            $data = array();
            $view = new View();
            $data['msg'] = $p[1];
            $data['url'] =  'index.php?controller=proveedor';
            $view->setData($data);
            $view->setTemplate( '../view/_error_app.php' );
            $view->setlayout( '../template/layout.php' );
            $view->render();
        }
      }
   
   public function search_autocomplete()
        {
            $obj = new proveedor();
            $data = array();
            $view = new View();
            if($_GET['tipo']==1)
            {
                $field = "ruc";
            }
            elseif ($_GET['tipo']==2) {
                $field = "razonsocial";
            }
            
            $data['value'] = $obj->getproveedor($_GET["term"],$field);
            $view->setData( $data );
            $view->setTemplate( '../view/proveedor/_json.php' );
            echo $view->renderPartial();
        }
      
}
?>