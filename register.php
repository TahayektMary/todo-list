<?php
require '../config/database.php';

$errors = [
    'nom' => '',
    'prenom' => '',
    'email' => '',
    'telephone' => '',
    'password' => '',
    'confirm_password' => '',
    'general' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = htmlspecialchars(trim($_POST['nom'] ?? ''));
    $prenom = htmlspecialchars(trim($_POST['prenom'] ?? ''));
    $email = htmlspecialchars(trim($_POST['email'] ?? ''));
    $telephone = htmlspecialchars(trim($_POST['telephone'] ?? ''));
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Validation des champs
    if (empty($nom)) {
        $errors['nom'] = "Le champ 'Nom' est requis.";
    }
    if (empty($prenom)) {
        $errors['prenom'] = "Le champ 'Prénom' est requis.";
    }
    if (empty($email)) {
        $errors['email'] = "Le champ 'Email' est requis.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "L'adresse email n'est pas valide.";
    }
    if (empty($telephone)) {
        $errors['telephone'] = "Le champ 'Téléphone' est requis.";
    } elseif (strlen($telephone) < 8) {
        $errors['telephone'] = "Le numéro de téléphone doit contenir au moins 8 chiffres.";
    }
    if (empty($password)) {
        $errors['password'] = "Le champ 'Mot de passe' est requis.";
    } elseif (!preg_match('/^(?=.*[A-Z])(?=.*\d).{8,}$/', $password)) {
        $errors['password'] = "Le mot de passe doit contenir au moins une lettre majuscule, un chiffre et être d'une longueur minimale de 8 caractères.";
    }
    
    if (empty($confirm_password)) {
        $errors['confirm_password'] = "Le champ 'Confirmation du mot de passe' est requis.";
    } elseif ($password !== $confirm_password) {
        $errors['confirm_password'] = "Les mots de passe ne correspondent pas.";
    }
    

    if (empty(array_filter($errors))) {
        try {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $query = $pdo->prepare("SELECT * FROM users WHERE email = :email");
            $query->execute(['email' => $email]);

            if ($query->rowCount() === 0) {
                $query = $pdo->prepare("INSERT INTO users (nom, prenom, email, telephone, password) VALUES (:nom, :prenom, :email, :telephone, :password)");
                $query->execute([
                    'nom' => $nom,
                    'prenom' => $prenom,
                    'email' => $email,
                    'telephone' => $telephone,
                    'password' => $hashed_password,
                ]);
                header('Location: ../auth/login.php');
                exit;
            } else {
                $errors['general'] = "Un compte avec cet email existe déjà.";
            }
        } catch (PDOException $e) {
            $errors['general'] = "Erreur lors de l'inscription : " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link rel="stylesheet" href="../style1.css">
    <style>
        .error-message {
            color: red;
            font-size: 0.9em;
            margin-top: 5px;
        }
        .error {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Inscription</h1>
        <?php if (!empty($errors['general'])): ?>
            <p class="error"><?= htmlspecialchars($errors['general']) ?></p>
        <?php endif; ?>
        <form method="POST">
            <div>
                <input type="text" name="nom" placeholder="Nom" value="<?= htmlspecialchars($nom ?? '') ?>">
                <?php if (!empty($errors['nom'])): ?>
                    <p class="error-message"><?= htmlspecialchars($errors['nom']) ?></p>
                <?php endif; ?>
            </div>
            <div>
                <input type="text" name="prenom" placeholder="Prénom" value="<?= htmlspecialchars($prenom ?? '') ?>">
                <?php if (!empty($errors['prenom'])): ?>
                    <p class="error-message"><?= htmlspecialchars($errors['prenom']) ?></p>
                <?php endif; ?>
            </div>
            <div>
                <input type="text" name="email" placeholder="Email" value="<?= htmlspecialchars($email ?? '') ?>">
                <?php if (!empty($errors['email'])): ?>
                    <p class="error-message"><?= htmlspecialchars($errors['email']) ?></p>
                <?php endif; ?>
            </div>
            <div>
                <input type="text" name="telephone" placeholder="Téléphone" value="<?= htmlspecialchars($telephone ?? '') ?>">
                <?php if (!empty($errors['telephone'])): ?>
                    <p class="error-message"><?= htmlspecialchars($errors['telephone']) ?></p>
                <?php endif; ?>
            </div>
            <div>
                <input type="password" name="password" placeholder="Mot de passe">
                <?php if (!empty($errors['password'])): ?>
                    <p class="error-message"><?= htmlspecialchars($errors['password']) ?></p>
                <?php endif; ?>
            </div>
            <div>
                <input type="password" name="confirm_password" placeholder="Confirmez le mot de passe">
                <?php if (!empty($errors['confirm_password'])): ?>
                    <p class="error-message"><?= htmlspecialchars($errors['confirm_password']) ?></p>
                <?php endif; ?>
            </div>
            <button type="submit">S'inscrire</button>
        </form>
        <p>Vous avez déjà un compte ? <a href="login.php">Connectez-vous</a></p>
    </div>
</body>
</html>
