<?php
session_start();
include 'db_config.php'; 

// Check if $conn is defined to prevent Fatal Error
if (!isset($conn)) {
    die("Database connection variable '$conn' not found. Check db_config.php");
}

$query = "SELECT * FROM uploads WHERE status = 'active' ORDER BY id DESC";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query Failed: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Browse All | SSALPU</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'sidebar_component.php'; ?>
    <div class="content">
        <div class="page-header">
            <h1>Browse <span>All Files</span></h1>
            <p>View the latest study materials shared by the community.</p>
        </div>
        
        <div class="results-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px;">
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <div class="card">
                        <div class="tag-group">
                            <span class="tag tag-major"><?php echo htmlspecialchars($row['major']); ?></span>
                            <span class="tag tag-sem">Sem <?php echo htmlspecialchars($row['semester']); ?></span>
                        </div>
                        <h3 style="margin: 10px 0;"><?php echo htmlspecialchars($row['title']); ?></h3>
                        <p style="color: var(--text-gray); font-size: 0.9rem; margin-bottom: 20px;">Added by User ID: <?php echo $row['user_id']; ?></p>
                        <a href="download.php?file_id=<?php echo $row['id']; ?>" class="primary-btn">Get File</a>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="card" style="grid-column: 1 / -1; text-align: center; padding: 50px;">
                    <i class="fa-solid fa-folder-open" style="font-size: 3rem; color: var(--text-gray); margin-bottom: 15px;"></i>
                    <p>No files have been uploaded yet. Be the first to share!</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>