<?php
session_start();
if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) {
    $nom = htmlspecialchars($_POST['Nom'], ENT_QUOTES);
    $prix = $_POST['Prix'];
    $desc = htmlspecialchars($_POST['Descriptif'], ENT_QUOTES);
    $gout = $_POST['choixGout'];
    $couleur = $_POST['choixCouleur'];
    $test = TRUE;
    
    //on verifie si les champs on été renseigner
    foreach($_POST as $cle=>$val)
    {
        if($val=='' && $cle!='Promotion'){
            $text=$text." $cle ";
            $test=FALSE;
        }
    }
    
    if($test==FALSE){
        echo "Le(s) champ(s) <b> $text </b> n'ont pas été renseignés<br>"
            ."<a href='javascript:history.go(-1)'>Retour au formulaire</a>";		
        exit;
    }
    
    $promo = $_POST['Promotion'];
    if($promo<0 or $promo>100){
        echo "La promotion doit etre comprise entre 0 et 100"
            ."<a href='javascript:history.go(-1)'>Retour au formulaire</a>";			
        exit;
    }    
    $nouvPrix = $prix-($prix*$promo/100);
    ////////////////////////////////////////////////////// FIN VERIF ///////////////
    require 'params.php';
    mysql_connect($host, $user, $password) or die('Erreur de connexion au SGBD.');
    mysql_select_db($base) or die('La base de données n\'existe pas');
    mysql_query("SET NAMES 'utf8'");
    $queryMax = "SELECT max(Reference) FROM bonbons";
    $r1 = mysql_query($queryMax);
    $max=mysql_result($r1,0);
    $max++;
    
    
//Liste des extensions prisent en compte
    if (!empty($_FILES['image']['tmp_name']) and is_uploaded_file($_FILES['image']['tmp_name'])) {
        $extensions = array('jpg', 'jpeg', 'gif', 'png');

        //Test1: fichier correctement uploadé
        if (!isset($_FILES['image']) OR $_FILES['image']['error'] > 0) {
            echo "Erreur lors du chargement du fichier<br>"
                ."<a href='javascript:history.go(-1)'>Retour au formulaire</a>";			
            exit;
        }
        //Test2: taille limite
        if ($_FILES['image']['size'] > 5000000) {
            echo "Le fichier est trop gros<br>"
                 ."<a href='javascript:history.go(-1)'>Retour au formulaire</a>";
            exit;
        }
        //Test3: extension
        $ext = substr(strrchr($_FILES['image']['name'], '.'), 1);
        if (!in_array($ext, $extensions)) {
            echo "L'extension du fichier n'est pas valide<br>"
                ."<a href='javascript:history.go(-1)'>Retour au formulaire</a>";
            exit;
        }
        //Déplacement
        $lien = 'images/' . $max . '.' . $ext;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $lien)) {
            echo 'Chargement réussi';
        }
    }
    
    if($lien==''){
        echo"le champs <b>Lien</b> n'a pas ete renseigner <br/>"
            ."<a href='javascript:history.go(-1)'>Retour au formulaire</a>";			
            exit;
    }

    
    $query = "insert into bonbons(Nom,Prix,Promotion,NouveauPrix,Descriptif,Lien,Gout,Couleur) "
            . "VALUES('$nom','$prix','$promo','$nouvPrix','$desc','$lien','$gout','$couleur')";
    if(mysql_query($query)){
        $_SESSION['dialog']="Ajout réussi";
    }
    else{
        $_SESSION['dialog']="Erreur lors de l'ajout";
    }
    mysql_close();
    header('location:toolBonbon.php');

}
?>
