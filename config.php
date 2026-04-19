<?php
// Database configuration
// define('DB_HOST', 'localhost');
// define('DB_NAME', 'u615191172_india_day_trip');
// define('DB_USER', 'u615191172_developer'); // Change as needed
// define('DB_PASS', '8958Shivay'); // Change as needed

define('DB_HOST', 'localhost');
define('DB_NAME', 'u615191172_india_day_trip');
define('DB_USER', 'root'); // Change as needed
define('DB_PASS', ''); // Change as needed

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
}
catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Include utility functions
require_once 'functions.php';

// Function to get setting value 
function getSetting($key)
{
    global $pdo;
    $stmt = $pdo->prepare("SELECT setting_value FROM settings WHERE setting_key = ?");
    $stmt->execute([$key]);
    return $stmt->fetchColumn();
}

// Function to update setting
function updateSetting($key, $value)
{
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO settings (setting_key, setting_value) VALUES (?, ?) ON DUPLICATE KEY UPDATE setting_value = ?");
    $stmt->execute([$key, $value, $value]);
}

// Resend Email Configuration
define('RESEND_API_KEY', 're_YOUR_API_KEY'); // Get from https://resend.com
define('RESEND_FROM_EMAIL', 'indiadaytrip@gmail.com'); // Use your verified domain
define('ADMIN_EMAIL', 'indiadaytrip@gmail.com');

?>