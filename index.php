<?php
declare(strict_types= 1);
    
$style = isset($_GET['style']) ? $_GET['style'] : 'style';
$lang = isset($_GET['lang']) ? $_GET['lang'] : 'fr';


if ($lang === 'en') {
    include 'english.inc.php';
} else {
    include 'french.inc.php';
}

$title="Accueil";
require "include/header.inc.php";
require "include/function.inc.php";



?>
<body>
    <h1>Page Tech - APIs JSON & XML</h1>
</body>

<?php
require "include/footer.inc.php";
?>