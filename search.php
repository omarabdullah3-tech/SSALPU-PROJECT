<?php
session_start();
require_once 'db_config.php';
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }

$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$major = isset($_GET['major']) ? $_GET['major'] : '';
$category = isset($_GET['category']) ? $_GET['category'] : '';

$sql = "SELECT r.*, u.full_name, u.major FROM resources r JOIN users u ON r.user_id = u.id WHERE 1=1";
$params = [];

if ($search !== '') { 
    $sql .= " AND (r.course_code LIKE ? OR r.title LIKE ?)"; 
    $params[] = "%$search%"; 
    $params[] = "%$search%"; 
}
if ($major !== '') { $sql .= " AND u.major = ?"; $params[] = $major; }
if ($category !== '') { $sql .= " AND r.category = ?"; $params[] = $category; }

$sql .= " ORDER BY r.uploaded_at DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$results = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Discovery Hub | sudaniShare</title>
    <link rel="stylesheet" href="explore_style.css">
</head>
<body>
    <nav>
        <div style="font-size: 1.6rem; font-weight: 700; color: var(--accent);">sudaniShare</div>
        <div class="nav-links">
            <a href="upload.php">Upload</a>
            <a href="view_all.php">Browse</a>
            <a href="search.php" class="active-link">Explore</a>
            <a href="profile.php">Profile</a>
        </div>
    </nav>

    <div class="container">
        <div style="text-align:center; padding: 60px 0 10px;">
            <h1 style="font-size: 3rem; margin-bottom: 0;">Discovery Hub</h1>
            <p style="color:#94a3b8;">Find community resources with precision filters.</p>
        </div>

        <form action="search.php" method="GET" class="filter-hub">
            <input type="text" name="search" placeholder="Search course or topic..." value="<?php echo htmlspecialchars($search); ?>">
            
            <select name="major">
                <option value="">All Majors</option>
                <option value="Computer Science" <?php if($major == 'Computer Science') echo 'selected'; ?>>CS</option>
                <option value="Information Technology" <?php if($major == 'Information Technology') echo 'selected'; ?>>IT</option>
                <option value="Mechanical Engineering" <?php if($major == 'Mechanical Engineering') echo 'selected'; ?>>Mech</option>
            </select>

            <select name="category">
                <option value="">All Types</option>
                <option value="Presentation" <?php if($category == 'Presentation') echo 'selected'; ?>>PPTs</option>
                <option value="Paper" <?php if($category == 'Paper') echo 'selected'; ?>>Papers</option>
                <option value="Notes" <?php if($category == 'Notes') echo 'selected'; ?>>Notes</option>
            </select>

            <button type="submit">Filter</button>
        </form>

        <div class="resource-grid">
            <?php foreach ($results as $res): ?>
                <div class="resource-card">
                    <span class="badge"><?php echo htmlspecialchars($res['course_code']); ?></span>
                    <h2 class="file-title"><?php echo htmlspecialchars($res['title']); ?></h2>
                    <p class="uploader">By <span style="color:var(--accent);"><?php echo htmlspecialchars($res['full_name']); ?></span> (<?php echo htmlspecialchars($res['major']); ?>)</p>
                    <a href="<?php echo htmlspecialchars($res['file_path']); ?>" download class="action-btn">📥 Download Resource</a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>