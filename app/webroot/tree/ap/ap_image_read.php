<?php
$img_id = htmlentities($_GET['r']);
$file = 'images/image-' . $img_id . '.jpg'; 
$filename = basename($file);
$file_extension = strtolower(substr(strrchr($filename,"."),1));

switch( $file_extension ) {
    case "gif": $ctype="image/gif"; break;
    case "png": $ctype="image/png"; break;
    case "jpeg":
    case "jpg": $ctype="image/jpg"; break;
    default:
}
header('Content-type: ' . $ctype);
readfile($file);
