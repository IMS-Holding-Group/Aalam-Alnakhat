<?php
session_start();
require_once '../database.php';

if (!isset($_SESSION['user_id']) || $_SESSION['username'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

$id = $_GET['id'] ?? 0;

if ($id) {
    try {
        $stmt = $pdo->prepare("DELETE FROM dishes WHERE id = ?");
        $stmt->execute([$id]);
    } catch (PDOException $e) {
    }
}

header('Location: index.php');
exit;
?>

