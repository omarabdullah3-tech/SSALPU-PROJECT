
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
            const selectedOption = majorSelect.options[majorSelect.selectedIndex];
            if(!selectedOption) return;
            const years = parseFloat(selectedOption.getAttribute('data-years'));
            const totalSemesters = Math.ceil(years * 2);
            semSelect.innerHTML = '';
            for (let i = 1; i <= totalSemesters; i++) {
                let option = document.createElement('option');
                option.value = i;
                option.text = 'Semester ' + i;
                semSelect.appendChild(option);
            }
        }
        function updateFileType() {
            const typeSelect = document.getElementById('file_type');
            const fileInput = document.getElementById('f');
            const zoneText = document.getElementById('fn');
            const mimeMap = { 
                'pdf': '.pdf', 
                'image': 'image/*', 
                'doc': '.doc,.docx,.txt',
                'ppt': '.ppt,.pptx'
            };
            fileInput.accept = mimeMap[typeSelect.value] || '*/*';
            zoneText.innerText = "CLICK TO PICK " + typeSelect.value.toUpperCase();
        }
    </script>
</head>
<body onload="updateSemesters(); updateFileType();">
    <?php include 'sidebar_component.php'; ?>
    
    <div class="content">
        <div class="page-header">
            <h1>Upload <span>Files</span></h1>
            <p>Share study materials and video references with the network.</p>
        </div>

        <div class="card" style="max-width:700px; margin-top:30px;">
            <form action="upload_handler.php" method="POST" enctype="multipart/form-data">
                
                <div class="form-group">
                    <label>Subject Title</label>
                    <input type="text" name="title" placeholder="e.g. Artificial Intelligence Notes" required>
                </div>

                <div class="input-row" style="display:grid; grid-template-columns: 1fr 1fr; gap:20px;">
                    <div class="form-group">
                        <label>File Format</label>
                        <select name="file_type" id="file_type" onchange="updateFileType()" required>
                            <option value="pdf" selected>PDF Document</option>
                            <option value="ppt">PowerPoint (PPT/PPTX)</option>
                            <option value="image">Image (JPG/PNG)</option>
                            <option value="doc">Word/Text File</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Semester</label>
                        <select name="semester" id="semester" required></select>
                    </div>
                </div>

                <div class="form-group">
                    <label>Department & Major (LPU)</label>
                    <select name="major" id="major" onchange="updateSemesters()" required>
                        <optgroup label="Engineering">
                            <option value="B.Tech CSE" data-years="4" selected>B.Tech Computer Science & Eng. (CSE)</option>
                            <option value="B.Tech ECE" data-years="4">B.Tech Electronics & Comm. Eng. (ECE)</option>
                            <option value="B.Tech ME" data-years="4">B.Tech Mechanical Eng. (ME)</option>
                            <option value="B.Tech Civil" data-years="4">B.Tech Civil Engineering</option>
                            <option value="B.Tech Biotech" data-years="4">B.Tech Biotechnology</option>
                            <option value="B.Tech Aerospace" data-years="4">B.Tech Aerospace Engineering</option>
                            <option value="B.Tech Robotics" data-years="4">B.Tech Robotics & Automation</option>
                            <option value="B.Tech Food Tech" data-years="4">B.Tech Food Technology</option>
                            <option value="B.Tech Automobile" data-years="4">B.Tech Automobile Engineering</option>
                            <option value="B.Tech Chemical" data-years="4">B.Tech Chemical Engineering</option>
                        </optgroup>
                        <optgroup label="Computer Applications">
                            <option value="BCA" data-years="3">BCA (Bachelor of Computer App.)</option>
                            <option value="B.Sc IT" data-years="3">B.Sc Information Technology</option>
                            <option value="MCA" data-years="2">MCA (Master of Computer App.)</option>
                            <option value="M.Sc IT" data-years="2">M.Sc Information Technology</option>
                        </optgroup>
                        <optgroup label="Management & Commerce">
                            <option value="BBA" data-years="3">BBA (Bachelor of Business Admin.)</option>
                            <option value="B.Com" data-years="3">B.Com (Bachelor of Commerce)</option>
                            <option value="MBA" data-years="2">MBA (Master of Business Admin.)</option>
                            <option value="M.Com" data-years="2">M.Com (Master of Commerce)</option>
                        </optgroup>
                        <optgroup label="Medical Sciences">
                            <option value="B.Pharm" data-years="4">B.Pharmacy</option>
                            <option value="BPT" data-years="4.5">Bachelor of Physiotherapy</option>
                            <option value="B.Sc MLT" data-years="3">B.Sc Medical Lab Technology</option>
                            <option value="B.Sc Nursing" data-years="4">B.Sc Nursing</option>
                        </optgroup>
                        <optgroup label="Architecture & Design">
                            <option value="B.Arch" data-years="5">B.Architecture (10 Sems)</option>
                            <option value="B.Des Fashion" data-years="4">B.Design (Fashion Design)</option>
                            <option value="B.Des Interior" data-years="4">B.Design (Interior & Furniture)</option>
                            <option value="B.Des Multimedia" data-years="4">B.Design (Multimedia & Animation)</option>
                        </optgroup>
                        <optgroup label="Law & Arts">
                            <option value="BA LLB" data-years="5">BA LLB (Hons.) - 10 Sems</option>
                            <option value="BBA LLB" data-years="5">BBA LLB (Hons.) - 10 Sems</option>
                            <option value="BA" data-years="3">Bachelor of Arts (BA)</option>
                        </optgroup>
                    </select>
                </div>

                <div class="form-group" style="margin-top:10px;">
                    <label>Attach Material</label>
                    <label for="f" class="upload-zone" style="display: block; border: 2px dashed rgba(16, 185, 129, 0.3); padding: 45px; text-align: center; border-radius: 20px; cursor: pointer; transition: 0.3s;">
                        <i class="fa-solid fa-file-arrow-up" style="font-size: 2rem; color: var(--accent); margin-bottom: 15px; display: block;"></i>
                        <span id="fn" style="font-weight: 600; color: var(--text-gray);">CLICK TO PICK FILE</span>
                    </label>
                    <input type="file" id="f" name="file" style="display:none;" onchange="document.getElementById('fn').innerText = 'Selected: ' + this.files[0].name; document.getElementById('fn').style.color='#10b981';">
                </div>

                <div class="form-group" style="margin-top:20px;">
                    <label><i class="fa-brands fa-youtube" style="color:#ff0000;"></i> Helpful YouTube Link <span style="font-size:0.75rem; color:var(--text-gray); font-weight:normal;">(Optional)</span></label>
                    <input type="text" name="youtube" placeholder="https://www.youtube.com/watch?v=...">
                </div>

                <button type="submit" class="primary-btn" style="margin-top:20px;">Send Resource</button>
            </form>
        </div>
    </div>
</body>
</html>
