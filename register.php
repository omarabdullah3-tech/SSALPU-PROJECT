<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Join | SSALPU</title>
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
        <h2>Join the Network</h2>
        <form action="register_handler.php" method="POST">
            <div class="form-group">
                <label>Your Name</label>
                <input type="text" name="full_name" required>
            </div>
            <div class="form-group">
                <label>LPU ID / Registration Number</label>
                <input type="text" name="registration_number" required>
            </div>
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label>What are you studying? (Major)</label>
                <input list="majors" name="major" placeholder="Search major..." required>
                <datalist id="majors">
                    <option value="B.Tech Computer Science & Engineering (CSE)">
                    <option value="B.Sc. Agriculture">
                    <option value="MBA (General)">
                </datalist>
            </div>
            <div class="form-group">
                <label>Study Level</label>
                <div class="study-level-container">
                    <label><input type="radio" name="study_level" value="Junior" checked><span>Junior</span></label>
                    <label><input type="radio" name="study_level" value="Senior"><span>Senior</span></label>
                </div>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" class="submit-btn">Create Account</button>
        </form>
    </div>
</body>
</html>