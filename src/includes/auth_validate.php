<?php
// VPN-only admin gate (WireGuard subnet)
$VPN_CIDRS = array('10.0.0.0/24'); // your wg subnet

$client_ip = $_SERVER['REMOTE_ADDR'];
if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $client_ip = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0];
    $client_ip = trim($client_ip);
}

function ip_in_cidr($ip, $cidr) {
    if (strpos($cidr, '/') === false) return $ip === $cidr;
    list($subnet, $bits) = explode('/', $cidr);
    $ip_long = ip2long($ip);
    $subnet_long = ip2long($subnet);
    if ($ip_long === false || $subnet_long === false) return false;
    $mask = -1 << (32 - (int)$bits);
    return ($ip_long & $mask) === ($subnet_long & $mask);
}

$is_vpn = false;
foreach ($VPN_CIDRS as $cidr) {
    if (ip_in_cidr($client_ip, $cidr)) { $is_vpn = true; break; }
}

if (!$is_vpn) {
    http_response_code(403);
    exit('VPN access required');
}
//If User is logged in the session['user_logged_in'] will be set to true

//if user is Not Logged in, redirect to login.php page.
if (!isset($_SESSION['user_logged_in'])) {
	header('Location:login.php');
}

 ?>
