<?php
require_once 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = trim($_POST['full_name']);
    $major = trim($_POST['major']);
    $reg_no = trim($_POST['reg_no']);
    $password = $_POST['password'];

    try {
        // 1. Check if the registration number already exists 
        $check_sql = "SELECT id FROM users WHERE registration_number = ?";
        $check_stmt = $pdo->prepare($check_sql);
        $check_stmt->execute([$reg_no]);

        if ($check_stmt->fetch()) {
            // If entry exists, tell the user instead of crashing 
            echo "<script>alert('Error: A user with this Registration Number already exists!'); window.history.back();</script>";
            exit();
        }

        // 2. If no duplicate, proceed with registration 
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (full_name, major, registration_number, password) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$full_name, $major, $reg_no, $hashed_password]);
        
        echo "<script>alert('Account created successfully!'); window.location='login.php';</script>";

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>