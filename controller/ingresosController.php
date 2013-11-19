<?php
require_once '../lib/controller.php';
require_once '../lib/view.php';
require_once '../model/ingresos.php';

class ingresosController extends Controller {    
    public function index() 
    {
        if(!isset($_GET['p'])){$_GET['p']=1;}
        if(!isset($_GET['q'])){$_GET['q']="";}        
        if(!isset($_GET['criterio'])){$_GET['criterio']="i.referencia";}        
        $obj = new ingresos();
        $data = array();
        $data['data'] = $obj->index($_GET['q'],$_GET['p'],$_GET['criterio']);
        $data['query'] = $_GET['q'];
        $data['pag'] = $this->Pagination(array('rows'=>$data['data']['rowspag'],'url'=>'index.php?controller=ingresos&action=index','query'=>$_GET['q'],'trows'=>$data['data']['total']));
        
        $this->registros = $data['data']['rows'];
        
        $this->columnas = array("N°"=>array('titulo'=>'Codigo','align'=>'center','ancho'=>'5'),
                                "FECHA" => array('ancho'=>'12','align'=>'center'),
                                "DESCRIPCION" => array(),
                                "FECHA DOC" => array('ancho'=>'12','align'=>'center'),
                                "TIPO DOC" => array(),
                                "NRO DOC" => array('align'=>'center','ancho'=>'15')                                
                                );                
        $this->busqueda = array("i.referencia"=>"referencia");                   
        $data['grilla'] = $this->grilla("ingresos",$data['pag']);        
        $view = new View();
        $view->setData($data);
        $view->setTemplate( '../view/ingresos/_index.php' );
        $view->setlayout( '../template/layout.php' );
        $view->render();
    }
    public function create() 
    {
        $data = array();
        $view = new View();   
        $data['tipodocumento'] = $this->Select(array('id'=>'idtipodocumento','name'=>'idtipodocumento','table'=>'tipodocumento'));
        $data['more_options'] = $this->more_options('ingresos');
        $data['detalle'] = $this->viewDetalle();
        $view->setData($data);
        $view->setTemplate( '../view/ingresos/_form.php' );
        $view->setlayout( '../template/layout.php' );
        $view->render();
    }
     public function viewDetalle()
    {        
        $view = new View();
        $data = array();        
        $view->setData($data);
        $view->setTemplate('../view/ingresos/_detalle.php');
        $view->setlayout( '../template/layout.php' );
        return $view->renderPartial();        
    }
    public function edit() 
    {
        $obj = new ingresos();
        $obj = $obj->edit($_GET['id']);
        $data = array();
        $data['more_options'] = $this->more_options('ingresos');
        $data['unidad'] = $this->Select(array('id'=>'idunidad','name'=>'idunidad','table'=>'unidad','code'=>$obj->idunidad));
        $view = new View();
        
        $data['obj'] = $obj;        
        $view->setData($data);
        $view->setTemplate( '../view/ingresos/_form.php' );
        $view->setlayout( '../template/layout.php' );
        $view->render();
    }
    public function save()
    {
        $obj = new ingresos();
        $result = array();
        
        if ($_POST['idingresos']=='') 
        {
            $p = $obj->insert($_POST);
            
                if ($p['res']=='1')                
                    $result = array(1,$p['msg'],$p['idm']);                
                else                 
                    $result = array(2,$p['msg'],'');
                print_r(json_encode($result));           
        }
        else 
        {
            $p = $obj->update($_POST);            
            if ($p['res']=='1')                
                $result = array(1,'',$p['ide']);                
            else                 
                $result = array(2,$p['msg'],'');
            print_r(json_encode($result));    
        }
    }
    public function delete(){
        $obj = new ingresos();
        $p = $obj->delete($_GET['id']);
        if ($p[0]){
            header('Location: index.php?controller=ingresos');
        } else {
        $data = array();
        $view = new View();
        $data['msg'] = $p[1];
        $data['url'] =  'index.php?controller=ingresos';
        $view->setData($data);
        $view->setTemplate( '../view/_error_app.php' );
        $view->setlayout( '../template/layout.php' );
        $view->render();
        }
    }
    public function printer()
    {
        $data = array();
        $view = new View();                
        $obj = new ingresos();
        $result = $obj->getdata((int)$_GET['iv']);
        if($result[0])
        {
            $data['head'] = $result[1];          
            $data['detalle'] = $result[2];
            $view->setData($data);
            $view->setTemplate( '../view/ingresos/_print.php');
            $view->setlayout( '../template/empty.php' );
            $view->render();  
        }
        else 
        {
            $data = array();
            $view = new View();
            $data['msg'] = 'No se ha podido encontrar el ingreso solicitado a imprimir.';
            $data['url'] =  'index.php?controller=ingresos';
            $view->setData($data);
            $view->setTemplate( '../view/_error_app.php' );
            $view->setlayout( '../template/layout.php' );
            $view->render();
        }
        
    }
 
}
?>