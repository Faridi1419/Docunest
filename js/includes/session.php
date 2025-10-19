<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class Session {
    public function __construct() {}

    // ---------- LOGIN / LOGOUT ----------
    public function isLoggedIn() {
        return isset($_SESSION['user_id'], $_SESSION['logged_in']);
    }

    public function login($user) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['first_name'] = $user['first_name'];
        $_SESSION['last_name'] = $user['last_name'];
        $_SESSION['user_type'] = $user['user_type'] ?? 'student';
        $_SESSION['university'] = $user['university'] ?? '';
        $_SESSION['major'] = $user['major'] ?? '';
        $_SESSION['year_of_study'] = $user['year_of_study'] ?? '';
        $_SESSION['logged_in'] = true;
        $_SESSION['login_time'] = time();
    }

    public function logout() {
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
    }

    // ---------- REDIRECT HELPERS ----------
    public function redirectIfNotLoggedIn($redirectTo = 'log-in.php') {
        if (!$this->isLoggedIn()) {
            $this->setFlash('error', 'Please log in to access this page.');
            header("Location: $redirectTo");
            exit();
        }
    }

    public function redirectIfLoggedIn($redirectTo = 'vault.php') {
        if ($this->isLoggedIn()) {
            header("Location: $redirectTo");
            exit();
        }
    }

    // ---------- FLASH MESSAGES ----------
    public function setFlash($type, $message) {
        $_SESSION['flash'] = ['type' => $type, 'message' => $message];
    }

    public function getFlash() {
        $flash = $_SESSION['flash'] ?? null;
        unset($_SESSION['flash']);
        return $flash;
    }

    // ---------- SESSION EXPIRATION ----------
    public function isSessionExpired($timeout = 3600) {
        if (!$this->isLoggedIn()) return true;

        $loginTime = $_SESSION['login_time'] ?? 0;
        if ($loginTime && (time() - $loginTime) > $timeout) {
            $this->setFlash('error', 'Your session has expired. Please log in again.');
            $this->logout();
            return true;
        }
        $_SESSION['login_time'] = time(); // refresh timestamp
        return false;
    }

    // ---------- GETTERS ----------
    public function getUserId() {
        return $_SESSION['user_id'] ?? null;
    }

    public function getEmail() {
        return $_SESSION['email'] ?? null;
    }

    public function getFirstName() {
        return $_SESSION['first_name'] ?? null;
    }

    public function getLastName() {
        return $_SESSION['last_name'] ?? null;
    }

    public function getUserType() {
        return $_SESSION['user_type'] ?? null;
    }

    public function getUniversity() {
        return $_SESSION['university'] ?? null;
    }

    public function getMajor() {
        return $_SESSION['major'] ?? null;
    }

    public function getYearOfStudy() {
        return $_SESSION['year_of_study'] ?? null;
    }
}

$session = new Session();
