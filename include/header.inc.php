<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="author" content="Abdoulaye Bamar Diagne" />
    <title><?=$title?></title>
    <nav>
            <a href="index.php?style=standard&lang=fr"><img src="images/fr.jpg" alt="Français"></a>
            <a href="index.php?style=standard&lang=en"><img src="images/en.jpg" alt="English"></a>
            <a href="index.php?style=dark&lang=<?= $lang ?>"><img src="images/day.jpg" alt="Mode Nuit"></a>
            
        </nav>

    <link rel="stylesheet" href="style/standard.css" />

    <style>
        .red{
            color: red;
            font-weight: bold;
        }

        .green{
            color: green;
            font-weight: bold;
        }

        .blue{
            color: blue;
            font-weight: bold;
        }
    </style>
     <header>
        
        
        <nav>
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="tech.php">TECH</a></li>
                <li><a href="meteo.php">TECH</a></li>
                
                
            </ul>
        </nav>
    </header>
</head>