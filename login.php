<?php
//Funciones de inicio--------
include("auth/includes/config.php");
include("auth/header.php");
include("clase_plantilla.php");
$errorMessage = '';
//----------------------------
$Variables_Salida = array(
'url_source'=>""
//'Test2'=>""
);

if ($_SESSION['basic_is_logged_in'] == true)
{
	header("Location: index.php");
}
if (isset($_GET['url_source']))
$Variables_Salida['url_source']=$_GET['url_source'];
//------------Autenticación--------------------------------------------
//echo session_id();

		$query = $manejador_bbdd->query("SELECT * FROM usuarios WHERE nombre='".$_POST['txtLogin']."'");
		//$query  = "SELECT * FROM usuarios WHERE nombre='".$_POST['txtLogin']."'";
		//$result = sqlite_query($manejador_bbdd, $query) or die(mysql_error()); 
		//$row = sqlite_fetch_array($result, SQLITE_ASSOC);
		foreach ($query as $row)
		{
			if ($row['sha_pass'] == sha1($_POST['txtLogin'].':'.$_POST['txtPassword']))
			{
				$_SESSION['basic_is_logged_in'] = true;
				$_SESSION['nombre']=$_POST['txtLogin'];
				$_SESSION['nivel']=$row['nivel'];
				$query = $manejador_bbdd->query("UPDATE usuarios SET sessionkey='".session_id()."' WHERE nombre='".$_POST['txtLogin']."'");
				//$query  = "UPDATE usuarios SET sessionkey='".session_id()."' WHERE nombre='".$_POST['txtLogin']."'";
				//$result = sqlite_query($manejador_bbdd, $query) or die(mysql_error());
				$result = $query->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT);
				if ($_GET['url_source']!=""){
					header("Location: ".$_GET['url_source']);
					exit;
				}
				header("Location: index.php");
			}
		}
//------}------fin de autenticación------------------------------------------------------
?>
<?php
	
	$Contenido=new Plantilla("login");
	$Contenido->asigna_variables($Variables_Salida);
	$ContenidoString = $Contenido->muestra();
	echo $ContenidoString;
?>
