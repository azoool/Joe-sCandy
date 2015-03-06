<?php
    session_start();
    require 'params.php';
    mysql_connect($host, $user, $password) or die('Erreur de connexion au SGBD.');
    mysql_select_db($base) or die('La base de données n\'existe pas');

    $id=$_GET['ID'];
    $query = "SELECT * from pages WHERE ID=$id";
    $r = mysql_query($query);
    mysql_close();
    if ($a = mysql_fetch_object($r)) {
        $titre = $a->Titre;
    }
    
    include ('menu.php');
    creeMenu($id,$titre);

    ////////////////////////////////////////////OPTION DE TRI////////////////////////////////
    $optionSelectionner = false;
    $couleur=$_SESSION['couleur'];
    
    echo "<div id='optionDessus'>"
            ."<div id='divAvantOption'></div>";
    
    
    ///////////////////////////////////////////// TRI /////////////////////////////////////////////
    
    $order=$_SESSION['tri'];
    if($order=='Reference desc'){
        $nouveaute = "selected='selected'";
    }
    elseif($order=='NouveauPrix asc'){
        $prixAsc = "selected='selected'";
    }
    elseif($order=='NouveauPrix desc'){
        $prixDesc = "selected='selected'";
    }

    else{
        $preferer = "selected='selected'";
    }
    echo"<div id='divTri'>"
                ."<form id='formTri' action=\"format.php?ID=$id\" method='post' name='onglet' enctype='multipart/form-data' align='left'>"
                    ."Trié par :"
                    ."<select onChange='onglet.submit()' name='choixTri'>"
                        ."<option $preferer value='nbVisite desc'>Préférés</option>"
                        ."<option $nouveaute value='Reference desc'>Nouveautés</option>"
                        ."<option $prixAsc value='NouveauPrix asc'>Prix croissant</option>"
                        ."<option $prixDesc value='NouveauPrix desc'>Prix décroissant</option>"
                     ."</select>"
                ."</form>"
        ."</div>";
    
    echo"<div class='espaceOption'></div>";
                              
//////////////////////////////////// COULEUR //////////////////////////////////////////        
        
        echo"<div class='selectCouleur'>"
                    ."<div class='listeTitreCacher' onclick='afficherMenu(0,this)'>"
                        ."<div class='menuListeDetail' >"
                            . "<p class='texteCouleur'>Couleur</p>"
                        ."</div>"
                        ."<div class='menuListeDetail'>"
                            ."<img class='imageArrow' src='images/downArrow.png' align='right'/>"
                        ."</div>"
                    . "</div>"
                    ."<div class='mesTrisCacher'>";
        $touteMesCouleurs= array ('Rouge','Vert','Bleu','Jaune','Mutli-couleurs');
        foreach ($touteMesCouleurs as $couleur){
            echo "<a href=\"format.php?ID=$id&couleur=$couleur\">"
                    ."<div class='couleurConteneur' align='center'>"
                       . "<img class='imageTri' src='images/$couleur.jpg' alt='$couleur' />";

            if (in_array($couleur, $_SESSION['couleur'])){
                echo "<img class='imageTriSelect' src='images/valider.png' alt='valider' />";
                $optionSelectionner = true;
            }
            else{
                 echo "<img class='imageTriNonSelect' src='images/valider.png' alt='valider' />";
            }
            echo        "</div>"
                    ."</a>"   
                    . "<div class='espaceCouleur'>"
                    . "</div>";
        }
    echo     "</div>"
        . "</div>";//fermeture div option de tri
     
    echo"<div class='espaceOption'></div>";
    
    ///////////////////////////////////////////// GOUT //////////////////////////////////////
    echo "<div id='selectGout'>"
            ."<div class='listeTitreCacher' onclick='afficherMenu(1,this)'>"
                ."<div class='menuListeDetail' >"
                    . "<p class='texteCouleur'>Gout</p>"
                ."</div>"
                ."<div class='menuListeDetail'>"
                    ."<img class='imageArrow' src='images/downArrow.png' align='right'/>"
                ."</div>"
            . "</div>"
            ."<div class='mesTrisCacher'>"
                . "<form id='formGout' action='format.php?ID=$id' method='post' onchange='modifGout()'>";
           
    $tousMesGouts = array('Acide','Doux','Extreme','Fruite');
    foreach ($tousMesGouts as $gout){
        if (in_array($gout, $_SESSION['gout'])){
            echo"<label class='labelCheckbox'><input type='checkbox' name='gout[]' value='$gout' checked='checked'/>$gout</label><br>";
            $optionSelectionner = true;
        }
        else{
            echo"<label class='labelCheckbox'><input type='checkbox' name='gout[]' value='$gout'/>$gout</label><br>";
        }
    }
    
    echo         "<input id='inputGout' type='submit' value='Appliquer' disabled='disabled'/>"
            ."</form>"
        ."</div>"
       ."</div>";
    
    echo"<div class='espaceOption'></div>";
    
