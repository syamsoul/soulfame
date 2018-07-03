<?php
define("APP_ROOT_DIR", dirname(__FILE__));
define("URL_BASE_PATH", (function(){
    $script_name = isset($_SERVER['SCRIPT_NAME']) ? $_SERVER['SCRIPT_NAME'] : $_SERVER['PHP_SELF'];
    if(empty($script_name)) die("ERROR: URL_BASE_PATH is empty");
    $script_name = str_replace("index.php", "", $script_name);
    while(substr($script_name, -1, 1) == "/") $script_name = substr($script_name, 0, -1);
    return $script_name;
})());
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
