<?php
// extension_check.php - Checks for required PHP extensions

echo "<h1>PHP Extension Checker</h1>";

// Function to check if an extension is loaded
function check_extension($name) {
    if (extension_loaded($name)) {
        echo "<p style='color:green'>✓ {$name} extension is loaded.</p>";
        return true;
    } else {
        echo "<p style='color:red'>✗ {$name} extension is NOT loaded.</p>";
        return false;
    }
}

// Check common database extensions
$mysqli_loaded = check_extension('mysqli');
$pdo_mysql_loaded = check_extension('pdo_mysql');
$mysql_loaded = check_extension('mysql'); // Older, deprecated extension

echo "<h2>PHP Information</h2>";
echo "<p>PHP Version: " . phpversion() . "</p>";
echo "<p>Loaded Configuration File: " . php_ini_loaded_file() . "</p>";
echo "<p>Extension Directory: " . ini_get('extension_dir') . "</p>";

// Provide guidance based on results
echo "<h2>Recommendations</h2>";

if (!$mysqli_loaded) {
    echo "<h3>To enable mysqli:</h3>";
    echo "<ol>";
    echo "<li>Open your php.ini file (location shown above)</li>";
    echo "<li>Find the line ';extension=mysqli' (it has a semicolon at the beginning)</li>";
    echo "<li>Remove the semicolon to uncomment the line</li>";
    echo "<li>Save the file and restart your web server</li>";
    echo "</ol>";
    
    echo "<h3>Alternative: Use PDO</h3>";
    echo "<p>If you can't enable mysqli, you can modify your code to use PDO instead:</p>";
    echo "<pre>";
    echo htmlspecialchars('
$db = new PDO("mysql:host=localhost;dbname=your_database", "username", "password");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);');
    echo "</pre>";
}

// Show all loaded extensions
echo "<h2>All Loaded Extensions</h2>";
echo "<ul>";
$loaded_extensions = get_loaded_extensions();
sort($loaded_extensions);
foreach ($loaded_extensions as $extension) {
    echo "<li>{$extension}</li>";
}
echo "</ul>";
?>