<script type="text/javascript">
    $(document).ready(function(){
       

        $("#gen").click(function(){      
            if(valid())
                {
                    var str = $("#frm").serialize();                    
                    $.get('index.php','controller=consultas&action=html_reclamos&'+str,function(data){
                        $("#wcont").empty().append(data);
                    });
                }
        });
        $("#pdf").click(function(){
            if(valid())
                {
                    var str = $("#frm").serialize();
                    window.open('index.php?controller=consultas&action=pdf_reclamos&'+str,"Reporte");
                }
        });
    });
    function valid()
    {
        var bval = true;                        
        return bval;
    }
</script>
<div class="div_container">
<h6 class="ui-widget-header">Consulta de Choferes</h6>
<div style="padding: 20px; background: #EBECEC">
    <form name="frm" id="frm" action="" method="get">  
        <label for="estado" class="lables">Estado: </label>
         <select name="estado" id="estado">
            <option value="1">PENDIENDTES</option>
            <option value="2">ATENDIDOS</option>
         </select>
         <label for="anio" class="lables">Anio: </label>
         <input type="text" name="anio" id="anio" value="<?php echo date('Y') ?>" style="width:80px;" />
         <label for="mes" class="lables">Mes: </label>
         <select name="mes" id="mes">
         <?php 
            $ms = date('m');
          $mes = array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
          foreach($mes as $k => $v)
          {
            $s = "";
            if($ms == ($k+1))
            {
                $s = "selected";
            }
            ?>
                <option value="<?php echo ($k+1) ?>" <?php echo $s; ?>><?php echo $v; ?></option>
            <?php
          }
         ?>
         </select>
    </form>
    <div  style="clear: both; padding: 5px; width: auto;text-align: center">
        <a href="index.php" class="button">CERRAR</a>
        <a href="#" id="gen" class="button">GENERAR</a>
<!--        <a href="#" id="pdf" class="button">VISTA PREVIA</a>-->
    </div>
</div>
<div id="wcont" style="padding: 10px;"></div>
</div>