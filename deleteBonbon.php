<?php
session_start();
if(isset($_SESSION['admin']) && $_SESSION['admin']==true)
{
$reference=$_GET['Reference'];
$lien=$_GET['Lien'];
require 'params.php';
mysql_connect($host,$user,$password) or die('Erreur de connexion au SGBD.');
mysql_select_db($base) or die('La base de données n\'existe pas');
$query="delete from bonbons where Reference='$reference'";
if(mysql_query($query)){
        $_SESSION['dialog']="Suppression réussie";
    }
    else{
        $_SESSION['dialog']="Erreur lors de la suppression";
}
mysql_close();

unlink("$lien");
header('location:toolBonbon.php');
}
?>
