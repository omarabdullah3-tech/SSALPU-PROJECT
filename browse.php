<?php
session_start();
require_once 'db_config.php';

// Fetch the most recent uploads from the database
try {
    $stmt = $pdo->query("
        SELECT u.title, u.file_path, u.category, u.upload_date, us.full_name 
        FROM uploads u 
        JOIN users us ON u.user_id = us.id 
        ORDER BY u.upload_date DESC 
        LIMIT 20
    ");
    $recent_files = $stmt->fetchAll();
} catch (PDOException $e) {
    $recent_files = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Browse All | SSALPU</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .file-list {
            margin-top: 30px;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .file-card {
            background: var(--card-bg);
            border: 1px solid rgba(255,255,255,0.05);
            padding: 20px 30px;
            border-radius: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: 0.3s;
        }

        .file-card:hover {
            border-color: var(--accent);
            transform: translateX(5px);
        }

        .file-info h4 {
            margin: 0;
            font-size: 1.1rem;
            color: var(--text-white);
        }

        .file-info p {
            margin: 5px 0 0;
            font-size: 0.85rem;
            color: var(--text-gray);
        }

        .category-badge {
            font-size: 0.7rem;
            background: rgba(16, 185, 129, 0.1);
            color: var(--accent);
            padding: 4px 10px;
            border-radius: 6px;
            text-transform: uppercase;
            font-weight: 700;
            margin-bottom: 8px;
            display: inline-block;
        }

        .download-btn {
            background: transparent;
            color: var(--accent);
            border: 1px solid var(--accent);
            padding: 10px 20px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 700;
            font-size: 0.85rem;
            transition: 0.3s;
        }

        .download-btn:hover {
            background: var(--accent);
            color: #050a14;
        }

        .empty-state {
            text-align: center;
            padding: 50px;
            color: var(--text-gray);
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="logo">SSALPU</div>
        <nav class="nav-menu">
            <a href="dashboard.php" class="nav-item">Home</a>
            <a href="explore.php" class="nav-item">Search Files</a>
            <a href="browse.php" class="nav-item active">Browse All</a>
            <a href="upload.php" class="nav-item">Upload Files</a>
            <a href="logout.php" class="nav-item logout">Logout</a>
        </nav>
    </div>

    <div class="content">
        <div class="page-header">
            <h1>Browse <span>All Files</span></h1>
            <p>View the latest study materials shared by the community.</p>
        </div>

        <div class="file-list">
            <?php if (!empty($recent_files)): ?>
                <?php foreach ($recent_files as $file): ?>
                    <div class="file-card">
                        <div class="file-info">
                            <span class="category-badge"><?php echo htmlspecialchars($file['category']); ?></span>
                            <h4><?php echo htmlspecialchars($file['title']); ?></h4>
                            <p>
                                <i class="fa-regular fa-user"></i> <?php echo htmlspecialchars($file['full_name']); ?> • 
                                <i class="fa-regular fa-calendar"></i> <?php echo date('d M Y', strtotime($file['upload_date'])); ?>
                            </p>
                        </div>
                        <a href="<?php echo htmlspecialchars($file['file_path']); ?>" class="download-btn" download>
                            <i class="fa-solid fa-download"></i> DOWNLOAD
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="card empty-state">
                    <i class="fa-solid fa-folder-open" style="font-size: 3rem; margin-bottom: 15px;"></i>
                    <p>No files have been uploaded yet. Be the first to share!</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
