<?php
// Resident Password Reset Script

// Check if running from command line
if (php_sapi_name() === 'cli') {
    // Get email and password from command line arguments
    if ($argc < 3) {
        echo "Usage: php reset_resident_password.php <email> <new_password>\n";
        echo "Example: php reset_resident_password.php resident@example.com newpassword123\n";
        exit(1);
    }
    
    $email = $argv[1];
    $newPassword = $argv[2];
} else {
    // Running from web, check for GET parameters
    if (!isset($_GET['email']) || !isset($_GET['password'])) {
        echo "<h2>Resident Password Reset</h2>";
        echo "<p>Usage: reset_resident_password.php?email=resident@example.com&password=newpassword123</p>";
        echo "<p><strong>Warning:</strong> This is not secure for production use!</p>";
        exit(1);
    }
    
    $email = $_GET['email'];
    $newPassword = $_GET['password'];
}

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