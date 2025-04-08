<?php
declare(strict_types = 1);
// Sélection du style (mode jour/nuit)
    $style = 'styles.css';
    $url = 'standard';
  
    if(!empty($_GET['style']) && $_GET['style'] === 'standard'){ 
        $style = 'style_alternatif.css';
        $url = 'alternatif';
    }

    $title ='Point Météo  - Prévisions Météorologiques';
    $description ='';
?>

<!DOCTYPE html>
<html lang="<?= $lang === 'english.inc.php' ? 'en' : 'fr' ?>">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<meta name="description" content="<?= $description ?>"/>
		<meta name="author" content="Dinga Madi" />
        <meta name="author" content="Abdoulaye ---" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link rel="icon" href="image/logo.png" type="image/x-icon" /> <!--  faut changer l'icon -->

		<link rel="stylesheet" href="css/<?= $style ?>"/>
        <title> <?= $title ?> </title>




<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="css/style.css">
    
</head>
<body class="<?php echo isset($_COOKIE['theme']) ? $_COOKIE['theme'] : 'light'; ?>">
    <header>
        <div class="container header-container">
            <div class="logo">
				<a href="index.php"><img src="./image/Picture1.png" alt="le logo du site"/></a>
                <h1>Point Météo</h1>
            </div>
            <nav>
                <ul>
                    <li><a href="accueil.php" class="active">Accueil</a></li>
                    <li><a href="prevision.php">Prévisions</a></li>
                    <li><a href="statistics.php">Statistiques</a></li>
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
                    <!-- <i class="fas fa-sun light-icon"></i> -->
                    <a href="index.php?style=<?=$url?>">
                        <img src="./image/dark_icon.png" alt=" mode jour/nuit">
                    </a>
                    <!-- <i class="fas fa-moon dark-icon"></i> -->
                </button>
            </div>
        </div>
    </header>