<?php
require_once '../lib/controller.php';
require_once '../lib/view.php';
require_once '../model/egresos.php';
class EgresoController extends Controller
{
   public function index() {
        if (!isset($_GET['p'])){$_GET['p']=1;}
        if(!isset($_GET['q'])){$_GET['q']="";}        
        $obj = new egresos();
        $data = array();
        $data['data'] = $obj->index($_GET['q'],$_GET['p']);
        $data['query'] = $_GET['q'];
        $data['pag'] = $this->Pagination(array('rows'=>$data['data']['rowspag'],'url'=>'index.php?controller=egreso&action=index','query'=>$_GET['q'],'trows'=>$data['data']['total']));
        $this->registros = $data['data']['rows'];
        $this->columnas = array(
                    "CODIGO"=>array('ancho'=>'5','align'=>'center','title'=>'Codigo'),
                      "PAGUESE A"=>array(),
                      "POR CONCEPTO"=>array(),
                      "SERIE-NUM"=>array('align'=>'center'),
                      "FECHA"=>array('align'=>'center'),
                      "CAJA"=>array('align'=>'center'),
                      "TOTAL"=>array('align'=>'right'),
                      "ESTADO"=>array('align'=>'center'),
                      "USUARIO"=>array('align'=>'center','ancho'=>10),
                      "-"=>array('align'=>'center','ancho'=>'3'),
                       "<p style='font-size:8px;'>&nbsp;</p>"=>array('ancho'=>3,'align'=>'center')
                    );         
        $this->busqueda = array("descripcion"=>"CONCEPTO");
        $this->asignarAccion('eliminar',false);
        $this->asignarAccion('editar',false);
        $this->asignarAccion('ver',true);
        $data['grilla'] = $this->grilla("egreso",$data['pag']);
        
        $view = new View();
        $view->setData($data);
        $view->setTemplate( '../view/egresos/_index.php' );
        $view->setlayout( '../template/layout.php' );
        $view->render();
    }
     
     public function create() 
    {
        $data = array();
        $view = new View();   
        $data['more_options'] = $this->more_options('egreso');        
        $data['detalle'] = $this->viewDetalle();
        $data['comprobante'] = $this->Select(
                                              array(
                                                    'id'=>'idtipo_documento',
                                                    'name'=>'idtipo_documento',
                                                    'table'=>'tipodoc'
                                                    )
                                                 );

         $view->setData($data);
        $view->setTemplate( '../view/egresos/_form.php' );
        $view->setlayout( '../template/layout.php' );
        $view->render();
    }    
    public function edit() 
    {
        
        $obj = new egresos();
        $obj = $obj->edit($_GET['id']);
        $data = array();
        $data['more_options'] = $this->more_options('egreso');
        $data['detalle'] = $this->viewDetalle();
        $view = new View();        
        $data['obj'] = $obj;
        $view->setData($data);
        $view->setTemplate( '../view/egresos/_form.php' );
        $view->setlayout( '../template/layout.php' );
        $view->render();
    }
     public function result()
    {
        $data = array();
        $view = new View();        
        $data['more_options'] = $this->more_options('egreso');        
        $data['idmovimiento'] = (int)$_GET['im'];
        $view->setData($data);
        $view->setTemplate( '../view/egresos/_result.php' );
        $view->setlayout( '../template/layout.php' );
        $view->render();
    }    
    public function save()
    {
        $obj = new egresos();
        $result = array();        
        if ($_POST['idmovimiento']=='') 
        {
            $p = $obj->insert($_POST);            
            if ($p['res']=='1')                
                $result = array(1,'',$p['idm']);
            else                 
                $result = array(2,$p['msg'],'');
            print_r(json_encode($result));
        }
        else 
        {
            $p = $obj->update($_POST);            
            if ($p['res']=='1')                
                $result = array(1,'',$p['idm']);                
            else                 
                $result = array(2,$p['msg'],'');
            print_r(json_encode($result));    
        }
    }
    public function anular()
    {
        $obj = new egresos();
        $p = $obj->anular($_GET['id']);
        if ($p[0])
        {
            header('Location: index.php?controller=egreso');
        } else {
        $data = array();
        $view = new View();
        $data['msg'] = $p[1];
        $data['url'] =  'index.php?controller=egreso';
        $view->setData($data);
        $view->setTemplate( '../view/_error_app.php' );
        $view->setlayout( '../template/layout.php' );
        $view->render();
        }
    }
    
    public function delete()
    {
        $obj = new egresos();
        $p = $obj->delete($_GET['id']);
        if ($p[0])
        {
            header('Location: index.php?controller=egreso');
        } else {
        $data = array();
        $view = new View();
        $data['msg'] = $p[1];
        $data['url'] =  'index.php?controller=egreso';
        $view->setData($data);
        $view->setTemplate( '../view/_error_app.php' );
        $view->setlayout( '../template/layout.php' );
        $view->render();
        }
    }
    public function add()
    {        
        $r = $_SESSION['conceptos']->add($_POST['idconcepto_movimiento'],$_POST['concepto'],$_POST['monto'],$_POST['cantidad']);
        if($r){print_r(json_encode(array("resp"=>"1","data"=>$this->viewDetalle())));}
            else{print_r(json_encode(array("resp"=>"0","data"=>"ESTE DESTINO YA FUE AGREGADO AL DETALLE")));}
    }    
    public function quit()
    {
        $_SESSION['conceptos']->quit($_POST['i']);
        echo $this->viewDetalle();
    }
    public function show() 
    {
        
        $obj = new egresos();
        $obj = $obj->edit($_GET['id']);
        $data = array();
        $data['more_options'] = $this->more_options('egreso');

        $data['detalle'] = $this->viewDetalle('readonly');
        $view = new View();        
        $data['obj'] = $obj;
        $view->setData($data);
        $view->setTemplate( '../view/egresos/_form.php' );
        $view->setlayout( '../template/layout.php' );
        $view->render();
    }    
    public function viewDetalle($type=null)
    {        
        $view = new View();
        $data = array();        
        $view->setData($data);
        if($type!="readonly")
        {
            $view->setTemplate('../view/egresos/_detalle.php');
        }
        else 
        {
            $view->setTemplate('../view/egresos/_detalle_readonly.php');
        }
        
        $view->setlayout( '../template/layout.php' );
        return $view->renderPartial();        
    }

    public function printer()
    {
        $data = array();
        $view = new View();                
        $obj = new egresos();
        $result = $obj->getdata((int)$_GET['iv']);
        if($result[0])
        {
            $data['head'] = $result[1];          
            $data['detalle'] = $result[2];
            $view->setData($data);
            $view->setTemplate( '../view/egresos/_print.php');
            $view->setlayout( '../template/empty.php' );
            $view->render();  
        }
        else 
        {
            $data = array();
            $view = new View();
            $data['msg'] = 'No se ha podido encontrar el egreso solicitado a imprimir.';
            $data['url'] =  'index.php?controller=egreso';
            $view->setData($data);
            $view->setTemplate( '../view/_error_app.php' );
            $view->setlayout( '../template/layout.php' );
            $view->render();
        }
        
    }
   
   
}
?>