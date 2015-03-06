<?php
    session_start();
    if (!isset($_SESSION['admin']) || $_SESSION['admin'] == false) {
        header('location:index.php');
    }
?>

<html>
    <head>
        <title>Tool Page</title>
        <link rel="stylesheet" href="css.css" />
        <script type="text/javascript" src="monJS.js"></script>
        <meta charset="UTF-8">
    </head>
    <body bgcolor="#D8E1DF" onload="gererFormat()">
        <div id="entete">
            <div id="titreEntete"><p><a href="format.php" >Joe's Candy</a></p></div>
            <div id='linkAdminBonbon'><p><a href='toolBonbon.php'>Admin bonbon</a></p></div>
            <div id="deconnect">
                <p><a  href="disconnect.php" >Se déconnecter</a></p>
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
            <h2><p align="center">Nouvelle page</p></h2>
            <form action="addPage.php" method="post" enctype="multipart/form-data" align="left" >
                <div class="ajoutnomPage">Format :
                    <select id="choixFormat" name="choixFormat" class="labelPage" width="50px" onChange="gererFormat()">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                    </select>
                </div>
                <div class="ajoutnomPage">Titre : <input name="titre" type="text" class="labelPage"/></div>
                
                <div id="format1">
                    <div class="ajoutnomPage">HTML 1 : <textarea  class="labelPage" name="HTML1" rows="3" cols="20"  class="label"></textarea></div>
                    <br/>
                    <div class="ajoutnomPage">Image 1 :</div>
                    <div align="center">
                        <input type="file" name="image1" class="choiximage" /><br/><br/>
                    </div> 
                </div>
                <div id="format2">
                    <div class="ajoutnomPage">HTML 2 : <textarea  class="labelPage" name="HTML2" rows="3" cols="20"  class="label"></textarea></div>
                    <br/>
                    <div class="ajoutnomPage">Image 2 :</div>
                    <div align="center">
                        <input type="file" name="image2" class="choiximage" /><br/><br/>
                    </div> 
                </div>
                <div align="center"><input type="submit" value="Ajouter" class="btnajout"/></div>
            </form>
        
        </div>
        
        <div id="mesPages" align="center">
            <h2 align='center'><b>Mes pages</b></h2>
<?php
    require 'params.php';
    mysql_connect($host, $user, $password) or die('Erreur de connexion au SGBD.');
    mysql_select_db($base) or die('La base de données n\'existe pas');
    mysql_query("SET NAMES 'utf8'");
    $query1 = 'SELECT count(ID) from pages';
    $r1 = mysql_query($query1);
    $nbPage=mysql_result($r1,0); 

    $query = 'SELECT * FROM pages order by Rang';
    $r = mysql_query($query);
    mysql_close();
    while ($a = mysql_fetch_object($r)) {
        $id = $a->ID;
        $rang = $a->Rang;
        $titre = $a->Titre;
        $format = $a->Format;
        
        echo"<div class='affichePages' align='center'>"
                ."<a href=\"format.php?ID=$id\">"
                    ."<p align='center'><b>$titre</b></p>"
                . "</a>";
        
        if($rang==1){
            echo "<p>&nbsp</p>"
                ."<p align='center'>$rang</p>"
                ."<a href=\"descendre.php?ID=$id&Rang=$rang\">"
                    ."<p>Descendre</p>"
                ."</a>";
        }
        elseif ($rang==$nbPage){
            echo"<a href=\"monter.php?ID=$id&Rang=$rang\">"
                    . "<p>Monter</p>"
                ."</a>"
                ."<p align='center'>$rang</p>"
                ."<p>&nbsp</p>"; 
        }
        else{
            echo "<a href=\"monter.php?ID=$id&Rang=$rang\">"
                    ."<p>Monter</p>"
                 ."</a>"
                 ."<p align='center'>$rang</p>"    
                ."<a href=\"descendre.php?ID=$id&Rang=$rang\">"
                   . "<p>Descendre</p>"
               . "</a>";
        }
        echo "<a href=\"modifPage.php?ID=$id\">"
                    . "<img class='imagePageModifier' src='images/edit.png' widht='20%' height='20%'>"
                . "</a>"
                ."<a href=\"deletePage.php?ID=$id&Rang=$rang\">"
                    . "<img class='imagePageSupprimer' src='images/corbeille.png' widht='20%' height='20%' align='right'/>"
                ."</a>"
            ."</div>";
    }     
?>
        </div>
            
    </body>
</html>


