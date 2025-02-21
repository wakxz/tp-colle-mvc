<?php


function startSessionIfNeeded() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

function generateCsrfToken() {
    startSessionIfNeeded();
    $token = bin2hex(random_bytes(32)); // Génère un jeton aléatoire sécurisé
    $_SESSION['csrf_token'] = $token;  // Stocke le jeton dans la session
    return $token;
}

function verifyCsrfToken($token) {
    startSessionIfNeeded();
    // Vérifie si le jeton existe dans la session et correspond au jeton soumis
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

function clearCsrfToken() {
    startSessionIfNeeded();
    unset($_SESSION['csrf_token']); // Supprime le jeton de la session
}
?>
