<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"><title>Edit Profile | SSALPU</title>
    <link rel="stylesheet" href="auth_style.css?v=12">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { display: flex; margin: 0; min-height: 100vh; background: #050a14; color: white; }
        .main-content { flex: 1; margin-left: 280px; padding: 60px; box-sizing: border-box; }
        .glass-card { background: rgba(15, 23, 42, 0.8); backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 24px; padding: 35px; }
        input, select { width: 100%; background: rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.1); padding: 14px; border-radius: 12px; color: white; margin-top: 8px; box-sizing: border-box; }
        .submit-btn { background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: #064e3b; border: none; padding: 16px; border-radius: 12px; font-weight: 800; cursor: pointer; width: 100%; margin-top: 20px; }
    </style>
</head>
<body>
    <aside class="sidebar">
        <div class="sidebar-logo">
            <div class="sudan-flag-icon"><div class="flag-red"></div><div class="flag-white"></div><div class="flag-black"></div><div class="flag-triangle"></div></div>
            <div class="logo-text">SSALPU</div>
        </div>
        <nav class="menu-group">
            <a href="dashboard.php" class="menu-item "><i class="fa-solid fa-house"></i> Dashboard</a>
            <a href="profile.php" class="menu-item active"><i class="fa-solid fa-circle-user"></i> Profile Page</a>
            <a href="explore.php" class="menu-item "><i class="fa-solid fa-compass"></i> Explore</a>
            <a href="browse.php" class="menu-item "><i class="fa-solid fa-folder-open"></i> Browse Files</a>
            <a href="upload.php" class="menu-item "><i class="fa-solid fa-cloud-arrow-up"></i> Upload</a>
            <div style="margin-top: auto;">
                <a href="logout.php" class="menu-item" style="color: #ef4444;"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
            </div>
        </nav>
    </aside>
<main class="main-content">
<h1>Edit Profile</h1>
<p style="color:var(--text-dim);">Update your personal details and avatar.</p>
<div class="glass-card" style="margin-top: 30px; max-width: 600px;">
    <form action="profile_handler.php" method="POST" enctype="multipart/form-data">
        <div class="form-group" style="text-align: center; margin-bottom: 30px;">
            <label style="display: block; margin-bottom: 15px;">Profile Picture</label>
            <input type="file" name="profile_pic" style="width: auto; border: none; background: transparent;">
        </div>
        <div class="form-group">
            <label>Display Name</label>
            <input type="text" name="new_name" value="omar">
        </div>
        <div class="form-group" style="margin-top: 20px;">
            <label>Major</label>
            <input type="text" value="B.Tech CSE" readonly style="opacity: 0.6;">
        </div>
        <button type="submit" class="submit-btn">Save Changes</button>
    </form>
</div>
</main></body></html>