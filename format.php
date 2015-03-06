<?php
    session_start();
    require 'params.php';
    mysql_connect($host, $user, $password) or die('Erreur de connexion au SGBD.');
    mysql_select_db($base) or die('La base de données n\'existe pas');
    $id=$_GET['ID'];
    if($id==''){
        $query = "SELECT * from pages WHERE Rang=1";
    }
    else{
        $query = "SELECT * from pages WHERE ID=$id";
    }
    
    $r = mysql_query($query);
    mysql_close();
    if ($a = mysql_fetch_object($r)) {
        $format = $a->Format;
        $id = $a->ID;
    }
    
    
    
  

    if($format==1 || $format==2){
      header("location:formats.php?ID=$id");  
    }
    elseif($format==3 || $format==4){    
        // gestion des tri et selections
        $tri = $_POST['choixTri'];
        $couleur = $_GET['couleur'];
        $goutAEnlever=$_GET['goutAEnlever'];
        $bonbonAChercher = $_POST['rechercheBonbon'];
        
        //si rien n'est renseigner on remet les variables a vide.
        if($tri=='' && $couleur=='' && $goutAEnlever=='' && $_POST['gout']=='' && $bonbonAChercher==''){
            if($format==3){
               $_SESSION['tri']='nbVisite desc'; 
            }
            else{
               $_SESSION['tri']='Promotion desc'; 
            }
            
            $_SESSION['couleur'] = array();
            $_SESSION['gout'] = array();
        }
        else{
            //gestion recherche bonbon
            if($bonbonAChercher!=''){
                $bonbonAChercher="&Recherche=$bonbonAChercher";
                if($format==3){
                    $_SESSION['tri']='nbVisite desc'; 
                }
                else{
                   $_SESSION['tri']='Promotion desc'; 
                }
                $_SESSION['couleur'] = array();
                $_SESSION['gout'] = array();
            }
            else{
                //gestion du tri
                if($tri=='-1'){
                    $_SESSION['tri']='';
                }
                elseif($tri!=''){
                    $_SESSION['tri']=$tri;
                }

                //gestion de la selection de la couleur
                $b=TRUE;
                for($i=0 ; $i<6; $i++){
                    if($couleur==$_SESSION['couleur'][$i]){
                        unset($_SESSION['couleur'][$i]);
                        $b=FALSE;
                    } 
                }
                //si la couleur est pas dans le tableau on lajoute
                if($b){
                    array_push($_SESSION['couleur'], $couleur);
                }

                //gestion de la selection du gout
                if($_POST['gout']!=''){
                    $_SESSION['gout'] = array();
                    foreach($_POST['gout'] as $gout)
                    {   
                        array_push($_SESSION['gout'], $gout);
                    }
                }
                if($goutAEnlever!=''){
                    for($i=0 ; $i<5; $i++){
                        if($goutAEnlever == $_SESSION['gout'][$i]){
                            unset($_SESSION['gout'][$i]);

                        }
                    }
                }
            }
            
        }
        header("location:formats.php?ID=$id"."$bonbonAChercher");  
         
         
    }

    else{
        echo "Le format de la page n\'est pas bon.<br/>"
            ."<a href=\"connexion.php\>Retour a la page connexion</a>"			
            ;
        exit;
    }
     

?>

