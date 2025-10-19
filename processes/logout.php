<?php
// processes/logout.php
session_start();
require_once '../includes/auth.php';

$auth = new Auth();
$auth->logout();

header("Location: ../log-in.php");
exit();
?>