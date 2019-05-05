<?php
$dest_dir= __DIR__."\\_uploads\\";

$files = [];
//get filenames from dest folder
$handler = opendir($dest_dir);
while (($filename = readdir($handler)) !== false) {
  if ($filename != "." && $filename != "..") {  
          $files[] = $filename ;  
     }  
 }  
  
closedir($handler);  

$files = json_encode($files);
echo $files;

?>