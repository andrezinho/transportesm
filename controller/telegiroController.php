<?php
require_once '../lib/controller.php';
require_once '../lib/view.php';
require_once '../model/tipo_pasajero.php';
require_once '../model/telegiro.php';
class telegiroController extends Controller
{
   public function index() 
   {
        if (!isset($_GET['p'])){$_GET['p']=1;}
        if(!isset($_GET['q'])){$_GET['q']="";} 
        if(!isset($_GET['op'])){$_GET['op']="0";}
        if(!isset($_GET['criterio'])){$_GET['criterio']="remitente.nombre";} 
        $obj = new telegiro();
        $data = array();
        $data['op'] = $_GET["op"];
        $data['data'] = $obj->index($_GET['q'],$_GET['p'],$_GET['criterio'],$_GET['op']);
        $data['query'] = $_GET['q'];
        $data['pag'] = $this->Pagination(array('rows'=>$data['data']['rowspag'],'url'=>'index.php?controller=telegiro&action=index','query'=>$_GET['q'],'trows'=>$data['data']['total']));
        $this->registros = $data['data']['rows'];
        $this->columnas = array("ID"=>array('ancho'=>3,'align'=>'center','title'=>'Codigo'),
                                "FECHA"=>array('ancho'=>10,'align'=>'center'),
                                "REMITENTE"=>array(),
                                "CONSIGNADO"=>array(),
                                "NRO"=>array('ancho'=>8,'align'=>'center'),
                                "MONTO"=>array('ancho'=>8,'align'=>'center'),
                                "ESTADO"=>array('ancho'=>10,'align'=>'center'),
                                "&nbsp;"=>array('ancho'=>5,'align'=>'center'),
                                "ACCION"=>array('ancho'=>5,'align'=>'center')
                                );
        $this->busqueda = array("remitente.nombre"=>"Remitente",
                                "consignado.nombre"=>"Consignado"
                                );
        if($_GET["op"] == "0")
        {
            $this->asignarAccion('eliminar',false);
            $this->asignarAccion('anular',true);
            $this->asignarAccion('editar',true);
            $this->asignarAccion('ver',false);
        } 
        else
        {
            $this->asignarAccion('eliminar',false);
            $this->asignarAccion('anular',false);
            $this->asignarAccion('editar',false);
            $this->asignarAccion('ver',false);
        }
        
        $data['grilla'] = $this->grilla("telegiro",$data['pag']);
        $view = new View();
        $view->setData($data);
        $view->setTemplate( '../view/telegiro/_Index.php' );
        $view->setLayout( '../template/layout.php' );
        $view->render();
    }
   public function create() 
   {
        $data = array();
        $view = new View();
        $data['destino'] = $this->Select(
                                            array(
                                                    'id'=>'iddestino',
                                                    'name'=>'iddestino',
                                                    'table'=>'voficina'
                                                    )
                                                 );
        $data['more_options'] = $this->more_options('telegiro');
        $view->setData($data);
        $view->setTemplate( '../view/telegiro/_Form.php' );
        $view->setLayout( '../template/layout.php' );
        $view->render();
    }
    public function entregar()
   {
        $obj = new telegiro();
        $obj = $obj->edit($_GET['id']);
        $data = array();
        $view = new View();          
        $data['destino'] = $this->Select(
                                            array(
                                                    'id'=>'iddestino',
                                                    'name'=>'iddestino',
                                                    'table'=>'voficina',
                                                    'code'=>$obj->iddestino,
                                                    'disabled'=>'disabled'
                                                    )
                                                 );
        $data['more_options'] = $this->more_options('telegiro');
        $data['obj'] = $obj;
        $view->setData($data);
        $view->setTemplate( '../view/telegiro/_Form.php' );
        $view->setLayout( '../template/layout.php' );
        $view->render();
    }
    public function edit()
   {
        $obj = new telegiro();
        $obj = $obj->edit($_GET['id']);
        $data = array();
        $view = new View();          
        $data['destino'] = $this->Select(
                                            array(
                                                    'id'=>'iddestino',
                                                    'name'=>'iddestino',
                                                    'table'=>'voficina',
                                                    'code'=>$obj->iddestino,
                                                    'disabled'=>'disabled'
                                                    )
                                                 );
        $data['more_options'] = $this->more_options('telegiro');
        $data['obj'] = $obj;
        $view->setData($data);
        $view->setTemplate( '../view/telegiro/_Form.php' );
        $view->setLayout( '../template/layout.php' );
        $view->render();
    }
    public function exec_entrega()
    {
         $obj = new telegiro();
         $p = $obj->entregar($_POST['idtelegiro']);
            if ($p['res']=='1')
            {
                $result = array(1,'SE HA ENTREGADO CORRECTAMENTE EL TELEGIRO');
            } 
            else 
            {
                $result = array(2,'HA OCURRIDO UN ERROR, FAVOR DE ACTUALIZAR LA PAGINA (F5) Y VOLVER A INTENTARLO','');
            }
            print_r(json_encode($result));
    }
    public function reembolsar() 
   {
        $obj = new telegiro();
        $p = $obj->reembolsar($_POST['idtelegiro']);
        if ($p['res']=='1')
            {
                $result = array(1,'SE HA REEMBOLSADO CORRECTAMENTE EL TELEGIRO');
            } 
            else 
            {
                $result = array(2,'HA OCURRIDO UN ERROR, FAVOR DE ACTUALIZAR LA PAGINA (F5) Y VOLVER A INTENTARLO','');
            }
            print_r(json_encode($result));
    }
    public function anular() 
   {
        $obj = new telegiro();
        $p = $obj->anular($_POST['idtelegiro']);
        if ((int)$p['res']==1)
            {
                $result = array(1,'SE HA ANULADO CORRECTAMENTE EL TELEGIRO');
            } 
            else if ((int)$p['res']==2)
            {
                $result = array(2,'NO SE PUEDE ANULAR EL TELEGIRO POR QUE SE ENCUENTRA EN OTRO ESTADO','');
            }
            else
            {
                $result = array(3,'HA OCURRIDO UN ERROR, FAVOR DE ACTUALIZAR LA PAGINA (F5) Y VOLVER A INTENTARLO','');
            }
            print_r(json_encode($result));
    }
    public function show() 
    {
        
        $obj = new telegiro();
        $obj = $obj->edit($_GET['id']);
        $data = array();
        $data['more_options'] = $this->more_options('telegiro');
        $data['destino'] = $this->Select(
                                            array(
                                                    'id'=>'iddestino',
                                                    'name'=>'iddestino',
                                                    'table'=>'destino',
                                                    'code'=>$obj->iddestino,
                                                    'disabled'=>'disabled'
                                                    )
                                                 );
        $data['detalle'] = $this->viewDetalle('readonly');
        $view = new View();        
        $data['obj'] = $obj;
        $view->setData($data);
        $view->setTemplate( '../view/telegiro/_Form.php' );
        $view->setLayout( '../template/layout.php' );
        $view->render();
    }
    public function result()
    {
        $data = array();
        $view = new View();        
        $data['more_options'] = $this->more_options('telegiro');        
        $data['idtelegiro'] = (int)$_GET['iv'];
        $view->setData($data);
        $view->setTemplate( '../view/telegiro/_result.php' );
        $view->setLayout( '../template/layout.php' );
        $view->render();
    }    
    public function save()
    {      
        $obj = new telegiro();
        $result = array();
        if ($_POST['idtelegiro']=='') 
        {
            $p = $obj->insert($_POST);
            
            if ($p['res']=='1')
            {
                $result = array(1,'SE HA REGISTRADO CORRECTAMENTE EL TELEGIRO',$p['id']);
            } 
            else 
            {
                $result = array(2,'HA OCURRIDO UN ERROR, FAVOR DE ACTUALIZAR LA PAGINA (F5) Y VOLVER A INTENTARLO','');
            }
            print_r(json_encode($result));
        } else{
            $p = $obj->update($_POST);
            
            if ($p['res']=='1')
            {
                //$result = array(1,'SE HA MODIFICADO CORRECTAMENTE EL TELEGIRO',$p['idv']);
                $result = array(1,$p['msg'],$p['idv']);
            } 
            else 
            {
                //$result = array(2,'HA OCURRIDO UN ERROR, FAVOR DE ACTUALIZAR LA PAGINA (F5) Y VOLVER A INTENTARLO','');
                $result = array(2,"asdf","");
            }
            print_r(json_encode($result));
        }
    }
    public function confirmarEntrega()
    {      
        $obj = new telegiro();
        $result = array();
            $p = $obj->entregar($_POST['idtelegiro']);
            
            if ($p['res']=='1')
            {
                $result = array(1,'SE HA ENTREGADO CORRECTAMENTE EL TELEGIRO',$p['idv']);
            } 
            else 
            {
                $result = array(2,'HA OCURRIDO UN ERROR, FAVOR DE ACTUALIZAR LA PAGINA (F5) Y VOLVER A INTENTARLO','');
            }
            print_r(json_encode($result));
    }
    public function confirmarReembolso()
    {      
        $obj = new telegiro();
        $result = array();

            $p = $obj->reembolsar($_POST['idtelegiro']);
            
            if ($p['res']=='1')
            {
                $result = array(1,'SE HA REEMBOLSADO CORRECTAMENTE EL TELEGIRO',$p['idv']);
            } 
            else 
            {
                $result = array(2,'HA OCURRIDO UN ERROR, FAVOR DE ACTUALIZAR LA PAGINA (F5) Y VOLVER A INTENTARLO','');
            }
            print_r(json_encode($result));
    }
//    public function anular()
//      {
//        $obj = new telegiro();
//        $p = $obj->anular($_GET['id']);
//        if ($p[0])
//        {
//            header('Location: index.php?controller=telegiro');
//        } 
//        else 
//        {
//            $data = array();
//            $view = new View();
//            $data['msg'] = $p[1];
//            $data['url'] =  'index.php?controller=telegiro';
//            $view->setData($data);
//            $view->setTemplate( '../view/_Error_App.php' );
//            $view->setLayout( '../template/Layout.php' );
//            $view->render();
//        }
//      }
    public function printer()
    {
        $data = array();
        $view = new View();                
        $obj = new telegiro();
        $result = $obj->getdata((int)$_GET['id']);
        if($result[0])
        {
            $data['head'] = $result[1];             
            $view->setData($data);
            $view->setTemplate( '../view/telegiro/_print.php');
            $view->setlayout( '../template/empty.php' );
            $view->render();
        }
        else 
        {
            $data = array();
            $view = new View();
            $data['msg'] = 'No se ha podido encontrar el telegiro solicitado a imprimir.';
            $data['url'] =  'index.php?controller=envio';
            $view->setData($data);
            $view->setTemplate( '../view/_error_app.php' );
            $view->setlayout( '../template/layout.php' );
            $view->render();
        }
        
    }
}
?>