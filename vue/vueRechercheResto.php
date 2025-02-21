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


<h1>Recherche d'un restaurant</h1>
<form action="./?action=recherche&critere=<?= htmlspecialchars($critere); ?>" method="POST">

    <!-- Champ caché pour le jeton CSRF -->
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token); ?>">

    <?php
    switch ($critere) {
        case "nom":
            ?>
            Recherche par nom : <br />
            <input type="text" name="nomR" placeholder="nom" value="<?= htmlspecialchars($nomR); ?>" /><br />
            <?php
            break;
        case "adresse":
            ?>
            Recherche par adresse : <br />
            <input type="text" name="villeR" placeholder="ville" value="<?= htmlspecialchars($villeR); ?>"/><br />
            <input type="text" name="cpR" placeholder="code postal" value="<?= htmlspecialchars($cpR); ?>"/><br />
            <input type="text" name="voieAdrR" placeholder="rue" value="<?= htmlspecialchars($voieAdrR); ?>"/><br />
            <?php
            break;
    }
    ?>
    <br /><br />
    <input type="submit" value="Rechercher" />

</form>
