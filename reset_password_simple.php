<?php
// Simple password reset script

// Database connection
$host = '127.0.0.1';
$dbname = 'project';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Email and new password
$email = 'serafinJoelito21@gmail.com';
$newPassword = 'password123';

// Hash the password (using bcrypt, same as Laravel)
$hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

// Update the password
try {
    $stmt = $pdo->prepare("UPDATE residents SET password = ? WHERE email = ?");
    $stmt->execute([$hashedPassword, $email]);
    
    $rowCount = $stmt->rowCount();
    
    if ($rowCount > 0) {
        echo "Password reset successfully for " . $email . "\n";
        echo "New password: " . $newPassword . "\n";
        echo "Please change this after logging in.\n";
    } else {
        echo "No resident found with email: " . $email . "\n";
    }
} catch(PDOException $e) {
    echo "Error updating password: " . $e->getMessage() . "\n";
}
?>