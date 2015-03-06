<?php
    session_start();
    if (!isset($_SESSION['admin']) || $_SESSION['admin'] == false) {
        header('location:index.php');
    }
?>

<html>
    <head>
        <title>Modification Bonbon</title>
        <link rel="stylesheet" href="css.css" />
        <meta charset="UTF-8">
        <script type="text/javascript" src="monJS.js"></script>
    </head>
    <body bgcolor="#D8E1DF" >
        <div id="entete">
            <div id="titreEntete"><p><a href="format.php" >Joe's Candy</a></p></div>
            <div id='linkAdminBonbon'><p><a href='toolBonbon.php'>Page admin bonbon</a></p></div>
            <div id='linkAdminPage'><p><a href='toolPage.php'>Page admin page</a></p></div>
            <div id="deconnect">
                <p><a href="disconnect.php" >Se déconnecter</a></p>
            </div>
        </div>



<?php
    $Reference = $_GET['Reference'];
    require 'params.php';
    mysql_connect($host, $user, $password) or die('Erreur de connexion au SGBD.');
    mysql_select_db($base) or die('La base de données n\'existe pas');
    $query = "SELECT * from bonbons WHERE Reference=$Reference";
    $r = mysql_query($query);
    if ($a = mysql_fetch_object($r)) {
        $reference = $a->Reference;
        $nom = $a->Nom;
        $prix = $a->Prix;
        $desc = $a->Descriptif;
        $promo = $a->Promotion;
        $gout = $a->Gout;
        $couleur = $a->Couleur;
        $lien = $a->Lien;
    }
    mysql_close();
?>
        <div id="ajout" >    
            <h2><p align="center">Modifier</p></h2>
            <form action="updateBonbon.php" method="post" enctype="multipart/form-data" align="left">
                <input type="hidden"  name="Reference"  value="<?php echo $reference; ?>">
                <div class="ajoutnomPage">NOM : <input  name="Nom" type="text" class="labelPage" value="<?php echo utf8_encode($nom); ?>"/></div>
                <div class="ajoutnomPage">PRIX : <input  name="Prix" type="text" class="labelPage" value="<?php echo $prix; ?>"/></div>
                <div class="ajoutnomPage">PROMOTION : <input  name="Promotion" type="text" class="labelPage" value="<?php echo $promo; ?>"/></div>
                <div class="ajoutnomPage">
                    GOUT :
                    <select name="ChoixGout" class="labelPage">
                       <option selected="selected" value="<?php echo $gout; ?>"><?php echo $gout; ?></option>
                        <option value="Acide">Acide</option>
                        <option value="Doux">Doux</option>
                        <option value="Extreme">Extrème</option>
                        <option value="Fruite">Fruité</option>
                     </select>
                </div>
                <div class="ajoutnomPage">
                    COULEUR :
                    <select name="ChoixCouleur" class="labelPage">
                       <option selected="selected" value="<?php echo $couleur; ?>"><?php echo $couleur; ?></option>
                        <option value="Rouge">Rouge</option>
                        <option value="Vert">Vert</option>
                        <option value="Bleu">Bleu</option>
                        <option value="Jaune">Jaune</option>
                        <option value="Mutli-couleurs">Mutli-couleurs</option>
                     </select>
                </div>
                <div class="ajoutnomPage">DESCRIPTIF : 
                    <textarea name="Descriptif" type="text" class="labelPage" rows="3" cols="20">
                        <?php echo utf8_encode($desc); ?>
                    </textarea>
                </div>
                <br/><br/><br/>
                <div class="ajoutnomPage">IMAGE:</div>      
                <div class="file" align="center">
                   <div><?php echo "<img src='$lien' width='200px'/>" ?></div>
                   <input type="hidden"  name="Lien"  value="<?php echo $lien; ?>">
                    <input type="file" name="Image" class="choiximage" /><br/><br/>
                    <input type="submit" value="Modifier" class="btnajout" /><br/>
                </div>
            </form> 
        </div>
    </body>
</html>
