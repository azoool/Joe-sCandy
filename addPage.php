<?php
session_start();
if (isset($_SESSION['admin']) && $_SESSION['admin'] == true) {   
    $format=$_POST['choixFormat'];
    $titre =  $_POST['titre'];   
    $titre= htmlspecialchars($titre, ENT_QUOTES);
    
    require 'params.php';
    mysql_connect($host, $user, $password) or die('Erreur de connexion au SGBD.');
    mysql_select_db($base) or die('La base de données n\'existe pas');
    mysql_query("SET NAMES 'utf8'");
    
    if($format==3 || $format==4){
        $queryF = "Select count(*) from pages where Format='$format'";
        $rF = mysql_query($queryF);
        if(mysql_result($rF,0)!=0){
            echo "Une page de <b>Format $format </b> existe deja. Vous ne pouvez pas en cree une deuxieme. <br/>"
            ."<a href='javascript:history.go(-1)'>Retour au formulaire</a>";			
        exit;
        }
    }
    else{
        $queryMax = "SELECT max(ID) FROM pages";
        $r1 = mysql_query($queryMax);
        $max=mysql_result($r1,0);
        $max++;
        
        $HTML1 =  $_POST['HTML1'];
        $HTML1= htmlspecialchars($HTML1, ENT_QUOTES);
        if (!empty($_FILES['image1']['tmp_name']) and is_uploaded_file($_FILES['image1']['tmp_name'])) {
            $extensions = array('jpg', 'jpeg', 'gif', 'png');

            //Test1: fichier correctement uploadé
            if (!isset($_FILES['image1']) OR $_FILES['image1']['error'] > 0) {
                echo "Erreur lors du chargement du fichier<br>"
                    ."<a href='javascript:history.go(-1)'>Retour au formulaire</a>";			
                exit;
            }
            //Test2: taille limite
            if ($_FILES['image1']['size'] > 5000000) {
                echo "Le fichier est trop gros<br>"
                     ."<a href='javascript:history.go(-1)'>Retour au formulaire</a>";
                exit;
            }
            //Test3: extension
            $ext = substr(strrchr($_FILES['image1']['name'], '.'), 1);
            if (!in_array($ext, $extensions)) {
                echo "L'extension du fichier n'est pas valide<br>"
                    ."<a href='javascript:history.go(-1)'>Retour au formulaire</a>";
                exit;
            }
            //Déplacement
            $lien1 = 'images/' . $max . '-1.' . $ext;
            if (move_uploaded_file($_FILES['image1']['tmp_name'], $lien1)) {
                echo 'Chargement réussi';
            }
        }
        
        if($format==2){
            $HTML2 =  $_POST['HTML2'];
            $HTML2= htmlspecialchars($HTML2, ENT_QUOTES);
            if (!empty($_FILES['image2']['tmp_name']) and is_uploaded_file($_FILES['image2']['tmp_name'])) {
                $extensions = array('jpg', 'jpeg', 'gif', 'png');

                //Test1: fichier correctement uploadé
                if (!isset($_FILES['image2']) OR $_FILES['image2']['error'] > 0) {
                    echo "Erreur lors du chargement du fichier<br>"
                        ."<a href='javascript:history.go(-1)'>Retour au formulaire</a>";			
                    exit;
                }
                //Test2: taille limite
                if ($_FILES['image2']['size'] > 5000000) {
                    echo "Le fichier est trop gros<br>"
                         ."<a href='javascript:history.go(-1)'>Retour au formulaire</a>";
                    exit;
                }
                //Test3: extension
                $ext = substr(strrchr($_FILES['image2']['name'], '.'), 1);
                if (!in_array($ext, $extensions)) {
                    echo "L'extension du fichier n'est pas valide<br>"
                        ."<a href='javascript:history.go(-1)'>Retour au formulaire</a>";
                    exit;
                }
                //Déplacement
                $lien2 = 'images/' . $max . '-2.' . $ext;
                if (move_uploaded_file($_FILES['image2']['tmp_name'], $lien2)) {
                    echo 'Chargement réussi';
                }
            }
        }
    }
    
    $query1 = 'SELECT count(ID) from pages';
    $r1 = mysql_query($query1);
    $rang=mysql_result($r1,0);
    $rang++;
    
    $query = "insert into pages(Format, Rang, Titre, HTML1, Image1, HTML2, Image2) "
            . "VALUES('$format','$rang','$titre','$HTML1','$lien1','$HTML2','$lien2')";    
    if(mysql_query($query)){
        $_SESSION['dialog']="Ajout réussi";
    }
    else{
        $_SESSION['dialog']="Erreur lors de l'ajout";
    }
    mysql_close();
    
    header('location:toolPage.php');
}
?>

