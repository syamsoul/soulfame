<?php
$root = dirname(__FILE__);
$filename = $root . "/install.php";
$handle = fopen($filename, "r");
$contents = fread($handle, filesize($filename));
fclose($handle);
?>

<?=base64_encode($contents)?>
