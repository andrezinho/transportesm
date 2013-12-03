<?php
require_once '../lib/controller.php';
require_once '../lib/view.php';
require_once '../model/ingresos.php';
class ingresosController extends Controller 
{
   public function index() 
   {
        if (!isset($_GET['p'])){$_GET['p']=1;}
        if(!isset($_GET['q'])){$_GET['q']="";}        
        if(!isset($_GET['criterio'])){$_GET['criterio']="remitente.nombre";} 
        $obj = new ingresos();
        $data = array();
        $data['data'] = $obj->index($_GET['q'],$_GET['p'],$_GET['criterio']);
        $data['query'] = $_GET['q'];
        $data['pag'] = $this->Pagination(array('rows'=>$data['data']['rowspag'],'url'=>'index.php?controller=ingresos&action=index','query'=>$_GET['q'],'trows'=>$data['data']['total']));
        $this->registros = $data['data']['rows'];
        $this->columnas = array("CODIGO"=>array('ancho'=>'5','align'=>'center','title'=>'Codigo'),
                      "RECIBI DE"=>array(),                      
                      "CHOFER"=>array(),
                      "FECHA"=>array('align'=>'center'),
                      "OBSERVCION"=>array(),                    
                      "ESTADO"=>array('align'=>'center'),
                       "TIPO"=>array('align'=>'center'),
                      "USUARIO"=>array('align'=>'center','ancho'=>'10'),
                      "-"=>array('ancho'=>'3','align'=>'center'),
                     "<p style='font-size:8px;'>&nbsp;</p>"=>array('ancho'=>3,'align'=>'center')
                    );

        $this->busqueda = array("descripcion"=>"RECIBI DE ");                
        
        $this->asignarAccion('eliminar',false);
        $this->asignarAccion('editar',false);
        $this->asignarAccion('ver',true);
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
        $data['more_options'] = $this->more_options('ingresos');        
        $data['detalle'] = $this->viewDetalle();
         $view->setData($data);
        $view->setTemplate( '../view/ingresos/_form.php' );
        $view->setlayout( '../template/layout.php' );
        $view->render();
    } 
   
    public function edit() 
    {
        
        $obj = new ingresos();
        $obj = $obj->edit($_GET['id']);
        $data = array();
        $data['more_options'] = $this->more_options('ingresos');
        $data['detalle'] = $this->viewDetalle();
        $view = new View();        
        $data['obj'] = $obj;
        $view->setData($data);
        $view->setTemplate( '../view/ingresos/_form.php' );
        $view->setlayout( '../template/layout.php' );
        $view->render();
    }
        public function result()
    {
        $data = array();
        $view = new View();        
        $data['more_options'] = $this->more_options('ingresos');        
        $data['idmovimiento'] = (int)$_GET['im'];
        $view->setData($data);
        $view->setTemplate( '../view/ingresos/_result.php' );
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
        public function anular()
    {
        $obj = new ingresos();
        $p = $obj->anular($_GET['id']);
        if ($p[0])
        {
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
        
        $obj = new ingresos();
        $obj = $obj->edit($_GET['id']);
        $data = array();
        $data['more_options'] = $this->more_options('ingresos');
        
        $data['detalle'] = $this->viewDetalle('readonly');
        $view = new View();        
        $data['obj'] = $obj;
        $view->setData($data);
        $view->setTemplate( '../view/ingresos/_form.php' );
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
            $view->setTemplate('../view/ingresos/_detalle.php');
        }
        else 
        {
            $view->setTemplate('../view/ingresos/_detalle_readonly.php');
        }
        
        $view->setlayout( '../template/layout.php' );
        return $view->renderPartial();        
    }
    
    public function viewDetalle2()
    {        
        $view = new View();
        $data = array();        
        $view->setData($data);
        $view->setTemplate('../view/ingresos/_detalle.php');
        $view->setlayout( '../template/layout.php' );
        return $view->renderPartial();        
    }
 
}
?>