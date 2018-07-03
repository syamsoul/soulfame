<?php
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
