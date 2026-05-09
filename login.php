<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login | SSALPU</title>
    <link rel="stylesheet" href="auth_style.css">
</head>
<body>
    <div class="logo-header">
        S<div class="sudan-flag-icon">
            <div class="flag-red"></div>
            <div class="flag-white"></div>
            <div class="flag-black"></div>
            <div class="flag-triangle"></div>
        </div>SALPU
    </div>
    <div class="auth-card">
        <h2>Welcome Back</h2>
        <form action="login_handler.php" method="POST">
            <div class="form-group">
                <label>Your Name</label>
                <input type="text" name="username" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" class="submit-btn">Sign In</button>
        </form>
    </div>
</body>
</html>