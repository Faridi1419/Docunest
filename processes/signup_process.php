<?php

// processes/signup_process.php
session_start();
// Use __DIR__ to go up one level (from /processes/) and then into /includes/
require_once __DIR__ . '/../includes/auth.php'; 
require_once __DIR__ . '/../includes/session.php';
require_once __DIR__ . '/../includes/functions.php';

global $session;
$auth = new Auth();
$auth->setSession($session);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate CSRF token
    if (!validateCSRFToken($_POST['csrf_token'] ?? '')) {
        $_SESSION['flash'] = [
            'type' => 'error',
            'message' => 'Invalid request. Please try again.'
        ];
        header("Location: ../sign-up.php");
        exit();
    }
    
    $userData = [
        'email' => sanitizeInput($_POST['email'] ?? ''),
        'password' => $_POST['password'] ?? '',
        'confirm_password' => $_POST['confirm_password'] ?? '',
        'first_name' => sanitizeInput($_POST['first_name'] ?? ''),
        'last_name' => sanitizeInput($_POST['last_name'] ?? ''),
        'university' => sanitizeInput($_POST['university'] ?? ''),
        'major' => sanitizeInput($_POST['major'] ?? ''),
        'year_of_study' => sanitizeInput($_POST['year_of_study'] ?? '')
    ];
    
    $result = $auth->register($userData);
    
    if ($result['success']) {
        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => $result['message']
        ];
        header("Location: ../log-in.php");
        exit();
    } else {
        $_SESSION['flash'] = [
            'type' => 'error',
            'message' => $result['message']
        ];
        header("Location: ../sign-up.php");
        exit();
    }
} else {
    header("Location: ../sign-up.php");
    exit();
}
?>