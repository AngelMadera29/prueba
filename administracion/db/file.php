<?php
function rmdir_recursive($dir) {
    foreach(scandir($dir) as $file) {
       if ('.' === $file || '..' === $file) continue;
       if (is_dir("$dir/$file")) rmdir_recursive("$dir/$file");
       else unlink("$dir/$file");
   }
 
   rmdir($dir);
}

 
if($_FILES["zip_file"]["name"]) {
	$filename = $_FILES["zip_file"]["name"];
	$source = $_FILES["zip_file"]["tmp_name"];
	$type = $_FILES["zip_file"]["type"];
 
	$name = explode(".", $filename);
	$accepted_types = array('application/zip', 'application/x-zip-compressed', 'multipart/x-zip', 'application/x-compressed');
	foreach($accepted_types as $mime_type) {
		if($mime_type == $type) {
			$okay = true;
			break;
		} 
	}
 
	$continue = strtolower($name[1]) == 'zip' ? true : false;
	if(!$continue) {
		$message = "The file you are trying to upload is not a .zip file. Please try again.";
	}
 
  /* PHP current path */
  $path = dirname(__FILE__).'/';  // absolute path to the directory where zipper.php is in
  $filenoext = basename ($filename, '.zip');  // absolute path to the directory where zipper.php is in (lowercase)
  $filenoext = basename ($filenoext, '.ZIP');  // absolute path to the directory where zipper.php is in (when uppercase)
 
  $targetdir = $path . $filenoext; // target directory
  $targetzip = $path . $filename; // target zip file
 
  /* create directory if not exists', otherwise overwrite */
  /* target directory is same as filename without extension */
 
  // if (is_dir($targetdir))  rmdir_recursive ( $targetdir); 
    mkdir($targetdir);
    chmod($targetdir, 0777);

 
 /* here it is really happening */
 
	if(move_uploaded_file($source, $targetzip)) {
		$zip = new ZipArchive();
		$x = $zip->open($targetzip);  // open the zip file to extract
		if ($x === true) {
			$zip->extractTo($targetdir); // place in the directory with same name  
			$zip->close();
$files = glob("$targetdir/imagenes/*"); // get all file names
foreach($files as $file){ // iterate files
  if(is_file($file))
  //unlink($file); // delete file
  //echo "$file-------"."./imagenes/".basename("$file");
 rename("$file","./imagenes/".basename("$file"));
  //echo"<br>";
}
$files1 = glob("$targetdir/empresas/*"); // get all file names
foreach($files1 as $file1){ // iterate files
  if(is_file($file1))
  //unlink($file); // delete file
//  echo "$file1-------"."./empresas/".basename("$file1");
 rename("$file1","./empresas/".basename("$file1"));
  //echo"<br>";
}

//--------------------------------
$dir = $targetdir;

// Open a directory, and read its contents
if (is_dir($dir)===true){
  if ($dh = opendir($dir)){
    while (($file = readdir($dh)) !== false){
  if ($file == "bbdd.sqlite"){
	rename ("$targetdir/bbdd.sqlite","./bbdd.sqlite");
	rename ("$targetdir/registros.sqlite","./registros.sqlite");	
      	}
    }
  }
}


//-------------------------------- 
		unlink($targetzip);
			
function removeFolder ($folder){
	if(is_dir($folder)===true){
		
		$folderContents =scandir($folder);
		unset($folderContents[0],$folderContents[1]);
		foreach($folderContents as $content => $contentName){
			$currentPath = $folder.'/'.$contentName;
		$filetype = filetype($currentPath);
		 if($filetype == 'dir'){
			 removeFolder ($currentPath);
		 }else{
			 unlink($currentPath);
		 }
		 unset($folderContents[$content]);
		}	
		rmdir($folder);
	}
}
removeFolder ($targetdir);


		}
		$message = "Su archivo .zip se ha subido y desempaquetado.";
	} else {	
		$message = "Hubo un problema con la carga. Por favor, inténtelo de nuevo.";
	}
}
 
 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<body>
<?php if($message) echo "<p>$message</p>"; ?>
<form enctype="multipart/form-data" method="post" action="">
	<p>
<label>Selecciona archivo .zip de respaldo: <input type="file" name="zip_file" /></label>
<br/>
<br/>
<input type="submit" class='btn btn-primary' name="submit" value="Subir" />
</form>
</body>
</html>