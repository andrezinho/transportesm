<?php
require_once '../lib/controller.php';
require_once '../lib/view.php';
require_once '../model/agrupaciones.php';
class agrupacionesController extends Controller
{
   public function index() 
   {
        $data = array();
        $view = new View();        
        $data['chofer'] = $this->Select(
                                            array(
                                                    'id'=>'idchofer',
                                                    'name'=>'idchofer',
                                                    'table'=>'vchofer'
                                                    )
                                                 );
        $data['propietario'] = $this->Select(
                                            array(
                                                    'id'=>'idpropietario',
                                                    'name'=>'idpropietario',
                                                    'table'=>'vpropietarios'
                                                    )
                                                 );
        $data['more_options'] = $this->more_options('agrupaciones');
        $data['grupo'] = $this->Select(array('name'=>'idgrupo','id'=>'idgrupo','table'=>'vgrupo'));
        $data['detalle'] = $this->viewDetalle();
        $view->setData($data);
        $view->setTemplate( '../view/agrupaciones/_index.php' );        
        $view->setlayout( '../template/layout.php' );
        $view->render();
    }   
    function getDetail()
    {
        echo $this->viewDetalle($_GET['g']);
    }
    public function edit() 
    {
        $obj = new agrupaciones();
        $data = array();
        $data['more_options'] = $this->more_options('agrupaciones');
        $view = new View();
        $obj = $obj->edit($_GET['id']);
        $data['obj'] = $obj;      
        $view->setData($data);
        $view->setTemplate( '../view/agrupaciones/_form.php' );
        $view->setlayout( '../template/layout.php' );        
        $view->render();
    }
    public function save()
    {
        $obj = new agrupaciones();
        $r = $obj->insert($_POST);
        if($r[0]==1)
        {
            $html = $this->viewDetalle($_POST['idgrupo']);
            print_r(json_encode(array(1,$html)));
        }
        else {
            print_r(json_encode(array(2,$r[1])));
        }
        
    }
    public function quit()
    {
        $obj = new agrupaciones();
        $p = $obj->quit($_POST['i']);
        if ($p[0])
        {
            $html = $this->viewDetalle($_POST['ig']);
            print_r(json_encode(array(1,$html)));
        } 
        else {
            print_r(json_encode(array(2,'NO SE HA PODIDO REALIZAR SU PETICION, PORFAVOR INTENTELO DE NUEVO')));
        }
    }
    public function viewDetalle($g=null)
    {
        $view = new View();
        $obj = new agrupaciones();
        if(isset($g)&&$g!="")
        {
            $rows = $obj->getDetalle($g);
        }
        $data = array();        
        $data['rows'] = $rows;
        $view->setData($data);        
        $view->setTemplate('../view/agrupaciones/_detalle.php');        
        $view->setlayout( '../template/layout.php' );
        return $view->renderPartial();        
    }
}
?>