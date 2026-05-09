<?php
session_start();
require_once 'db_config.php';

// Get search and filter parameters
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$major = isset($_GET['major']) ? $_GET['major'] : '';
$semester = isset($_GET['semester']) ? $_GET['semester'] : '';

try {
    $query = "SELECT u.*, us.full_name FROM uploads u JOIN users us ON u.user_id = us.id WHERE 1=1";
    $params = [];

    if (!empty($search)) {
        $query .= " AND u.title LIKE ?";
        $params[] = "%$search%";
    }
    if (!empty($major)) {
        $query .= " AND u.major = ?";
        $params[] = $major;
    }
    if (!empty($semester)) {
        $query .= " AND u.semester = ?";
        $params[] = $semester;
    }

    $query .= " ORDER BY u.upload_date DESC";
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $results = $stmt->fetchAll();
} catch (PDOException $e) {
    $results = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search Files | SSALPU</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .search-area {
            background: var(--card-bg);
            padding: 30px;
            border-radius: 24px;
            border: 1px solid rgba(255,255,255,0.05);
            margin-bottom: 40px;
        }

        .filter-row {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            gap: 15px;
            margin-top: 15px;
        }

        .search-input-wrapper {
            position: relative;
        }

        .search-input-wrapper i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--accent);
        }

        .search-input-wrapper input {
            padding-left: 45px;
            margin-bottom: 0;
        }

        .filter-row select {
            margin-bottom: 0;
        }

        .result-card {
            background: var(--card-bg);
            border: 1px solid rgba(255,255,255,0.05);
            padding: 25px;
            border-radius: 20px;
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: 0.3s;
        }

        .result-card:hover {
            border-color: var(--accent);
        }

        .tag-group {
            display: flex;
            gap: 10px;
            margin-bottom: 8px;
        }

        .tag {
            font-size: 0.7rem;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 6px;
            text-transform: uppercase;
        }

        .tag-major { background: rgba(16, 185, 129, 0.1); color: var(--accent); }
        .tag-sem { background: rgba(255, 255, 255, 0.05); color: var(--text-gray); }

        .btn-get {
            background: var(--accent);
            color: #050a14;
            padding: 10px 20px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 700;
            font-size: 0.8rem;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="logo">SSALPU</div>
        <nav class="nav-menu">
            <a href="dashboard.php" class="nav-item">Home</a>
            <a href="explore.php" class="nav-item active">Search Files</a>
            <a href="browse.php" class="nav-item">Browse All</a>
            <a href="upload.php" class="nav-item">Upload Files</a>
            <a href="logout.php" class="nav-item logout">Logout</a>
        </nav>
    </div>

    <div class="content">
        <div class="page-header">
            <h1>Search <span>Files</span></h1>
            <p>Use filters to find specific study materials.</p>
        </div>

        <div class="search-area">
            <form action="explore.php" method="GET">
                <div class="search-input-wrapper">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" name="search" placeholder="Enter subject name..." value="<?php echo htmlspecialchars($search); ?>">
                </div>
                
                <div class="filter-row">
                    <select name="major">
                        <option value="">All Majors</option>
                        <option value="B.Tech CSE" <?php if($major=='B.Tech CSE') echo 'selected'; ?>>B.Tech CSE</option>
                        <option value="B.Tech ME" <?php if($major=='B.Tech ME') echo 'selected'; ?>>B.Tech ME</option>
                        <option value="MBA" <?php if($major=='MBA') echo 'selected'; ?>>MBA</option>
                    </select>

                    <select name="semester">
                        <option value="">All Semesters</option>
                        <?php for($i=1; $i<=8; $i++): ?>
                            <option value="<?php echo $i; ?>" <?php if($semester==$i) echo 'selected'; ?>>Sem <?php echo $i; ?></option>
                        <?php endfor; ?>
                    </select>

                    <button type="submit" class="primary-btn">Apply Filter</button>
                </div>
            </form>
        </div>

        <div class="results">
            <?php if (!empty($results)): ?>
                <?php foreach ($results as $res): ?>
                    <div class="result-card">
                        <div>
                            <div class="tag-group">
                                <span class="tag tag-major"><?php echo htmlspecialchars($res['major']); ?></span>
                                <span class="tag tag-sem">Semester <?php echo htmlspecialchars($res['semester']); ?></span>
                            </div>
                            <h4 style="margin:0;"><?php echo htmlspecialchars($res['title']); ?></h4>
                            <p style="margin:5px 0 0; color:var(--text-gray); font-size:0.85rem;">
                                Added by <?php echo htmlspecialchars($res['full_name']); ?>
                            </p>
                        </div>
                        <a href="<?php echo htmlspecialchars($res['file_path']); ?>" class="btn-get" download>GET FILE</a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="text-align:center; color:var(--text-gray); margin-top:50px;">No files match your search criteria.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
