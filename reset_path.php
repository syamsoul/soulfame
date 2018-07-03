<?php
require_once dirname(__FILE__) . "/incl/config/general.php";
require_once dirname(__FILE__) . "/incl/class/function.php";

resetPath(dirname(__FILE__), URL_BASE_PATH);

header("Location: forbidden.php");
?>
