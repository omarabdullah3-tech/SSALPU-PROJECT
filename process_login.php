<?php
require_once 'db_config.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $identifier = trim($_POST['identifier']); // Trim to match database
    $password = $_POST['password'];

    try {
        $sql = "SELECT * FROM users WHERE registration_number = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$identifier]);
        $user = $stmt->fetch();

        if ($user) {
            // Check password
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['full_name'] = $user['full_name'];
                $_SESSION['major'] = $user['major'];

                header("Location: upload.php");
                exit();
            } else {
                // Password mismatch
                echo "<script>alert('Invalid Password'); window.location='login.php';</script>";
            }
        } else {
            // Reg number not found
            echo "<script>alert('Registration Number not found'); window.location='login.php';</script>";
        }
    } catch (PDOException $e) {
        echo "Login Error: " . $e->getMessage();
    }
}
?>