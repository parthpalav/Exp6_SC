<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/csrf.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$token = '';
if (isSecureMode()) {
    $token = generateToken();
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body { font-family: Tahoma, sans-serif; margin: 0; background: #f4f7fb; color: #1f2937; }
        .card { max-width: 650px; margin: 60px auto; background: #fff; padding: 28px; border-radius: 10px; box-shadow: 0 8px 24px rgba(0,0,0,0.08); }
        .mode { padding: 10px 14px; border-radius: 8px; margin: 14px 0; background: #eef2ff; }
        button { border: 0; padding: 12px 18px; border-radius: 8px; cursor: pointer; font-weight: bold; background: #0f766e; color: #fff; }
        a { color: #1d4ed8; }
    </style>
</head>
<body>
<div class="card">
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['user'], ENT_QUOTES, 'UTF-8'); ?></h1>
    <div class="mode"><strong>Current Mode:</strong> <?php echo ucfirst(currentMode()); ?></div>

    <p>This dashboard performs a state-changing transfer action.</p>

    <form method="post" action="transfer.php">
        <input type="hidden" name="amount" value="1000">
        <?php if (isSecureMode()): ?>
            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($token, ENT_QUOTES, 'UTF-8'); ?>">
        <?php endif; ?>
        <button type="submit">Transfer ₹1000</button>
    </form>

    <p><a href="logout.php">Logout</a> | <a href="index.php">Change mode</a></p>
</div>
</body>
</html>
