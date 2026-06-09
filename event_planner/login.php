<?php
require_once 'db.php';
session_start();

// Redirect user to the marketplace if they are already signed in
if (isset($_SESSION['user_id'])) {
    header("Location: explore.php");
    exit;
}

$error_msg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (!empty($email) && !empty($password)) {
        try {
            // Lookup user associated with input email
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            // Evaluate database matching tokens and cross-reference crypt hash structures
            if ($user && password_verify($password, $user['password_hash'])) {
                // Initialize global system access cookie tokens
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['full_name'];
                
                header("Location: explore.php");
                exit;
            } else {
                $error_msg = "Invalid email or password combination.";
            }
        } catch (Exception $e) {
            $error_msg = "Authentication engine processing error.";
        }
    } else {
        $error_msg = "Please fill in all security credentials.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In | EliteEvents</title>
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
            <h2>Welcome Back</h2>
            <p>Log in to access your personal dashboard, tickets, and reservations.</p>
        </div>

        <?php if (!empty($error_msg)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error_msg) ?></div>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" placeholder="yourname@domain.com" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="••••••••" required>
            </div>
            <button type="submit" class="auth-btn">Sign In</button>
        </form>

        <div class="auth-footer">
            New to our platform? <a href="register.php">Create Account</a>
        </div>
    </div>

</body>
</html>