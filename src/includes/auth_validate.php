<?php
$VPN_CIDRS = ['10.0.0.0/24'];

$client_ip = $_SERVER['REMOTE_ADDR'] ?? '';

/* Prefer X-Real-IP if your proxy sets it; otherwise first XFF entry.
   Only do this if you are actually behind a trusted proxy (best practice),
   but this is the minimal functional improvement. */
if (!empty($_SERVER['HTTP_X_REAL_IP'])) {
    $client_ip = trim($_SERVER['HTTP_X_REAL_IP']);
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $client_ip = trim(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0]);
}

/* If it isn't a valid IPv4, fail closed (or implement IPv6 support). */
if (!filter_var($client_ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
    http_response_code(403);
    exit('VPN access required');
}
//If User is logged in the session['user_logged_in'] will be set to true

//if user is Not Logged in, redirect to login.php page.
if (!isset($_SESSION['user_logged_in'])) {
	header('Location:login.php');
}

 ?>
