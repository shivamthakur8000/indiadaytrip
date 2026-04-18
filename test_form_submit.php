<?php
// Test form submission
error_reporting(E_ALL);
ini_set('display_errors', '1');

$_SERVER['REQUEST_METHOD'] = 'POST';
$_POST = array(
    'first_name' => 'John',
    'last_name' => 'Test',
    'email' => 'test@example.com',
    'phone' => '1234567890',
    'tour_name' => 'Test Tour',
    'travel_date' => '2024-04-15',
    'adults' => '2',
    'children' => '0',
    'special_requests' => 'No special requests',
    'captcha' => '5',
    'use_captcha' => '0',
    'csrf_token' => '',
    'website_url' => ''
);

// Start session BEFORE any output
$_SESSION = array('captcha_answer' => 5);
@session_start();

// Now output
echo "=== FORM SUBMISSION TEST ===\n";
echo "POST data set, session started. Including API...\n";

ob_start();
include 'api/mail.php';
$output = ob_get_clean();

echo "API Output:\n";
echo $output;
echo "\n=== END TEST ===\n";
