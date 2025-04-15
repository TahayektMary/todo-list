<?php
session_start();
require '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task_name = isset($_POST['task_name']) ? trim($_POST['task_name']) : '';
    $list_id = isset($_POST['list_id']) ? $_POST['list_id'] : '';
    if (!empty($task_name) && !empty($list_id)) {
        $query = $pdo->prepare("INSERT INTO tasks (titre, list_id) VALUES (:titre, :list_id)");

        try {
            $query->execute(['titre' => $task_name, 'list_id' => $list_id]);
        } catch (PDOException $e) {
            die("Erreur lors de l'insertion de la tâche : " . $e->getMessage());
        }
    } else {
        die("Le nom de la tâche ou l'ID de la liste n'est pas défini.");
    }
}
header('Location: ../index.php');
exit;
?>
