<?php
require_once '../lib/controller.php';
require_once '../lib/view.php';
require_once '../model/envio.php';
require_once '../model/tipo_pasajero.php';
require_once '../model/destino.php';
require_once '../model/salida.php';

class envioController extends Controller
{
   public function index() 
   {
        if (!isset($_GET['p'])){$_GET['p']=1;}
        if(!isset($_GET['q'])){$_GET['q']="";} 
        if(!isset($_GET['criterio'])){$_GET['criterio']="1";} 
        if(!isset($_GET['tipoe'])){$_GET['tipoe']=1;}
        $obj = new envio();
        $data = array();
        $data['data'] = $obj->index($_GET['q'],$_GET['p'],$_GET['criterio'],$_GET['tipoe']);
        $data['query'] = $_GET['q'];
        $data['pag'] = $this->Pagination(array('rows'=>$data['data']['rowspag'],'url'=>'index.php?controller=envio&action=index','query'=>$_GET['q'],'trows'=>$data['data']['total']));
        $this->registros = $data['data']['rows'];
        $this->columnas = array("ID"=>array('ancho'=>'5','align'=>'center','title'=>'Codigo'),
                                "FECHA"=>array('ancho'=>'7','align'=>'center'),
                                "TIPO"=>array('ancho'=>4,'align'=>'center'),
                                "REMITENTE"=>array(),
                                "CONSIGNADO"=>array(),
                                "NRO"=>array('ancho'=>10,'align'=>'center'),
                                "DESTINO FINAL"=>array('ancho'=>12),
                                "PAGO"=>array('ancho'=>3,'align'=>'center'),                                
                                "ESTADO"=>array('ancho'=>'7','align'=>'center'),
                                "USER"=>array('ancho'=>5,'align'=>'center'),
                                "<p style='font-size:7px;'>&nbsp;</p>"=>array('ancho'=>3,'align'=>'center'),
                                "<p style='font-size:7px;'>Anular</p>"=>array('ancho'=>3,'align'=>'center'),
                                "<p style='font-size:7px;'>Print</p>"=>array('ancho'=>3,'align'=>'center')
                                );         
        $this->busqueda = array(
                                "1"=>"Nro Ticket",
                                "2"=>"Remitente",
                                "3"=>"Consignado"
                                );
        $this->asignarAccion('eliminar',false);
        $this->asignarAccion('editar',true);
        $this->asignarAccion('ver',true);
        $data['grilla'] = $this->grilla("envio",$data['pag']);
        $data['tipoe']=1;
        $view = new View();
        $view->setData($data);
        $view->setTemplate( '../view/envio/_index.php' );
        $view->setlayout( '../template/layout.php' );
        $view->render();
    }
    public function indexe() 
    {
        if (!isset($_GET['p'])){$_GET['p']=1;}
        if(!isset($_GET['q'])){$_GET['q']="";} 
        if(!isset($_GET['criterio'])){$_GET['criterio']="1";} 
        if(!isset($_GET['tipoe'])){$_GET['tipoe']=1;}
        $obj = new envio();
        $data = array();
        $data['data'] = $obj->indexe($_GET['q'],$_GET['p'],$_GET['criterio'],$_GET['tipoe']);
        $data['query'] = $_GET['q'];
        $data['pag'] = $this->Pagination(array('rows'=>$data['data']['rowspag'],'url'=>'index.php?controller=envio&action=indexe','query'=>$_GET['q'],'trows'=>$data['data']['total']));
        $this->registros = $data['data']['rows'];
        $this->columnas = array("ID"=>array('ancho'=>'5','align'=>'center','title'=>'Codigo'),
                                "FECHA"=>array('ancho'=>'7','align'=>'center'),
                                "TIPO"=>array('ancho'=>4,'align'=>'center'),
                                "REMITENTE"=>array(),
                                "CONSIGNADO A"=>array(),
                                "NRO"=>array('ancho'=>7,'align'=>'center'),
                                "PROVENIENTE DE"=>array('ancho'=>10),
                                "DESTINO FINAL"=>array('ancho'=>10),
                                "PAGO"=>array('ancho'=>3,'align'=>'center'),
                                "ESTADO"=>array('ancho'=>'7','align'=>'center'),
                                "USUARIO"=>array('ancho'=>7,'align'=>'center'),
                                "<p style='font-size:8px;'>Print</p>"=>array('ancho'=>4,'align'=>'center'),
                                "<p style='font-size:8px;'>&nbsp;</p>"=>array('ancho'=>4,'align'=>'center')
                                );         
        $this->busqueda = array(
                                "1"=>"Nro Ticket",
                                "2"=>"Remitente",
                                "3"=>"Consignado"
                                );
        $this->asignarAccion('eliminar',false);
        $this->asignarAccion('editar',false);
        $this->asignarAccion('ver',true);
        $data['tipoe']=2;
        $data['grilla'] = $this->grilla("envio",$data['pag']);
        $view = new View();
        $view->setData($data);
        $view->setTemplate( '../view/envio/_index.php' );
        $view->setlayout( '../template/layout.php' );
        $view->render();
    }
   public function create() 
   {
        $data = array();
        $view = new View(); 
        $objd = new destino();
        $destinos = $objd->getDDestinos();
        $data['destino'] = $this->Select(
                                            array(
                                                    'id'=>'iddestino',
                                                    'name'=>'iddestino',
                                                    'table'=>$destinos
                                                    )
                                                 );

        $data['tipos'] = $this->vtipo_pasajero();
        $data['more_options'] = $this->more_options('envio');
        $data['detalle'] = $this->viewDetalle();
        $view->setData($data);
        $view->setTemplate( '../view/envio/_form.php' );
        $view->setlayout( '../template/layout.php' );
        $view->render();
    }    
    public function vtipo_pasajero()
    {
        $data = array();
        $view = new View(); 
        $otp = new tipo_pasajero();
        $data['rows'] = $otp->gettipos();
        $view->setData($data);
        $view->setTemplate( '../view/tipo_pasajero/_tipos.php' );
        return $view->renderPartial();
        
    }
    public function edit() 
    {
        
        $obj = new envio();
        
        $obj = $obj->edit($_GET['id']);
        $objd = new destino();
        $destinos = $objd->getDDestinos();
        $data = array();
        $data['more_options'] = $this->more_options('envio');

        $estado = $obj->estado;
        $msg = "";

        if($estado!=1)
        {
            $msg = "YA NO PUEDE SER EDITADA YA QUE, YA FUE PROCESADA";
            $data['destino'] = $this->Select(
                                            array(
                                                    'id'=>'iddestino',
                                                    'name'=>'iddestino',
                                                    'table'=>$destinos,
                                                    'code'=>$obj->iddestino,
                                                    'disabled'=>'disabled'
                                                    )
                                                 );
            $data['detalle'] = $this->viewDetalle('readonly');            
            
        }
        else 
        {
            $data['destino'] = $this->Select(
                                            array(
                                                    'id'=>'iddestino',
                                                    'name'=>'iddestino',
                                                    'table'=>'destino',
                                                    'code'=>$obj->iddestino                                                    
                                                    )
                                                 );
            $objs = new salida();
            $salidas = $objs->getSalidasOk($obj->iddestino,$obj->fecha); 
            $tsalidas = array();        
            foreach($salidas as $key => $v)
            {
                if($key!="")
                {
                    $tsalidas[] = array($v['idsalida'],$v['descripcion']);                
                }
                
            }
            if($obj->idsalida=="")
            {
                $data['salidasok'] = $this->Select(
                                            array(
                                                    'id'=>'salidas',
                                                    'name'=>'salidas',
                                                    'table'=>$tsalidas                                                    
                                                    )
                                                 );
            }
            else 
            {
                $data['salidasok'] = $this->Select(
                                            array(
                                                    'id'=>'salidas',
                                                    'name'=>'salidas',
                                                    'table'=>$tsalidas,
                                                    'code'=>$obj->idsalida                                                    
                                                    )
                                                 );
            }
            
            $data['detalle'] = $this->viewDetalle();
        }
        
        
        $view = new View();        
        $data['obj'] = $obj;
        $data['msg'] = $msg;
        $view->setData($data);
        $view->setTemplate( '../view/envio/_form.php' );
        $view->setlayout( '../template/layout.php' );
        $view->render();
    }
    public function contrae() 
    {
        
        $obj = new envio();
        $obj = $obj->edit($_GET['id']);
        $data = array();
        $data['more_options'] = $this->more_options('envio');
        $data['msg'] = "<p style='text-align:center;padding-top:4px;'>CONFIRMAR CONTRA ENTREGA</p>";
        $data['contrae'] = 1;
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
        $view->setTemplate( '../view/envio/_form.php' );
        $view->setlayout( '../template/layout.php' );
        $view->render();
    }
    public function show() 
    {
        
        $obj = new envio();
        $obj = $obj->edit($_GET['id']);
        $data = array();
        $data['more_options'] = $this->more_options('envio');
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
        $data['msg'] = "<p style='text-align:center; padding-top:4px'>VISTA DE SOLO LECTURA</p>";
        $view = new View();        
        $data['obj'] = $obj;
        $view->setData($data);
        $view->setTemplate( '../view/envio/_form.php' );
        $view->setlayout( '../template/layout.php' );
        $view->render();
    }
    public function result()
    {
        $data = array();
        $view = new View();        
        $data['more_options'] = $this->more_options('envio');        
        $data['idenvio'] = (int)$_GET['iv'];
        $view->setData($data);
        $view->setTemplate( '../view/envio/_result.php' );
        $view->setlayout( '../template/layout.php' );
        $view->render();
    }    
    public function save()
    {      
        $obj = new envio();
        $result = array();
        
        if ($_POST['idenvio']=='') 
        {
            $p = $obj->insert($_POST);
            
                if ($p['res']=='1')                
                    $result = array(1,'',$p['ide'],$p['ce']);                
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
    public function save_ce()
    {
        $obj = new envio();
        $result = array();        
        $p = $obj->save_ce($_POST);            
        if ($p['res']=='1')                
            $result = array(1,'',$p['ide'],$p['ce']);                
        else                 
            $result = array(2,$p['msg'],'');
        print_r(json_encode($result));           
    }
    public function update()
    {
        $obj = new envio();
        $result = array();
        $id = (int)$_POST['idenvio'];
        if ($id!='') 
        {
            $p = $obj->updateInfo($_POST);
            if ($p==1)
            {
                $result = array('1','',(int)$_POST['idenvio']);
            } 
            else 
            {
                $result = array('0','HA OCURRIDO UN ERROR, FAVOR DE ACTUALIZAR LA PAGINA (F5) Y VOLVER A INTENTARLO','');
            }
            print_r(json_encode($result));
        }
        else {
            $result = array('0','NO PODEMOS PROCESAR SU SOLICITUD, PORFAVOR ACTUALIZAR LA PAGINA (F5) Y VOLVER A INTENTARLO','');
        }
    }
    public function sending()
    {
        $obj = new envio();
        $result = array();     
        $id = (int)$_POST['id'];   
        if ($id!='') 
        {
            $p = $obj->sending($id,$_POST['tipo']);
            if ($p[0]==1)
            {
                $result = array("1","<p style='font-size:9px; font-style:italic'>".$p[1]."</p>",$p[2]);
            } 
            else 
            {
                $result = array("0","HA OCURRIDO UN ERROR, FAVOR DE ACTUALIZAR LA PAGINA (F5) Y VOLVER A INTENTARLO");
            }
            print_r(json_encode($result));
        }
        else {
            $result = array('0','NO PODEMOS PROCESAR SU SOLICITUD, PORFAVOR ACTUALIZAR LA PAGINA (F5) Y VOLVER A INTENTARLO','');
        }
    }
    public function anular_es()
    {
        $obj = new envio();
        $result = array();     
        $id = (int)$_POST['id'];   
        if ($id!='') 
        {
            $p = $obj->anular_es($id);
            if ($p[0]==1)
            {
                $result = array("1","Ok",$p[2]);
            } 
            else 
            {
                $result = array("0","HA OCURRIDO UN ERROR, FAVOR DE ACTUALIZAR LA PAGINA (F5) Y VOLVER A INTENTARLO");
            }
            print_r(json_encode($result));
        }
        else {
            $result = array('0','NO PODEMOS PROCESAR SU SOLICITUD, PORFAVOR ACTUALIZAR LA PAGINA (F5) Y VOLVER A INTENTARLO','');
        }
    }
    public function cancelar_es()
    {
        $obj = new envio();
        $result = array();     
        $id = (int)$_POST['id'];
        if ($id!='') 
        {
            $p = $obj->cancelar_es($id);
            if ($p[0]==1)
            {
                $result = array("1","Ok",$p[2]);
            } 
            else 
            {
                $result = array("0","",$p[2]);
            }
            print_r(json_encode($result));
        }
        else {
            $result = array('0','NO PODEMOS PROCESAR SU SOLICITUD, PORFAVOR ACTUALIZAR LA PAGINA (F5) Y VOLVER A INTENTARLO','');
        }
    }
    public function frmRecepcion()
    {
        $obj = new envio();
        $view = new View();
        $data = array();
        //$data['rows'] = $obj->getInfoEnvio();
        //Obtener todos los detalles de envio del envio valga la redundancia
        //y mostrar en una tabla con un total abajo. y un boton para confirmar el apgo
        //una vez confirmado, imprimir si asi lo requiere.
        $view->setData($data);
        $view->setTemplate( '../view/envio/_frmRecepcionCE.php');
        $view->setlayout( '../template/layout.php' );
        $view->renderPartial();
    }
    public function confirmRecepcion()
    {
        $obj = new envio();
        $result = array();
        $id = (int)$_POST['id'];
        if ($id!='') 
        {
            $p = $obj->confirmRecepcion($id);
            if ($p[0]==1)
            {
                $result = array("1",$p[1],$p[2]);
            }
            else 
            {
                $result = array("0","HA OCURRIDO UN ERROR, FAVOR DE ACTUALIZAR LA PAGINA (F5) Y VOLVER A INTENTARLO");
            }
            print_r(json_encode($result));
        }
        else {
            $result = array('0','NO PODEMOS PROCESAR SU SOLICITUD, PORFAVOR ACTUALIZAR LA PAGINA (F5) Y VOLVER A INTENTARLO','');
        }
    }
    public function anular()
      {
        $obj = new envio();
        $p = $obj->anular($_GET['id']);
        if ($p[0])
        {
            header('Location: index.php?controller=envio');
        } 
        else 
        {
            $data = array();
            $view = new View();
            $data['msg'] = $p[1];
            $data['url'] =  'index.php?controller=envio';
            $view->setData($data);
            $view->setTemplate( '../view/_error_app.php' );
            $view->setlayout( '../template/layout.php' );
            $view->render();
        }
      }
    public function add()
    {
        $r = $_SESSION['envios']->add($_POST['descripcion'],$_POST['precio'],$_POST['cantidad'],$_POST['precioc']);
        if($r){print_r(json_encode(array("resp"=>"1","data"=>$this->viewDetalle())));}
            else{print_r(json_encode(array("resp"=>"0","data"=>"ESTA DESCRIPCION YA FUE AGREGADO AL DETALLE")));}
    }    
    public function quit()
    {
        $_SESSION['envios']->quit($_POST['i']);
        echo $this->viewDetalle();
    }    
    public function getDetalle()
    {
        echo $this->viewDetalle();
    }
    public function viewDetalle($type = null)
    {
        $view = new View();
        $data = array();        
        $view->setData($data);
        if($type!="readonly")
        {
            $view->setTemplate('../view/envio/_detalle.php');
        }
        else 
        {
            $view->setTemplate('../view/envio/_detalle_readonly.php');
        }
        
        $view->setlayout( '../template/layout.php' );
        return $view->renderPartial();        
    }
    public function printer()
    {
        $data = array();
        $view = new View();                
        $obj = new envio();
        $result = $obj->getdata((int)$_GET['iv']);
        if($result[0])
        {
            $data['head'] = $result[1]; 
            $data['detalle'] = $result[2];
            $view->setData($data);
            $view->setTemplate( '../view/envio/_print_envio.php');
            $view->setlayout( '../template/empty.php' );
            $view->render();
        }
        else 
        {
            $data = array();
            $view = new View();
            $data['msg'] = 'No se ha podido encontrar la encomienda solicitado a imprimir.';
            $data['url'] =  'index.php?controller=envio';
            $view->setData($data);
            $view->setTemplate( '../view/_error_app.php' );
            $view->setlayout( '../template/layout.php' );
            $view->render();
        }
        
    }
    public function loadVenta()
    {        
        $view = new View();
        $obj = new envio();
        $data = array();   
        $obj = $obj->edit($_GET['i'],1); 
        $data['obj'] = $obj;
        $data['tipo_documento'] = $this->Select(
                                            array(
                                                    'id'=>'idtipo_documento',
                                                    'name'=>'idtipo_documento',
                                                    'table'=>'tipodoc'
                                                    )
                                                 ); 
        $data['detalle'] = $this->viewDetalleventa();
        $view->setData($data);                
        $view->setTemplate('../view/envio/_frmventa.php');                
        $view->setlayout( '../template/layout.php' );
        echo $view->renderPartial();
    }
    public function viewDetalleventa()
    {
        $view = new View();
        $data = array();        
        $view->setData($data);        
        $view->setTemplate('../view/envio/_detalleventa.php');                
        $view->setlayout( '../template/layout.php' );
        return $view->renderPartial();        
    }
    /*
        Type: Function
        Name: frmcmpl
        Descripcion: Permite obtener el formulario para completar la informacion de 
                     referente a la salida que se encargará de llevar la encomienda.
    */
    public function frmcmpl()
    {
        $view = new View();   
        $objd = new destino();
        $obj = new envio();
        $obj = $obj->edit($_GET['id']);
        $destinos = $objd->getDDestinos();     
        $data = array();
        $id = (int)$_GET['id'];
        $data['idenvio'] = $id;
        $data['destino'] = $this->Select(
                                            array(
                                                    'id'=>'iddestino',
                                                    'name'=>'iddestino',
                                                    'table'=>$destinos,
                                                    'code'=>$obj->iddestino
                                                    )
                                                 );
        $view->setData($data);
        $view->setTemplate('../view/envio/_frmconfm.php');
        $view->setlayout('../template/layout.php');
        echo $view->renderPartial();
    }

    public function getlistsalidas()
    {
        $view = new View();           
        $obj = new envio();
        $obj2 = $obj->getlistsalidas($_GET['id']);  
        $Permisoadd = $obj->getPermisoAddNewDestino($_GET['id']);
        $data = array();        
        $data['idenvio'] = $_GET['id'];
        $data['rows'] = $obj2;
        $data['permiso'] = $Permisoadd;
        $view->setData($data);
        $view->setTemplate('../view/envio/_frmlistsalidas.php');
        $view->setlayout('../template/layout.php');
        echo $view->renderPartial();
    }

    public function getEstado($id)
    {
        $obj = new envio();
        $estado = $obj->getEstado($id);
        return $estado;
    }
}
?>