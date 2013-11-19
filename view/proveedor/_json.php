<?php
$result = array();
foreach ($value as $key => $val) {
      array_push($result, array(	
                                "id"=>$val['idproveedor'], 
                                "name"=>strtoupper($val['razonsocial']),
                                "ruc"=>$val['ruc']
                            )
      			);
      if ( $key > 7 ) { break; }
}
print_r(json_encode($result));

?>