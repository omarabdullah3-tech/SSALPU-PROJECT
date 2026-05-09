
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
            const years = parseInt(selectedOption.getAttribute('data-years'));
            const totalSemesters = years * 2;
            
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
                'doc': '.doc,.docx,.txt'
            };

            fileInput.accept = mimeMap[typeSelect.value] || '*/*';
            zoneText.innerText = "Select " + typeSelect.value.toUpperCase() + " file";
        }
    </script>
</head>
<body onload="updateSemesters(); updateFileType();">
    <?php include 'sidebar_component.php'; ?>
    <div class="content">
        <div class="page-header">
            <h1>Upload <span>Resource</span></h1>
            <p>Select your specific LPU department and course.</p>
        </div>
        <div class="card" style="max-width:800px;">
            <form action="upload_handler.php" method="POST" enctype="multipart/form-data">
                
                <div class="input-row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div class="form-group">
                        <label>Subject Title</label>
                        <input type="text" name="title" placeholder="e.g. Machine Learning" required>
                    </div>
                    <div class="form-group">
                        <label>File Format</label>
                        <select name="file_type" id="file_type" onchange="updateFileType()" required>
                            <option value="pdf" selected>PDF (Notes/Books)</option>
                            <option value="image">Image (Handwritten/Diagrams)</option>
                            <option value="doc">Word/Text Document</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Department & Major (All LPU Courses)</label>
                    <select name="major" id="major" onchange="updateSemesters()" required>
                        <optgroup label="Engineering (B.Tech - 4 Years)">
                            <option value="B.Tech CSE" data-years="4">B.Tech Computer Science & Eng.</option>
                            <option value="B.Tech ECE" data-years="4">B.Tech Electronics & Comm. Eng.</option>
                            <option value="B.Tech ME" data-years="4">B.Tech Mechanical Eng.</option>
                            <option value="B.Tech Civil" data-years="4">B.Tech Civil Eng.</option>
                            <option value="B.Tech Biotech" data-years="4">B.Tech Biotechnology</option>
                            <option value="B.Tech Aerospace" data-years="4">B.Tech Aerospace Eng.</option>
                            <option value="B.Tech Automobile" data-years="4">B.Tech Automobile Eng.</option>
                            <option value="B.Tech Robotics" data-years="4">B.Tech Robotics & Automation</option>
                            <option value="B.Tech Chemical" data-years="4">B.Tech Chemical Eng.</option>
                        </optgroup>
                        <optgroup label="Computer Applications (3/2 Years)">
                            <option value="BCA" data-years="3">BCA (Bachelor of Computer App.)</option>
                            <option value="B.Sc IT" data-years="3">B.Sc Information Technology</option>
                            <option value="MCA" data-years="2">MCA (Master of Computer App.)</option>
                            <option value="M.Sc IT" data-years="2">M.Sc Information Technology</option>
                        </optgroup>
                        <optgroup label="Management & Commerce (3/2 Years)">
                            <option value="BBA" data-years="3">BBA (Bachelor of Business Admin.)</option>
                            <option value="B.Com" data-years="3">B.Com (Bachelor of Commerce)</option>
                            <option value="MBA" data-years="2">MBA (Master of Business Admin.)</option>
                            <option value="M.Com" data-years="2">M.Com (Master of Commerce)</option>
                        </optgroup>
                        <optgroup label="Agriculture & Sciences (4/3 Years)">
                            <option value="B.Sc Agriculture" data-years="4">B.Sc (Hons.) Agriculture</option>
                            <option value="B.Sc Forensic" data-years="3">B.Sc Forensic Sciences</option>
                            <option value="B.Sc Physics" data-years="3">B.Sc Physics</option>
                            <option value="B.Sc Chemistry" data-years="3">B.Sc Chemistry</option>
                            <option value="B.Sc Math" data-years="3">B.Sc Mathematics</option>
                            <option value="M.Sc Physics" data-years="2">M.Sc Physics</option>
                        </optgroup>
                        <optgroup label="Pharmaceutical & Medical (4/2 Years)">
                            <option value="B.Pharm" data-years="4">B.Pharmacy</option>
                            <option value="BPT" data-years="4.5">Bachelor of Physiotherapy</option>
                            <option value="B.Sc MLT" data-years="3">B.Sc Medical Lab Tech</option>
                            <option value="M.Pharm" data-years="2">M.Pharmacy</option>
                        </optgroup>
                        <optgroup label="Architecture & Design (5/4 Years)">
                            <option value="B.Arch" data-years="5">B.Architecture</option>
                            <option value="B.Des Fashion" data-years="4">B.Design (Fashion)</option>
                            <option value="B.Des Interior" data-years="4">B.Design (Interior & Furniture)</option>
                            <option value="B.Des Multimedia" data-years="4">B.Design (Multimedia/Animation)</option>
                        </optgroup>
                        <optgroup label="Law & Humanities (5/3/2 Years)">
                            <option value="BA LLB" data-years="5">Integrated BA LLB (Hons.)</option>
                            <option value="BBA LLB" data-years="5">Integrated BBA LLB (Hons.)</option>
                            <option value="BA" data-years="3">Bachelor of Arts</option>
                            <option value="MA" data-years="2">Master of Arts</option>
                        </optgroup>
                        <optgroup label="Hotel Management (4/3 Years)">
                            <option value="BHMCT" data-years="4">BHMCT (Hotel Management)</option>
                            <option value="B.Sc Hotel" data-years="3">B.Sc Hotel Management</option>
                        </optgroup>
                    </select>
                </div>

                <div class="form-group">
                    <label>Select Semester</label>
                    <select name="semester" id="semester" required></select>
                </div>

                <div class="form-group">
                    <label>Attach Material</label>
                    <div class="upload-zone" onclick="document.getElementById('f').click()" style="border: 2px dashed #10b981; padding: 40px; text-align: center; border-radius: 15px; cursor: pointer;">
                        <i class="fa-solid fa-file-shield" style="font-size:2rem; color:#10b981; margin-bottom:10px;"></i>
                        <div id="fn" style="font-weight:600;">Choose File</div>
                    </div>
                    <input type="file" id="f" name="file" style="display:none;" onchange="document.getElementById('fn').innerText = this.files[0].name; document.getElementById('fn').style.color='#10b981';">
                </div>

                <div class="form-group">
                    <label><i class="fa-brands fa-youtube" style="color:#ff0000;"></i> YouTube Reference</label>
                    <input type="text" name="youtube" placeholder="Optional video link...">
                </div>

                <button type="submit" class="primary-btn">Secure Upload</button>
            </form>
        </div>
    </div>
</body>
</html>
