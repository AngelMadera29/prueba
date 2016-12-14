<?php
	session_start();
	$bbdd_tipo = "mysql";
if ($_SESSION['nivel'] == '' || $_SESSION['nivel']  < 3 ){exit;}
if (isset($_GET))
{
	$id=$_GET['datos'];
	if ($id != "")
	{
if($bbdd_tipo=="sqlite"){		
$conexion = new PDO("sqlite:administracion/db/bbdd.sqlite");
$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$resultado = $conexion->query("DELETE FROM ubicacion WHERE id in ($id) ");

}if($bbdd_tipo=="mysql"){
	
$conexion = new mysqli ("localhost","root","root","bbdd") or die("Error " . mysqli_error($conexion));
$resultado = $conexion->query("DELETE FROM ubicacion WHERE id in ($id) ");
}

$usuario = $_SESSION['nombre'];
$now = gmdate('d-m-y H:i:s', time() - 3600 * 5);

if ($bbdd_tipo=="sqlite"){
	$db3 = new PDO("sqlite:administracion/db/registros.sqlite");
	$db3->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$logs= $db3->query("INSERT INTO logs(`id`,`usuario`,`fecha`,`accion`,`descripcion`)VALUES(NULL,'".$usuario."','".$now."','eliminacion','borrado ubicacion $id')");
}	
if($bbdd_tipo=="mysql"){
	$db3 = new mysqli ("localhost","root","root","registros");
	$log = $db3->query("INSERT INTO logs(`id`,`usuario`,`fecha`,`accion`,`descripcion`)VALUES(NULL,'".$usuario."','".$now."','eliminacion','borrado ubicacion $id')");
}//fin del try para agregar logs dentro de la base de datos	
		
	}
}

?>

<script type="text/javascript">
<!--
var answer = confirm("Ubicación eliminada");
if (!answer){
window.location = "administracion/vistas/ubi.php";
}
//-->
</script>

<?php
	include "administracion/vistas/ubi.php";
?>