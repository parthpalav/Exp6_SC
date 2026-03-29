<?php

$requestedMode = null;
if (isset($_POST['mode'])) {
    $requestedMode = $_POST['mode'];
} elseif (isset($_GET['mode'])) {
    $requestedMode = $_GET['mode'];
} elseif (isset($_COOKIE['app_mode'])) {
    $requestedMode = $_COOKIE['app_mode'];
}

if ($requestedMode !== 'secure' && $requestedMode !== 'insecure') {
    $requestedMode = 'insecure';
}

if ($requestedMode === 'secure') {
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'domain' => '',
        'secure' => false,
        'httponly' => true,
        'samesite' => 'Lax'
    ]);
}

session_start();

if (isset($_POST['mode']) && ($_POST['mode'] === 'secure' || $_POST['mode'] === 'insecure')) {
    $_SESSION['mode'] = $_POST['mode'];
    setcookie('app_mode', $_POST['mode'], time() + (86400 * 30), '/');
}

if (!isset($_SESSION['mode'])) {
    $_SESSION['mode'] = $requestedMode;
}

function currentMode()
{
    return (isset($_SESSION['mode']) && $_SESSION['mode'] === 'secure') ? 'secure' : 'insecure';
}

function isSecureMode()
{
    return currentMode() === 'secure';
}

if (isSecureMode()) {
    header('X-Frame-Options: DENY');
    header('X-Content-Type-Options: nosniff');
    header("Content-Security-Policy: default-src 'self'");

    $timeoutSeconds = 900;
    if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > $timeoutSeconds)) {
        session_unset();
        session_destroy();
        session_start();
        $_SESSION['mode'] = 'secure';
        header('Location: login.php?msg=Session+expired+due+to+inactivity');
        exit;
    }

    $_SESSION['LAST_ACTIVITY'] = time();
}

function logAction($user, $action)
{
    $logFile = __DIR__ . '/logs.txt';
    $username = $user ? $user : 'guest';
    $mode = currentMode();
    $line = sprintf(
        "[%s] USER: %s | ACTION: %s | MODE: %s\n",
        date('Y-m-d H:i:s'),
        $username,
        $action,
        $mode
    );

    file_put_contents($logFile, $line, FILE_APPEND | LOCK_EX);
}
