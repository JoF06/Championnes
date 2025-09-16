<?php
session_start();

// Si pas connecté
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $date = $_POST["date"];
    $content = $_POST["content"];

    $thumbnailPath = "";

    // Gestion upload
    if (isset($_FILES["thumbnail"]) && $_FILES["thumbnail"]["error"] == 0) {
        $targetDir = "uploads/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true); // créer si inexistant
        }

        $fileName = time() . "_" . basename($_FILES["thumbnail"]["name"]);
        $targetFile = $targetDir . $fileName;

        if (move_uploaded_file($_FILES["thumbnail"]["tmp_name"], $targetFile)) {
            $thumbnailPath = $targetFile;
        }
    }

    $file = "articles.json";

    if (file_exists($file)) {
        $articles = json_decode(file_get_contents($file), true);
    } else {
        $articles = [];
    }

    $articles[] = [
        "title" => $title,
        "date" => $date,
        "thumbnail" => $thumbnailPath,
        "content" => $content
    ];

    file_put_contents($file, json_encode($articles, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

    header("Location: admin.php");
    exit;
}
?>
