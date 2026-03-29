<?php
require_once __DIR__ . '/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mode'])) {
    header('Location: login.php');
    exit;
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Session & CSRF Demo</title>
    <style>
        body { font-family: Tahoma, sans-serif; margin: 0; background: #f4f7fb; color: #1f2937; }
        .card { max-width: 700px; margin: 60px auto; background: #fff; padding: 28px; border-radius: 10px; box-shadow: 0 8px 24px rgba(0,0,0,0.08); }
        h1 { margin-top: 0; }
        .mode { padding: 10px 14px; border-radius: 8px; margin: 14px 0 20px; background: #eef2ff; }
        .btns { display: flex; gap: 12px; flex-wrap: wrap; }
        button { border: 0; padding: 12px 18px; border-radius: 8px; cursor: pointer; font-weight: bold; }
        .insecure { background: #ef4444; color: #fff; }
        .secure { background: #059669; color: #fff; }
        .hint { margin-top: 20px; color: #4b5563; }
    </style>
</head>
<body>
<div class="card">
    <h1>Session Security & CSRF Demo</h1>
    <p>Select a mode to compare insecure behavior with secure defenses.</p>
    <div class="mode">
        <strong>Current Mode:</strong> <?php echo ucfirst(currentMode()); ?>
    </div>

    <form method="post" class="btns">
        <button type="submit" name="mode" value="insecure" class="insecure">Insecure Mode</button>
        <button type="submit" name="mode" value="secure" class="secure">Secure Mode</button>
    </form>

    <p class="hint">After selecting mode, login with username <strong>admin</strong> and password <strong>password</strong>.</p>
</div>
</body>
</html>
