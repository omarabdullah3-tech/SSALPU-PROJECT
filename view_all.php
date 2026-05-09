<?php
session_start();
require_once 'db_config.php';
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }

$sql = "SELECT r.*, u.full_name FROM resources r JOIN users u ON r.user_id = u.id ORDER BY r.uploaded_at DESC";
$resources = $pdo->query($sql)->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Library | sudaniShare</title>
    <!-- LINKING TO THE NEW DIFFERENT STYLE FILE -->
    <link rel="stylesheet" href="library_style.css">
</head>
<body>
    <nav>
        <div style="font-size: 1.6rem; font-weight: 700; color: var(--accent);">sudaniShare</div>
        <div class="nav-links">
            <a href="upload.php">Upload</a>
            <a href="view_all.php" class="active-link">Browse</a>
            <a href="search.php">Explore</a>
            <a href="logout.php">Sign Out</a>
        </div>
    </nav>
    <div class="container">
        <header style="margin-bottom: 40px;">
            <h1>Community Library</h1>
            <p style="color: var(--text-dim);">Materials shared by Sudanese students.</p>
        </header>
        <div class="resource-grid">
            <?php foreach ($resources as $res): ?>
                <div class="resource-card">
                    <div class="card-top">
                        <span class="badge"><?php echo htmlspecialchars($res['course_code']); ?></span>
                        <span style="font-size: 0.7rem; opacity: 0.6; text-transform: uppercase;"><?php echo htmlspecialchars($res['category']); ?></span>
                    </div>
                    
                    <h3 class="file-title"><?php echo htmlspecialchars($res['title']); ?></h3>
                    <p class="uploader">By <?php echo htmlspecialchars($res['full_name']); ?></p>
                    
                    <?php if(!empty($res['video_url'])): ?>
                        <a href="<?php echo htmlspecialchars($res['video_url']); ?>" target="_blank" class="video-btn">📺 Watch Tutorial</a>
                    <?php endif; ?>

                    <div class="btn-group">
                        <div class="view-btn" onclick="openPreview('<?php echo htmlspecialchars($res['file_path']); ?>')">👁️ View</div>
                        <a href="<?php echo htmlspecialchars($res['file_path']); ?>" download class="download-btn">📥 Download</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div id="previewModal" class="preview-modal">
        <span class="close-x" onclick="closeModal()">&times;</span>
        <div class="modal-content"><iframe id="previewIframe"></iframe></div>
    </div>
    <script>
        function openPreview(path) {
            const modal = document.getElementById('previewModal');
            const iframe = document.getElementById('previewIframe');
            const url = window.location.origin + '/' + path;
            iframe.src = `https://docs.google.com/gview?url=${encodeURIComponent(url)}&embedded=true`;
            modal.style.display = 'flex';
        }
        function closeModal() { document.getElementById('previewModal').style.display = 'none'; document.getElementById('previewIframe').src = ''; }
    </script>
</body>
</html>