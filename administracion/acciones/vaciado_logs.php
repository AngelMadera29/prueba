<?php
	session_start();
if ($_SESSION['nivel'] == '' || $_SESSION['nivel']  < 3 ){exit;}

if (isset($_GET))
{
	$id=$_GET['datos'];
	if ($id != "")
	{

$conexion = new PDO("sqlite:administracion/db/registros.sqlite");
$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$resultado = $conexion->query("DELETE FROM logs WHERE id in ($id)");

$res = $resultado->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT);
sw
$usuario = $_SESSION['nombre'];
$now = gmdate('d-m-y H:i:s', time() - 3600 * 5);

$insertar = $conexion->exec("INSERT INTO logs('id','usuario','fecha','accion','descripcion')VALUES(NULL,'".$usuario."','".$now."','eliminacion','borrado logs $id')");
	}
}
?>

<script type="text/javascript">
<!--
var answer = confirm("logs eliminado");
if (!answer){
window.location = "administracion/vistas/logs.php";
}
//-->
</script>

<?php
	include "administracion/vistas/logs.php";
	?>