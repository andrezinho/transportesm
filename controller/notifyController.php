<?php
require_once '../lib/controller.php';
require_once '../model/notify.php';
class notifyController extends Controller
{
   public function getAlerts() 
   {
       $obj = new notify();
       $data = $obj->getData($id);
       print_r(json_encode($data));
   }
}
?>