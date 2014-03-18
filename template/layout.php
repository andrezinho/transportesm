<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
    <title>SISTEMA DE CONTROL DE TRANSPORTE</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="expires" content="0" />
    <link type="text/css" href="css/jquery-ui-1.8.21.custom.css" rel="stylesheet" />
    <link type="text/css" href="css/layout.css" rel="stylesheet" />
    <link href="css/cssmenu.css" rel="stylesheet" type="text/css" />
    <link href="css/style_forms.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
        <script type="text/javascript" src="js/jquery-ui-1.8.21.custom.min.js"></script>    
        <script type="text/javascript" src="js/menus.js"></script>
        <script type="text/javascript" src="js/session.js"></script>
        <script type="text/javascript" src="js/required.js"></script>
        <script type="text/javascript" src="js/validateradiobutton.js"></script>
        <script type="text/javascript" src="js/utiles.js"></script>
        <script type="text/javascript" src="js/js-layout.js"></script>
    <link href='http://fonts.googleapis.com/css?family=Poiret+One' rel='stylesheet' type='text/css'>    
    <link href='http://fonts.googleapis.com/css?family=Buda:300' rel='stylesheet' type='text/css'>
</head>
<body>
    <?php  ?>
    <header id="site_head">
        <div class="header_cont">
            <h1><a href="#">Empresa San Martin S.A.</a></h1>        
            <nav class="head_nav"></nav>
        </div>        
        <div id="barra-session">
            <ul class="item-top">   
                <li>
                    <?php echo $_SESSION['sucursal']; ?>
                </li>
                <li>
                    <b><?php echo strtoupper($_SESSION['oficina']) ?></b>
                </li>                               
                <li>
                    CAJA (<?php echo $_SESSION['name_turno'] ?>): <?php echo $_SESSION['fecha_caja'] ?> 
               </li>            
            </ul>
            <a id="notify-entrada" href="#" class="box-item-notification notification-entrada-empty" title="Llegada de Vehiculos"></a>            
            <a id="notify-encomienda" href="#" class="box-item-notification notification-encomienda-empty" title="Encomiendas en camino..."></a>
            <a id="notify-telegiro" href="#" class="box-item-notification notification-telegiro-empty" title="Telegiros Pendientes"></a>
            <div id="barra-user">                   
                <a href="#" class="login"><?php echo strtoupper($_SESSION['user']); ?></a>
                <a href="index.php?controller=user&action=logout" class="logout">SALIR</a>                
            </div>
        </div>
    </header>
    <div id="body">
         <div id="banner"></div>        
        <div class="spacer"></div>        
        <div id="content">
            <?php echo $content; ?>
        </div>
        <div  class="spacer"></div>
        <div id="foot" class="ui-corner-bottom ui-widget-header">
            CORETEC <br/>2013
        </div>
        <div  class="spacer"></div>        
    </div>
    <div id="dialog-session" title="Su sesión ha expirado." style="display:none">
        <div class="ui-state-error" style="padding: 0 .7em; border: 0">
            <p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
            <strong>Por favor vuelva a iniciar sesión.</strong></p>
        </div>
    </div>
    <div id="dialog"></div>
    <div id="box-alerts" class="ui-corner-all" style="display:none">
        <div class="ui-corner-all" style="">
            Vencimientos de SOAT: <b>2</b> Vehiculos los proximos 7 días
        </div>
    </div>
</body>
</html>