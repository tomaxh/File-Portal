<?php
// store file object(array?)
$upFile=$_FILES['file'];
if ($_FILES['file']['error'] > 0)
  {
  echo 'Error: ' . 'Empty/invalid file submitted.'. '<br />';
  }
//setting constants and flag
$type = array('php', 'css', 'js', 'html', );
$status = true;
$dest_dir= __DIR__.'\\_uploads\\';
$target_file = '';
    if( !is_dir($dest_dir) || !is_writeable($dest_dir) )
    {
        die('Upload file '.$dest_dir.' DNE or cannot write.');
    }else{
      $target_file = $dest_dir . basename($upFile['name']);
      echo '('.$target_file . ' is the target file path.'. ')'.'<br/>';

    }
//condition checks for uploading file
if (!checkFileType($upFile, $type)){
  $status = false;
  echo 'Only accepts '. implode(',',$type) .'. <br/>';
}

if(!checkFileSize($upFile)){
  $status = false;
  echo 'Only accepts file size from 1KB to 1MB.' .'<br/>';
}
//If requirement meet, start upload
if($status){
  if(move_uploaded_file($upFile['tmp_name'], $target_file)){
    echo '<strong>'.'The file '. basename($upFile['name']). ' has been uploaded. Returning to the main page.<br/></strong>';
  }
}else{
  echo '<strong>Unable to upload file, check file requirements.</strong>';
}



//check file type
function checkFileType($file, $type){
  return in_array(pathinfo($file['name'])['extension'], $type);
}

//check file size
function checkFileSize($file){
  return  ($file['size'] <= 1048576) && ($file['size'] >= 1000);
}

//If modified name is avaliable, store the modified name in the cookie with key=original filename
function modifyName($file){
  $cookie_name = $file['name'];
  if ($_REQUEST['filename'] !=null){
    setcookie($cookie_name, ($_REQUEST['filename']), (20 * 365 * 24 * 60 * 600), '/',null);
  }
}


modifyName($upFile);

//auto redirect to main page
header( "refresh:3;url=index.html" );



?>