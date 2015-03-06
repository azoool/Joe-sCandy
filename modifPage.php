<?php
session_start();
if (!isset($_SESSION['admin']) || $_SESSION['admin'] == false)
    header('location:index.php');
?>

<html>
    <head>
        <title>Modification Page</title>
        <link rel="stylesheet" href="css.css" />
        <meta charset="UTF-8">
        <script type="text/javascript" src="monJS.js"></script>
    </head>
    <body bgcolor="#D8E1DF"  onload="gererFormat()">
        <div id="entete">
            <div id="titreEntete"><p><a href="format.php" >Joe's Candy</a></p></div>
            <div id='linkAdminBonbon'><p><a href='toolBonbon.php'>Page admin bonbon</a></p></div>
            <div id='linkAdminPage'><p><a href='toolPage.php'>Page admin page</a></p></div>
            <div id="deconnect">
                <p><a href="disconnect.php" >Se déconnecter</a></p>
            </div>
        </div>

    <?php
    $id = $_GET['ID'];
    require 'params.php';
    mysql_connect($host, $user, $password) or die('Erreur de connexion au SGBD.');
    mysql_select_db($base) or die('La base de données n\'existe pas');
    $query = "SELECT * from pages WHERE ID=$id";
    $r = mysql_query($query);
    if ($a = mysql_fetch_object($r)) {
        $id = $a->ID;
        $rang = $a->Rang;
        $titre = $a->Titre;
        $format = $a->Format;
        $HTML1 = $a->HTML1;
        $image1 = $a->Image1;
        $HTML2 = $a->HTML2;
        $image2 = $a->Image2;
    }
    mysql_close();
    ?>
        <div id="ajout" > 
            <h2 align="center">Modification</h2>
            <form action="updatePage.php" method="post" enctype="multipart/form-data">
                <div class="ajoutnomPage">
                    Format : 
                    <select id="choixFormat" name="choixFormat" class="labelPage" onChange="gererFormat()">
                        <option selected="selected" value="<?php echo $format; ?>"><?php echo $format; ?></option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                    </select>
                </div>
                <div class="ajoutnomPage">Titre : <input class="labelPage" name="titre" type="text" value="<?php echo utf8_encode($titre); ?>" class="label"/></div>
                
                <div id="format1">
                    <div class="ajoutnomPage">HTML 1 : <textarea class="labelPage" name="HTML1" rows="3" cols="20"  class="label"><?php echo utf8_encode($HTML1); ?></textarea></div>
                    <br/>
                    <div class="ajoutnomPage">Image 1 :</div>
                    <div class="file" align="center">
                        <div><?php echo "<img src='$image1' width='150px'/>" ?></div>
                        <input type="file" name="image1" class="choiximage" /><br/><br/>
                    </div> 
                </div>
                <div id="format2">
                    <div class="ajoutnomPage">HTML 2 : <textarea class="labelPage" name="HTML2" rows="3" cols="20"  class="label"><?php echo utf8_encode($HTML2); ?></textarea></div>
                    <br/>
                    <div class="ajoutnomPage">Image 2 :</div>
                    <div class="file" align="center">
                        <div><?php echo "<img src='$image2' width='150px'/>" ?></div>
                        <input type="file" name="image2" class="choiximage" /><br/><br/>
                    </div> 
                </div>
                <div align="center"><input type="submit" value="Modifier" align="center"/></div>
                <input type="hidden" name="ID" value="<?php echo $id; ?>" />
                <input type="hidden"  name="Lien1"  value="<?php echo $image1; ?>">
                <input type="hidden"  name="Lien2"  value="<?php echo $image2; ?>">
                
            </form>
        </div>
    </body>
</html>

