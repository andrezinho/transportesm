<?php
require_once '../lib/controller.php';
require_once '../lib/view.php';
require_once '../model/user.php';
require_once '../model/periodo.php';
require_once '../model/caja.php';

class UserController extends Controller {
    public static function  login() 
    {
        $obj = new User();        
        $_p = $obj->Start();
        $obj = $_p['obj'];           
        if ($obj->login != '') 
        {
            //Datos del usuario logueado
            $_SESSION['idempleado'] = $obj->idempleado;   
            $_SESSION['user'] = $obj->login;
            $_SESSION['name'] = $obj->nombres;            
            $_SESSION['id_perfil'] = $obj->idperfil;
            $_SESSION['perfil'] = $obj->perfil;
            $_SESSION['turno'] = $obj->turno;
            $turno = $obj->turno;
            if($turno==1)$_SESSION['name_turno']="NORMAL";
                elseif($turno==2)$_SESSION['name_turno']="GUARDIANIA";
            
            //Oficina
            $_SESSION['idoficina'] = $obj->idoficina;
            $_SESSION['oficina'] = $obj->oficina;
            
            //Sucursal
            $_SESSION['idsucursal'] = $obj->idsucursal;
            $_SESSION['sucursal'] = $obj->sucursal;
            
            //Parametros de Empresa
            $_SESSION['empresa'] = "EMPRESA SAN MARTIN S.A.";
            
            //Obtenemos el perido mensual
            $objp = new periodo();
            $r = $objp->getPeriodo();            
            $_SESSION['idperiodo'] = $r->idperiodo;
            $_SESSION['name_periodo'] = "General";//$r->anio."-".$r->mes;
            
            //Obtenemos el periodo diario
            $obj_caja = new caja();
            //Verificamos si existe caja aperturada o esta cerrada con los siguientes filtros
            // 1. Turno
            // 2. Fecha 
            // 3. Oficina
            // 4. Usuario
            $current_date = date('Y-m-d');
            $r = $obj_caja->verifApertura($turno,$current_date,$_SESSION['idoficina'],$_SESSION['idempleado']);            
            if($r[0])
            {
                if($r[1]==1)              
                {
                    //Seteamos los valores a las sessiones de caja
                    $_SESSION['fecha_caja'] = $current_date;
                    $_SESSION['turno'] = $turno;                
                    $_SESSION['id_caja'] = $r[2];
                    $_SESSION['caja'] = 1; // Caja aperturada y correcta
                }                
                else 
                {
                    //La caja para esta fecha, turno, empleado, oficina ya fue cerrada
                }
            }
            else 
            {                
                //Verificamos si este empleado, con el turno y la oficina tiene aperturada alguna caja
                $v = array();
                $v = $obj_caja->verifAperturaAll($turno,$_SESSION['idoficina'],$_SESSION['idempleado']);
                if($v[0])
                {
                    // Si existe una caja aperturada con fecha anterior
                    $_SESSION['fecha_caja'] = $v[1];
                    $_SESSION['turno'] = $turno;
                    $_SESSION['id_caja'] = $v[2];
                    $_SESSION['caja'] = 0; // Caja aperturada y con error (Fecha anterior)
                    
                }
                else 
                {
                    //No existe ninguna caja aperturada
                }
            }   
            header('location:index.php');            
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
        $obj = new User();
        $data = array();
        if(!isset($_GET['q'])){$_GET['q']="";}
        if(!isset($_GET['p'])){$_GET['p']="";}
        if(!isset($_GET['criterio'])){$_GET['criterio']="empleado.aleas";}
        $data['data'] = $obj->index($_GET['q'],$_GET['p'],$_GET['criterio']);
        $data['query'] = $_GET['q'];
        $data['pag'] = $this->Pagination(array('rows'=>$data['data']['rowspag'],'url'=>'index.php?controller=user&action=index','query'=>$_GET['q'],'trows'=>$data['data']['total']));
        
        //Definiendo los parametros para la generacion de la grilla
        $this->registros = $data['data']['rows'];        
        $this->columnas = array("DNI"=>array('titulo'=>'DNI','align'=>'center','ancho'=>'8'),
                                "NOMBRES Y APELLIDOS" => array(),
                                "APODO" => array(),
                                "OFICINA" =>array(),                                
                                "ESTADO"=>array('align'=>'center')
                              );                        
        $this->busqueda = array( "empleado.aleas"=>"Apodo",
                                 "empleado.idempleado"=>"dni",
                                 "empleado.nombre"=>"Nombre",
                                 "empleado.apellidos"=>"Apellidos",
                                 "tipo_empleado.descripcion"=>"Tipo de Empleado"
                                 );
        $this->asignarAccion("eliminar", false);
            //Creacion de la grilla
        $data['grilla'] = $this->grilla("user",$data['pag']);        
        //Fin grid        
        $view = new View();
        $view->setData($data);
        $view->setTemplate( '../view/user/_index.php' );
        $view->setlayout( '../template/layout.php' );
        $view->render();
    }
    public function buscar()
    {        
        $data = array();
        $listuser = $this->UserAjax(array('id'=>'idusuariod','name'=>'idusuariod','table'=>'view_usuarios','filtro'=>$_POST['idd']));
        echo $listuser;        
    }
    public function getUser()
    {        
        $obj = new User();
        $data = array();
        $data['obj'] = $obj->getUser($_SESSION['idusuario']);
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/user/_frmuser.php');
        echo $view->renderPartial();
    }
    public function VerifUser()
    {        
        $obj = new User();        
        $n = $obj->VeriUser($_POST['cpass'],$_POST['iduser']);
        $view = new View();        
        if($n>0)
        {
            $view->setTemplate('../view/user/_change_passw.php');
            $html = $view->renderPartial();
            print_r(json_encode(array('rep'=>1,'html'=>$html)));
        }
        else {
            $view->setTemplate('../view/user/_msg_error.php');
            $html = $view->renderPartial();
            print_r(json_encode(array('rep'=>2,'html'=>$html)));
        }
    }
    public function save_change_passw()
    {
        $obj = new User();
        $result = $obj->save_change_passw($_POST['npassw'],$_POST['iduser']);
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
        $data['perfil'] = $this->Select(array('id'=>'idperfil','name'=>'idperfil','table'=>'perfil','code'=>$obj->idperfil));
        $data['oficina'] = $this->Select(array('id'=>'idoficina','name'=>'idoficina','table'=>'voficina'));
        $data['tipo_empleado'] = $this->Select(array('id'=>'idtipo_empleado','name'=>'idtipo_empleado','table'=>'tipo_empleado'));
        $data['grupo'] = $this->Select(array('id'=>'idgrupo','name'=>'idgrupo','table'=>'grupo'));
        $data['more_options'] = $this->more_options('user');
        $view->setData($data);
        $view->setTemplate( '../view/user/_form.php' );
        $view->setlayout( '../template/layout.php' );
        $view->render();
    }
   public function edit() 
    {
        $obj = new User();
        $data = array();
        $view = new View();        
        $obj = $obj->edit($_GET['id']);
        $data['obj'] = $obj;
        $data['perfil'] = $this->Select(array('id'=>'idperfil','name'=>'idperfil','table'=>'perfil','code'=>$obj->idperfil));        
        $data['oficina'] = $this->Select(array('id'=>'idoficina','name'=>'idoficina','table'=>'voficina','code'=>$obj->idoficina));
        $data['tipo_empleado'] = $this->Select(array('id'=>'idtipo_empleado','name'=>'idtipo_empleado','table'=>'tipo_empleado','code'=>$obj->idtipo_empleado));
        $data['grupo'] = $this->Select(array('id'=>'idgrupo','name'=>'idgrupo','table'=>'grupo','code'=>$obj->idgrupo));        
        $data['more_options'] = $this->more_options('User');
        $view->setData($data);
        $view->setTemplate( '../view/user/_form.php' );
        $view->setlayout( '../template/layout.php' );
        $view->render();
    }
   
   public function save()
   {        
       //die($_POST['iddependencia']);
        $obj = new User();

        if ($_POST['oper']=='0') {

            $p = $obj->insert($_POST);
            if ($p[0]){
                header('Location: index.php?controller=user');
            } else {
            $data = array();
            $view = new View();
            $data['msg'] = $p[1];
            $data['url'] =  'index.php?controller=user';
            $view->setData($data);
            $view->setTemplate( '../view/_error_app.php' );
            $view->setlayout( '../template/layout.php' );
            $view->render();
            }
        } else {
            $p = $obj->update($_POST);
            if ($p[0]){
                header('Location: index.php?controller=user');
            } else {
            $data = array();
            $view = new View();
            $data['msg'] = $p[1];
            $data['url'] =  'index.php?controller=user';
            $view->setData($data);
            $view->setTemplate( '../view/_error_app.php' );
            $view->setlayout( '../template/layout.php' );
            $view->render();
            }
        }
    }
    public function delete()
      {
        $obj = new User();
        $p = $obj->delete($_POST);
        if ($p[0]){
            header('Location: index.php?controller=user');
        } 
        else {
            $data = array();
            $view = new View();
            $data['msg'] = $p[1];
            $data['url'] =  'index.php?controller=user';
            $view->setData($data);
            $view->setTemplate( '../view/_error_app.php' );
            $view->setlayout( '../template/layout.php' );
            $view->render();
        }
      }

  public function search()
    {
        if (!isset($_GET['p'])){$_GET['p']=1;}
        $obj = new User();
        $data = array();
        if(!isset($_GET['q'])){$_GET['q']="";}
        if(!isset($_GET['p'])){$_GET['p']="";}
        if(!isset($_GET['criterio'])){$_GET['criterio']="usuario.idusuario";}
        $data['data'] = $obj->index($_GET['q'],$_GET['p'],$_GET['criterio']);
        $data['query'] = $_GET['q'];
        $data['pag'] = $this->Pagination(array('rows'=>$data['data']['rowspag'],'url'=>'index.php?controller=user&action=search','query'=>$_GET['q']));
        
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
        $data['grilla'] = $this->grilla("user",$data['pag']);        
        //Fin grid
        
        $view = new View();
        $view->setData($data);
        
        $view->setTemplate( '../view/user/_lista.php' );
        $view->setlayout('../template/list.php');
        $view->render();
    }
    public function search_autocomplete()
        {
            $obj = new User();
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
            $view->setTemplate( '../view/user/_json.php' );
            echo $view->renderPartial();
        }
}
?>