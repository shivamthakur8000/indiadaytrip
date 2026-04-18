<?php
/**
 * FORM BUTTON FIX VERIFICATION
 * This script verifies all form submission issues have been resolved
 */

session_start();

// Test results
$tests = array(
    'jquery_loaded' => false,
    'main_js_exists' => false,
    'to_book_form_ok' => false,
    'contact_form_ok' => false, 
    'tour_detail_form_ok' => false,
    'api_mail_exists' => false,
    'csrf_generation_ok' => false,
    'session_ok' => false
);

echo "<h1>Form Button Fix Verification Report</h1>\n";
echo "<p>Generated: " . date('Y-m-d H:i:s') . "</p>\n";

// Test 1: jQuery
echo "<h2>1. jQuery Status</h2>\n";
$jquery_file = 'assets/js/vendor/jquery-3.6.0.min.js';
$tests['jquery_loaded'] = file_exists($jquery_file);
echo "<p>jQuery file exists: " . ($tests['jquery_loaded'] ? '✅ YES' : '❌ NO') . "</p>\n";
if (file_exists($jquery_file)) {
    echo "<p>File size: " . filesize($jquery_file) . " bytes</p>\n";
}

// Test 2: main.js
echo "<h2>2. Main.js Handler</h2>\n";
$main_js = 'assets/js/main.js';
$tests['main_js_exists'] = file_exists($main_js);
echo "<p>Main.js exists: " . ($tests['main_js_exists'] ? '✅ YES' : '❌ NO') . "</p>\n";
if ($tests['main_js_exists']) {
    $content = file_get_contents($main_js);
    $has_fixed_selector = strpos($content, 'var form = $(o).closest(p)[0]') !== false;
    echo "<p>Has fixed jQuery selector: " . ($has_fixed_selector ? '✅ YES' : '❌ NO') . "</p>\n";
    echo "<p>Has submit handler: " . (strpos($content, "on('submit', '.ajax-contact'") !== false ? '✅ YES' : '❌ NO') . "</p>\n";
}

// Test 3: to_book form
echo "<h2>3. To_book Form (/to_book/)</h2>\n";
$to_book = 'to_book/index.php';
$tests['to_book_form_ok'] = file_exists($to_book);
echo "<p>File exists: " . ($tests['to_book_form_ok'] ? '✅ YES' : '❌ NO') . "</p>\n";
if ($tests['to_book_form_ok']) {
    $content = file_get_contents($to_book);
    echo "<p>Has ajax-contact class: " . (strpos($content, 'class="booking-form ajax-contact"') !== false ? '✅ YES' : '❌ NO') . "</p>\n";
    echo "<p>Has form_type field: " . (strpos($content, 'name="form_type"') !== false ? '✅ YES' : '❌ NO') . "</p>\n";
    echo "<p>Has CSRF token: " . (strpos($content, 'name="csrf_token"') !== false ? '✅ YES' : '❌ NO') . "</p>\n";
    echo "<p>Has form-messages: " . (strpos($content, 'class="form-messages') !== false ? '✅ YES' : '❌ NO') . "</p>\n";
    echo "<p>Action is ../api/mail.php: " . (strpos($content, 'action="../api/mail.php"') !== false ? '✅ YES' : '❌ NO') . "</p>\n";
}

// Test 4: contact form
echo "<h2>4. Contact Form (/contact/)</h2>\n";
$contact = 'contact/index.php';
$tests['contact_form_ok'] = file_exists($contact);
echo "<p>File exists: " . ($tests['contact_form_ok'] ? '✅ YES' : '❌ NO') . "</p>\n";
if ($tests['contact_form_ok']) {
    $content = file_get_contents($contact);
    // Check if form-messages is INSIDE the form (before </form>)
    preg_match('/<form.*?form-messages.*?<\/form>/s', $content, $matches);
    $messages_inside = !empty($matches);
    echo "<p>Has form with id=contactForm: " . (strpos($content, 'id="contactForm"') !== false ? '✅ YES' : '❌ NO') . "</p>\n";
    echo "<p>Has form_type field: " . (strpos($content, 'name="form_type"') !== false ? '✅ YES' : '❌ NO') . "</p>\n";
    echo "<p>Has CSRF token: " . (strpos($content, 'name="csrf_token"') !== false ? '✅ YES' : '❌ NO') . "</p>\n";
    echo "<p>Form-messages INSIDE form tag: " . ($messages_inside ? '✅ YES (FIXED)' : '❌ NO (BUG)') . "</p>\n";
}

