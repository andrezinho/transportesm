<?php
require_once '../lib/controller.php';
require_once '../lib/view.php';
require_once '../model/reportes.php';
class reportesController extends Controller
{
    
    public function rcumpleanos()
    {
        $data = array();
        $view = new View();        
        $data['more_options'] = $this->more_options('reportes');
        $view->setData($data);
        $view->setTemplate( '../view/reportes/_cumpleanos.php' );        
        $view->setlayout( '../template/layout.php' );
        $view->render();
    }    
    public function html_cumpleanos()
    {
		
        $obj = new reportes();
        $data = array();
        $result = $obj->data_cumpleanos($_GET['mes']);
        $data['rowsi'] = $result[0];
        $data['rows'] = $result[1];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/reportes/_html_cumpleanos.php');
        echo $view->renderPartial();
    }    
    public function pdf_cumpleanos()
    {
		//var_dump($g['fechai']);die;
        $obj = new reportes();
        $data = array();
        $result = $obj->data_cumpleanos($_GET['mes']);
        $mes = array("ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SETIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
        $data['mes'] = $mes[$_GET['mes']-1];
        $data['rowsi'] = $result[0];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/reportes/_pdf_cumpleanos.php');
        $view->setlayout('../template/empty.php');
        $view->render();
    }
    
    public function rfec_ven_rev()
    {
        $data = array();
        $view = new View();        
        $data['more_options'] = $this->more_options('reportes');
        $view->setData($data);
        $view->setTemplate( '../view/reportes/_fec_ven_rev.php' );        
        $view->setlayout( '../template/layout.php' );
        $view->render();
    }    
    public function html_fec_ven_rev()
    {
		
        $obj = new reportes();
        $data = array();
        $result = $obj->data_fec_ven_rev($_GET['mes']);
        $data['rowsi'] = $result[0];
        $data['rows'] = $result[1];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/reportes/_html_fec_ven_rev.php');
        echo $view->renderPartial();
    }    
    public function pdf_fec_ven_rev()
    {
		//var_dump($g['fechai']);die;
        $obj = new reportes();
        $data = array();
        $result = $obj->data_fec_ven_rev($_GET['mes']);
        $mes = array("ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SETIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
        $data['mes'] = $mes[$_GET['mes']-1];
        $data['rowsi'] = $result[0];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/reportes/_pdf_fec_ven_rev.php');
        $view->setlayout('../template/empty.php');
        $view->render();
    }
    
    public function rfec_ven_soat()
    {
        $data = array();
        $view = new View();        
        $data['more_options'] = $this->more_options('reportes');
        $view->setData($data);
        $view->setTemplate( '../view/reportes/_fec_ven_soat.php' );        
        $view->setlayout( '../template/layout.php' );
        $view->render();
    }    
    public function html_fec_ven_soat()
    {
		
        $obj = new reportes();
        $data = array();
        $result = $obj->data_fec_ven_soat($_GET['mes']);
        $data['rowsi'] = $result[0];
        $data['rows'] = $result[1];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/reportes/_html_fec_ven_soat.php');
        echo $view->renderPartial();
    }    
    public function pdf_fec_ven_soat()
    {
		//var_dump($g['fechai']);die;
        $obj = new reportes();
        $data = array();
        $result = $obj->data_fec_ven_soat($_GET['mes']);
        $mes = array("ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SETIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
        $data['mes'] = $mes[$_GET['mes']-1];
        $data['rowsi'] = $result[0];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/reportes/_pdf_fec_ven_soat.php');
        $view->setlayout('../template/empty.php');
        $view->render();
    }
    
    public function ringresos()
    {
        $data = array();
        $view = new View();        
        $data['more_options'] = $this->more_options('reportes');
        $view->setData($data);
        $view->setTemplate( '../view/reportes/_ingresos.php' );        
        $view->setlayout( '../template/layout.php' );
        $view->render();
    }    
    public function html_ingresos()
    {
		
        $obj = new reportes();
        $data = array();
        $result = $obj->data_ingresos($_GET);
        $data['rowsi'] = $result[0];
        $data['rows'] = $result[1];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/reportes/_html_ingresos.php');
        echo $view->renderPartial();
    }    
    public function pdf_ingresos()
    {
		//var_dump($g['fechai']);die;
        $obj = new reportes();
        $data = array();
        $result = $obj->data_ingresos($_GET);
        $data['rowsi'] = $result[0];
        $data['fechai'] = $_GET['fechai'];
        $data['fechaf'] = $_GET['fechaf'];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/reportes/_pdf_ingresos.php');
        $view->setlayout('../template/empty.php');
        $view->render();
    }
    
    public function regresos()
    {
        $data = array();
        $view = new View();        
        $data['more_options'] = $this->more_options('reportes');
        $view->setData($data);
        $view->setTemplate( '../view/reportes/_egresos.php' );        
        $view->setlayout( '../template/layout.php' );
        $view->render();
    }
    public function html_egresos()
    {
		
        $obj = new reportes();
        $data = array();
        $result = $obj->data_egresos($_GET);
        $data['rowsi'] = $result[0];
        $data['rows'] = $result[1];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/reportes/_html_egresos.php');
        echo $view->renderPartial();
    }
    public function pdf_egresos()
    {
		//var_dump($g['fechai']);die;
        $obj = new reportes();
        $data = array();
        $result = $obj->data_egresos($_GET);
        $data['rowsi'] = $result[0];
        $data['fechai'] = $_GET['fechai'];
        $data['fechaf'] = $_GET['fechaf'];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/reportes/_pdf_egresos.php');
        $view->setlayout('../template/empty.php');
        $view->render();
    }
    public function rventas()
    {
        $data = array();
        $view = new View();        
        $data['more_options'] = $this->more_options('reportes');
        $view->setData($data);
        $view->setTemplate( '../view/reportes/_ventas.php' );        
        $view->setlayout( '../template/layout.php' );
        $view->render();
    }    
    public function html_ventas()
    {
		
        $obj = new reportes();
        $data = array();
        $result = $obj->data_ventas($_GET);
        $data['rowsi'] = $result[0];
        $data['rows'] = $result[1];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/reportes/_html_ventas.php');
        echo $view->renderPartial();
    }    
    public function pdf_ventas()
    {
		//var_dump($g['fechai']);die;
        $obj = new reportes();
        $data = array();
        $result = $obj->data_ventas($_GET);
        $data['rowsi'] = $result[0];
        $data['rows'] = $result[1];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/reportes/_pdf_ventas.php');
        $view->setlayout('../template/empty.php');
        $view->render();
    }
   //other  
public function renvio()
    {
        $data = array();
        $view = new View();        
        $data['more_options'] = $this->more_options('reportes');
        $view->setData($data);
        $view->setTemplate( '../view/reportes/_envio.php' );        
        $view->setlayout( '../template/layout.php' );
        $view->render();
    }    
    public function html_envio()
    {
		//var_dump($_POST);die;
        $obj = new reportes();
        $data = array();
        $result = $obj->data_envio($_GET);
        $data['rowsi'] = $result[0];
        $data['rows'] = $result[1];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/reportes/_html_envio.php');
        echo $view->renderPartial();
    }    
    public function pdf_envio()
    {
		//var_dump($g['fechai']);die;
        $obj = new reportes();
        $data = array();
        $result = $obj->data_envio($_GET);
        $data['rowsi'] = $result[0];
        $data['rows'] = $result[1];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/reportes/_pdf_envio.php');
        $view->setlayout('../template/empty.php');
        $view->render();
    }
//salida
public function rsalida()
    {
        $data = array();
        $view = new View();        
        $data['more_options'] = $this->more_options('reportes');
        $view->setData($data);
        $view->setTemplate( '../view/reportes/_salida.php' );        
        $view->setlayout( '../template/layout.php' );
        $view->render();
    }    
    public function html_salida()
    {
		//var_dump($_POST);die;
        $obj = new reportes();
        $data = array();
        $result = $obj->data_salida($_GET);
        $data['rowsi'] = $result[0];
        $data['rows'] = $result[1];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/reportes/_html_salida.php');
        echo $view->renderPartial();
    }    
    public function pdf_salida()
    {
		//var_dump($g['fechai']);die;
        $obj = new reportes();
        $data = array();
        $result = $obj->data_salida($_GET);
        $data['rowsi'] = $result[0];
        $data['rows'] = $result[1];
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/reportes/_pdf_salida.php');
        $view->setlayout('../template/empty.php');
        $view->render();
    }

}

?>