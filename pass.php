<?php

// Kata sandi yang ingin di-hash
$passwordAsli = 'admin123';

// Membuat hash dari kata sandi
// PASSWORD_DEFAULT adalah algoritma hashing yang direkomendasikan dan akan terus diperbarui oleh PHP
$hashPassword = password_hash($passwordAsli, PASSWORD_DEFAULT);

// Menampilkan hash yang sudah dibuat
echo "Password Asli: " . $passwordAsli . "<br>";
echo "Password Hash: " . $hashPassword;

?>