<?php
$reset_path = dirname(__FILE__) . "/reset_path.php";
if(!file_exists($reset_path)){
    $fp = fopen($reset_path, 'w');
    fwrite($fp, base64_decode("PD9waHANCnJlcXVpcmVfb25jZSBkaXJuYW1lKF9fRklMRV9fKSAuICIvaW5jbC9jbGFzcy9mdW5jdGlvbi5waHAiOw0KDQokZm9yY2VfaHR0cHMgPSBmYWxzZTsNCg0KcmVzZXRQYXRoKGRpcm5hbWUoX19GSUxFX18pLCBnZXRfdXJsX2Jhc2VfcGF0aCgpLCAkZm9yY2VfaHR0cHMpOw0KDQpoZWFkZXIoIkxvY2F0aW9uOiBmb3JiaWRkZW4ucGhwIik7DQo/Pg0K"));
    fclose($fp);
    header("Location: reset_path.php");
    exit();
}

define("APP_ROOT_DIR", dirname(__FILE__));
define("CURRENT_PAGE", $_GET['page']);

require_once APP_ROOT_DIR . "/incl/init.php";
require_once APP_ROOT_DIR . "/incl/config/route.php";
require_once APP_ROOT_DIR . "/incl/config/nav.php";

$navmenu->checkActiveNav(CURRENT_PAGE, true);
$filename = $pages->executeRoute(CURRENT_PAGE);

if($filename === false){
    die("ERROR: No page found");
}
require $filename;
?>
