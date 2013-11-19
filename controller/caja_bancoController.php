<?php
require_once '../lib/controller.php';
require_once '../lib/view.php';
require_once '../model/caja_banco.php';
class caja_bancoController extends Controller
{
   public function index() 
   {
        if (!isset($_GET['p'])){$_GET['p']=1;}
        if(!isset($_GET['q'])){$_GET['q']="";}        
        $obj = new caja_banco();
        $data = array();
        $data['data'] = $obj->index($_GET['q'],$_GET['p']);
        $data['query'] = $_GET['q'];
        $data['pag'] = $this->Pagination(array('rows'=>$data['data']['rowspag'],'url'=>'index.php?controller=caja_banco&action=index','query'=>$_GET['q'],'trows'=>$data['data']['total']));
        $this->registros = $data['data']['rows'];
        $this->columnas = array("CODIGO"=>array('ancho'=>'10','align'=>'center','title'=>'Codigo'),                                
                                "FECHA"=>array('align'=>'center','ancho'=>'10'),
                                "TIPO MOV"=>array('align'=>'center'),
                                "MONTO"=>array('align'=>'right','ancho'=>'10'),
                                "OFICINA"=>array('align'=>'center'),
                                "OBSERV."=>array('align'=>'left'),
                                "ESTADO"=>array('align'=>'center'),
                                "ANULAR"=>array('align'=>'center')
            );         
        $this->busqueda = array("fecha"=>"FECHA");                
        $this->asignarAccion('eliminar',false);
        $this->asignarAccion('editar',false);
        $this->asignarAccion('ver',true);
        $data['grilla'] = $this->grilla("caja_banco",$data['pag']);        
        
        $view = new View();
        $view->setData($data);
        $view->setTemplate( '../view/caja_banco/_index.php' );
        $view->setlayout( '../template/layout.php' );
        $view->render();
   }
     
   public function create()
   {
        $data = array();
        $view = new View();        
        $data['more_options'] = $this->more_options('caja_banco');
        $view->setData($data);
        $view->setTemplate( '../view/caja_banco/_form.php' );        
        $view->setlayout( '../template/layout.php' );
        $view->render();
    }
    public function show() 
    {
        $obj = new caja_banco();
        $data = array();
        $data['more_options'] = $this->more_options('caja_banco');
        $view = new View();
        $obj = $obj->edit($_GET['id']);
        $data['obj'] = $obj;      
        $view->setData($data);
        $view->setTemplate( '../view/caja_banco/_form.php' );
        $view->setlayout( '../template/layout.php' );        
        $view->render();
    }
   public function save()
   {
        $obj = new caja_banco();
        if ($_POST['idcaja_banco']=='') {
            $p = $obj->insert($_POST);
            if ($p[0]){
                header('Location: index.php?controller=caja_banco');
            } else {
            $data = array();
            $view = new View();
            $data['msg'] = $p[1];
            $data['url'] =  'index.php?controller=caja_banco';
            $view->setData($data);
            $view->setTemplate( '../view/_error_app.php' );
            $view->setlayout( '../template/layout.php' );
            $view->render();
            }
        } else {
            $p = $obj->update($_POST);
            if ($p[0]){
                header('Location: index.php?controller=caja_banco');
            } else {
            $data = array();
            $view = new View();
            $data['msg'] = $p[1];
            $data['url'] =  'index.php?controller=caja_banco';
            $view->setData($data);
            $view->setTemplate( '../view/_error_app.php' );
            $view->setlayout( '../template/layout.php' );
            $view->render();
            }
        }
    }
    public function anular()
      {
        $obj = new caja_banco();
        $p = $obj->anular($_GET['id']);
        if ($p[0]){
            header('Location: index.php?controller=caja_banco');
        } 
        else {
            $data = array();
            $view = new View();
            $data['msg'] = $p[1];
            $data['url'] =  'index.php?controller=caja_banco';
            $view->setData($data);
            $view->setTemplate( '../view/_error_app.php' );
            $view->setlayout( '../template/layout.php' );
            $view->render();
        }
      }
      
      public function dep_caja()
      {
          //echo "OKKK";
          $obj = new caja_banco();
          $d = $obj->dep_caja($_POST);
          //echo "OKK";
          print_r(json_encode($d));
      }
   
   
}
?>