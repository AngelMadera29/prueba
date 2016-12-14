<?php
if(INCLUDED!=true)exit;
include_once ("auth/includes/usuario.class.php");
$user = new usuario_web();
$url = $user->get_url();
if (isset($_SESSION['basic_is_logged_in'])) 
	{
		
	}
	
 else {
		session_regenerate_id(true);
		$_SESSION = array();
		header("Location: login.php?url_source=$url");
		exit;
}
?>
