
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload | SSALPU</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        function updateSemesters() {
            const majorSelect = document.getElementById('major');
            const semSelect = document.getElementById('semester');
            
            // Get the year duration from the selected major's data-years attribute
            const selectedOption = majorSelect.options[majorSelect.selectedIndex];
            const years = parseInt(selectedOption.getAttribute('data-years'));
            const totalSemesters = years * 2;

            // Clear the Semester dropdown
            semSelect.innerHTML = '<option value="" disabled selected>Select Semester</option>';

            // Fill with exact semesters for that major
            for (let i = 1; i <= totalSemesters; i++) {
                let option = document.createElement('option');
                option.value = i;
                option.text = 'Semester ' + i;
                semSelect.appendChild(option);
            }
        }
    </script>
</head>
<body onload="updateSemesters()">
    <?php include 'sidebar_component.php'; ?>
    <div class="content">
        <div class="page-header">
            <h1>Upload <span>Files</span></h1>
            <p>Pick a Major to see its specific Semesters.</p>
        </div>
        <div class="card" style="max-width:750px;">
            <form action="upload_handler.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Subject Title</label>
                    <input type="text" name="title" placeholder="e.g. Database Management" required>
                </div>
                
                <div class="input-row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div class="form-group">
                        <label>Major / Course</label>
                        <select name="major" id="major" onchange="updateSemesters()" required>
                            <option value="" disabled>-- Engineering (4 Years) --</option>
                            <option value="B.Tech CSE" data-years="4" selected>B.Tech CSE</option>
                            <option value="B.Tech ME" data-years="4">B.Tech ME</option>
                            <option value="B.Tech Civil" data-years="4">B.Tech Civil</option>
                            
                            <option value="" disabled>-- Management (3 Years) --</option>
                            <option value="BBA" data-years="3">BBA</option>
                            <option value="B.Com" data-years="3">B.Com</option>
                            <option value="BCA" data-years="3">BCA</option>
                            
                            <option value="" disabled>-- Masters (2 Years) --</option>
                            <option value="MBA" data-years="2">MBA</option>
                            <option value="MCA" data-years="2">MCA</option>
                            <option value="M.Sc IT" data-years="2">M.Sc IT</option>

                            <option value="" disabled>-- Architecture (5 Years) --</option>
                            <option value="B.Arch" data-years="5">B.Arch</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Semester</label>
                        <select name="semester" id="semester" required>
                            <!-- This will be filled automatically based on the Major above -->
                        </select>
                    </div>
                </div>

                <div class="form-group" style="margin-top: 10px;">
                    <label>Resource File</label>
                    <div class="upload-zone" onclick="document.getElementById('f').click()" style="border: 2px dashed #10b981; padding: 40px; text-align: center; border-radius: 15px; cursor: pointer;">
                        <i class="fa-solid fa-file-arrow-up" style="font-size:2rem; color:#10b981;"></i>
                        <div id="fn" style="margin-top:10px; color:#94a3b8;">Choose File</div>
                    </div>
                    <input type="file" id="f" name="file" style="display:none;" onchange="document.getElementById('fn').innerText = this.files[0].name;">
                </div>

                <div class="form-group">
                    <label><i class="fa-brands fa-youtube" style="color:#ff0000;"></i> YouTube Link</label>
                    <input type="text" name="youtube" placeholder="Paste link here...">
                </div>

                <button type="submit" class="primary-btn">Upload Now</button>
            </form>
        </div>
    </div>
</body>
</html>
