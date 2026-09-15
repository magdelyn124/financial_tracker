<?php
session_start();

session_unset();
session_destroy();

header("Location: /financial_tracker/auth/login.php");
exit();
?>