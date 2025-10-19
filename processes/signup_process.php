<?php

// processes/signup_process.php
session_start();
// Use __DIR__ to go up one level (from /processes/) and then into /includes/
require_once __DIR__ . '/../includes/auth.php'; 
require_once __DIR__ . '/../includes/session.php';
// ... rest of the code

global $session;
$auth = new Auth();
$auth->setSession($session);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userData = [
        'email' => $_POST['email'] ?? '',
        'password' => $_POST['password'] ?? '',
        'confirm_password' => $_POST['confirm_password'] ?? '',
        'first_name' => $_POST['first_name'] ?? '',
        'last_name' => $_POST['last_name'] ?? '',
        'university' => $_POST['university'] ?? '',
        'major' => $_POST['major'] ?? '',
        'year_of_study' => $_POST['year_of_study'] ?? ''
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