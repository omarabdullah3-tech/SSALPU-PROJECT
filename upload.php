
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload | SSALPU</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <?php include 'sidebar_component.php'; ?>
    <div class="content">
        <div class="page-header">
            <h1>Upload <span>Files</span></h1>
            <p>Share resources with your fellow students.</p>
        </div>
        <div class="card" style="max-width:750px;">
            <form action="upload_handler.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Subject Title</label>
                    <input type="text" name="title" placeholder="Enter subject name..." required>
                </div>
                
                <div class="input-row">
                    <div class="form-group">
                        <label>Major</label>
                        <select name="major" required>
                            <option value="B.Tech CSE">B.Tech CSE</option>
                            <option value="MBA">MBA</option>
                            <option value="B.Tech ME">B.Tech ME</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Semester</label>
                        <select name="semester" required>
                            <option value="1">Semester 1</option>
                            <option value="2">Semester 2</option>
                            <option value="3">Semester 3</option>
                            <option value="4">Semester 4</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label>File</label>
                    <div class="upload-zone" onclick="document.getElementById('f').click()">
                        <i class="fa-solid fa-file-arrow-up" style="font-size:2.5rem; color:var(--accent); margin-bottom:10px;"></i>
                        <div id="fn" style="font-weight:600; color:var(--text-gray);">CLICK TO PICK FILE</div>
                    </div>
                    <input type="file" id="f" name="file" style="display:none;" onchange="document.getElementById('fn').innerText = this.files[0].name; document.getElementById('fn').style.color='#10b981';">
                </div>

                <div class="form-group">
                    <label><i class="fa-brands fa-youtube" style="color:#ff0000;"></i> YouTube Link (Optional)</label>
                    <input type="text" name="youtube" placeholder="https://youtube.com/watch?v=...">
                </div>

                <button type="submit" class="primary-btn">Send Resource</button>
            </form>
        </div>
    </div>
</body>
</html>
