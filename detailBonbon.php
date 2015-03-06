<?php
    session_start();
    require 'params.php';
    mysql_connect($host, $user, $password) or die('Erreur de connexion au SGBD.');
    mysql_select_db($base) or die('La base de données n\'existe pas');
    mysql_query("SET NAMES 'utf8'");
    $reference=$_GET['Reference'];
    $query="Select * from bonbons where Reference=$reference";
    
    $r = mysql_query($query);
    mysql_close();
    if ($a = mysql_fetch_object($r)) {
        $nom = $a->Nom;
        $prix = $a->Prix;
        $promo = $a->Promotion;
        $nouvPrix = $a->NouveauPrix;
        $descriptif = $a->Descriptif;
        $lien = $a->Lien;
        $gout = $a->Gout;
        $couleur = $a->Couleur;
        
    }

    
    include ('menu.php');   
    creeMenu($nom);
    
    echo"<div align='center'>"
            . "<div id='pageDetailBonbon'>"
                ."<div id='divDetailBonbon'>"
                    ."<img id='imageDetailBonbon' alt='$nom' src='$lien' align='center' width='350px'/>"
                ."</div>"
                ."<div id='detailDuBonbon'>"
                    ."<p><b>Détail</b><p>"
                    ."<p align='left'>Nom : $nom<p>";
                    if($promo!=0){
                        echo "<p align='left'>Ancien Prix : <s>$prix €</s><p>"
                            . "<p align='left'>Nouveau prix-><font color='red'> $nouvPrix! </font>soit $promo% de réduction</p>";
                    }
                    else{
                        echo "<p align='left'>Prix : $prix €<p>";
                    }    
                    echo"<p align='left'>$descriptif<p>"
                    ."<p align='left'>Gout : $gout<p>"
                    ."<p align='left'>Couleur : $couleur<p>"
                ."</div>"
            ."</div>"
       ."</div>"
   ."</body>"
 . "</html>";
?>