<?php
session_start();
date_default_timezone_set("America/Lima"); 
require_once '../lib/FrontController.php';
FrontController::MainPublic();
?>