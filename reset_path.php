<?php
require_once dirname(__FILE__) . "/incl/class/function.php";

$force_https = false;

resetPath(dirname(__FILE__), get_url_base_path(), $force_https);

header("Location: forbidden.php");
?>