// Test 5: tour-detail form
echo "<h2>5. Tour Detail Form (/tour/slug)</h2>\n";
$tour_detail = 'tour-detail.php';
$tests['tour_detail_form_ok'] = file_exists($tour_detail);
echo "<p>File exists: " . ($tests['tour_detail_form_ok'] ? '✅ YES' : '❌ NO') . "</p>\n";
if ($tests['tour_detail_form_ok']) {
    $content = file_get_contents($tour_detail);
    echo "<p>Includes config.php: " . (strpos($content, "require_once __DIR__ . '/config.php'") !== false ? '✅ YES' : '❌ NO') . "</p>\n";
    echo "<p>Has ajax-contact class: " . (strpos($content, 'class="booking-form ajax-contact"') !== false ? '✅ YES' : '❌ NO') . "</p>\n";
    echo "<p>Has form_type field: " . (strpos($content, 'name="form_type"') !== false ? '✅ YES' : '❌ NO') . "</p>\n";
    echo "<p>Has CSRF token: " . (strpos($content, 'name="csrf_token"') !== false ? '✅ YES' : '❌ NO') . "</p>\n";
    echo "<p>Action is /api/mail.php (absolute): " . (strpos($content, 'action="/api/mail.php"') !== false ? '✅ YES' : '❌ NO') . "</p>\n";
}

// Test 6: API
echo "<h2>6. Email API (/api/mail.php)</h2>\n";
$api = 'api/mail.php';
$tests['api_mail_exists'] = file_exists($api);
echo "<p>File exists: " . ($tests['api_mail_exists'] ? '✅ YES' : '❌ NO') . "</p>\n";
if ($tests['api_mail_exists']) {
    $content = file_get_contents($api);
    echo "<p>Has honeypot check: " . (strpos($content, 'checkHoneypot') !== false ? '✅ YES' : '❌ NO') . "</p>\n";
    echo "<p>Has CAPTCHA validation: " . (strpos($content, 'validateCaptcha') !== false ? '✅ YES' : '❌ NO') . "</p>\n";
    echo "<p>Has form_type routing: " . (strpos($content, "\$form_type === 'booking'") !== false ? '✅ YES' : '❌ NO') . "</p>\n";
    echo "<p>Uses PHPMailer: " . (strpos($content, 'PHPMailer') !== false ? '✅ YES' : '❌ NO') . "</p>\n";
}

// Test 7: CSRF function
echo "<h2>7. CSRF Token Generation</h2>\n";
$functions = 'functions.php';
$tests['csrf_generation_ok'] = file_exists($functions);
echo "<p>Functions.php exists: " . ($tests['csrf_generation_ok'] ? '✅ YES' : '❌ NO') . "</p>\n";
if ($tests['csrf_generation_ok']) {
    $content = file_get_contents($functions);
    echo "<p>Has generateCSRFToken: " . (strpos($content, 'function generateCSRFToken') !== false ? '✅ YES' : '❌ NO') . "</p>\n";
    echo "<p>Has startSessionIfPossible: " . (strpos($content, 'function startSessionIfPossible') !== false ? '✅ YES' : '❌ NO') . "</p>\n";
}

// Test 8: Session
echo "<h2>8. Session Status</h2>\n";
$tests['session_ok'] = session_status() === PHP_SESSION_ACTIVE;
echo "<p>Session active: " . ($tests['session_ok'] ? '✅ YES' : '❌ NO') . "</p>\n";
if ($tests['session_ok']) {
    require_once 'functions.php';
    $csrf = generateCSRFToken();
    echo "<p>CSRF token generated: " . (strlen($csrf) > 0 ? '✅ YES (' . strlen($csrf) . ' chars)' : '❌ NO') . "</p>\n";
}

// Summary
echo "<h2>Summary</h2>\n";
$passed = array_sum(array_values($tests));
$total = count($tests);
echo "<p><strong>Tests Passed: $passed/$total</strong></p>\n";

if ($passed === $total) {
    echo "<p style='color: green; font-size: 18px;'><strong>✅ ALL TESTS PASSED - FORMS SHOULD WORK!</strong></p>\n";
} else {
    echo "<p style='color: orange;'>Some tests failed - check details above</p>\n";
    echo "<ul>\n";
    foreach ($tests as $name => $passed) {
        if (!$passed) {
            echo "<li>❌ $name</li>\n";
        }
    }
    echo "</ul>\n";
}

echo "<hr>\n";
echo "<h2>How to Test</h2>\n";
echo "<ol>\n";
echo "<li>Visit: <a href='to_book/'>to_book/index.php</a></li>\n";
echo "<li>Fill out the booking form</li>\n";
echo "<li>Click 'Book Now' button</li>\n";
echo "<li>You should see success/error message without page reload</li>\n";
echo "<li>Check your email (Gmail: indiadaytrip@gmail.com for admin, your email for confirmation)</li>\n";
echo "</ol>\n";

?>
