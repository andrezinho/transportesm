<?php
require_once '../lib/controller.php';
require_once '../lib/view.php';
require_once '../model/concepto_movimiento.php';
class concepto_movimientoController extends Controller
{
   public function index() {
        if (!isset($_GET['p'])){$_GET['p']=1;}
        if(!isset($_GET['q'])){$_GET['q']="";}        
        $obj = new concepto_movimiento();
        $data = array();
        $data['data'] = $obj->index($_GET['q'],$_GET['p']);
        $data['query'] = $_GET['q'];
        $data['pag'] = $this->Pagination(array('rows'=>$data['data']['rowspag'],'url'=>'index.php?controller=concepto_movimiento&action=index','query'=>$_GET['q'],'trows'=>$data['data']['total']));
        $this->registros = $data['data']['rows'];
        $this->columnas = array("CODIGO"=>array('ancho'=>'10','align'=>'center','title'=>'Codigo'),
                      "DESCRIPCION"=>array(),
                      "TIPO"=>array());
        $this->busqueda = array("descripcion"=>"DESCRIPCION");                
        $data['grilla'] = $this->grilla("concepto_movimiento",$data['pag']);
        
        $view = new View();
        $view->setData($data);
        $view->setTemplate( '../view/concepto_movimiento/_index.php' );
        $view->setlayout( '../template/layout.php' );
        $view->render();
    }
     
    public function create()
    {
        $data = array();
        $view = new View();        
        $data['more_options'] = $this->more_options('concepto_movimiento');
        $data['descripcion'] = $this->Select(array('id'=>'idtipo_concepto','name'=>'idtipo_concepto','table'=>'tipo_concepto'));
        $view->setData($data);
        $view->setTemplate( '../view/concepto_movimiento/_form.php' );
        
        $view->setlayout( '../template/layout.php' );
        $view->render();
    }
    public function edit() {
        $obj = new concepto_movimiento();
        $obj = $obj->edit($_GET['id']);
        $data = array();
        $data['more_options'] = $this->more_options('concepto_movimiento');
        $data['descripcion'] = $this->Select(array('id'=>'tipo','name'=>'tipo','table'=>'tipo_concepto','code'=>$obj->idtipo_concepto));
        $view = new View();
        
        $data['obj'] = $obj;      
        $view->setData($data);
        $view->setTemplate( '../view/concepto_movimiento/_form.php' );
        $view->setlayout( '../template/layout.php' );
        
        $view->render();
    }
   public function save()
   {
        $obj = new concepto_movimiento();
        if ($_POST['idconcepto_movimiento']=='') {
            $p = $obj->insert($_POST);
            if ($p[0]){
                header('Location: index.php?controller=concepto_movimiento');
            } else {
            $data = array();
            $view = new View();
            $data['msg'] = $p[1];
            $data['url'] =  'index.php?controller=concepto_movimiento';
            $view->setData($data);
            $view->setTemplate( '../view/_error_app.php' );
            $view->setlayout( '../template/layout.php' );
            $view->render();
            }
        } else {
            $p = $obj->update($_POST);
            if ($p[0]){
                header('Location: index.php?controller=concepto_movimiento');
            } else {
            $data = array();
            $view = new View();
            $data['msg'] = $p[1];
            $data['url'] =  'index.php?controller=concepto_movimiento';
            $view->setData($data);
            $view->setTemplate( '../view/_error_app.php' );
            $view->setlayout( '../template/layout.php' );
            $view->render();
            }
        }
    }
    public function delete()
      {
        $obj = new concepto_movimiento();
        $p = $obj->delete($_GET['id']);
        if ($p[0]){
            header('Location: index.php?controller=concepto_movimiento');
        } 
        else {
            $data = array();
            $view = new View();
            $data['msg'] = $p[1];
            $data['url'] =  'index.php?controller=concepto_movimiento';
            $view->setData($data);
            $view->setTemplate( '../view/_error_app.php' );
            $view->setlayout( '../template/layout.php' );
            $view->render();
        }
      }
      
      public function search_autocompletei()
        {
            $obj = new concepto_movimiento();
            $data = array();
            $view = new View();
            if($_GET['tipo']==1)
            {
                $field = "idconcepto_movimiento";
            }
            elseif ($_GET['tipo']==2) {
                $field = "descripcion";
            }
            
            $data['value'] = $obj->getconceptoi($_GET["term"],$field);
            $view->setData( $data );
            $view->setTemplate( '../view/concepto_movimiento/_json.php' );
            echo $view->renderPartial();
        }
          public function search_autocompletee()
        {
            $obj = new concepto_movimiento();
            $data = array();
            $view = new View();
            if($_GET['tipo']==1)
            {
                $field = "idconcepto_movimiento";
            }
            elseif ($_GET['tipo']==2) {
                $field = "descripcion";
            }
            
            $data['value'] = $obj->getconceptoe($_GET["term"],$field);
            $view->setData( $data );
            $view->setTemplate( '../view/concepto_movimiento/_json.php' );
            echo $view->renderPartial();
        }
   
   
}
?>