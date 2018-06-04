<?php
error_reporting(0);
session_start();
include('database_connection.php');include('function.php');
if(!isset($_SESSION["id"])) {header("location:login.php");}
include('header.php');
?>
	<span id="alert_action"></span>
<?php include "module.php";include("footer.php");
?>