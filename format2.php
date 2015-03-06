
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
        $HTML1 = $a->HTML1;
        $image1 = $a->Image1;   
        $HTML2 = $a->HTML2;
        $image2 = $a->Image2; 
    }
    mysql_close();
    
    include ('menu.php');
    creeMenu($id,$titre);
    
    echo "<br/>"
    . "<div align='center' id='divFormat'>"
            ."<div class='contenuFor1'>"
                ."<div class='partiGauche'>"
                        ."<img alt='$image1' src='$image1' width='300px'/>"
                ."</div>"
                ."<div class='partiDroite'>"
                        .$HTML1
                ."</div>"  
            ."</div>"
            ."<hr class='barAccueil' align='center'>"
            ."<div class='contenuFor1'>"
                ."<div class='partiGauche'>"
                        .$HTML2
                ."</div>"
                ."<div class='partiDroite'>"
                        ."<img alt='$image2' src='$image2' width='300px'/>" 
                ."</div>" 
            ."</div>"
        ."</div>";
    
    
    basPage();
    ?>
    
    </body>
</html>