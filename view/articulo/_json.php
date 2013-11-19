<?php
$result = array();
foreach ($value as $key => $val) {
      array_push($result, array(	
      								"id"=>$val['idarticulo'], 
      								"name"=>$val['descripcion'],
      								"unidad"=>$val['unidad'],
      								"precio"=>$val['precio']
      							)
      			);
      if ( $key > 7 ) { break; }
}
print_r(json_encode($result));

?>