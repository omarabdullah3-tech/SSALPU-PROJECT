<?php
session_start();
require_once 'db_config.php';

if (!isset($_SESSION['user_id']) || !isset($_POST['id'])) {
    exit('Unauthorized');
}

$user_id = $_SESSION['user_id'];
$res_id = $_POST['id'];

try {
    // Check if already liked
    $check = $pdo->prepare("SELECT id FROM resource_likes WHERE user_id = ? AND resource_id = ?");
    $check->execute([$user_id, $res_id]);
    
    if (!$check->fetch()) {
        // Add like to tracking table
        $pdo->prepare("INSERT INTO resource_likes (user_id, resource_id) VALUES (?, ?)")->execute([$user_id, $res_id]);
        // Update count in resources table
        $pdo->prepare("UPDATE resources SET likes = likes + 1 WHERE id = ?")->execute([$res_id]);
        echo "liked";
    } else {
        // Unlike
        $pdo->prepare("DELETE FROM resource_likes WHERE user_id = ? AND resource_id = ?")->execute([$user_id, $res_id]);
        $pdo->prepare("UPDATE resources SET likes = likes - 1 WHERE id = ?")->execute([$res_id]);
        echo "unliked";
    }
} catch (PDOException $e) {
    exit('error');
}
?>