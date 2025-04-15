<?php
require '../config/database.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (!empty($email) && !empty($password)) {
        $query = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $query->execute(['email' => $email]);
        $user = $query->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            header('Location: ../index.php');
            exit;
        } else {
            $error = "Email ou mot de passe incorrect.";
        }
    } else {
        $error = "Veuillez remplir tous les champs.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="../style1.css">
</head>
<body>
    <div class="container">
        <h1>Connexion</h1>
        <?php if (!empty($error)): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <form method="POST">
            <div>
                <input 
                    type="email" 
                    name="email" 
                    placeholder="Email" 
                    value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" 
                    class="<?= empty($email) && !empty($error) ? 'error-border' : '' ?>"
                >
                <?php if (empty($email) && !empty($error)): ?>
                    <p class="error-message">Le champ 'Email' est requis.</p>
                <?php endif; ?>
            </div>
            <div>
                <input 
                    type="password" 
                    name="password" 
                    placeholder="Mot de passe" 
                    class="<?= empty($password) && !empty($error) ? 'error-border' : '' ?>"
                >
                <?php if (empty($password) && !empty($error)): ?>
                    <p class="error-message">Le champ 'Mot de passe' est requis.</p>
                <?php endif; ?>
            </div>
            <button type="submit">Se connecter</button>
        </form>
        <p>Pas encore de compte ? <a href="register.php">Inscrivez-vous</a></p>
    </div>
</body>
</html>
