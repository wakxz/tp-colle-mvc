<?php
// Protection contre le ClickJacking
header("X-Frame-Options: SAMEORIGIN"); // Permet l'inclusion uniquement depuis le même domaine
header("Content-Security-Policy: frame-ancestors 'self';"); // Directive moderne pour les navigateurs récents
header("Content-Security-Policy: default-src 'self'; style-src 'self' 'unsafe-inline';");
header("Content-Security-Policy: default-src 'self'; img-src 'self' data:; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; font-src 'self' https://fonts.gstatic.com; script-src 'self';");

?>

<?php
if ( $_SERVER["SCRIPT_FILENAME"] == __FILE__ ){
    $racine="..";
}
include_once "$racine/modele/bd.resto.inc.php";
include_once "$racine/modele/bd.typecuisine.inc.php";
include_once "$racine/modele/bd.photo.inc.php";

// Récupération des données GET, POST, et SESSION
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérification du jeton CSRF
    if (!isset($_POST['csrf_token']) || !verifyCsrfToken($_POST['csrf_token'])) {
        die("Erreur : Jeton CSRF invalide ou manquant !");
    }

// creation du menu burger
$menuBurger = array();
$menuBurger[] = Array("url"=>"./?action=recherche&critere=nom","label"=>"Recherche par nom");
$menuBurger[] = Array("url"=>"./?action=recherche&critere=adresse","label"=>"Recherche par adresse");

// critere de recherche par defaut
$critere = "nom";
if (isset($_GET["critere"])) {
    $critere = $_GET["critere"];
}

// recuperation des donnees GET, POST, et SESSION
if (isset($_GET["critere"])){
    $critere = $_GET["critere"];
}
$nomR="";
if (isset($_POST["nomR"])){
    $nomR = $_POST["nomR"];
}
$voieAdrR="";
if (isset($_POST["voieAdrR"])){
    $voieAdrR = $_POST["voieAdrR"];
}
$cpR="";
if (isset($_POST["cpR"])){
    $cpR = $_POST["cpR"];
}
$villeR="";
if (isset($_POST["villeR"])){
    $villeR = $_POST["villeR"];
}
$tabIdTC = array();
if(isset($_POST["tabIdTC"])){
    $tabIdTC = $_POST["tabIdTC"];
}


// appel des fonctions permettant de recuperer les donnees utiles a l'affichage 


switch($critere){
    case 'nom':
        // recherche par nom
        $listeRestos = getRestosByNomR($nomR);
        break;
    case 'adresse':
        // recherche par adresse
        $listeRestos = getRestosByAdresse($voieAdrR, $cpR, $villeR);
        break;
    
}


// traitement si necessaire des donnees recuperees
;

// appel du script de vue qui permet de gerer l'affichage des donnees
$titre = "Recherche d'un restaurant";
include "$racine/vue/entete.html.php";
include "$racine/vue/vueRechercheResto.php";
if (!empty($_POST)) {
    // affichage des resultats de la recherche
    include "$racine/vue/vueResultRecherche.php";
}
include "$racine/vue/pied.html.php";


?>