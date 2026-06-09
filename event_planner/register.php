<?php
require_once 'db.php';
session_start();

// Redirect user to the marketplace if they are already signed in
if (isset($_SESSION['user_id'])) {
    header("Location: explore.php");
    exit;
}

$error_msg = "";
$success_msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (!empty($full_name) && !empty($email) && !empty($password)) {
        try {
            // Check if email already exists in the system
            $check_stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
            $check_stmt->execute([$email]);
            
            if ($check_stmt->fetch()) {
                $error_msg = "This email address is already registered.";
            } else {
                // Securely hash the password string before database insertion
                $hashed_password = password_hash($password, PASSWORD_BCRYPT);
                
                // Insert user account logs into MySQL
                $insert_stmt = $pdo->prepare("INSERT INTO users (full_name, email, password_hash) VALUES (?, ?, ?)");
                $insert_stmt->execute([$full_name, $email, $hashed_password]);
                
                $success_msg = "Account created successfully! You can now login.";
            }
        } catch (Exception $e) {
            $error_msg = "Registration system failure. Please try again later.";
        }
    } else {
        $error_msg = "Please fill in all required configuration fields.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create an Account | EliteEvents</title>
    <style>
        /* Cute Pink & Pastel Aesthetic Theme Architecture */
        :root {
            --primary: #ff769f;          /* Bright pastel pink for buttons and focus */
            --primary-light: #ffb3c6;    /* Soft blush pink for borders and highlights */
            --primary-dark: #e0537d;     /* Deep rose pink for hover states */
            --secondary: #fcd34d;        /* Soft pastel gold for a tiny sparkle accent */
            --dark-bg: #2d1b22;          /* Cozy deep plum-brown instead of harsh black */
            --card-bg: #ffffff;          /* Clean white for event cards */
            --text-main: #4a2834;        /* Deep berry colored text instead of gray */
            --text-muted: #a78bfa;       /* Pastel lavender for secondary icons/text */
            --body-bg: #fff0f3;          /* Sweet, soft pastel pink-tinted background */
            --border-color: #ffe3e8;     /* Ultra soft pink borders */
            --radius-lg: 20px;           /* Rounder, cuter corners for cards and inputs */
            --radius-sm: 10px;          /* Rounder button edges */
            --shadow-sm: 0 8px 16px -4px rgba(255, 118, 159, 0.1);
            --shadow-lg: 0 20px 30px -10px rgba(74, 40, 52, 0.15);
            --transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275); /* Bouncy, playful transitions */
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: system-ui, -apple-system, sans-serif; }

        body {
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .auth-card {
            background: var(--card-bg);
            max-width: 450px;
            width: 100%;
            padding: 40px;
            border-radius: var(--radius);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3);
        }

        .auth-header h2 { font-size: 28px; font-weight: 800; color: var(--dark-bg); margin-bottom: 8px; }
        .auth-header p { color: var(--text-muted); font-size: 14px; margin-bottom: 24px; }

        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-size: 14px; font-weight: 600; color: var(--text-main); margin-bottom: 6px; }
        .form-group input {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 15px;
            outline: none;
            transition: var(--transition);
        }
        .form-group input:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15); }

        .alert { padding: 12px 16px; border-radius: 8px; font-size: 14px; font-weight: 600; margin-bottom: 20px; }
        .alert-danger { background: #fee2e2; color: #991b1b; }
        .alert-success { background: #d1fae5; color: #065f46; }

        .auth-btn {
            width: 100%;
            background: var(--primary);
            color: white;
            border: none;
            padding: 14px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: var(--transition);
        }
        .auth-btn:hover { background: var(--primary-dark); }

        .auth-footer { text-align: center; margin-top: 24px; font-size: 14px; color: var(--text-muted); }
        .auth-footer a { color: var(--primary); text-decoration: none; font-weight: 600; }
        .auth-footer a:hover { text-decoration: underline; }
    </style>
</head>
<body>

    <div class="auth-card">
        <div class="auth-header">
            <h2>Get Started</h2>
            <p>Create your custom user profile to access event tickets instantly.</p>
        </div>

        <?php if (!empty($error_msg)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error_msg) ?></div>
        <?php endif; ?>

        <?php if (!empty($success_msg)): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success_msg) ?></div>
        <?php endif; ?>

        <form action="register.php" method="POST">
            <div class="form-group">
                <label for="full_name">Full Name</label>
                <input type="text" id="full_name" name="full_name" placeholder="full names" required>
            </div>
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" placeholder="name@domain.com" required>
            </div>
            <div class="form-group">
    <label for="password">Password</label>
    <input type="password" id="password" name="password" placeholder="••••••••" required>
    
    <div class="password-meter-container" style="margin-top: 8px;">
        <div id="strengthBar" style="height: 6px; width: 0%; background: #e2e8f0; border-radius: 4px; transition: all 0.3s ease;"></div>
        <p id="strengthText" style="font-size: 12px; font-weight: 600; margin-top: 4px; color: var(--text-muted);"></p>
    </div>
</div>
            <button type="submit" class="auth-btn">Register Account</button>
        </form>

        <div class="auth-footer">
            Already have an active profile? <a href="login.php">Sign In</a>
        </div>
    </div>
      <script src="app.js"></script>
</body>
</html>