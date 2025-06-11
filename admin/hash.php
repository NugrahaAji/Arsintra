<?php
// Cara pakai: D:\XAMPP\php\php.exe hash.php password_baru
if (isset($argv[1])) {
    $password = $argv[1];
    echo password_hash($password, PASSWORD_BCRYPT) . "\n";
} else {
    echo "Usage: php hash.php password_baru\n";
} 