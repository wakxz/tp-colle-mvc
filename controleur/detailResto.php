<?php
// Protection contre le ClickJacking
header("X-Frame-Options: SAMEORIGIN"); // Permet l'inclusion uniquement depuis le même domaine
header("Content-Security-Policy: frame-ancestors 'self';"); // Directive moderne pour les navigateurs récents
header("Content-Security-Policy: default-src 'self'; style-src 'self' 'unsafe-inline';");
header("Content-Security-Policy: default-src 'self'; img-src 'self' data:; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; font-src 'self' https://fonts.gstatic.com; script-src 'self';");

?>

<?php

if ($_SERVER["SCRIPT_FILENAME"] == __FILE__) {
    $racine = "..";
}
include_once "$racine/modele/bd.resto.inc.php";
include_once "$racine/modele/bd.typecuisine.inc.php";
include_once "$racine/modele/bd.photo.inc.php";
include_once "$racine/modele/bd.critiquer.inc.php";
include_once "$racine/modele/bd.aimer.inc.php";
include_once "$racine/modele/authentification.inc.php";

// creation du menu burger
$menuBurger = array();
$menuBurger[] = Array("url"=>"#top","label"=>"Le restaurant");
$menuBurger[] = Array("url"=>"#adresse","label"=>"Adresse");
$menuBurger[] = Array("url"=>"#photos","label"=>"Photos");
$menuBurger[] = Array("url"=>"#horaires","label"=>"Horaires");
$menuBurger[] = Array("url"=>"#crit","label"=>"Critiques");

// recuperation des donnees GET, POST, et SESSION
$idR = $_GET["idR"];

// appel des fonctions permettant de recuperer les donnees utiles a l'affichage 
$unResto = getRestoByIdR($idR);

$lesTypesCuisine = getTypesCuisineByIdR($idR);
$lesPhotos = getPhotosByIdR($idR);
$noteMoy = round(getNoteMoyenneByIdR($idR), 0);
$mailU = getMailULoggedOn();
$aimer = getAimerById($mailU, $idR);
$critiques = getCritiquerByIdR($idR);


// appel du script de vue qui permet de gerer l'affichage des donnees
$titre = "detail d'un restaurant";
include "$racine/vue/entete.html.php";
include "$racine/vue/vueDetailResto.php";
include "$racine/vue/pied.html.php";
?>