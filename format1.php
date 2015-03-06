
<?php
    require 'params.php';
    mysql_connect($host, $user, $password) or die('Erreur de connexion au SGBD.');
    mysql_select_db($base) or die('La base de données n\'existe pas');
    mysql_query("SET NAMES 'utf8'");
    $id=$_GET['ID'];
    $query = "SELECT * from pages WHERE ID=$id";
    $r = mysql_query($query);
    if ($a = mysql_fetch_object($r)) {
        $titre = $a->Titre;
        $HTML = $a->HTML1;
        $image = $a->Image1;   
    }
    mysql_close();
    
    include ('menu.php');
    creeMenu($id,$titre);

    echo "<div align='center' id='divFormat'>"
            ."<div class='contenuFor1'>"
                ."<div class='partiGauche'>"
                        ."<img alt='$image' src='$image' width='400px'/>"
                ."</div>"
                ."<div class='partiDroite'>"
                        ."$HTML"
                ."</div>"  
            ."</div>"     
        ."</div>";
      
     
    ?>

    