<?php
require_once '../lib/controller.php';
require_once '../lib/view.php';
require_once '../model/chofer.php';
require_once '../model/periodo.php';

class choferController extends Controller {
    function login() 
    {
        $obj = new chofer();        
        $_p = $obj->Start();
        $obj = $_p['obj'];   
        
        if ($obj->login != '') 
        {
            $_SESSION['chofer'] = $obj->login;
            $_SESSION['name'] = $obj->nombres;
            
            $_SESSION['id_perfil'] = $obj->idperfil;
            $_SESSION['perfil'] = $obj->perfil;
            
            $_SESSION['idempleado'] = $obj->idempleado;   
            $_SESSION['idoficina'] = $obj->idoficina;
            $_SESSION['oficina'] = $obj->oficina;
            $_SESSION['idsucursal'] = $obj->idsucursal;
            $_SESSION['sucursal'] = $obj->sucursal;
            //Parametros de Empresa
            $_SESSION['empresa'] = "HUALLAGA EXPRESS";            
            $objp = new periodo();
            $r = $objp->getPeriodo();
            
            $_SESSION['idperiodo'] = $r->idperiodo;
            $_SESSION['name_periodo'] = $r->anio."-".$r->mes;
            
            header('location:index.php');
            //print_r(json_encode(array("resp"=>"1","msg"=>"Correcto")));
        }
        else 
        {
            header('location:login.php');
            print_r(json_encode(array("resp"=>"0","msg"=>"Sus datos son incorrectos")));
        }
    }

    function logout()
    {
        session_destroy();
        header('Location: ../web/login.php');
    }
    
    public function index() 
    {
        if (!isset($_GET['p'])){$_GET['p']=1;}
        $obj = new chofer();
        $data = array();
        if(!isset($_GET['q'])){$_GET['q']="";}
        if(!isset($_GET['p'])){$_GET['p']="";}
        if(!isset($_GET['criterio'])){$_GET['criterio']="empleado.nombre";}
        $data['data'] = $obj->index($_GET['q'],$_GET['p'],$_GET['criterio']);
        $data['query'] = $_GET['q'];
        $data['pag'] = $this->Pagination(array('rows'=>$data['data']['rowspag'],'url'=>'index.php?controller=chofer&action=index','query'=>$_GET['q'],'trows'=>$data['data']['total']));
        
        //Definiendo los parametros para la generacion de la grilla
        $this->registros = $data['data']['rows'];        
        $this->columnas = array("DNI"=>array('titulo'=>'DNI','align'=>'center','ancho'=>'8'),
                                "NOMBRES Y APELLIDOS" => array(),
                                "ALIAS" =>array(),
                                "OFICINA"=>array(),
                                "ESTADO"=>array('align'=>'center')
                              );                        
        $this->busqueda = array( "empleado.idempleado"=>"dni",
                                 "empleado.nombre"=>"Nombre",
                                 "empleado.apellidos"=>"Apellidos",
                                 "empleado.aleas"=>"Alias"
                                 );
        $this->asignarAccion("eliminar", false);
            //Creacion de la grilla
        $data['grilla'] = $this->grilla("chofer",$data['pag']);        
        //Fin grid        
        $view = new View();
        $view->setData($data);
        $view->setTemplate( '../view/chofer/_index.php' );
        $view->setlayout( '../template/layout.php' );
        $view->render();
    }
    public function buscar()
    {        
        $data = array();
        $listchofer = $this->choferAjax(array('id'=>'idusuariod','name'=>'idusuariod','table'=>'view_usuarios','filtro'=>$_POST['idd']));
        echo $listchofer;        
    }
    public function getchofer()
    {        
        $obj = new chofer();
        $data = array();
        $data['obj'] = $obj->getchofer($_SESSION['idusuario']);
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/chofer/_frmchofer.php');
        echo $view->renderPartial();
    }
    public function Verifchofer()
    {        
        $obj = new chofer();        
        $n = $obj->Verichofer($_POST['cpass'],$_POST['idchofer']);
        $view = new View();        
        if($n>0)
        {
            $view->setTemplate('../view/chofer/_change_passw.php');
            $html = $view->renderPartial();
            print_r(json_encode(array('rep'=>1,'html'=>$html)));
        }
        else {
            $view->setTemplate('../view/chofer/_msg_error.php');
            $html = $view->renderPartial();
            print_r(json_encode(array('rep'=>2,'html'=>$html)));
        }
    }
    public function save_change_passw()
    {
        $obj = new chofer();
        $result = $obj->save_change_passw($_POST['npassw'],$_POST['idchofer']);
        if($result)
        {
            echo 'Su password a sido modificado correctamente';
        }
        else 
        {
            echo 'A ocurrido un error al tratar de modificar su password';
        }        
    }
   public function create()
    {
        $data = array();
        $view = new View();   
        //$data['perfil'] = $this->Select(array('id'=>'idperfil','name'=>'idperfil','table'=>'perfil','code'=>$obj->idperfil));
        $data['oficina'] = $this->Select(array('id'=>'idoficina','name'=>'idoficina','table'=>'voficina'));
        //$data['tipo_empleado'] = $this->Select(array('id'=>'idtipo_empleado','name'=>'idtipo_empleado','table'=>'tipo_empleado'));
        //$data['grupo'] = $this->Select(array('id'=>'idgrupo','name'=>'idgrupo','table'=>'vgrupo'));
        $data['more_options'] = $this->more_options('chofer');
        $view->setData($data);
        $view->setTemplate( '../view/chofer/_form.php' );
        $view->setlayout( '../template/layout.php' );
        $view->render();
    }
   public function edit() 
    {
        $obj = new chofer();
        $data = array();
        $view = new View();        
        $obj = $obj->edit($_GET['id']);
        $data['obj'] = $obj;
        //$data['perfil'] = $this->Select(array('id'=>'idperfil','name'=>'idperfil','table'=>'perfil','code'=>$obj->idperfil));        
        $data['oficina'] = $this->Select(array('id'=>'idoficina','name'=>'idoficina','table'=>'voficina','code'=>$obj->idoficina));
        //$data['tipo_empleado'] = $this->Select(array('id'=>'idtipo_empleado','name'=>'idtipo_empleado','table'=>'tipo_empleado','code'=>$obj->idtipo_empleado));
        //$data['grupo'] = $this->Select(array('id'=>'idgrupo','name'=>'idgrupo','table'=>'vgrupo','code'=>$obj->idgrupo));        
        $data['more_options'] = $this->more_options('chofer');
        $view->setData($data);
        $view->setTemplate( '../view/chofer/_form.php' );
        $view->setlayout( '../template/layout.php' );
        $view->render();
    }
   
