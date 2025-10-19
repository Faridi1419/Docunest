<?php
// includes/functions.php

function sanitizeInput($data) {
    if (is_array($data)) {
        return array_map('sanitizeInput', $data);
    }
    return htmlspecialchars(strip_tags(trim($data)));
}

function displayError($message) {
    return '<div class="alert alert-error">' . $message . '</div>';
}

function displaySuccess($message) {
    return '<div class="alert alert-success">' . $message . '</div>';
}

function displayFlashMessage() {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    $flash = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    
    if ($flash) {
        $class = $flash['type'] == 'error' ? 'alert-error' : 'alert-success';
        return '<div class="alert ' . $class . '">' . $flash['message'] . '</div>';
    }
    return '';
}

function redirect($url) {
    header("Location: $url");
    exit();
}

function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function validatePassword($password) {
    return strlen($password) >= 6;
}

function formatFileSize($bytes) {
    if ($bytes >= 1073741824) {
        return number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        return number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        return number_format($bytes / 1024, 2) . ' KB';
    } else {
        return $bytes . ' bytes';
    }
}

function getCurrentDateTime() {
    return date('Y-m-d H:i:s');
}

function setFlash($type, $message) {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $_SESSION['flash'] = [
        'type' => $type,
        'message' => $message
    ];
}

function getFlash() {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $flash = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    return $flash;
}

// CSS for alerts
function getAlertStyles() {
    return '
    <style>
    .alert {
        padding: 12px 16px;
        margin: 15px 0;
        border-radius: 6px;
        font-weight: 500;
        border: 1px solid transparent;
        font-size: 14px;
    }
    .alert-error {
        background-color: #fef2f2;
        border-color: #fecaca;
        color: #dc2626;
    }
    .alert-success {
        background-color: #f0fdf4;
        border-color: #bbf7d0;
        color: #16a34a;
    }
    .alert-info {
        background-color: #f0f9ff;
        border-color: #bae6fd;
        color: #0369a1;
    }
    .alert-warning {
        background-color: #fffbeb;
        border-color: #fed7aa;
        color: #ea580c;
    }
    </style>
    ';
}

// Session functions moved to Session class - use $session object instead

// Debug function removed for production security

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function generateCSRFToken() {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function validateCSRFToken($token) {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

function formatDate($date, $format = 'F j, Y') {
    return date($format, strtotime($date));
}

function truncateText($text, $length = 100) {
    if (strlen($text) <= $length) {
        return $text;
    }
    return substr($text, 0, $length) . '...';
}
