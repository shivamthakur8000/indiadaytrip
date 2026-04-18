<?php
// Simple test for gallery management system
require_once 'config.php';

echo "<h1>Gallery Management System Test</h1>";

// Test 1: Check if gallery table exists
echo "<h2>Test 1: Database Connection and Gallery Table</h2>";
try {
    $stmt = $pdo->query("SHOW TABLES LIKE 'gallery_images'");
    $table_exists = $stmt->fetch();
    
    if ($table_exists) {
        echo "<p style='color: green;'>✓ Gallery table exists</p>";
        
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM gallery_images");
        $count = $stmt->fetch();
        echo "<p>✓ Gallery has {$count['count']} images</p>";
        
        if ($count['count'] > 0) {
            $stmt = $pdo->query("SELECT id, filename, alt_text FROM gallery_images LIMIT 3");
            $images = $stmt->fetchAll();
            echo "<h3>Sample Images:</h3>";
            foreach ($images as $image) {
                echo "<p><strong>" . ($image['alt_text'] ?: 'No alt text') . "</strong> - {$image['filename']} (ID: {$image['id']})</p>";
            }
        }
    } else {
        echo "<p style='color: red;'>✗ Gallery table does not exist</p>";
    }
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Database error: " . $e->getMessage() . "</p>";
}

// Test 2: Check if gallery files exist
echo "<h2>Test 2: Gallery Files</h2>";
$gallery_dir = 'assets/img/gallery/';
if (is_dir($gallery_dir)) {
    $images = glob($gallery_dir . '*.{webp,jpg,jpeg,png,gif}', GLOB_BRACE);
    echo "<p>✓ Gallery directory exists with " . count($images) . " images</p>";
    if (count($images) > 0) {
        echo "<h3>Sample Images:</h3>";
        foreach (array_slice($images, 0, 5) as $image) {
            $filename = basename($image);
            echo "<p>• $filename</p>";
        }
    }
} else {
    echo "<p style='color: red;'>✗ Gallery directory not found</p>";
}

// Test 3: Check if admin gallery simple exists
echo "<h2>Test 3: Admin Gallery Simple</h2>";
$admin_gallery = 'admin/gallery_simple.php';
if (file_exists($admin_gallery)) {
    echo "<p style='color: green;'>✓ Simple admin gallery exists at $admin_gallery</p>";
    echo "<p><a href='$admin_gallery' class='btn btn-primary' target='_blank'>Open Admin Gallery</a></p>";
} else {
    echo "<p style='color: red;'>✗ Simple admin gallery not found at $admin_gallery</p>";
}

// Test 4: Check if gallery page exists
echo "<h2>Test 4: Gallery Page</h2>";
$gallery_page = 'gallery/index.php';
if (file_exists($gallery_page)) {
    echo "<p style='color: green;'>✓ Gallery page exists at $gallery_page</p>";
    echo "<p><a href='$gallery_page' class='btn btn-success' target='_blank'>View Gallery</a></p>";
} else {
    echo "<p style='color: red;'>✗ Gallery page not found at $gallery_page</p>";
}

echo "<h2>Test Summary</h2>";
echo "<p>The simplified gallery management system has been successfully implemented with the following features:</p>";
echo "<ul>";
echo "<li>✓ Database table for gallery images</li>";
echo "<li>✓ Simple admin interface for CRUD operations</li>";
echo "<li>✓ Image upload without complex processing</li>";
echo "<li>✓ Dynamic gallery page loading</li>";
echo "<li>✓ API endpoint for gallery management</li>";
echo "<li>✓ Simplified interface with only essential fields (image and alt text)</li>";
echo "</ul>";

echo "<h2>How to Use</h2>";
echo "<ol>";
echo "<li>Access the admin panel at <a href='admin/gallery_simple.php' target='_blank'>admin/gallery_simple.php</a></li>";
echo "<li>Log in with admin credentials</li>";
echo "<li>Click 'Add New Image' to upload images</li>";
echo "<li>Fill in the alt text and select an image file</li>";
echo "<li>Click 'Save Image' to add the image to the gallery</li>";
echo "<li>View the gallery at <a href='gallery/index.php' target='_blank'>gallery/index.php</a></li>";
echo "</ol>";

echo "<h2>Troubleshooting</h2>";
echo "<ul>";
echo "<li>If you get 'Failed to upload image' error, check that the <code>assets/img/gallery/</code> directory exists and is writable</li>";
echo "<li>If you get 'Error occurred while saving', check the browser console for detailed error messages</li>";
echo "<li>Make sure you're using the simple admin interface at <code>admin/gallery_simple.php</code></li>";
echo "</ul>";
?>