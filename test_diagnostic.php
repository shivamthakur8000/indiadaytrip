<?php
// Diagnostic test to check what's happening in mail API
error_reporting(0);
ini_set('display_errors', '0');

// START SESSION FIRST
session_start();

// THEN output
echo "START TEST\n";

// Simulate POST
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

echo "Test 1: Check if POST is POST\n";
if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
    echo "FAILED: Not POST\n";
    exit;
}
echo "PASSED\n";

echo "Test 2: Check honeypot\n";
$honeypot = isset($_POST['website_url']) ? $_POST['website_url'] : '';
if (!empty($honeypot)) {
    echo "FAILED: Honeypot filled\n";
    exit;
}
echo "PASSED\n";

echo "Test 3: Check input validation (first_name)\n";
$first_name = $_POST['first_name'] ?? '';
if (empty($first_name)) {
    echo "FAILED: first_name empty\n";
    exit;
}
echo "PASSED: first_name = $first_name\n";

echo "Test 4: Form type detection\n";
$form_type = isset($_POST['form_type']) ? $_POST['form_type'] : 'booking';
echo "form_type = $form_type\n";

if ($form_type === 'booking' || isset($_POST['first_name'])) {
    echo "PASSED: Will use booking handler\n";
} else {
    echo "FAILED: No handler matched\n";
    exit;
}

echo "Test 5: Check required booking fields\n";
$last_name = isset($_POST['last_name']) ? trim($_POST['last_name']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';

if (empty($first_name) || empty($last_name) || empty($email) || empty($phone)) {
    echo "FAILED: Missing required fields\n";
    exit;
}
echo "PASSED: All required fields present\n";

echo "Test 6: Would reach email sending\n";
echo "SUCCESS: Form would be processed\n";
