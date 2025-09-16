<?php
session_start();

// Si pas connecté → renvoie vers login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Administration - Ajouter un article</title>
  <style>
    body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 20px; }
    form { background: white; padding: 20px; border-radius: 10px; max-width: 600px; margin: auto; box-shadow: 0 4px 10px rgba(0,0,0,0.2); }
    input, textarea { width: 100%; padding: 10px; margin-bottom: 15px; font-size: 1em; }
    button { background: #866d7d; color: white; border: none; padding: 12px; cursor: pointer; }
    button:hover { background: #5d4a58; }
  </style>
</head>
<body>
  <h2>Ajouter un article</h2>
  <form action="save_article.php" method="post" enctype="multipart/form-data">
  <input type="text" name="title" placeholder="Titre de l'article" required>
  <input type="date" name="date" required>
  
  <label for="thumbnail">Miniature :</label>
  <input type="file" name="thumbnail" accept="image/*"><br><br>
  
  <textarea name="content" rows="6" placeholder="Contenu de l'article" required></textarea>
  <button type="submit">Publier</button>
</form>
<?php
// Charger les articles existants
$articles = [];
if (file_exists("articles.json")) {
    $articles = json_decode(file_get_contents("articles.json"), true);
}
?>

<h2>Articles existants</h2>
<ul>
  <?php foreach ($articles as $index => $article): ?>
    <li>
      <strong><?= htmlspecialchars($article["title"]) ?></strong> 
      (<?= htmlspecialchars($article["date"]) ?>)
      <form action="delete_article.php" method="post" style="display:inline;">
        <input type="hidden" name="index" value="<?= $index ?>">
        <button type="submit" onclick="return confirm('Supprimer cet article ?');">Supprimer</button>
      </form>
    </li>
  <?php endforeach; ?>
</ul>

</body>
</html>
