<?php
session_start();
require_once 'db_config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_name = trim($_POST['new_name']);
    
    // Handle Profile Picture Upload
    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['profile_pic']['name'];
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        
        if (in_array($ext, $allowed)) {
            // Create uploads folder if it doesn't exist
            if (!is_dir('uploads/avatars')) {
                mkdir('uploads/avatars', 0777, true);
            }
            
            $new_filename = "avatar_" . $user_id . "." . $ext;
            $upload_path = 'uploads/avatars/' . $new_filename;
            
            if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $upload_path)) {
                // Update database with image path
                $sql = "UPDATE users SET profile_pic = ?, full_name = ? WHERE id = ?";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$upload_path, $new_name, $user_id]);
            }
        }
    } else {
        // Just update the name if no file was uploaded
        $sql = "UPDATE users SET full_name = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$new_name, $user_id]);
    }
    
    // Update session name
    $_SESSION['full_name'] = $new_name;
    
    header("Location: profile.php?success=updated");
    exit();
}
?>