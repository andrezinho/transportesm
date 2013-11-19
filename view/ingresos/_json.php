<?php
$items = array();
foreach ($value as $key => $val ) {
    $items[$val[0]]=$val[1];
}

$result = array();
foreach ($items as $key => $value) {
      array_push($result, array("id"=>$key, "name"=>$value));
      if ( $key > 7 ) { break; }
}
print_r(json_encode($result));

?>