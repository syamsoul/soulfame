<?php
if(!isset($_ROUTE['filename']) || empty($_ROUTE['filename'])) die("ERROR: No image path provided");

$file_path = IMG_STORAGE_PATH;
if(!empty($_ROUTE['folder'])) $file_path .= "/" . $_ROUTE['folder'];
$file_path .= "/" . $_ROUTE['filename'];

if(!file_exists($file_path)) die("ERROR: No image found");

$filename = basename($file_path);
$file_extension = strtolower(substr(strrchr($filename,"."),1));

switch( $file_extension ) {
    case "gif": $ctype="image/gif"; break;
    case "png": $ctype="image/png"; break;
    case "jpeg":
    case "jpg": $ctype="image/jpeg"; break;
    default:
}

header('Content-type: ' . $ctype);
header('Content-Length: ' . filesize($file_path));
readfile($file_path);


function checkIsExist($folder_file, $module_name, $table){

    global $db, $module, $aid;

    if(!$module->check($module_name)) return false;

    $is_exist = $db->select($table, Array("id"), Array("admin_id"=>$aid, "image_filename"=>$folder_file[1]), 1, 1);
    if($is_exist === false) return false;

    return true;

}
?>
