<?php
session_start();

// Vérifier que l’admin est connecté
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

$file = "articles.json";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["index"])) {
    $index = (int) $_POST["index"];

    if (file_exists($file)) {
        $articles = json_decode(file_get_contents($file), true);

        if (isset($articles[$index])) {
            // Supprimer l'article
            unset($articles[$index]);

            // Réindexer le tableau (sinon les clés sautent)
            $articles = array_values($articles);

            // Sauvegarder
            file_put_contents($file, json_encode($articles, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        }
    }
}

// Retour à l’admin
header("Location: admin.php");
exit;
?>
