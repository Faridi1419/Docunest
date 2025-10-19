<?php
// processes/login_process.php
session_start();
require_once '../includes/auth.php';
require_once '../includes/session.php';
require_once '../includes/functions.php';

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
        header("Location: ../log-in.php");
        exit();
    }
    
    $email = sanitizeInput($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    
    $result = $auth->login($email, $password);
    
    if ($result['success']) {
        header("Location: ../vault.php");
        exit();
    } else {
        $_SESSION['flash'] = [
            'type' => 'error',
            'message' => $result['message']
        ];
        header("Location: ../log-in.php");
        exit();
    }
} else {
    header("Location: ../log-in.php");
    exit();
}
?>