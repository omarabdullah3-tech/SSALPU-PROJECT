<?php
session_start();
require_once 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE full_name = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id']   = $user['id'];
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['is_admin']  = $user['is_admin'];
            header("Location: search.php");
            exit();
        } else {
            header("Location: login.php?error=1");
            exit();
        }
    } catch (PDOException $e) {
        die("System Failure: " . $e->getMessage());
    }
}
?>