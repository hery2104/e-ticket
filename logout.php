<?php 
include 'admin/backend.php';
$db=new backend;
session_start();
session_unset();
// die(var_dump("expression"));
$db->redirect('./index.php');
 ?>