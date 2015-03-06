<?php

    $reference=$_GET['Reference'];
    session_start();
    require 'params.php';
    mysql_connect($host, $user, $password) or die('Erreur de connexion au SGBD.');
    mysql_select_db($base) or die('La base de données n\'existe pas');
    $query="Update bonbons set nbVisite=nbVisite+1 where Reference=$reference";
    mysql_query($query);
    mysql_close();
    header("location:detailBonbon.php?Reference=$reference");

    
    ?>

