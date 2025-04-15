<?php
declare(strict_types = 1);

// Initialisation des classes de navigation
$classe1 = $classe2 = $classe3 = "";
if ($title === "Carte interactive - Point Météo") $classe1 = "active";
if ($title === "Prévisions Météorologiques - Point Météo") $classe2 = "active";
if ($title === "Statistiques - Point Météo") $classe3 = "active";

// Gestion du style
$style = 'style.css';
$currentStyle = $_GET['style'] ?? 'jour';

if ($currentStyle === 'alternatif') {
    $style = 'style_alternatif.css';
    $nextStyle = 'jour';
    $styleIcon = './image/light_icon.png'; // Icône pour revenir au jour
} else {
    $nextStyle = 'alternatif';
    $styleIcon = './image/dark_icon.png'; // Icône pour passer en nuit
}

// Construction de l’URL pour changer de style tout en gardant les autres paramètres
$params = $_GET;
$params['style'] = $nextStyle;
$switchStyleUrl = $_SERVER['PHP_SELF'] . '?' . http_build_query($params);

// Langue actuelle
$lang = $_GET['lang'] ?? 'fr';
?>

<!DOCTYPE html>
<html lang="<?= htmlspecialchars($lang) ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= htmlspecialchars($description ?? '') ?>"/>
    <meta name="author" content="Dinga Madi, Abdoulaye ---" />
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" href="image/logo.png" type="image/x-icon" />
    <link rel="stylesheet" href="css/<?= $style ?>"/>
    
    <title><?= htmlspecialchars($title ?? 'Point Météo') ?></title>
</head>
<body>
    <header>
        <div class="container header-container">
            <div class="logo">
                <a href="index.php"><img src="./image/Picture1.png" alt="logo du site"/></a>
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
                        <?php
                        $baseParams = $_GET;
                        $baseParams['lang'] = 'fr';
                        echo '<a href="?' . http_build_query($baseParams) . '" ' . ($lang === 'fr' ? 'class="active"' : '') . '>Français</a>';

                        $baseParams['lang'] = 'en';
                        echo '<a href="?' . http_build_query($baseParams) . '" ' . ($lang === 'en' ? 'class="active"' : '') . '>English</a>';
                        ?>
                    </div>
                </div>

                <!-- Bouton de changement de thème -->
                <a href="<?= $switchStyleUrl ?>" id="theme-toggle">
                    <img src="<?= $styleIcon ?>" alt="Changer le thème jour/nuit">
                </a>
            </div>
        </div>
    </header>
