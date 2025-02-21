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
include_once "$racine/modele/bd.utilisateur.inc.php";
include_once "$racine/csrf.php"; 

// Création du menu burger
$menuBurger = array();
$menuBurger[] = Array("url"=>"./?action=connexion","label"=>"Connexion");
$menuBurger[] = Array("url"=>"./?action=inscription","label"=>"Inscription");

$inscrit = false;
$msg = "";

// Récupération des données GET, POST et SESSION
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérification du jeton CSRF
    if (!isset($_POST["csrf_token"]) || !verifyCsrfToken($_POST["csrf_token"])) {
        die("Erreur : Jeton CSRF invalide ou manquant !");
    }

    // Vérifier si tous les champs sont renseignés
    if (isset($_POST["mailU"], $_POST["mdpU"], $_POST["pseudoU"]) && 
        $_POST["mailU"] !== "" && $_POST["mdpU"] !== "" && $_POST["pseudoU"] !== "") {
        
        $mailU = $_POST["mailU"];
        $mdpU = $_POST["mdpU"];
        $pseudoU = $_POST["pseudoU"];

        // Enregistrement des données
        $ret = addUtilisateur($mailU, $mdpU, $pseudoU);
        if ($ret) {
            $inscrit = true;
        } else {
            $msg = "L'utilisateur n'a pas été enregistré.";
        }
    } else {
        $msg = "Renseignez tous les champs...";
    }
}

if ($inscrit) {
    // Appel du script de vue qui permet de gérer l'affichage des données
    $titre = "Inscription confirmée";
    include "$racine/vue/entete.html.php";
    include "$racine/vue/vueConfirmationInscription.php";
    include "$racine/vue/pied.html.php";
} else {
    // Générer un nouveau jeton CSRF pour le formulaire
    $csrf_token = generateCsrfToken();

    // Appel du script de vue qui permet de gérer l'affichage des données
    $titre = "Inscription";
    include "$racine/vue/entete.html.php";
    include "$racine/vue/vueInscription.php";
    include "$racine/vue/pied.html.php";
}
?>
