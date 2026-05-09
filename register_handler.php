<?php
require_once 'db_config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = trim($_POST['full_name']);
    $reg_no    = trim($_POST['registration_number']);
    $email     = trim($_POST['email']);
    $major     = trim($_POST['major']);
    $study_lvl = isset($_POST['study_level']) ? $_POST['study_level'] : 'Junior';
    $password  = $_POST['password'];
    
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    try {
        $sql = "INSERT INTO users (full_name, registration_number, email, major, study_level, password, is_admin) VALUES (?, ?, ?, ?, ?, ?, 0)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$full_name, $reg_no, $email, $major, $study_lvl, $hashed_password]);

        header("Location: login.php?success=1");
        exit();

    } catch (PDOException $e) {
        die("Database Error: " . $e->getMessage());
    }
}
?>