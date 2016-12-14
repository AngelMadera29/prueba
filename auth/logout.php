<?php
	
if(INCLUDED!=true)exit;
include("includes/config.php");
include("$_SERVER[DOCUMENT_ROOT]/$path_website/auth/includes/database.class.php");
include("$_SERVER[DOCUMENT_ROOT]/$path_website/auth/header.php");
include("$_SERVER[DOCUMENT_ROOT]/$path_website/auth/includes/usuario.class.php");
include("$_SERVER[DOCUMENT_ROOT]/$path_website/auth/header_registered.php");

session_regenerate_id(true);
if (isset($_GET['url_source'])){
	header("Location:/".$path_website."/".$_GET['url_source']);
	exit;
	}
header("Location: /$path_website/$mainfile");
?>