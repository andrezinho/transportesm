<?php 
    session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="expires" content="0" />
<title>Empresa San Martin</title>
<link href="web/css/templatemo_style.css" rel="stylesheet" type="text/css" />
<link href="web/css/jquery-ui-1.8.21.custom.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="web/css/featuredcontentglider.css" />
<script type="text/javascript" src="web/js/jquery3.js"></script>
<script type="text/javascript" src="web/js/jquery-ui-1.8.21.custom.min.js"></script>
<script type="text/javascript" src="web/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="web/css/featuredcontentglider.js"></script>
<script language="javascript" type="text/javascript">
    function clearText(field)
    {
        if (field.defaultValue == field.value) field.value = '';
        else if (field.value == '') field.value = field.defaultValue;
    }
</script>
</head>
<body>
<div id="templatemo_wrapper_outer">
<div id="templatemo_wrapper">

	<div id="temmplatmeo_header">  
            <?php 
                    $margin_top = "90px";
                    $padding_top = "35px";
                    if(isset($_SESSION['user'])&&$_SESSION['user']!="") 
                    {
                        $margin_top = "70px";
                        $padding_top = "15px";
                 ?>
            <span style="float: right; display: block; clear: both; color: #fff; font-weight: bold;">BIENVENIDO: <?php echo $_SESSION['name']; ?> - <a href="web/logout.php">Cerrar Sesión</a></span>
                 <?php
                    }
            ?>
                        <div style="clear: both"></div>
   	<div id="site_title" style="padding-top: <?php echo $padding_top; ?>" >                
           	<a href="#">
            	<img src="web/images/LOGO.png" alt="free css template" />
            	
                <span>PUNTUALIDAD&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SEGURIDAD&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;RESPONSABILIDAD</span>
                </a>
        </div>                         
    	<div id="templatemo_menu" style="margin-top: <?php echo $margin_top; ?>">        
            <ul>
                <li><a href="index.php" >Inicio</a></li>
                <li><a href="#" class="current">Empresa</a></li>                                
		<li><a href="contactenos.php">Contactenos</a></li>
                <?php if(isset($_SESSION['user'])&&$_SESSION['user']!="") { ?>
                <li><a href="web/index.php">Sistema</a></li>
                <?php } ?>
            </ul>    	        
        </div> <!-- end of _menu -->
    
    </div> <!-- end of _header -->    
    <div id="templatemo_content_wrapper_top"></div>
    <div id="templatemo_content_wrapper">
        <div id="templatemo_banner"><span class="frame"></span>        
        <script type="text/javascript">    
            featuredcontentglider.init({
                gliderid: "canadaprovinces", //ID of main glider container
                contentclass: "glidecontent", //Shared CSS class name of each glider content
                togglerid: "p-select", //ID of toggler container
                remotecontent: "", //Get gliding contents from external file on server? "filename" or "" to disable
                selected: 0, //Default selected content index (0=1st)
                persiststate: false, //Remember last content shown within browser session (true/false)?
                speed: 500, //Glide animation duration (in milliseconds)
                direction: "rightleft", //set direction of glide: "updown", "downup", "leftright", or "rightleft"
                autorotate: true, //Auto rotate contents (true/false)?
                autorotateconfig: [3000, 2] //if auto rotate enabled, set [milliseconds_btw_rotations, cycles_before_stopping]
            });            
         </script>            
            <div id="canadaprovinces" class="glidecontentwrapper">            
            <div class="glidecontent">
                <img src="web/images/banner.jpg" alt="bird" />
            </div>            
            <div class="glidecontent">
            <img src="web/images/templatemo_image_02.jpg" alt="image" />
            </div>            
            <div class="glidecontent">
            <img src="web/images/templatemo_image_03.jpg" alt="image" />
            </div>            
            </div>            
            <div id="p-select" class="cssbuttonstoggler">
            <a href="#" class="toc"><span>1</span></a> <a href="#" class="toc"><span>2</span></a> <a href="#" class="toc"><span>3</span></a>            
            </div>
        </div> 
    	<div id="content">
       <div class="full_width">
            
            	<div >
                    
                    <h2>MISION</h2>
Somos una empresa de servicios de transporte terrestre de pasajeros y correspondencia comprometida en brindar a nuestros clientes y usuarios en general un servicio con un nivel de alta calidad, puntualidad, seguridad, y comodidad; satisfaciendo totalmente sus expectativas.
<br/><br/>
<h2>VISION</h2>
Convertirnos en una de las empresas líderes de transporte terrestre de pasajeros interprovincial del Perú, logrando expandir nuestras rutas y que nuestros estándares sean lo más altos posibles, de manera que sus usuarios se sientan totalmente a gusto con nuestros servicios y seamos reconocidos por nuestros valores empresariales.
<br/><br/>
<h2>OBJETIVOS</h2>
<ul>
    <li>Liderar en competitividad.</li>
    <li>Crecer empresarialmente.</li>
    <li>Innovar de la mano con la tecnología que día a día lo requiere.</li>
</ul>
                </div>
                
                <div class="cleaner"></div>
            
            </div>
            
           
            

        
		</div> <!-- end of content -->
        
</div><div id="templatemo_content_wrapper_bottom"></div> <!-- end of templatemo_wrapper -->

        <div id="templatemo_footer">
   	    Copyright © <?php echo date('Y');?> <a href="#">Empresa San Martin</a></div>
</div>
</div>
</body>
</html>