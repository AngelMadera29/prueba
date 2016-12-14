<?php
session_start();
$bbdd_tipo = "sqlite";
if ($_SESSION['nivel'] == '' || $_SESSION['nivel']  < 2 ){exit;}
if (isset($_GET))
{
	$id=$_GET['datos'];
	if ($id != "")
	{
		
if($bbdd_tipo=="sqlite"){
	$conexion = new PDO("sqlite:administracion/db/bbdd.sqlite");
	$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
if($bbdd_tipo=="mysql"){
	$conexion = new mysqli ("localhost","root","root","bbdd") or die("Error " . mysqli_error($conexion));

}

$foto = "fotografia_$id.jpg";
unlink("administracion/db/empresas/$foto");

$del = "DELETE FROM Empresas WHERE id in ($id) ";
if($bbdd_tipo=="sqlite"){
	$stmt=$conexion->prepare($del);
	$stmt->execute();
}
if ($bbdd_tipo=="mysql"){
	$result = mysqli_query($conexion, $del);
}

$usuario = $_SESSION['nombre'];
$now = gmdate('d-m-y H:i:s', time() - 3600 * 5);

$logs = "INSERT INTO logs(`id`,`usuario`,`fecha`,`accion`,`descripcion`)VALUES(NULL,'".$usuario."','".$now."','eliminacion','borrado empresas $id')";


if ($bbdd_tipo=="sqlite"){
$db3 = new PDO("sqlite:administracion/db/registros.sqlite");
$db3->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$result = $db3->query($logs); //replace exec with query
}	
if($bbdd_tipo=="mysql"){
$db3 = new mysqli ("localhost","root","root","registros");
$result = mysqli_query($db3,$logs);	 
}//fin del try para agregar logs dentro de la base de datos

	}
}

?>

<script type="text/javascript">
<!--
var answer = confirm("empresa eliminada");
if (!answer){
window.location = "administracion/vistas/emp.php";
}
//-->
</script>

<?php
	include "administracion/vistas/emp.php";
	?>