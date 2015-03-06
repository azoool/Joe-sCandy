<?php
session_start();
if (!isset($_SESSION['admin']) || $_SESSION['admin'] == false)
    header('location:index.php');
?>
<html>
    <head>
        <title>Tool Bonbon</title>
        <link rel="stylesheet" href="css.css" />
        <meta charset="UTF-8">
        <script type="text/javascript" src="monJS.js"></script>
    </head>
    <body bgcolor="#D8E1DF" >
        <div id="entete">
            <div id="titreEntete"><p><a href="format.php" >Joe's Candy</a></p></div>
            <div id='linkAdminPage'><p><a href='toolPage.php'>Admin page</a></p></div>
            <div id="deconnect">
                <p><a href="disconnect.php" >Se déconnecter</a></p>
            </div>
        </div>
        <?php
        if(isset($_SESSION['dialog']) && $_SESSION['dialog']!=""){
        $text = $_SESSION['dialog'];
        echo "<script>messageConfirm()</script>";
        
        echo"<div id='messageConfirm' align='center'>"
                ."<p id='textConfirm' >$text</p>" 
            ."</div>";
        }
        $_SESSION['dialog']="";
        ?>
        <div id="ajout">    
            <h2><p align="center">Ajouter</p></h2>
            <form action="addBonbon.php" method="post" enctype="multipart/form-data" align="left">
                <div class="ajoutnomPage">NOM : <input  name="Nom" type="text" class="labelPage" /></div>
                <div class="ajoutnomPage">PRIX : <input  name="Prix" type="text" class="labelPage"/></div>
                <div class="ajoutnomPage">PROMOTION : <input  name="Promotion" type="text" class="labelPage"/></div>
                <div class="ajoutnomPage">
                    GOUT :
                    <select name="choixGout" class="labelPage">
                        <option value="Acide">Acide</option>
                        <option value="Doux">Doux</option>
                        <option value="Extreme">Extrème</option>
                        <option value="Fruite">Fruité</option>
                     </select>
                </div>
                <div class="ajoutnomPage">
                    COULEUR :
                    <select name="choixCouleur" class="labelPage">
                        <option value="Rouge">Rouge</option>
                        <option value="Vert">Vert</option>
                        <option value="Bleu">Bleu</option>
                        <option value="Jaune">Jaune</option>
                        <option value="Mutli-couleurs">Mutli-couleurs</option>
                     </select>
                </div>
                <div class="ajoutnomPage">DESCRIPTIF : 
                    <textarea name="Descriptif" rows="3" cols="20"type="text" class="labelPage"></textarea>
                </div>
                <br/><br/><br/>
                <div class="file" align="center"    >
                    <input type="file" name="image" class="choiximage" /><br/><br/>
                    <input type="submit" value="Ajouter" class="btnajout" /><br/>
                </div>
            </form> 
        </div>
        <div id="home" align="center">
            <?php
                require 'params.php';
                mysql_connect($host, $user, $password) or die('Erreur de connexion au SGBD.');
                mysql_select_db($base) or die('La base de données n\'existe pas');
                mysql_query("SET NAMES 'utf8'");
                $query = 'SELECT * FROM bonbons';
                $r = mysql_query($query);
                mysql_close();
                $couleurPromo = array("#FACC2E","#FE9A2E","#FE642E","#FE2E2E","#FF0000","#DF0101","#B40404","#8A0808","#610B0B","#3B0B0B");
                
                while ($a = mysql_fetch_object($r)) {
                    $Reference = $a->Reference;
                    $nom = $a->Nom;
                    $prix = $a->Prix;
                    $nouvPrix = $a->NouveauPrix;
                    $promo = $a->Promotion;
                    $descriptif = $a->Descriptif;
                    $lien = $a->Lien;
                    
                     $couleurProm = $couleurPromo[round($promo/10)];
                    
                    echo
                    "<div class='show' align='center'>"
                        ."<a href=\"modifBonbon.php?Reference=$Reference\" class='show_block'>"
                            ."<img src='$lien' width='210px'/>"
                            ."<div class='show-info' >" 
                                ."<div class='info'>"
                                    ."<div class='hautDetailTool' >";
                                       if($promo!=0){
                                             echo "<p align='left'><s>$prix €</s>"
                                                    ."<font color='yellow'>&nbsp&nbsp$nouvPrix € </font></p>";
                                        }
                                        else{
                                            echo "<p align='left'>$prix €</p>";
                                        } 
                                    echo "</div>"
                                    ."<div class='hautDetailTool' >"
                                    . "</div>"
                                    ."<div class='desc' align='center'>"
                                        ."<div class='title'>"
                                            ."<b>$nom</b>"
                                        ."</div>"
                                        ."<p>$descriptif</p>"
                                    ."</div>"
                                    ."<div class='ajoutmodif' align='center'>"
                                        ."<p>Cliquez pour modifier</p>"
                                    ."</div>"
                                ."</div>"
                            . "</div>"  
                        ."</a>"
                        ."<a href=\"modifBonbon.php?Reference=$Reference\" class='name'>$nom</a>"
                        ."<div class='supprimerBonbon' onclick='supprimer(\"$Reference\",\"$lien\")'>"
                            ."<img src='images/supprimer.png'  />"
                        ."</div>";
                        if($promo!=0){
                            echo "<div class='pastillePromo' style='background-color: $couleurProm'; '>"
                                . "<p><font color='white'><b> -$promo%</b></font></p>"
                            . "</div>";
                        }
                    echo "</div>"  
                    ;
                }
            ?> 
        </div>
    </body>
</html>
