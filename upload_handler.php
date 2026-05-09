<?php
session_start();
require_once 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = trim($_POST['title']);
    $url = trim($_POST['url']);
    $user_id = $_SESSION['user_id'];
    
    $target_dir = "uploads/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $file_path = "";
    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
        $file_name = time() . "_" . basename($_FILES["file"]["name"]);
        $file_path = $target_dir . $file_name;
        move_uploaded_file($_FILES["file"]["tmp_name"], $file_path);
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO uploads (title, file_path, youtube_url, user_id) VALUES (?, ?, ?, ?)");
        $stmt->execute([$title, $file_path, $url, $user_id]);
        header("Location: browse.php?status=uploaded");
        exit();
    } catch (PDOException $e) {
        die("Upload Error: " . $e->getMessage());
    }
}
?>