   public function save()
   {        
       //die($_POST['iddependencia']);
        $obj = new chofer();

        if ($_POST['oper']=='0') {

            $p = $obj->insert($_POST);
            if ($p[0]){
                header('Location: index.php?controller=chofer');
            } else {
            $data = array();
            $view = new View();
            $data['msg'] = $p[1];
            $data['url'] =  'index.php?controller=chofer';
            $view->setData($data);
            $view->setTemplate( '../view/_error_app.php' );
            $view->setlayout( '../template/layout.php' );
            $view->render();
            }
        } else {
            $p = $obj->update($_POST);
            if ($p[0]){
                header('Location: index.php?controller=chofer');
            } else {
            $data = array();
            $view = new View();
            $data['msg'] = $p[1];
            $data['url'] =  'index.php?controller=chofer';
            $view->setData($data);
            $view->setTemplate( '../view/_error_app.php' );
            $view->setlayout( '../template/layout.php' );
            $view->render();
            }
        }
    }
        
    public function delete()
      {
        $obj = new chofer();
        $p = $obj->delete($_POST);
        if ($p[0]){
            header('Location: index.php?controller=chofer');
        } 
        else {
            $data = array();
            $view = new View();
            $data['msg'] = $p[1];
            $data['url'] =  'index.php?controller=chofer';
            $view->setData($data);
            $view->setTemplate( '../view/_error_app.php' );
            $view->setlayout( '../template/layout.php' );
            $view->render();
        }
      }

  public function search()
    {
        if (!isset($_GET['p'])){$_GET['p']=1;}
        $obj = new chofer();
        $data = array();
        if(!isset($_GET['q'])){$_GET['q']="";}
        if(!isset($_GET['p'])){$_GET['p']="";}
        if(!isset($_GET['criterio'])){$_GET['criterio']="usuario.idusuario";}
        $data['data'] = $obj->index($_GET['q'],$_GET['p'],$_GET['criterio']);
        $data['query'] = $_GET['q'];
        $data['pag'] = $this->Pagination(array('rows'=>$data['data']['rowspag'],'url'=>'index.php?controller=chofer&action=search','query'=>$_GET['q']));
        
        //Definiendo los parametros para la generacion de la grilla
        $this->registros = $data['data']['rows'];        
        $this->columnas = array("DNI"=>array('titulo'=>'DNI','align'=>'center','ancho'=>'5'),
                              "NOMBRES Y APELLIDOS" => array(),
                              "PERFIL" => array('ancho'=>'15'),
                              "CELULAR" => array('align'=>'center','ancho'=>'15'),
                              "DEPENDENCIA"=>array(),
                              "ESTADO"=>array('align'=>'center')
                              );                        
        $this->busqueda = array("usuario.idusuario"=>"dni",
                                 "nombres"=>"nombres y apellidos",
                                 "descripcion"=>"perfil");
        $this->asignarAccion("eliminar", false);
        $this->asignarAccion("nuevo", false);
        $this->asignarAccion("editar", false);
        $this->asignarAccion("seleccionar", true);
            //Creacion de la grilla
        $data['grilla'] = $this->grilla("chofer",$data['pag']);        
        //Fin grid
        
        $view = new View();
        $view->setData($data);
        
        $view->setTemplate( '../view/chofer/_lista.php' );
        $view->setlayout('../template/list.php');
        $view->render();
    }
    public function search_autocomplete()
        {
            $obj = new chofer();
            $data = array();
            $view = new View();
            if($_GET['tipo']==1)
            {
                $field = "idempleado";
            }
            elseif ($_GET['tipo']==2) {
                $field = "nombre";
            }
            
            $data['value'] = $obj->getchofer($_GET["term"],$field);
            $view->setData( $data );
            $view->setTemplate( '../view/chofer/_json.php' );
            echo $view->renderPartial();
        }
}
?>