<?php
$result = array();
foreach ($value as $key => $val) {
      array_push($result, array(	
                                "id"=>$val['idconcepto_movimiento'], 
                                "name"=>strtoupper($val['descripcion']),                                
                            )
      			);
      if ( $key > 7 ) { break; }
}
print_r(json_encode($result));

?>