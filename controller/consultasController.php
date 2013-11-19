<?php
require_once '../lib/controller.php';
require_once '../lib/view.php';
require_once '../model/consultas.php';
class consultasController extends Controller
{
    //--------------------
    //Consultas de Grupos
    //--------------------
    public function cgrupos()
    {
        $data = array();
        $view = new View();        
        $data['more_options'] = $this->more_options('consultas');
        $data['destino'] = $this->Select(array('name'=>'iddestino','id'=>'iddestino','table'=>'vdestino'));
        $view->setData($data);
        $view->setTemplate( '../view/consultas/grupos/_index.php' );        
        $view->setlayout( '../template/layout.php' );
        $view->render();
    }    
    public function html_grupos()
    {
		
        $obj = new consultas();
        $data = array();
        $result = $obj->data_grupos($_GET);
        $data['rowsi'] = $result[0];
        $data['rows'] = $result[1];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/consultas/grupos/_html.php');
        echo $view->renderPartial();
    }    
    public function pdf_grupos()
    {	
        
    }       
    //Fin de consultas de grupos
    //--------------------------
    
    
    //----------------------
    //Consultas de Choferes
    //----------------------
    public function cchoferes()
    {
        $data = array();
        $view = new View();        
        $data['more_options'] = $this->more_options('consultas');        
        $view->setData($data);
        $view->setTemplate( '../view/consultas/choferes/_index.php' );        
        $view->setlayout( '../template/layout.php' );
        $view->render();
    }    
    public function html_choferes()
    {
		
        $obj = new consultas();
        $data = array();
        $result = $obj->data_choferes($_GET);
        $stado = "ACTIVOS";
        if($_GET['estado']==0)
        {
            $stado = "INACTIVOS";
        }
        $data['title'] = "CONSULTA DE CHOFERES ".$stado;
        $data['rowsi'] = $result[0];
        $data['rows'] = $result[1];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/consultas/choferes/_html.php');
        echo $view->renderPartial();
    }    
    public function pdf_choferes()
    {
	
    } 
    //Fin de Consultas de Choferes
    //-----------------------------
    
    
    //-----------------------
    //Consultas de empleados
    //-----------------------
    public function cempleados()
    {
        $data = array();
        $view = new View();        
        $data['more_options'] = $this->more_options('consultas');        
        $data['oficinas'] = $this->Select(array('id'=>'idoficina','name'=>'idoficina','table'=>'voficina'));
        $view->setData($data);
        $view->setTemplate( '../view/consultas/empleados/_index.php' );        
        $view->setlayout( '../template/layout.php' );
        $view->render();
    }    
    public function html_empleados()
    {		
        $obj = new consultas();
        $data = array();
        $result = $obj->data_empleados($_GET);                
        $data['title'] = "CONSULTA DE EMPLEADOS ";
        $data['rowsi'] = $result[0];
        $data['rows'] = $result[1];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/consultas/empleados/_html.php');
        echo $view->renderPartial();
    }    
    public function pdf_empleados()
    {
	
    }
    //Fin de consultas de Empleados
    //-----------------------------
  }
?>