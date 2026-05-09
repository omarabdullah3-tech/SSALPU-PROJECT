<?php
session_start();
include 'db_config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'] ?? 'User';
$role = $_SESSION['role'] ?? 'user'; 

// Logic for Admin to post announcement
if ($role === 'admin' && isset($_POST['post_announcement'])) {
    $title = mysqli_real_escape_string($conn, $_POST['ann_title']);
    $msg = mysqli_real_escape_string($conn, $_POST['ann_msg']);
    mysqli_query($conn, "INSERT INTO announcements (title, message) VALUES ('$title', '$msg')");
    header("Location: dashboard.php"); // Refresh to show
    exit();
}

// Logic for Admin to delete announcement
if ($role === 'admin' && isset($_GET['delete_ann'])) {
    $ann_id = intval($_GET['delete_ann']);
    mysqli_query($conn, "UPDATE announcements SET status = 'deleted' WHERE id = $ann_id");
    header("Location: dashboard.php");
    exit();
}

// Fetch stats
$stmt = $conn->prepare("SELECT COUNT(*) as total FROM uploads WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$total_uploads = $stmt->get_result()->fetch_assoc()['total'] ?? 0;

// Fetch latest active announcement
$ann_res = mysqli_query($conn, "SELECT * FROM announcements WHERE status = 'active' ORDER BY id DESC LIMIT 1");
$latest_ann = mysqli_fetch_assoc($ann_res);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | SSALPU</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <?php include 'sidebar_component.php'; ?>
    <div class="content">
        <div class="page-header">
            <h1>Welcome, <span><?php echo htmlspecialchars($username); ?></span></h1>
            <p>Your academic hub and community updates.</p>
        </div>

        <!-- ANNOUNCEMENT SECTION -->
        <?php if ($latest_ann): ?>
        <div class="card" style="border-left: 5px solid var(--accent); background: rgba(16, 185, 129, 0.05); margin-bottom: 25px; position: relative;">
            <?php if ($role === 'admin'): ?>
                <a href="dashboard.php?delete_ann=<?php echo $latest_ann['id']; ?>" 
                   onclick="return confirm('Are you sure you want to remove this announcement?')"
                   style="position: absolute; top: 15px; right: 20px; color: #ef4444; text-decoration: none; font-size: 0.9rem;">
                   <i class="fa-solid fa-trash-can"></i> Delete
                </a>
            <?php endif; ?>
            <h2 style="color: var(--accent); font-size: 1.1rem;"><i class="fa-solid fa-bullhorn"></i> Community Announcement</h2>
            <h3 style="margin: 10px 0; font-size: 1.3rem;"><?php echo htmlspecialchars($latest_ann['title']); ?></h3>
            <p style="color: var(--text-gray); line-height: 1.6;"><?php echo nl2br(htmlspecialchars($latest_ann['message'])); ?></p>
            <small style="display:block; margin-top:10px; color: #64748b;"><?php echo date('F j, Y', strtotime($latest_ann['created_at'])); ?></small>
        </div>
        <?php endif; ?>

        <!-- ADMIN POST PANEL -->
        <?php if ($role === 'admin'): ?>
        <div class="card" style="margin-bottom: 25px; border: 1px dashed var(--accent);">
            <h2 style="font-size: 1.1rem; margin-bottom: 15px;">Post New Announcement</h2>
            <form method="POST">
                <div class="form-group">
                    <input type="text" name="ann_title" placeholder="Announcement Title" required style="width: 100%; margin-bottom: 10px;">
                    <textarea name="ann_msg" placeholder="Write your message..." required style="width: 100%; height: 80px; background: var(--bg-card); border: 1px solid #334155; border-radius: 8px; color: white; padding: 10px;"></textarea>
                </div>
                <button type="submit" name="post_announcement" class="primary-btn" style="margin-top: 10px; padding: 8px 20px;">Broadcast to All</button>
            </form>
        </div>
        <?php endif; ?>

        <div class="stats-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px;">
            <div class="card stat-card">
                <i class="fa-solid fa-upload" style="color: var(--accent); font-size: 1.5rem;"></i>
                <div><h3><?php echo $total_uploads; ?></h3><p>Total Uploads</p></div>
            </div>
        </div>
    </div>
</body>
</html>