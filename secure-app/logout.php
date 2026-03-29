<?php
require_once __DIR__ . '/config.php';

$user = isset($_SESSION['user']) ? $_SESSION['user'] : 'guest';
logAction($user, 'logout');

session_unset();
session_destroy();

header('Location: login.php');
exit;
