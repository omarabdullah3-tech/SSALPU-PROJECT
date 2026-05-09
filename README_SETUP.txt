SSALPU - PHPMailer Setup Guide
--------------------------------
The error 'No such file or directory' means PHP cannot find the PHPMailer files.

TO FIX THIS:
1. Go to C:\xampp\htdocs\sudaniShare\
2. Create a folder named 'PHPMailer'
3. Inside 'PHPMailer', create a folder named 'src'
4. Download PHPMailer from GitHub (https://github.com/PHPMailer/PHPMailer)
5. Copy 'Exception.php', 'PHPMailer.php', and 'SMTP.php' from the 'src' folder of the download.
6. Paste them into: C:\xampp\htdocs\sudaniShare\PHPMailer\src\

Your final path MUST look like this:
C:\xampp\htdocs\sudaniShare\PHPMailer\src\Exception.php
