<?php
require_once 'db_config.php';

if (isset($_GET['id']) && isset($_GET['file'])) {
    $id = $_GET['id'];
    $file = $_GET['file'];

    // Increment download count
    $stmt = $pdo->prepare("UPDATE resources SET download_count = download_count + 1 WHERE id = ?");
    $stmt->execute([$id]);

    // Redirect to the actual file
    header("Location: " . $file);
    exit();
}
?>