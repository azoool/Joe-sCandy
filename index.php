<?php
session_start();
if(isset($_SESSION['admin']) && $_SESSION['admin']==true)
	header('location:toolPage.php');
	else header('location:format.php');
?>