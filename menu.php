<?php
session_start();
function creeMenu($monId,$montitre){
    echo"<html>"
    ."<head>"
        ."<title>$montitre</title>"
        ."<link rel='stylesheet' href='css.css' />"
        ."<meta charset='UTF-8' />"
        ."<script type='text/javascript' src='monJS.js'></script>"
    ."</head>"
    ."<body bgcolor='#D8E1DF'>"

        ."<div id='entete'>"
            ."<div id='titreEntete'><p><a href='format.php' >Joe's Candy</a></p></div>";
                if(isset($_SESSION['admin']) && $_SESSION['admin']==true){
                    echo 
                     "<div id='linkAdminBonbon'><p><a href='toolBonbon.php'>Admin bonbon</a></p></div>"
                    . "<div id='linkAdminPage'><p><a href='toolPage.php'>Admin page</a></p></div>"
                    ."<div id='deconnect'><p><a href='disconnect.php'>Se déconnecter</a></p></div>"
                    
                    ;
                }
                else{
                    echo "<div id='formCo'>"
                            ."<form method='post' action='connect.php'>"
                                ."<div class='login'><p>Login : <input class='champsCo' type='text' name='pseudo' size='10' /></p></div>"
                                ."<div class='login'><p>Mot de passe  : <input class='champsCo' type='password' name='password' size='10' /></p></div>"
                                ."<div id='bouton'><input id='seCo' type='submit' value='Se connecter' /></div>"
                            ."</form>"
                        ."</div>";
                }
            echo
        "</div>"      
        ."<nav id='menu'>"    
            ."<div class='row'>"
                ."<ul class='ul-menu'>";
            
        require 'params.php';
        mysql_connect($host, $user, $password) or die('Erreur de connexion au SGBD.');
        mysql_select_db($base) or die('La base de données n\'existe pas');
        mysql_query("SET NAMES 'utf8'");
        $query1 = 'SELECT count(ID) from pages';
        $r1 = mysql_query($query1);
        $nbPage=mysql_result($r1,0);        
        $nbDivider = 0;
        $query = "SELECT ID, Titre, Rang from pages order by Rang";
        $r = mysql_query($query);
        mysql_close();
        while ($a = mysql_fetch_object($r)) {
            $id = $a->ID;
            $titre = $a->Titre; 
            $rang = $a->Rang;
            
            if($id==$monId){
                if($nbDivider<$nbPage-1){    
                echo 
                    "<li class='li-menuActif'>"
                        ."<a href=\"format.php?ID=$id\">"
                            ."<span class='spanMenu'>$titre</span>"
                        ."</a>"
                    ."</li>"
                    ."<li class='divider-menu'>|</li>"
                ;
                }
                else {
                    echo 
                        "<li class='li-menuActif'>"
                            ."<a href=\"format.php?ID=$id\">"
                                ."<span class='spanMenu'>$titre</span>"
                            ."</a>"
                        ."</li>"
                    ;  
                }
                $nbDivider = $nbDivider+1;
            }
            else {
                if($nbDivider<$nbPage-1){    
                    echo 
                        "<li class='li-menu'>"
                            ."<a class='lienMenu'href=\"format.php?ID=$id\">"
                                ."<span class='spanMenu'>$titre</span>"
                            ."</a>"
                        ."</li>"
                        ."<li class='divider-menu'>|</li>"
                    ;
                }
                else {
                    echo 
                        "<li class='li-menu'>"
                            ."<a class='lienMenu' href=\"format.php?ID=$id\">"
                                ."<span class='spanMenu'>$titre</span>"
                            ."</a>"
                        ."</li>"
                    ;  
                }
                $nbDivider = $nbDivider+1;
            }
        }
        echo    "</ul>"
            ."</div>"
        ."</nav>"
        ."</br></br>"
        ;            
}

function basPage(){
}

?>