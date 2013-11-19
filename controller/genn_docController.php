<?php
require_once '../lib/controller.php';
require_once '../lib/view.php';
require_once '../model/genn_doc.php';
class genn_docController extends Controller
{
    
      public function index() {
        if (!isset($_GET['p'])){$_GET['p']=1;}
        if(!isset($_GET['q'])){$_GET['q']="";}        
        $obj = new genn_doc();
        $data = array();
        $data['data'] = $obj->index($_GET['q'],$_GET['p']);
        $data['query'] = $_GET['q'];
        $data['pag'] = $this->Pagination(array('rows'=>$data['data']['rowspag'],'url'=>'index.php?controller=genn_doc&action=index','query'=>$_GET['q'],'trows'=>$data['data']['total']));
        $this->registros = $data['data']['rows'];
        $this->columnas = array("CODIGO"=>array('ancho'=>'10','align'=>'center','title'=>'Codigo'),
                                "OFICINA"=>array(),
                                "TIPO DE DOCUMENTO"=>array(),
                                "SERIE"=>array(),
                                "Nº INICIAL"=>array(),
                                "Nº FINAL"=>array(),
                                "Nº ACTUAL"=>array()
                    );         
        $this->busqueda = array("descripcion"=>"TIPO DE DOCUMENTO");                
        $data['grilla'] = $this->grilla("genn_doc",$data['pag']);
        
        $view = new View();
        $view->setData($data);
        $view->setTemplate( '../view/genn_doc/_index.php' );
        $view->setlayout( '../template/layout.php' );
        $view->render();
    }
        public function create()
    {
        $data = array();
        $view = new View();        
        $data['more_options'] = $this->more_options('genn_doc');
        $data['oficina'] = $this->Select(array('id'=>'idoficina','name'=>'idoficina','table'=>'voficina'));
        $data['tipo_documento'] = $this->Select(array('id'=>'idtipo_documento','name'=>'idtipo_documento','table'=>'tipo_documento'));
        $view->setData($data);
        $view->setTemplate( '../view/genn_doc/_form.php' );
        
        $view->setlayout( '../template/layout.php' );
        $view->render();
    }
    public function edit()
    {
        $obj = new genn_doc();
        $data = array();
        $view = new View();        
        $obj = $obj->edit($_GET['id']);
        $data['obj'] = $obj;        
        $data['oficina'] = $this->Select(array('id'=>'idoficina','name'=>'idoficina','table'=>'voficina','code'=>$obj->idoficina));
        $data['tipo_documento'] = $this->Select(array('id'=>'idtipo_documento','name'=>'idtipo_documento','table'=>'tipo_documento','code'=>$obj->idtipo_documento));        
        $data['more_options'] = $this->more_options('genn_doc');
        $view->setData($data);
        $view->setTemplate( '../view/genn_doc/_form.php' );
        $view->setlayout( '../template/layout.php' );
        $view->render();
    }
   public function getcurrent() 
   {
        $obj = new genn_doc();
        $data = array();        
        $view = new View();
        $r = $obj->getcurrent($_GET['idtd']);
        print_r(json_encode(array('serie'=>str_pad($r->serie, 4, '0', 0),'numero'=>str_pad($r->current, 6, '0', 0))));        
   }
   public function save()
   {
        $obj = new genn_doc();
        if ($_POST['idgenn_doc']=='') {
            $p = $obj->insert($_POST);
            if ($p[0]){
                header('Location: index.php?controller=genn_doc');
            } else {
            $data = array();
            $view = new View();
            $data['msg'] = $p[1];
            $data['url'] =  'index.php?controller=genn_doc';
            $view->setData($data);
            $view->setTemplate( '../view/_error_app.php' );
            $view->setlayout( '../template/layout.php' );
            $view->render();
            }
        } else {
            $p = $obj->update($_POST);
            if ($p[0]){
                header('Location: index.php?controller=genn_doc');
            } else {
            $data = array();
            $view = new View();
            $data['msg'] = $p[1];
            $data['url'] =  'index.php?controller=genn_doc';
            $view->setData($data);
            $view->setTemplate( '../view/_error_app.php' );
            $view->setlayout( '../template/layout.php' );
            $view->render();
            }
        }
    }
    public function delete()
      {
        $obj = new genn_doc();
        $p = $obj->delete($_GET['id']);
        if ($p[0]){
            header('Location: index.php?controller=genn_doc');
        } 
        else {
            $data = array();
            $view = new View();
            $data['msg'] = $p[1];
            $data['url'] =  'index.php?controller=genn_doc';
            $view->setData($data);
            $view->setTemplate( '../view/_error_app.php' );
            $view->setlayout( '../template/layout.php' );
            $view->render();
        }
      }
   
   
}
?>