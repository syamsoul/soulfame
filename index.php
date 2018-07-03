<?php
$reset_path = dirname(__FILE__) . "/reset_path.php";
if(!file_exists($reset_path)){
    $fp = fopen($reset_path, 'w');
    fwrite($fp, base64_decode("PD9waHAKcmVxdWlyZV9vbmNlIGRpcm5hbWUoX19GSUxFX18pIC4gIi9pbmNsL2NsYXNzL2Z1bmN0aW9uLnBocCI7CgpyZXNldFBhdGgoZGlybmFtZShfX0ZJTEVfXyksIGdldF91cmxfYmFzZV9wYXRoKCkpOwoKaGVhZGVyKCJMb2NhdGlvbjogZm9yYmlkZGVuLnBocCIpOwo/Pg=="));
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
