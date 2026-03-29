<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/csrf.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: dashboard.php');
    exit;
}

if (isSecureMode()) {
    $token = isset($_POST['csrf_token']) ? $_POST['csrf_token'] : '';
    if (!verifyToken($token)) {
        http_response_code(403);
        exit('CSRF attack detected');
    }
}

$amount = isset($_POST['amount']) ? preg_replace('/[^0-9]/', '', $_POST['amount']) : '1000';
if ($amount === '') {
    $amount = '1000';
}

logAction($_SESSION['user'], 'transfer');
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transfer Result</title>
    <style>
        body { font-family: Tahoma, sans-serif; margin: 0; background: #f4f7fb; color: #1f2937; }
        .card { max-width: 650px; margin: 60px auto; background: #fff; padding: 28px; border-radius: 10px; box-shadow: 0 8px 24px rgba(0,0,0,0.08); }
        .mode { padding: 10px 14px; border-radius: 8px; margin: 14px 0; background: #eef2ff; }
        a { color: #1d4ed8; }
    </style>
</head>
<body>
<div class="card">
    <h1>Transfer Complete</h1>
    <div class="mode"><strong>Current Mode:</strong> <?php echo ucfirst(currentMode()); ?></div>
    <p>₹<?php echo htmlspecialchars($amount, ENT_QUOTES, 'UTF-8'); ?> transferred successfully.</p>
    <p><a href="dashboard.php">Back to Dashboard</a></p>
</div>
</body>
</html>
