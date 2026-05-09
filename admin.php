<?php
session_start();
require_once 'db_config.php';

// Security: Check if user is logged in AND is an admin
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }

$stmt = $pdo->prepare("SELECT is_admin FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

if (!$user || $user['is_admin'] != 1) {
    die("<h1 style='color:white; background:#050a14; height:100vh; display:flex; align-items:center; justify-content:center;'>Access Denied: Admin Clearance Required</h1>");
}

// Handle File Deletion
if (isset($_POST['delete_id'])) {
    $id = $_POST['delete_id'];
    // Get file path to delete from server storage
    $stmt = $pdo->prepare("SELECT file_path FROM resources WHERE id = ?");
    $stmt->execute([$id]);
    $file = $stmt->fetch();
    
    if ($file && file_exists($file['file_path'])) {
        unlink($file['file_path']);
    }
    
    $pdo->prepare("DELETE FROM resources WHERE id = ?")->execute([$id]);
    $msg = "Resource purged successfully.";
}

// Fetch all resources for management
$resources = $pdo->query("SELECT r.*, u.full_name FROM resources r JOIN users u ON r.user_id = u.id ORDER BY r.uploaded_at DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Terminal | sudaniShare</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .admin-table { width: 100%; border-collapse: collapse; margin-top: 30px; background: var(--glass); border-radius: 20px; overflow: hidden; }
        .admin-table th, .admin-table td { padding: 20px; text-align: left; border-bottom: 1px solid var(--glass-border); }
        .admin-table th { background: rgba(255,255,255,0.05); color: var(--accent); text-transform: uppercase; font-size: 0.8rem; }
        .delete-btn { background: #ff4444; color: white; border: none; padding: 8px 15px; border-radius: 8px; cursor: pointer; transition: 0.3s; }
        .delete-btn:hover { background: #cc0000; box-shadow: 0 0 15px rgba(255,68,68,0.4); }
        .stats-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 40px; }
        .stat-card { background: var(--glass); padding: 30px; border-radius: 20px; border: 1px solid var(--glass-border); text-align: center; }
    </style>
</head>
<body>
    <nav>
        <div style="font-size: 1.6rem; font-weight: 700; color: var(--accent);">sudaniShare Admin</div>
        <div class="nav-links">
            <a href="view_all.php">Live Site</a>
            <a href="logout.php">Logout</a>
        </div>
    </nav>

    <div class="container">
        <h1>System Management</h1>
        
        <div class="stats-grid">
            <div class="stat-card"><h3>Total Files</h3><p style="font-size: 2rem; color: var(--accent);"><?php echo count($resources); ?></p></div>
            <div class="stat-card"><h3>Global Downloads</h3><p style="font-size: 2rem; color: var(--accent);"><?php echo array_sum(array_column($resources, 'download_count')); ?></p></div>
            <div class="stat-card"><h3>Global Likes</h3><p style="font-size: 2rem; color: var(--accent);"><?php echo array_sum(array_column($resources, 'likes')); ?></p></div>
        </div>

        <table class="admin-table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Uploader</th>
                    <th>Date</th>
                    <th>Stats</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($resources as $res): ?>
                <tr>
                    <td><strong><?php echo htmlspecialchars($res['title']); ?></strong><br><small><?php echo htmlspecialchars($res['course_code']); ?></small></td>
                    <td><?php echo htmlspecialchars($res['full_name']); ?></td>
                    <td><?php echo date('M j, Y', strtotime($res['uploaded_at'])); ?></td>
                    <td>❤️ <?php echo $res['likes']; ?> | 📥 <?php echo $res['download_count']; ?></td>
                    <td>
                        <form method="POST" onsubmit="return confirm('Permanently delete this file?');">
                            <input type="hidden" name="delete_id" value="<?php echo $res['id']; ?>">
                            <button type="submit" class="delete-btn">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>