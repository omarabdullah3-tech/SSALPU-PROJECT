<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8"><title>Profile</title><link rel="stylesheet" href="style.css"></head>
<body>
    
    <div class="sidebar">
        <div class="logo-section"><div class="logo-text">SSALPU</div></div>
        <nav class="nav-menu">
            <a href="dashboard.php" class="nav-item ">Home</a>
            <a href="upload.php" class="nav-item ">Upload</a>
            <a href="browse.php" class="nav-item ">Browse</a>
            <a href="explore.php" class="nav-item ">Explore</a>
            <a href="profile.php" class="nav-item active">Profile</a>
            <a href="logout.php" class="nav-item logout">Logout</a>
        </nav>
    </div>
    <div class="main-content">
        <h1 class="page-title">My <span>Identity</span></h1>
        <p style="color: var(--text-dim); margin-bottom: 40px;">Manage your personal student details.</p>
        
<div class="stat-card" style="max-width: 500px;">
    <div style="display:flex; gap:20px; align-items:center;">
        <div style="width:80px; height:80px; background:var(--accent-emerald); border-radius:50%;"></div>
        <div><h2 style="margin:0;">Omar Asf</h2><p style="color:var(--text-dim); margin:0;">B.Tech CSE - 3rd Year</p></div>
    </div>
    <hr style="border:0; border-top:1px solid rgba(255,255,255,0.05); margin:20px 0;">
    <button class="btn" style="width:100%;">Edit Profile Details</button>
</div>

    </div>
</body>
</html>