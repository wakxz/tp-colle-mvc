<?php

include_once "bd.inc.php";

function getCritiquerByIdR($idR) {
    $resultat = array();

    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("SELECT * FROM critiquer WHERE idR=:idR");
        $req->bindValue(':idR', $idR, PDO::PARAM_INT);
        
        $req->execute();

        while ($ligne = $req->fetch(PDO::FETCH_ASSOC)) {
            $resultat[] = $ligne;
        }
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
    return $resultat;
}

function getNoteMoyenneByIdR($idR) {
    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("SELECT AVG(note) as moyenne FROM critiquer WHERE idR=:idR");
        $req->bindValue(':idR', $idR, PDO::PARAM_INT);
        
        $req->execute();

        $resultat = $req->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
    return ($resultat && $resultat["moyenne"] !== null) ? $resultat["moyenne"] : 0;
}

/**
 * Ajoute une critique avec une note pour un élément donné.
 * @param int $idR L'identifiant de l'élément critiqué.
 * @param string $commentaire Le commentaire laissé par l'utilisateur.
 * @param int $note La note attribuée (supposée être entre 0 et 5).
 * @return bool Indique si l'insertion a réussi.
 */
function ajouterCritique($idR, $commentaire, $note) {
    try {
        $cnx = connexionPDO();
        $req = $cnx->prepare("INSERT INTO critiquer (idR, commentaire, note) VALUES (:idR, :commentaire, :note)");
        $req->bindValue(':idR', $idR, PDO::PARAM_INT);
        $req->bindValue(':commentaire', $commentaire, PDO::PARAM_STR);
        $req->bindValue(':note', $note, PDO::PARAM_INT);
        
        return $req->execute();
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        return false;
    }
}

// Test du programme
if ($_SERVER["SCRIPT_FILENAME"] == __FILE__) {
    header('Content-Type:text/plain');

    echo "\n getCritiquerByIdR(1) : \n";
    print_r(getCritiquerByIdR(1));

    echo "\n getNoteMoyenneByIdR(1) : \n";
    print_r(getNoteMoyenneByIdR(1));

    echo "\n Ajouter une critique : \n";
    if (ajouterCritique(1, "Très bon restaurant, service rapide.", 5)) {
        echo "Critique ajoutée avec succès !\n";
    } else {
        echo "Erreur lors de l'ajout de la critique.\n";
    }

    echo "\n getCritiquerByIdR(1) après ajout : \n";
    print_r(getCritiquerByIdR(1));

    echo "\n getNoteMoyenneByIdR(1) après ajout : \n";
    print_r(getNoteMoyenneByIdR(1));
}
?>
