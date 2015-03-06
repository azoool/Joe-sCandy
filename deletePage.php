<?php
session_start();
if(isset($_SESSION['admin']) && $_SESSION['admin']==true)
{
    $id=$_GET['ID'];
    $rang=$_GET['Rang'];
    $image1 = $GET['image1'];
    $image2 = $GET['image2'];
    if(isset($image1)){
        unlink("$image1");
    } 
    if(isset($image2)){
        unlink("$image2");
    } 
    require 'params.php';
    mysql_connect($host,$user,$password) or die('Erreur de connexion au SGBD.');
    mysql_select_db($base) or die('La base de données n\'existe pas');
    $query1="update pages set Rang=Rang-1 where Rang>$rang";
    mysql_query($query1);
    $query="delete from pages where ID='$id'";
    if(mysql_query($query)){
        $_SESSION['dialog']="Suppression réussie";
    }
    else{
        $_SESSION['dialog']="Erreur lors de la suppression";
    }
    mysql_close();
    header('location:toolPage.php');
}
?>
