<?php
session_start();

function isLoggedIn() {
    return isset($_SESSION['user_id']) || isset($_SESSION['admin_id']);
}

function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: ../index.php");
        exit();
    }
}

function adminRequireLogin() {
    if (!isLoggedIn()) {
        header("Location: adminlogin.php");
        exit();
    }
}

function getUserRole() {
    return $_SESSION['user_role'] ?? null;
}

function isAdmin() {
    return getUserRole() === 'admin';
}

function logout() {
    session_destroy();
    header("Location: ../index.php");
    exit();
}
?>
