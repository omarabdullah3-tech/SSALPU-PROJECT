<!-- header.php - Integrated with SSALPU branding -->
<?php if(!isset($_SESSION)) { session_start(); } ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title : 'SSALPU'; ?></title>
    <link rel="stylesheet" href="main_style.css">
</head>
<body>
    <header class="main-header">
        <a href="search.php" class="logo-link">
            S<div class="sudan-flag-icon">
                <div class="flag-red"></div>
                <div class="flag-white"></div>
                <div class="flag-black"></div>
                <div class="flag-triangle"></div>
            </div>SALPU
        </a>
        
        <nav class="nav-links">
            <a href="search.php">Home</a>
            <a href="upload.php" class="<?php echo ($current_page == 'upload') ? 'active' : ''; ?>">Upload</a>
            <a href="view_all.php" class="<?php echo ($current_page == 'browse') ? 'active' : ''; ?>">Browse</a>
            <a href="profile.php" class="<?php echo ($current_page == 'profile') ? 'active' : ''; ?>">Profile</a>
            <a href="logout.php" class="sign-out">Sign Out</a>
        </nav>
    </header>
