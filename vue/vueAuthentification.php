<?php
// Protection contre le ClickJacking
header("X-Frame-Options: SAMEORIGIN"); // Permet l'inclusion uniquement depuis le même domaine
header("Content-Security-Policy: frame-ancestors 'self';"); // Directive moderne pour les navigateurs récents
header("Content-Security-Policy: default-src 'self'; style-src 'self' 'unsafe-inline';");
header("Content-Security-Policy: default-src 'self'; img-src 'self' data:; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; font-src 'self' https://fonts.gstatic.com; script-src 'self';");

?>

<?php
include_once "$racine/csrf.php";
$csrf_token = generateCsrfToken();
?>

<h1>Connexion</h1>
<form action="./?action=connexion" method="POST">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token); ?>">

    <input type="text" name="mailU" placeholder="Email de connexion" /><br />
    <input type="password" name="mdpU" placeholder="Mot de passe"  /><br />
    <input type="submit" />

</form>
<br />
<a href="./?action=inscription">Inscription</a>

<hr>
Utilisateur de test : <br />
login : test@bts.sio<br />
mot de passe : sio

