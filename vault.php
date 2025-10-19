<?php
// vault.php — Fixed version

// Vault.php

// ✅ Keep functions.php if you still use utilities like formatFileSize, etc.
require_once __DIR__ . '/includes/session.php';
require_once __DIR__ . '/includes/functions.php'; 
require_once __DIR__ . '/includes/auth.php';

// ✅ Use the Session object for redirects
$session = new Session();
$session->redirectIfNotLoggedIn('log-in.php');

// ... rest of the file
// ✅ Initialize Auth handler
$auth = new Auth();
$auth->setSession($session);

// ✅ Get user info
$userId = $session->getUserId();
$user = null;

if ($userId) {
    $user = $auth->getUserById($userId);
}

// ✅ Fallback user data if DB fetch fails
if (!$user) {
    $user = [
        'first_name' => $session->getFirstName() ?: 'User',
        'last_name'  => $session->getLastName() ?: '',
        'email'      => $session->getEmail() ?: 'User'
    ];
}

// Full name helper
$userFullName = trim($user['first_name'] . ' ' . $user['last_name']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Vault - DocuNest</title>
  <link rel="stylesheet" href="css/vault.css">
</head>
<body>

  <!-- Quick Logout Button -->
  <div style="position: fixed; top: 15px; right: 15px; z-index: 1000;">
    <span style="margin-right: 15px;">
      Welcome, <strong><?php echo htmlspecialchars($userFullName); ?></strong>
    </span>
    <button onclick="location.href='processes/logout.php'" 
            style="padding: 8px 15px; background: #ff4444; color: white; border: none; border-radius: 4px; cursor: pointer;">
      Logout
    </button>
  </div>

  <button id="darkModeToggle">🌙 Toggle Dark Mode</button>

  <div class="main-container">
    <!-- Sidebar -->
    <div class="sidebar">
      <div class="sidebar-top">
        <div class="search-bar">
          <input type="text" placeholder="Search">
        </div>

        <h2 class="title">My Vault</h2>

        <ul class="nav-section">
          <li><span>🏠</span> Home</li>
          <li><span>🛒</span> Book Store</li>
          <li id="myDocumentsBtn"><span>📂</span> My Documents</li>
        </ul>

        <h4 class="section-title">Library</h4>
        <ul class="nav-section">
          <li><span>📁</span> All</li>
          <li><span>📖</span> Want to Read</li>
          <li><span>✅</span> Finished</li>
          <li><span>📕</span> Books</li>
          <li><span>📄</span> PDFs</li>
          <li id="mySamplesBtn"><span>📌</span> My Samples</li>
        </ul>

        <h4 class="section-title">My Collections</h4>
        <ul class="nav-section">
          <li><span>➕</span> New Collection</li>
        </ul>
      </div>

      <div class="sidebar-bottom">
        <div class="user-info">
          <img src="assets/pictures/photo_2025-01-13_07-38-34.jpg" alt="User">
          <p id="username-display">
            <?php echo htmlspecialchars($userFullName ?: 'User'); ?>
          </p>
          <button id="signOutBtn" onclick="location.href='processes/logout.php'">
            Sign Out
          </button>
        </div>
      </div>
    </div>

    <!-- Right Side Content -->
    <div class="content">
      <div class="header-row">
        <h1>Home</h1>
      </div>

      <!-- Continue Reading Section -->
      <div class="section">
        <h3>Continue</h3>
        <div class="continue-scroll">
          <div class="continue-card">📖 Elevate and Dominate<br><small>1%</small></div>
          <div class="continue-card">📚 Redwood Court<br><small>10%</small></div>
          <div class="continue-card">🔫 Crosshairs<br><small>55%</small></div>
        </div>
      </div>

      <!-- Library Section -->
      <div class="section">
        <h3>Library</h3>

        <div class="section">
          <h3>My Samples</h3>
          <div id="mySamplesContainer"></div>
        </div>

        <div class="library-grid">
          <div class="book-card">
            <img src="https://covers.openlibrary.org/b/id/10594795-L.jpg" alt="Book 1">
            <p>The Other Mothers</p>
          </div>

          <div class="book-card">
            <img src="https://covers.openlibrary.org/b/id/9871864-L.jpg" alt="Book 2">
            <p>Dark Matter</p>
          </div>

          <div class="book-card">
            <img src="https://covers.openlibrary.org/b/id/10590779-L.jpg" alt="Book 3">
            <p>May Picks</p>
          </div>

          <div class="book-card">
            <img src="https://covers.openlibrary.org/b/id/12751521-L.jpg" alt="Book 4">
            <p>Spring Picks</p>
          </div>
        </div>
      </div>

      <!-- Document Editor Section -->
      <div class="section">
        <h3>Write a New Document</h3>

        <div class="editor-toolbar">
          <button onclick="execCmd('bold')"><b>B</b></button>
          <button onclick="execCmd('italic')"><i>I</i></button>
          <button onclick="execCmd('underline')"><u>U</u></button>
          <button onclick="execCmd('insertUnorderedList')">• List</button>
          <button onclick="execCmd('justifyLeft')">🡸</button>
          <button onclick="execCmd('justifyCenter')">🡺🡸</button>
          <button onclick="execCmd('justifyRight')">🡺</button>
          <button onclick="execCmd('undo')">↺ Undo</button>
          <button onclick="execCmd('redo')">↻ Redo</button>
        </div>

        <div class="editor-area" contenteditable="true" id="editor">
          Start writing your document here...
        </div>
        <button id="saveDocBtn">Save Document</button>
      </div>
    </div> 
  </div>

  <script>
  function execCmd(command) {
    document.execCommand(command, false, null);
  }
  </script>

  <script src="js/vault.js"></script>
</body>
</html>
