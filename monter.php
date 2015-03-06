<?php
session_start();
if(isset($_SESSION['admin']) && $_SESSION['admin']==true)
{
    $id=$_GET['ID'];
    $rang=$_GET['Rang'];
    $rang=$rang-1;
    require 'params.php';
    mysql_connect($host,$user,$password) or die('Erreur de connexion au SGBD.');
    mysql_select_db($base) or die('La base de données n\'existe pas');
    $query="update pages set Rang=Rang-1 where ID='$id'";
    mysql_query($query);
    $query="update pages set Rang=Rang+1 where Rang='$rang' and ID!='$id'";
    if(mysql_query($query)){
        $_SESSION['dialog']="Montée réussie";
    }
    else{
        $_SESSION['dialog']="Erreur lors de la montée";
    }
    mysql_close();
    header('location:toolPage.php');
}
?>
