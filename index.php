<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: auth/login.php'); 
    exit;
}

require 'config/database.php';
if (!isset($pdo)) {
    die("Erreur : La connexion à la base de données n'est pas initialisée.");
}

$user_id = $_SESSION['user_id'];

// kantaakdo wach les chekbox done awla lae
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['toggle_done'], $_POST['task_id'])) {
    $task_id = $_POST['task_id'];
    $is_done = isset($_POST['is_done']) ? 1 : 0;
    
    try {
        $stmt = $pdo->prepare("UPDATE tasks SET is_done = :is_done WHERE id = :id");
        $stmt->execute([
            'is_done' => $is_done,
            'id' => $task_id
        ]);
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    } catch (PDOException $e) {
        die("Erreur lors de la mise à jour de l'état de la tâche : " . $e->getMessage());
    }
}
try {
    $query = $pdo->prepare("SELECT * FROM lists WHERE user_id = :user_id");
    $query->execute(['user_id' => $user_id]);
    $lists = $query->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur lors de la récupération des listes : " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="container">
        <h1>Mes Listes de Tâches</h1>
        <form action="lists/add.php" method="POST" class="add-form">
            <input type="text" name="list_name" placeholder="Nouvelle liste" required>
            <button type="submit" title="Ajouter Liste"><i class="fas fa-plus-circle"></i></button>
        </form>

         <?php foreach ($lists as $list): ?> <!-- kajiblna chaque list recuperer we affiche contenu dyala -->
            <div class="list">
                 <!-- form dyal modification dyal liste -->
                <form action="lists/update.php" method="POST" class="update-form">
                    <input type="text" name="list_id" value="<?= htmlspecialchars($list['id']) ?>">
                    <input type="text" name="list_name" value="<?= htmlspecialchars($list['titre']) ?>" required>
                    <button type="submit" class="update-list-btn" title="Modifier Liste"><i class="fas fa-edit"></i></button>
                </form>

                <p>Créé le : <?= htmlspecialchars(date('d/m/Y H:i', strtotime($list['date_creation']))) ?></p>
                <form action="tasks/add.php" method="POST" class="add-form">
                    <input type="hidden" name="list_id" value="<?= htmlspecialchars($list['id']) ?>">
                    <input type="text" name="task_name" placeholder="Nouvelle tâche" required>
                    <button type="submit" title="Ajouter Tâche"><i class="fas fa-plus-circle"></i></button>
                </form>
                <!-- lien pour supprimer une liste -->
                <a href="lists/delete.php?id=<?= htmlspecialchars($list['id']) ?>" class="delete-list-btn" title="Supprimer Liste">  
                    <i class="fas fa-trash-alt"></i>
                </a>

                <ul class="task-list">
                    <!-- recuperation de tache associee a une liste donne -->
                    <?php
                    try {
                        $query = $pdo->prepare("SELECT * FROM tasks WHERE list_id = :list_id");
                        $query->execute(['list_id' => $list['id']]);
                        $tasks = $query->fetchAll(PDO::FETCH_ASSOC);
                    } catch (PDOException $e) {
                        die("Erreur lors de la récupération des tâches : " . $e->getMessage());
                    }
                    ?>
                    <?php foreach ($tasks as $task): ?>
                        <li>
                            <!-- form pour maequer une tache terminee ou nom  -->
                            <form method="POST" style="display:inline;">
                                <input type="text" name="task_id" value="<?= htmlspecialchars($task['id']) ?>">
                                <input type="hidden" name="toggle_done" value="1">
                                <input type="checkbox" name="is_done" onchange="this.form.submit()" <?= $task['is_done'] ? 'checked' : '' ?>>
                            </form>

                            <!--  form modification dyal les tache -->
                            <form action="tasks/update.php" method="POST" class="update-form" style="display:inline;">
                                <input type="hidden" name="task_id" value="<?= htmlspecialchars($task['id']) ?>">
                                <input type="text" name="task_name" value="<?= htmlspecialchars($task['titre']) ?>"
                                       <?= $task['is_done'] ? 'style="text-decoration: line-through; color: gray;"' : '' ?> required>
                                <button type="submit" class="update-task-btn" title="Modifier Tâche"><i class="fas fa-edit"></i></button>
                            </form>

                            <!-- form dyal delete tache -->
                            <form action="tasks/delete.php" method="POST" style="display:inline;">
                                <input type="hidden" name="task_id" value="<?= htmlspecialchars($task['id']) ?>">
                                <button type="submit" class="delete-task-btn" title="Supprimer Tâche"><i class="fas fa-trash-alt"></i></button>
                            </form>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endforeach; ?>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
