<?php
include 'config.php';

// Password baru yang ingin di-hash
$new_password = 'admin123';
$hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

// Update password di database
$query = "UPDATE admin SET password='$hashed_password' WHERE username='admin'";
if ($conn->query($query) === TRUE) {
    echo "Password berhasil diperbarui.";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>