<?php
//  if(INCLUDED!=true)exit;
//session_start();



if ($_GET['autenticar']=="remoto")
{
        date_default_timezone_set('GMT');
        $ahora=time();
   	
        if ($ahora>=$_GET['ahora'] && ($ahora-10)<$_GET['ahora'])
        {
			$web_password = file_get_contents('http://127.0.0.1/echo_password.php');
			//si hiciese falta mandar junto con la sesion cuando se conecta un nº que se mantendría y sería el reto
			$testigo=md5($_GET['ahora']."|".$_GET['numero_aleatorio']."|".$web_password);
			//echo $web_password."<br/>";
			//echo $testigo."<br/>";exit;
			if ($testigo==$_GET['testigo'])
			{
				$_SESSION['basic_is_logged_in']=true;
				$_SESSION['autenticado_remoto']=true;
				echo "<script lanugaje='javascript'>location='".$fichero_principal."';</script>";
				exit;
			}
		}
		else
			echo "<script lanugaje='javascript'>location='login.php?url_source=".$fichero_principal."';</script>";
}
//$directorio=getcwd();
//chdir($_SERVER['DOCUMENT_ROOT']);

$manejador_bbdd = new PDO("sqlite:administracion/db/bbdd.sqlite"); 
$manejador_bbdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//chdir($directorio);

?>
