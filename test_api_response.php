<?php
// Test mail API with actual email sending attempt
error_reporting(0);
ini_set('display_errors', '0');

session_start();

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
    'special_requests' => 'Test',
    'captcha' => '5',
    'use_captcha' => '0',
    'csrf_token' => '',
    'website_url' => ''
);

$_SESSION['captcha_answer'] = 5;

// Try to include the actual API
echo "INCLUDING MAIL API...\n";
ob_start();
include 'api/mail.php';
$api_output = ob_get_clean();

echo "API RESPONSE:\n";
echo $api_output;
echo "\nEND\n";
