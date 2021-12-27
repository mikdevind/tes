<?php
if(isset($_POST['excute']))
{
 $uploadfile=$_FILES["file_upload"]["tmp_name"];
 $folder="uploads/";
 $file_name=$_FILES["file_upload"]["name"];
 move_uploaded_file($_FILES["file_upload"]["tmp_name"], "$folder".$_FILES["file_upload"]["name"]);

 $zip = new \ZipArchive; // Load zip library 
 $zip_name ="upload.zip"; // Zip name
 if($zip->open($zip_name, ZIPARCHIVE::CREATE)!==TRUE)
 { 
  echo "Sorry ZIP creation failed at this time";
 }
 $zip->addFile("uploads/".$file_name);
 $zip->close();
}
?>