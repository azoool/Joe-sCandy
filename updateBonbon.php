<?php
session_start();
if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) {
    $reference = $_POST['Reference'];
    $nom = htmlspecialchars($_POST['Nom'], ENT_QUOTES);
    $prix = $_POST['Prix'];
    $desc = htmlspecialchars($_POST['Descriptif'], ENT_QUOTES);
    $promo = $_POST['Promotion'];
    $gout = $_POST['ChoixGout'];
    $couleur = $_POST['ChoixCouleur'];
    $ancienLien = $_POST['Lien'];
    
    if($promo<0 or $promo>100){
        echo "La promotion doit etre comprise entre 0 et 100"
            ."<a href='javascript:history.go(-1)'>Retour au formulaire</a>";			
        include("footer.php");
        exit;
    }
    
    $nouvPrix = $prix-($prix*$promo/100);

    if (!empty($_FILES['Image']['tmp_name']) and is_uploaded_file($_FILES['Image']['tmp_name'])) {
        unlink("$ancienLien");
        //Liste des extensions prisent en compte
        $extensions = array('jpg', 'jpeg', 'gif', 'png');

        //Test1: fichier correctement uploadé
        if (!isset($_FILES['Image']) OR $_FILES['Image']['error'] > 0) {
            echo "Erreur lors du chargement du fichier<br>"
                ."<a href='javascript:history.go(-1)'>Retour au formulaire</a>";			
            include("footer.php");
            exit;
        }
        //Test2: taille limite
        if ($_FILES['Image']['size'] > 5000000) {
            echo "Le fichier est trop gros<br>"
                ."<a href='javascript:history.go(-1)'>Retour au formulaire</a>";
            include("footer.php");
            exit;
        }
        //Test3: extension
        $ext = substr(strrchr($_FILES['Image']['name'], '.'), 1);
        if (!in_array($ext, $extensions)) {
            echo "L'extension du fichier n'est pas valide<br>"
                ."<a href='javascript:history.go(-1)'>Retour au formulaire</a>";
            include("footer.php");
            exit;
        }
        //Déplacement
        $lien = 'images/' . $reference . '.' . $ext;
        if (move_uploaded_file($_FILES['Image']['tmp_name'], $lien)) {
            echo 'Chargement réussi';
        }
    } else {
        $lien = $ancienLien;
    }

    require 'params.php';
    mysql_connect($host, $user, $password) or die('Erreur de connexion au SGBD.');
    mysql_select_db($base) or die('La base de données n\'existe pas');
    mysql_query("SET NAMES 'utf8'");
    $query = "UPDATE bonbons SET Nom='$nom',Promotion='$promo', NouveauPrix='$nouvPrix', Prix='$prix', Descriptif='$desc', "
            . "Lien='$lien', Gout='$gout', Couleur='$couleur' "
            . "WHERE Reference='$reference'";
    if(mysql_query($query)){
        $_SESSION['dialog']="Modification réussie";
    }
    else{
        $_SESSION['dialog']="Erreur lors de la modification";
    }
    mysql_close();
    header('location:toolBonbon.php');
}
?>
