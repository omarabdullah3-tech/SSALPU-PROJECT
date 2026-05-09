<?php
session_start();
require_once 'db_config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$full_name = $_SESSION['full_name'] ?? 'Student';

// Logic for Universal Campus Activities
$activities = [
    [
        'title' => 'Software Workshop',
        'desc' => 'Learn the basics of PHP and MySQL for your semester projects.',
        'date' => 'May 14, 2026',
        'time' => '2:00 PM',
        'loc' => 'Lab 3, IT Block',
        'type' => 'Academic',
        'icon' => 'fa-code'
    ],
    [
        'title' => 'Football Championship',
        'desc' => 'The annual inter-department cup final match.',
        'date' => 'May 16, 2026',
        'time' => '5:00 PM',
        'loc' => 'University Field',
        'type' => 'Sports',
        'icon' => 'fa-futbol'
    ],
    [
        'title' => 'Sudan Day Trip',
        'desc' => 'Community outing to the local park for BBQ and networking.',
        'date' => 'May 22, 2026',
        'time' => '9:00 AM',
        'loc' => 'Meeting Point A',
        'type' => 'Social',
        'icon' => 'fa-bus'
    ],
    [
        'title' => 'Volunteer Call',
        'desc' => 'Looking for 5 students to help organize the upcoming graduation ceremony.',
        'date' => 'Ongoing',
        'time' => 'Anytime',
        'loc' => 'Admin Office',
        'type' => 'Volunteering',
        'icon' => 'fa-hands-helping'
    ]
];

// Fetch stats
try {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM uploads WHERE user_id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $my_uploads = $stmt->fetchColumn();
} catch (PDOException $e) { $my_uploads = 0; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home | SSALPU</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .activity-feed {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 25px;
            margin-top: 30px;
        }
        
        .activity-card {
            background: var(--card-bg);
            border-radius: 24px;
            padding: 30px;
            border: 1px solid rgba(255,255,255,0.05);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .activity-card:hover {
            border-color: var(--accent);
            transform: translateY(-8px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.3);
        }

        .card-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .activity-type-pill {
            font-size: 0.65rem;
            font-weight: 800;
            text-transform: uppercase;
            padding: 5px 12px;
            border-radius: 50px;
            background: rgba(16, 185, 129, 0.1);
            color: var(--accent);
            letter-spacing: 0.5px;
        }

        .icon-box {
            width: 45px;
            height: 45px;
            background: rgba(255,255,255,0.03);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--accent);
            font-size: 1.2rem;
        }

        .activity-body h4 {
            margin: 10px 0 8px;
            font-size: 1.2rem;
            color: var(--text-white);
        }

        .activity-body p {
            color: var(--text-gray);
            font-size: 0.9rem;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .activity-footer {
            margin-top: auto;
            padding-top: 20px;
            border-top: 1px solid rgba(255,255,255,0.05);
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .info-tag {
            font-size: 0.8rem;
            color: var(--text-gray);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .info-tag i { color: var(--accent); width: 14px; }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="logo">SSALPU</div>
        <nav class="nav-menu">
            <a href="dashboard.php" class="nav-item active">Home</a>
            <a href="explore.php" class="nav-item">Search Files</a>
            <a href="browse.php" class="nav-item">Browse All</a>
            <a href="upload.php" class="nav-item">Upload Files</a>
            <a href="logout.php" class="nav-item logout">Logout</a>
        </nav>
    </div>

    <div class="content">
        <div class="page-header">
            <h1>Welcome, <span><?php echo htmlspecialchars($full_name); ?></span></h1>
            <p>Your portal for files, academic news, and campus life.</p>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 50px;">
            <div class="card">
                <p style="color:var(--text-gray); margin:0;">Total Contributions</p>
                <h2 style="color:var(--accent); margin:10px 0 0;"><?php echo $my_uploads; ?> Files</h2>
            </div>
            <div class="card">
                <p style="color:var(--text-gray); margin:0;">Network Status</p>
                <h2 style="color:var(--accent); margin:10px 0 0;">Active</h2>
            </div>
        </div>

        <h3 style="margin-bottom: 25px; font-weight: 700;">Upcoming Activities</h3>

        <div class="activity-feed">
            <?php foreach ($activities as $act): ?>
                <div class="activity-card">
                    <div class="card-top">
                        <div class="icon-box">
                            <i class="fa-solid <?php echo $act['icon']; ?>"></i>
                        </div>
                        <span class="activity-type-pill"><?php echo $act['type']; ?></span>
                    </div>
                    
                    <div class="activity-body">
                        <h4><?php echo htmlspecialchars($act['title']); ?></h4>
                        <p><?php echo htmlspecialchars($act['desc']); ?></p>
                    </div>
                    
                    <div class="activity-footer">
                        <div class="info-tag"><i class="fa-regular fa-calendar"></i> <?php echo $act['date']; ?></div>
                        <div class="info-tag"><i class="fa-regular fa-clock"></i> <?php echo $act['time']; ?></div>
                        <div class="info-tag" style="grid-column: span 2;"><i class="fa-solid fa-location-dot"></i> <?php echo $act['loc']; ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
