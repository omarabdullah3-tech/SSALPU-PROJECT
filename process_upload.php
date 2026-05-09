<?php
session_start();
require_once 'db_config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $course_code = strtoupper(trim($_POST['course_code']));
    $title = trim($_POST['title']);
    $category = $_POST['category'];
    $video_url = trim($_POST['video_url']);
    $user_id = $_SESSION['user_id'];
    
    $target_dir = "uploads/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $file_name = time() . "_" . basename($_FILES["resource_file"]["name"]);
    $target_file = $target_dir . $file_name;

    if (move_uploaded_file($_FILES["resource_file"]["tmp_name"], $target_file)) {
        try {
            $sql = "INSERT INTO resources (user_id, course_code, title, category, file_path, video_url) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$user_id, $course_code, $title, $category, $target_file, $video_url]);
            
            header("Location: upload.php?status=success");
            exit();
        } catch (PDOException $e) {
            die("Database Error: " . $e->getMessage());
        }
    } else {
        die("Upload Failed.");
    }
}
?>