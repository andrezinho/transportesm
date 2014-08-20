<?php
require_once '../lib/controller.php';
require_once '../lib/view.php';
require_once '../model/reclamos.php';
class reclamosController extends Controller
{
   public function index() 
   {
        if (!isset($_GET['p'])){$_GET['p']=1;}
        if(!isset($_GET['q'])){$_GET['q']="";}        
        $obj = new reclamos();
        $data = array();
        $data['data'] = $obj->index($_GET['q'],$_GET['p']);
        $data['query'] = $_GET['q'];
        $data['pag'] = $this->Pagination(array('rows'=>$data['data']['rowspag'],'url'=>'public.php?controller=reclamos&action=index','query'=>$_GET['q'],'trows'=>$data['data']['total']));
        $this->registros = $data['data']['rows'];
        $this->columnas = array("CODIGO"=>array('ancho'=>'5','align'=>'center','title'=>'Codigo'),
                      "DESCRIPCION"=>array(),
                      "ESTADO"=>array('ancho'=>'10','align'=>'center')
                    );         
        $this->busqueda = array("descripcion"=>"DESCRIPCION");                
        $data['grilla'] = $this->grilla("reclamos",$data['pag']);        
        $view = new View();
        $view->setData($data);
        $view->setTemplate( '../view/reclamos/_index.php' );
        $view->setlayout( '../template/layout.php' );
        $view->render();
    }
     
    public function create()
    {
        $data = array();
        $view = new View();
        $data['tipo_servicio'] = $this->Select(array('id'=>'idtipo_servicio','name'=>'idtipo_servicio','table'=>'tipo_servicio'));
        $view->setData($data);
        $view->setTemplate( '../view/reclamos/_form.php' );
        $view->setlayout( '../template/empty.php' );
        $view->render();
    }

    public function show()
    {

        $obj = new reclamos();        
        $obj = $obj->edit($_GET['nro']);
        $data = array();        
        $data['tipo_servicio'] = $this->Select(array('id'=>'idtipo_servicio','name'=>'idtipo_servicio','table'=>'tipo_servicio','code'=>$obj->idtipo_servicio));
        
        $view = new View();        
        $data['obj'] = $obj;

        $view->setData($data);
        $view->setTemplate( '../view/reclamos/_form_show.php' );
        $view->setlayout( '../template/empty.php' );
        $view->render();
    }

   public function save()
   {
        $obj = new reclamos();
        if ($_POST['idreclamo']=='') 
        {
            $p = $obj->insert($_POST);
            if ($p['res']=='1')
            {
                $html = "<div style='width:340px; margin:0 auto; height:300px; '>
                            <div><a href='reclamos.php'>Registrar Nuevo</a></div>
                            <div class='ui-corner-all' style='text-align:center;  color:#FFFFFF; padding:20px;background:url(web/images/header.jpg) repeat;'>
                                Su reclamo fue registrado correctamente.
                                <br/>
                                <h2>Nro:".$p['idr']."</h2>
                            </div>
                            <div style='clear:both'></div>
                            </div>";
                $result = array(1,$html);
            } 
            else 
            {
                $result = array(2,'HA OCURRIDO UN ERROR, FAVOR DE ACTUALIZAR LA PAGINA (F5) Y VOLVER A INTENTARLO. '.$p['msg'],'');
            }
            print_r(json_encode($result));
        }
    }

    public function resultado($numero)
    {
        $data = array();
        $view = new View();
        $data['numero'] = $numero;
        $view->setData($data);
        $view->setTemplate( '../view/reclamos/_form.php' );        
        return $view->renderPartial();
    }
}
?>