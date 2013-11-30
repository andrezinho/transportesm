<?php  include("../lib/helpers.php");  ?>
<script type="text/javascript">
$(document).ready(function(){
	
})
</script>
<h6 class="ui-widget-header">NOTICIAS Y ALERTAS</h6>
<div style="width:800px; margin: 0 auto;">
    <div style="padding: 10px 20px">
        <div style="width: 65%; float: left;">
            <div style="padding: 10px;">
                <div style="background: #fafafa; padding: 10px; box-shadow: 2px 2px 5px #dadada;">
                    <div>
                        <p class="noticias-sub-titles">VENCIMIENTO DE SOAT'S</p>
                    </div>
                    <div>
                        <div style="float: left; width: 130px; text-align: center;">
                            <div class="noticia-head-text" style="color:red">VENCIDAS</div>
                        </div>
                        <div style="float: left; width: 130px; text-align: center;">
                            <div class="noticia-head-text">ESTE MES</div>
                        </div>
                        <div style="float: left; width: 180px; text-align: center;">
                            <div class="noticia-head-text" style="border: 0; ">ESTA SEMANA</div>
                        </div>                        
                    </div>                    
                    <div>
                        <div style="float: left; width: 130px; text-align: center;">
                            <div class="noticia-head-value" style="color:red"><?php echo $rows['v1']; ?></div>
                        </div>
                        <div style="float: left; width: 130px; text-align: center;">
                            <div class="noticia-head-value"><?php echo $rows['v2']; ?></div>
                        </div>
                        <div style="float: left; width: 180px; text-align: center;">
                            <div class="noticia-head-value" style="border: 0; "><?php echo $rows['v3']; ?></div>
                        </div>                        
                    </div>
                    <div style="clear: both; text-align: right;">
                        <a href="#" class="link_notify">[ ir al reporte ]</a>
                    </div>
                    
                </div>                
            </div>            
        </div>
        <div style=" width: 35%; float: left;">
            <div style="padding: 10px;">
                <div style="background: #dadada; padding: 10px; box-shadow: 2px 2px 5px #999;">
                    <div>
                        <p class="noticias-sub-titles" style="border-color:#666;">REVISION TECNICA</p>
                    </div>
                    <div>                        
                        <div style="float: left; width: 90px; text-align: center; ">
                            <div class="noticia-head-text" style="border-color:#666; color:red;">VENCIDAS</div>
                        </div>
                        <div style="float: left; width: 120px; text-align: center;">
                            <div class="noticia-head-text" style="border: 0; border-color:#666;">ESTA SEMANA</div>
                        </div>                        
                    </div>  
                     <div>
                        <div style="float: left; width: 90px; text-align: center;">
                            <div class="noticia-head-value" style=" border-color:#666;color:red;"><?php echo $rows['t1']; ?></div>
                        </div>
                        <div style="float: left; width: 120px; text-align: center;">
                            <div class="noticia-head-value" style="border: 0; border-color:#666;"><?php echo $rows['t2']; ?></div>
                        </div>
                                           
                    </div>
                    <div style="clear: both; text-align: right;">
                        <a href="#" class="link_notify">[ ir al reporte ]</a>
                    </div>
                </div>
            </div>            
        </div>
    </div>    
    <div style="padding: 20px;">
        <div style="width: 100%; float: left;">
            <div style="padding: 10px;">
                <div style="background: #F3F3F3; padding: 10px; box-shadow: 2px 2px 5px #dadada;">
                    <div>
                        <p class="noticias-sub-titles" style="text-align:center">HB !  &nbsp;&nbsp;CUMPLEAÑOS</p>
                    </div>
                    <div>
                         <div style="float: left; width: 100%; text-align: left;">
                             <?php 
                             $n = count($rows['c1']);                             
                             ?>
                            <div class="noticia-head-text">HOY DÍA <?php echo date('d/m/Y'); ?></div>
                            <div class="list-cumplidos">
                                <ul style="color:#096DA1">
                                    <?php
                                        if($n==0)
                                        {
                                            echo '<li style="font-style:italic">Nadie cumple a&ntilde;os hoy dia.</li>';
                                        }
                                        foreach($rows['c1'] as $k => $v)
                                        {
                                            ?>
                                            <li>- <?php echo $v['nombre']." ".$v['apellidos'] ?>, <?php echo $v['edad'] ?> A&ntilde;os</li>
                                            <?php
                                        }
                                    ?> 
                                </ul>
                            </div>
                            
                        </div>
                    </div>
                    <div>
                         <div style="float: left; width: 100%; text-align: left;">
                              <?php 
                             $n = count($rows['c2']);
                             
                             ?>
                            <div class="noticia-head-text">ESTA SEMANA</div>
                            <div class="list-cumplidos">
                                <ul>
                                    <?php
                                        if($n==0)
                                        {
                                            echo '<li style="font-style:italic">- Nadie cumple a&ntilde;os esta semana</li>';
                                        }
                                        foreach($rows['c2'] as $k => $v)
                                        {
                                            ?>
                                            <li>- <?php echo $v['nombre']." ".$v['apellidos'] ?>, <?php echo fdate($v['fecha_nacimiento'],'ES') ?></li>
                                            <?php
                                        }
                                    ?>                                    
                                </ul>                                
                            </div>
                            
                        </div>
                    </div>
                    <div style="clear: both; text-align: right;">
                        <a href="#" class="link_notify">[ ir al reporte ]</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>