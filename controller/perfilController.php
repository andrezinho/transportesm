<?php
require_once '../lib/controller.php';
require_once '../lib/view.php';
require_once '../model/perfil.php';
class PerfilController extends Controller
{
   public function index() 
   {
        if (!isset($_GET['p'])){$_GET['p']=1;}
        if(!isset($_GET['q'])){$_GET['q']="";}        
        $obj = new Perfil();
        $data = array();
        $data['data'] = $obj->index($_GET['q'],$_GET['p']);
        $data['query'] = $_GET['q'];
        $data['pag'] = $this->Pagination(array('rows'=>$data['data']['rowspag'],'url'=>'index.php?controller=perfil&action=index','query'=>$_GET['q'],'trows'=>$data['data']['total']));
        $this->registros = $data['data']['rows'];
        $this->columnas = array("CODIGO"=>array('ancho'=>'5','align'=>'center','title'=>'Codigo'),
                      "DESCRIPCION"=>array(),
                      "ESTADO"=>array('ancho'=>'10','align'=>'center')
                    );         
        $this->busqueda = array("descripcion"=>"DESCRIPCION");                
        $data['grilla'] = $this->grilla("Perfil",$data['pag']);        
        $view = new View();
        $view->setData($data);
        $view->setTemplate( '../view/perfil/_index.php' );
        $view->setlayout( '../template/layout.php' );
        $view->render();
    }
     
    public function create()
    {
        $data = array();
        $view = new View();        
        $data['more_options'] = $this->more_options('Perfil');
        $view->setData($data);
        $view->setTemplate( '../view/perfil/_form.php' );        
        $view->setlayout( '../template/layout.php' );
        $view->render();
    }
    public function edit() 
    {
        $obj = new Perfil();
        $data = array();
        $data['more_options'] = $this->more_options('Perfil');
        $view = new View();
        $obj = $obj->edit($_GET['id']);
        $data['obj'] = $obj;      
        $view->setData($data);
        $view->setTemplate( '../view/perfil/_form.php' );
        $view->setlayout( '../template/layout.php' );
        
        $view->render();
    }
   public function save()
   {
        $obj = new Perfil();
        if ($_POST['idperfil']=='') {
            $p = $obj->insert($_POST);
            if ($p[0]){
                header('Location: index.php?controller=perfil');
            } else {
            $data = array();
            $view = new View();
            $data['msg'] = $p[1];
            $data['url'] =  'index.php?controller=perfil';
            $view->setData($data);
            $view->setTemplate( '../view/_error_app.php' );
            $view->setlayout( '../template/layout.php' );
            $view->render();
            }
        } else {
            $p = $obj->update($_POST);
            if ($p[0]){
                header('Location: index.php?controller=perfil');
            } else {
            $data = array();
            $view = new View();
            $data['msg'] = $p[1];
            $data['url'] =  'index.php?controller=perfil';
            $view->setData($data);
            $view->setTemplate( '../view/_error_app.php' );
            $view->setlayout( '../template/layout.php' );
            $view->render();
            }
        }
    }
    public function delete()
      {
        $obj = new Perfil();
        $p = $obj->delete($_GET['id']);
        if ($p[0]){
            header('Location: index.php?controller=perfil');
        } 
        else {
            $data = array();
            $view = new View();
            $data['msg'] = $p[1];
            $data['url'] =  'index.php?controller=perfil';
            $view->setData($data);
            $view->setTemplate( '../view/_error_app.php' );
            $view->setlayout( '../template/layout.php' );
            $view->render();
        }
      }
   
   
}
?>