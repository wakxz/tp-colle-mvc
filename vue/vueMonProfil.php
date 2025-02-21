<?php
// Protection contre le ClickJacking
header("X-Frame-Options: SAMEORIGIN"); // Permet l'inclusion uniquement depuis le même domaine
header("Content-Security-Policy: frame-ancestors 'self';"); // Directive moderne pour les navigateurs récents
header("Content-Security-Policy: default-src 'self'; style-src 'self' 'unsafe-inline';");
header("Content-Security-Policy: default-src 'self'; img-src 'self' data:; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; font-src 'self' https://fonts.gstatic.com; script-src 'self';");

?>

<?php
header("Content-Security-Policy: default-src 'self'; img-src 'self' data:; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; font-src 'self' https://fonts.gstatic.com; script-src 'self';");
?>
<h1>Mon profil</h1>

Mon adresse électronique : <?= $util["mailU"] ?> <br />
Mon pseudo : <?= $util["pseudoU"] ?> <br />

<hr>

les restaurants que j'aime : <br />
<?php for($i=0;$i<count($mesRestosAimes);$i++){ ?>
    <a href="./?action=detail&idR=<?= $mesRestosAimes[$i]["idR"] ?>"><?= $mesRestosAimes[$i]["nomR"] ?></a><br />
<?php } ?>
<hr>
les types de cuisine que j'aime : 
<ul id="tagFood">		
<?php for($i=0;$i<count($mesTypeCuisineAimes);$i++){ ?>
    <li class="tag"><span class="tag">#</span><?= $mesTypeCuisineAimes[$i]["libelleTC"] ?></li>
<?php } ?>
</ul>
<hr>
<a href="./?action=deconnexion">se deconnecter</a>


