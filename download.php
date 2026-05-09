<?php
session_start();
include 'db_config.php';

// 1. Security Check
if (!isset($_SESSION['user_id'])) {
    die("Error: Please log in to download files.");
}

if (isset($_GET['file_id'])) {
    $id = intval($_GET['file_id']);
    
    // 2. Fetch file details
    $query = "SELECT * FROM uploads WHERE id = $id LIMIT 1";
    $result = mysqli_query($conn, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $file_data = mysqli_fetch_assoc($result);
        $file_name = $file_data['file_path']; // Contains "uploads/filename.pdf"
        
        // 3. Resolve the path
        // Since $file_name already starts with "uploads/", we just use __DIR__
        $file_path = __DIR__ . "/" . $file_name;

        if (file_exists($file_path)) {
            // 4. Update download counter
            mysqli_query($conn, "UPDATE uploads SET downloads = downloads + 1 WHERE id = $id");

            // 5. Clean buffer
            if (ob_get_level()) {
                ob_end_clean();
            }

            // 6. Force Download Headers
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file_path));
            
            readfile($file_path);
            exit;
        } else {
            // This error will show you where the script is looking if it still fails
            die("Error: File not found. Script looked in: " . $file_path);
        }
    } else {
        die("Error: File record not found in database.");
    }
} else {
    die("Error: No file ID specified.");
}
?>