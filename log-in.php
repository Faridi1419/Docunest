<?php
// login.php - FIXED VERSION (no database connection)
session_start(); // Only start session, no database

// Check for flash messages
$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

// Also check for URL error parameter
$error = $_GET['error'] ?? null;
?>

<!DOCTYPE html>
<html>
<head>
  <title>Login - Learning Log</title>
  <link rel="stylesheet" href="css/log-in.css">
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
  </style>
</head>
<body>

  <div class="main-container">
    <div class="login-container">
      <h2>Welcome Back</h2>
      
      <?php 
      // Display flash messages without database
      if ($flash): ?>
        <div class="alert alert-<?php echo $flash['type']; ?>">
          <?php echo $flash['message']; ?>
        </div>
      <?php endif; ?>
      
      <?php if ($error): ?>
        <div class="alert alert-error">
          <?php echo htmlspecialchars($error); ?>
        </div>
      <?php endif; ?>
      
      <form method="POST" action="processes/login_process.php">
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Log In</button>
      </form>

      <p>Don't have an account? <a href="signup.php">Sign up</a></p>
    </div>
  </div>

</body>
</html>