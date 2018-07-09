<?php
define("APP_ROOT_DIR", dirname(__FILE__));
define("CURRENT_PAGE", (isset($_GET['page']) ? $_GET['page'] : ""));

require_once APP_ROOT_DIR . "/incl/class/function.php";
require_once APP_ROOT_DIR . "/incl/config/general.php";

checkResetPath(FORCE_HTTPS, FORCE_SUBDOMAIN);

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
