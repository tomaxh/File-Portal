<?php

$download_file = '';
//Unable to get Payload from Ajax post method.
//Static file name can be downloaded.

//Use hidden form to pass filename
$download_file = $_REQUEST['downFileName'];
$modifiedName='';

//PHP get cookie method $_COOKIE represents '.' as '_'.
//rename the cookie for file downloading.
$cookieString = pathinfo($download_file)['filename'].'_'.pathinfo($download_file)['extension'];

//set modified name if the cookie exist.
if(isset($_COOKIE[$cookieString])){
    $modifiedName = ($_COOKIE[$cookieString]).'_';
}

//set target upload path
$file_path = __DIR__."\\_uploads\\".$download_file;
//check
$file_basename= basename($download_file);

if(!file_exists($file_path)){
    echo "File does not exist."; 
    return ; 
}else{
    $file_size=filesize($file_path);
    $fp=fopen($file_path,"r");
    
    Header("Content-type: application/octet-stream");
    Header("Accept-Ranges: bytes"); 
    Header("Accept-Length:".$file_size); 
    Header("Content-Disposition:attachment;filename=".pathinfo($download_file)['filename'].'_'.$modifiedName.date('Y-m-d').'.'.pathinfo($download_file)['extension']); 
  
    readfile($file_path);
}

?>