////////////////////////////////////////////BAR DE RECHERCHE////////////////////////////////
    
    
    $recherche=$_GET["Recherche"];
        echo "<div id='divSearch'>"
                . "<form action=\"format.php?ID=$id\" name='search' method='post' enctype='multipart/form-data' align='left'>"
                    ."<input class='textSearch' name='rechercheBonbon' type='text' placeholder='Rechercher un nom' />"
                    ."<input class='submitSearch' type='submit' value=' '/>"
                ."</form>"
            ."</div>";
        
    echo "</div>";//Fermeture de div de Tri
////////////////////////////////////////////OPTION SELECTIONNE////////////////////////////////
    
    if($optionSelectionner){
        echo    "<div id='divOptionSelectionner'>Votre selection : ";
            foreach ($_SESSION['couleur'] as $couleur){
                echo"<a href=\"format.php?ID=$id&couleur=$couleur\">"
                    . "<span class='optionSelectionner'>"
                        . "&nbsp $couleur &nbsp"
                    . "</span>"
                ."</a>";
            }
            foreach ($_SESSION['gout'] as $gout){
                echo"<a href=\"format.php?ID=$id&goutAEnlever=$gout\">"
                    . "<span class='optionSelectionner'>"
                        . "&nbsp $gout &nbsp"
                    . "</span>"
                ."</a>";
            }
            
            echo"<a href=\"format.php?ID=$id\">"
                    . "<span id='RetirerTous'>"
                        . "&nbsp Retirer tout les critères &nbsp"
                    . "</span>"
                ."</a>";
            echo "</div>";
    }      
    
    /////////////////////////////////////////AFFICHAGE BONBON //////////////////////////////////////////


    echo"<div id='home' align='center'>";
  
    require 'params.php';
    mysql_connect($host, $user, $password) or die('Erreur de connexion au SGBD.');
    mysql_select_db($base) or die('La base de données n\'existe pas');
    mysql_query("SET NAMES 'utf8'");
    
    //gestion couleur
    $i=0;
    foreach ($_SESSION['couleur'] as $couleur) {
        if($i==0){
            $mescouleurs="( Couleur='$couleur'";
        }
        else{
            $mescouleurs=$mescouleurs." or "."Couleur='$couleur'";
        }
        
        $i++;
    }
    if($mescouleurs!=''){
        $mescouleurs = $mescouleurs." )";
    }
    
    
    //gestion gout
    $i=0;
    foreach ($_SESSION['gout'] as $gout) {
        if($i==0){
            if($mescouleurs!=''){
                $mesgouts=" and ";           
            }
            $mesgouts=$mesgouts." ( Gout='$gout'";
        }
        else{
            $mesgouts=$mesgouts." or "."Gout='$gout'";
        }
        
        $i++;
    }
    if($mesgouts!=''){
        $mesgouts = $mesgouts." )";        
    }
   
    
    //gestion recherche
    $maRecherche = $_GET['Recherche'];
    if($maRecherche!=''){
        $query = "Select * FROM bonbons where Nom like ('%$maRecherche%')";
    }
    else{
        //gestion query
        $order=$_SESSION['tri'];
        $query = 'SELECT * FROM bonbons';
        if($mescouleurs!='' || $mesgouts!=''){
            $query = $query." where $mescouleurs $mesgouts ";
        }
        if($order!=''){
            $query = $query." order by ".$order;
        }
    }
    $r = mysql_query($query);
    mysql_close();
    $couleurPromo = array("#FACC2E","#FE9A2E","#FE642E","#FE2E2E","#FF0000","#DF0101","#B40404","#8A0808","#610B0B","#3B0B0B");

    
    while ($a = mysql_fetch_object($r)) {
        $reference = $a-> Reference;
        $nom = $a->Nom;
        $prix = $a->Prix;
        $descriptif = $a->Descriptif;
        $lien = $a->Lien;
        $couleur = $a->Couleur;
        $promo = $a->Promotion;
        $nouvPrix = $a->NouveauPrix;
        
        $couleurProm = $couleurPromo[round($promo/10)];
        echo
            "<div class='show' align='center'>"
                ."<a href='updatePreferer.php?Reference=$reference' class='show_block'>"
                    ."<img alt='$nom' src='$lien' width='210px'/>"
                    ."<div class='show-info' >" 
                        ."<div>"
                            ."<div class='info' align='right'>";
                                if($promo!=0){
                                    echo "<s>$prix €</s>"
                                         ."<font color='yellow'>&nbsp&nbsp$nouvPrix € </font>";
                                }
                                else{
                                    echo "$prix €";
                                }
                            echo "</div>"
                            ."<div class='desc'>"
                                ."<div class='title'>"
                                    ."<b>$nom</b>"
                                ."</div>"
                                ."<p>$descriptif</p>"
                            ."</div>"
                        ."</div>"
                    . "</div>"
                ."</a>"
                ."<a href='updatePreferer.php?Reference=$reference' class='name'><font color='black'>$nom</font></a>";
                    if($promo!=0){
                        echo "<div class='pastillePromo' style='background-color: $couleurProm'; '>"
                            . "<p><font color='white'><b> -$promo%</b></font></p>"
                        . "</div>";
                    }
            echo "</div>"    
        ;
    }
    echo"</div>";
    basPage();
    ?>   
    </body>
</html>