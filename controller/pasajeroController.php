<?php
require_once '../lib/controller.php';
require_once '../lib/view.php';
require_once '../model/pasajero.php';
class pasajeroController extends Controller
{
   public function index() {
        if (!isset($_GET['p'])){$_GET['p']=1;}
        if(!isset($_GET['q'])){$_GET['q']="";}        
        $obj = new pasajero();
        $data = array();
        $data['data'] = $obj->index($_GET['q'],$_GET['p']);
        $data['query'] = $_GET['q'];
        $data['pag'] = $this->Pagination(array('rows'=>$data['data']['rowspag'],'url'=>'index.php?controller=pasajero&action=index','query'=>$_GET['q'],'trows'=>$data['data']['total']));
        $this->registros = $data['data']['rows'];
        $this->columnas = array("CODIGO"=>array('ancho'=>'10','align'=>'center','title'=>'Codigo'),
                        "NRO DOC"=>array('ancho'=>'15','align'=>'center'),
                        "NOMBRE"=>array()
                    );         
        $this->busqueda = array("nombre"=>"Nombre y Apellidos");                
        $data['grilla'] = $this->grilla("pasajero",$data['pag']);
        
        $view = new View();
        $view->setData($data);
        $view->setTemplate( '../view/pasajero/_index.php' );
        $view->setlayout( '../template/layout.php' );
        $view->render();
    }
     
    public function create()
    {
        $data = array();
        $view = new View();        
        $data['more_options'] = $this->more_options('pasajero');
        $view->setData($data);
        $view->setTemplate( '../view/pasajero/_form.php' );
        
        $view->setlayout( '../template/layout.php' );
        $view->render();
    }
    public function edit() {
        $obj = new pasajero();
        $data = array();
        $data['more_options'] = $this->more_options('pasajero');
        $view = new View();
        $obj = $obj->edit($_GET['id']);
        $data['obj'] = $obj;      
        $view->setData($data);
        $view->setTemplate( '../view/pasajero/_form.php' );
        $view->setlayout( '../template/layout.php' );
        
        $view->render();
    }
   public function save()
   {
        $obj = new pasajero();
        if ($_POST['idpasajero']=='') {
            $p = $obj->insert($_POST);
            if ($p[0]){
                header('Location: index.php?controller=pasajero');
            } else {
            $data = array();
            $view = new View();
            $data['msg'] = $p[1];
            $data['url'] =  'index.php?controller=pasajero';
            $view->setData($data);
            $view->setTemplate( '../view/_error_app.php' );
            $view->setlayout( '../template/layout.php' );
            $view->render();
            }
        } else {
            $p = $obj->update($_POST);
            if ($p[0]){
                header('Location: index.php?controller=pasajero');
            } else {
            $data = array();
            $view = new View();
            $data['msg'] = $p[1];
            $data['url'] =  'index.php?controller=pasajero';
            $view->setData($data);
            $view->setTemplate( '../view/_error_app.php' );
            $view->setlayout( '../template/layout.php' );
            $view->render();
            }
        }
    }
    public function delete()
      {
        $obj = new pasajero();
        $p = $obj->delete($_GET['id']);
        if ($p[0]){
            header('Location: index.php?controller=pasajero');
        } 
        else {
            $data = array();
            $view = new View();
            $data['msg'] = $p[1];
            $data['url'] =  'index.php?controller=pasajero';
            $view->setData($data);
            $view->setTemplate( '../view/_error_app.php' );
            $view->setlayout( '../template/layout.php' );
            $view->render();
        }
      }
      public function search_autocomplete()
        {
            $obj = new pasajero();
            $data = array();
            $view = new View();
            $field = "direccion";
            if($_GET['tipo']==1)
            {
                $field = "nrodocumento";
            }
            elseif ($_GET['tipo']==2) {
                $field = "nombre";
            }
            
            $data['value'] = $obj->getpasajero($_GET["term"],$field,$_GET["t"]);
            $view->setData( $data );
            $view->setTemplate( '../view/pasajero/_json.php' );
            echo $view->renderPartial();
        }
   
}
?>