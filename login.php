<?php
session_start();

// Si déjà connecté → redirige vers admin
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("Location: admin.php");
    exit;
}

// Vérification du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // 🔒 Identifiants (à modifier)
    $valid_user = "president";
    $valid_pass = "Echecsadmin";

    if ($username === $valid_user && $password === $valid_pass) {
        $_SESSION['loggedin'] = true;
        header("Location: admin.php");
        exit;
    } else {
        $error = "Identifiants incorrects.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Connexion - Administration</title>
  <style>
    body { font-family: Arial, sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; background: #f4f4f4; }
    form { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.2); }
    input { display: block; width: 100%; padding: 10px; margin-bottom: 15px; font-size: 1em; }
    button { background: #866d7d; color: white; border: none; padding: 10px; cursor: pointer; width: 100%; }
    button:hover { background: #5d4a58; }
    .error { color: red; margin-bottom: 10px; }
  </style>
</head>
<body>
  <form method="post" action="">
    <h2>Connexion</h2>
    <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>
    <input type="text" name="username" placeholder="Identifiant" required>
    <input type="password" name="password" placeholder="Mot de passe" required>
    <button type="submit">Se connecter</button>
  </form>
</body>
</html>
