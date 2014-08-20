<?php session_start(); ?>
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
                <li><a href="index.php" class="current">Inicio</a></li>
                <li><a href="empresa.php">Empresa</a></li>                                
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
            
            	<div class="section_w280 margin_r_30 w280_bg">
                
                	<h2 class="services">Nuestros Servicios</h2>
                    
                    <p>Empresa San Martin les ofrece los siguientes servicios con la total garantia de un exelente servicio.</p>
                    
                    <ul class="service_list" style="padding-bottom: 7px;">
                      <li><a href="#">Transporte de Encomiendas</a></li>
                      <li><a href="#">Telegiros</a></li>
                      <li><a href="#">Recojo de pasajeros a domicilio.</a></li>                      
                      <li><a href="#">Pasajes a diferentes Destinos</a></li>
                  </ul>
<!--                    <div class="button_01 float_r"><a href="#">Ver Todos</a></div>-->
                        <br/><br/><br/>
                </div>
                <div class="section_w280 margin_r_30 w280_bg">                
                  <h2 class="project">Servicios Turisticos</h2>                    
                  <a href="#"><img src="web/images/templatemo_image_08.png" alt="image" /></a>                    
                  <p>Realize sus viajes turisticos con toda la seguridad, comodidad y experiencia que nuestros Choferes cuentan. </p>
                  <br/><br/><br/>
                  <br/><br/>
              </div>                
                <div class="section_w280 w280_bg">                
                    <h2 class="project">Nuestras Rutas</h2>                    
                    <p>Empresa San Martin les ofrece las siguientes Rutas.</p>                    
                    <ul class="service_list" style="padding-bottom: 7px;">
                      <li><a href="#">Naranjos</a></li>
                      <li><a href="#">Nva. Cajamarca</a></li>
                      <li><a href="#">Rioja - Moyobamba</a></li>                      
                      <li><a href="#">Tarapoto - Picota</a></li>
                      <li><a href="#">Bellavista - Juanjui</a></li>
                      <li><a href="#">Yurimaguas</a></li>
                      <li><a href="#">Y viceversa</a></li>
                  </ul>                	
                </div>                
                <div class="cleaner"></div>            
            </div>
            
            <div class="full_width">
            	<div class="section_w590 margin_r_30" style="">                	
                    <h2 class="current_activities">Nuestras Oficinas</h2>
                    <div class="box-sucrusales ui-corner-all">
                        <span class="title-oficina">Tarapoto</span><br/>
                        Av. Alfonso Ugarte N&deg; 1456 <br/>
                        Telf: (042) 526327 <br/>
                        RPM: #916835  <br/> Cel: 942959656
                    </div>
                    <div class="box-sucrusales ui-corner-all" >
                        <span class="title-oficina">Moyobamba</span><br/>
                        Jr. Benavides N&deg; 276 <br/>
                        Telf: (042) 562716 <br/>
                        RPM: #916503  <br/> Cel: 942959655
                    </div>
                    <div class="box-sucrusales ui-corner-all">
                        <span class="title-oficina">Yurimaguas</span><br/>
                        Calle Victor Sifuentes S/N <br/>
                        Telf: (065) 351438 <br/>
                        RPM: #916485  <br/> Cel: 942959654
                    </div>
                    <div class="box-sucrusales ui-corner-all">
                        <span class="title-oficina">Juanjui</span><br/>
                        Jr. Huallaga N&deg; 1532 <br/>
                        Telf: (042) 546500 <br/>
                        RPM: #966548976  <br/> Cel: 966548976
                    </div>
                    <div class="box-sucrusales ui-corner-all">
                        <span class="title-oficina">Rioja</span><br/>
                        Jr. Santo Toribio N&deg; 772 <br/>
                        Telf: (042) 559294 <br/>
                        RPM: #190551  <br/> Cel: 942048979
                    </div>
                    <div class="box-sucrusales ui-corner-all">
                        <span class="title-oficina">Tocache</span><br/>
                        Jr. Jorge Chavez N&deg; 386 <br/>
                        Telf: (042) 552022 <br/>
                        RPM: #788177  <br/> Cel: 942626686
                    </div>
                    <div class="box-sucrusales ui-corner-all">
                        <span class="title-oficina">Nueva Cajamarca</span><br/>
                        Av. Cajamarca Sur N&deg; 654 <br/>
                        Telf: (042) 500436 <br/>
                        RPM: #949689698  <br/> Cel: 949689698
                    </div>
                    <div class="cleaner"></div>
           	</div>
                
                <?php if(!isset($_SESSION['user'])) { ?>
                <div class="section_w280 w280_bg" style="margin-bottom: 10px">                
                   <h2 class="portfolio" >Intranet</h2>                    
                   <a target="_blank" href="web/">Acceda a la Intranet</a>
                   <br/>
                   Solo personal autorizado
                   <br/><br/>
                </div>
                <?php } ?>
                <div class="section_w280 w280_bg">                
                    <h2 class="newsletter2"><a href="reclamos.php">Libro de Reclamaciones</a></h2>
                    <p style="text-align:center">Conforme a lo establecido en el Código de 
                    Protección y Defensa del Consumidor este 
                    establecimiento cuenta con un Libro de 
                    Reclamaciones a tu disposición. Solicítalo para 
                    registrar la queja o reclamo que tengas.
                    </p>
                    <br/>
                  
                </div>
                <div class="section_w280">                
                    <h2 class="newsletter">Boletines</h2>                    
                    <form action="#" method="get" class="search_box">
                        <input type="text" value="Enter your email" name="q" size="10" id="searchfield" title="searchfield" onfocus="clearText(this)" onblur="clearText(this)" />
                        <input type="submit" name="Search" value="Subscribe" alt="Search" id="searchbutton" title="Search" />
                    </form>                    
		          <strong>Email:</strong> <a href="#">em.sanmartinsa@hotmail.com</a>    
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