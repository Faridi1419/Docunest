<?php
// sign-up.php
require_once __DIR__ . '/includes/session.php';
require_once __DIR__ . '/includes/functions.php';

$session = new Session();

// Redirect to vault if already logged in
$session->redirectIfLoggedIn('vault.php');

// Retrieve flash message set by processes/signup_process.php
$flash = $session->getFlash();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up - DocuNest</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f0f2f5; padding: 50px; }
        .container { max-width: 400px; margin: auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h1 { text-align: center; }
        input { width: 100%; padding: 10px; margin: 8px 0; border-radius: 4px; border: 1px solid #ccc; }
        button { width: 100%; padding: 10px; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background: #0056b3; }
        .errors { color: red; margin-bottom: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Sign Up</h1>

        <?php if (!empty($errors)): ?>
            <div class="errors">
                <?php foreach ($errors as $err) echo "<p>$err</p>"; ?>
            </div>
        <?php endif; ?>

    <form method="POST" action="/processes/signup_process.php">

    <?php if ($flash): ?>
        <div class="<?php echo ($flash['type'] == 'error' ? 'alert-error' : 'alert-success'); ?>">
            <?php echo htmlspecialchars($flash['message']); ?>
        </div>
    <?php endif; ?>

    <input type="text" name="first_name" placeholder="First Name" required value="<?php echo htmlspecialchars($_POST['first_name'] ?? ''); ?>">
    <input type="text" name="last_name" placeholder="Last Name" required value="<?php echo htmlspecialchars($_POST['last_name'] ?? ''); ?>">
    <input type="email" name="email" placeholder="Email" required value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
    <input type="password" name="password" placeholder="Password (min 6 chars)" required>
    <input type="password" name="confirm_password" placeholder="Confirm Password" required>

    <input type="text" name="university" placeholder="University (Optional)">
    <input type="text" name="major" placeholder="Major (Optional)">
    <input type="text" name="year_of_study" placeholder="Year of Study (Optional)">

    <button type="submit">Sign Up</button>
</form>

    </div>
</body>
</html>
