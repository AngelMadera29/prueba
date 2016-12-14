<?php

if(INCLUDED!=true)exit;
include ("includes/usuario.class.php");
$user = new usuario_web();
$url = $user->get_url();
$comprobar_sesion=1;

$nombre=explode ('.',$_SERVER['SERVER_NAME']);
if ($nombre[1].'.'.$nombre[2] == "ateire.com" && ($_SESSION['cuenta_atv']==$nombre[0] || $_SESSION['nivel']>3 && $nombre[0]=="ateiretv" ))
{
	$comprobar_sesion=0;
}

if ($_GET['autenticar']=="remoto")
{
        date_default_timezone_set('GMT');
        $ahora=time();
        if ($ahora>$_GET['ahora'] && ($ahora-10)<$_GET['ahora'])
        {
		$web_password = file_get_contents('http://127.0.0.1/echo_password.php');
		//si hiciese falta mandar junto con la sesion cuando se conecta un n? que se mantendr? y ser? el reto
		$testigo=md5($_GET['ahora']."|".$_GET['numero_aleatorio']."|".$web_password);
		if ($testigo==$_GET['testigo'])
		{
			$_SESSION['basic_is_logged_in']=true;
			$_SESSION['autenticado_remoto']=true;
		}
		else
			echo "<script lanugaje='javascript'>location='login.php?url_source=index.php';</script>";
        }
	else
		echo "<script lanugaje='javascript'>location='login.php?url_source=index.php';</script>";
}



if ($_SESSION['autenticado_remoto']!=true)
{
	
	if (isset($_SESSION['basic_is_logged_in'])) 
		{
			
			
			$query = $manejador_bbdd->query("SELECT * FROM usuarios WHERE nombre='".$_SESSION['nombre']."'");
			
			
			//$query  = "SELECT * FROM usuarios WHERE nombre='".$_SESSION['nombre']."'";
			//$result = sqlite_query($manejador_bbdd, $query) or die(mysql_error());
			//$row = sqlite_fetch_array($result, SQLITE_ASSOC);
			foreach ($query as $row)
			{
				if ($row['sessionkey']!=session_id() && $comprobar_sesion == 1)
				{
					session_regenerate_id(true);
					$_SESSION = array();
					//header("Location: login.php?url_source=$url");
					echo "<script lanugaje='javascript'>location='login.php?url_source=index.php';</script>";
					exit;
				
				}
				if ($row['nivel']<$nivel && $comprobar_sesion == 1)
				{	
					session_regenerate_id(true);
					$_SESSION = array();
					//header("Location: login  .php?url_source=$url");
					echo "<script lanugaje='javascript'>location='login.php?url_source=index.php';</script>";
					exit;
			
				}
			}
	 	}
	 	else 
	 	{
			session_regenerate_id(true);
			$_SESSION = array();
			if ($_GET['autenticar']=="remoto")
				echo "<script lanugaje='javascript'>parent.location.reload();</script>";
			else
				header("Location: login.php?url_source=$url");
			exit;
		}
	
}
?>
