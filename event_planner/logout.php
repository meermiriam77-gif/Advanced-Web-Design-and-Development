<?php
/**
 * EliteEvents Secure Logout Handlers
 * Destroys all current server cookie properties.
 */
session_start();

// Unset all session array data structures
$_SESSION = array();

// Destroy server file traces completely
session_destroy();

// Route traffic back cleanly
header("Location: login.php");
exit;
?>