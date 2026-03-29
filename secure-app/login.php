<?php
require_once __DIR__ . '/config.php';

if (isset($_SESSION['user'])) {
    header('Location: dashboard.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if ($username === 'admin' && $password === 'password') {
        if (isSecureMode()) {
            session_regenerate_id(true);
        }

        $_SESSION['user'] = 'admin';
        logAction('admin', 'login');
        header('Location: dashboard.php');
        exit;
    }

    $error = 'Invalid credentials';
}

$msg = isset($_GET['msg']) ? $_GET['msg'] : '';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body { font-family: Tahoma, sans-serif; margin: 0; background: #f4f7fb; color: #1f2937; }
        .card { max-width: 500px; margin: 60px auto; background: #fff; padding: 28px; border-radius: 10px; box-shadow: 0 8px 24px rgba(0,0,0,0.08); }
        .row { margin-bottom: 12px; }
        input { width: 100%; box-sizing: border-box; padding: 10px; border: 1px solid #cbd5e1; border-radius: 8px; }
        button { border: 0; padding: 10px 14px; border-radius: 8px; cursor: pointer; font-weight: bold; background: #1d4ed8; color: #fff; }
        .mode { padding: 10px 14px; border-radius: 8px; margin-bottom: 14px; background: #eef2ff; }
        .error { color: #b91c1c; margin-bottom: 12px; }
        .info { color: #1d4ed8; margin-bottom: 12px; }
        a { color: #1d4ed8; }
    </style>
</head>
<body>
<div class="card">
    <h1>Login</h1>
    <div class="mode"><strong>Current Mode:</strong> <?php echo ucfirst(currentMode()); ?></div>

    <?php if ($msg !== ''): ?>
        <div class="info"><?php echo htmlspecialchars($msg, ENT_QUOTES, 'UTF-8'); ?></div>
    <?php endif; ?>

    <?php if ($error !== ''): ?>
        <div class="error"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div>
    <?php endif; ?>

    <form method="post" action="login.php">
        <div class="row">
            <label for="username">Username</label>
            <input id="username" type="text" name="username" required>
        </div>
        <div class="row">
            <label for="password">Password</label>
            <input id="password" type="password" name="password" required>
        </div>
        <button type="submit">Login</button>
    </form>

    <p><a href="index.php">Back to mode selection</a></p>
</div>
</body>
</html>
