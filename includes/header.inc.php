<?php
declare(strict_types = 1);

$classe1="";
$classe2="";
$classe3="";
if($title =="Carte interactive - Point Météo") $classe1 ="active";
if($title =="Prévisions Météorologiques - Point Météo") $classe2 ="active";
if($title =="Statistiques - Point Météo") $classe3 ="active";
// Sélection du style (mode jour/nuit)
    $style = 'style.css';
    $url = 'standard';
  
    if(!empty($_GET['style']) && $_GET['style'] === 'standard'){ 
        $style = 'style_alternatif.css';
        $url = 'alternatif';
    }
?>

<!DOCTYPE html>
    <html lang="fr">
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta name="description" content="<?= $description ?>"/>
            <meta name="author" content="Dinga Madi" />
            <meta name="author" content="Diagne Abdoulaye" />

            <!-- <script src="js/script.js"></script> -->
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
            <link rel="icon" href="image/logo.png" type="image/x-icon" /> <!--  faut changer l'icon -->
            <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous"> -->

            <!-- <link rel="stylesheet" href="css/style.css"> -->
            <link rel="stylesheet" href="css/<?= $style ?>"/>
                <title> <?= $title ?> </title>
    
        </head>
        <body>
            <header>
                <div class="container header-container">
                    <div class="logo">
                        <a href="index.php"><img src="./image/Picture1.png" alt="le logo du site"/></a>
                        <h1>Point Météo</h1>
                    </div>
                    <nav>
                        <ul>
                            <li><a href="carte.php" class="<?= $classe1 ?>">Carte</a></li>
                            <li><a href="prevision.php" class="<?= $classe2 ?>">Prévisions</a></li>
                            <li><a href="statistics.php" class="<?= $classe3 ?>">Statistiques</a></li>
                        </ul>
                    </nav>
                    <div class="controls">
                        <div class="language-selector">
                            <button id="language-btn">
                                <i class="fas fa-globe"></i>
                            </button>
                            <div class="language-dropdown">
                                <a href="?lang=fr" <?php echo ($_GET['lang'] ?? 'fr') === 'fr' ? 'class="active"' : ''; ?>>Français</a>
                                <a href="?lang=en" <?php echo ($_GET['lang'] ?? 'fr') === 'en' ? 'class="active"' : ''; ?>>English</a>
                            </div>
                        </div>
                        <button id="theme-toggle">
                            <a href="index.php?style=<?=$url?>">
                                <img src="./image/dark_icon.png" alt=" mode jour/nuit">
                            </a>
                        </button>
                    </div>
                </div>
            </header>