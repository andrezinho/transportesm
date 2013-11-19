<?php
require_once '../lib/controller.php';
require_once '../lib/view.php';
require_once '../model/entrada.php';
require_once '../model/tipo_pasajero.php';
require_once '../model/destino.php';
class entradaController extends Controller
{
   public function index() 
   {
        if (!isset($_GET['p'])){$_GET['p']=1;}
        if(!isset($_GET['q'])){$_GET['q']="";} 
        if(!isset($_GET['criterio'])){$_GET['criterio']="chofer.nombre";} 
        $obj = new entrada();
        $data = array();
        $data['data'] = $obj->index($_GET['q'],$_GET['p'],$_GET['criterio']);
        $data['query'] = $_GET['q'];
        $data['pag'] = $this->Pagination(array('rows'=>$data['data']['rowspag'],'url'=>'index.php?controller=salida&action=index','query'=>$_GET['q'],'trows'=>$data['data']['total']));
        $this->registros = $data['data']['rows'];
        $this->columnas = array("ID"=>array('ancho'=>'5','align'=>'center','titulo'=>'Codigo de salida'),
                                "<p style='font-size:9px'>FECHA SALIDA</p>"=>array('ancho'=>'8','align'=>'center'),
                                "<p style='font-size:9px'>HORA SALIDA</p>"=>array('ancho'=>'4','align'=>'center'),
                                "CHOFER"=>array(),
                                "VEHICULO"=>array('ancho'=>9,'align'=>'center'),
                                "PROCEDENCIA"=>array('ancho'=>13,'align'=>'center'),
                                "TICKET"=>array('ancho'=>6,'align'=>'center','colspan'=>1),
                                "TIPO"=>array('ancho'=>4,'align'=>'center'),
                                "ESTADO"=>array('ancho'=>'10','align'=>'center'),
                                "USER"=>array('ancho'=>7,'align'=>'center'),
                                "<p style='font-size:9px;'>Llegada</p>"=>array('ancho'=>4,'align'=>'center')
                                );         
        $this->busqueda = array("chofer.nombre"=>"Chofer",
                                "vehiculo.placa"=>"Placa de Vehiculo");
        $this->asignarAccion('eliminar',false);
        $this->asignarAccion('editar',false);
        $this->asignarAccion('nuevo',false);
        $this->asignarAccion('ver',false);
        $data['grilla'] = $this->grilla("salida",$data['pag']);
        $view = new View();
        $view->setData($data);
        $view->setTemplate( '../view/entrada/_index.php' );
        $view->setlayout( '../template/layout.php' );
        $view->render();
    }
    public function llegada()
    {
        $obj = new entrada();
        $id = (int)$_POST['i'];
        $r = $obj->llegada($id);
        if($r['res']=="1")
        {
            print_r(json_encode(array('1',substr($r['msg'],0,5))));
        }
        else 
        {
            print_r(json_encode(array('0',$r['msg'])));
        }
    }
}
?>