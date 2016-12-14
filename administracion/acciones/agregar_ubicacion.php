<?php 
	session_start();
	$bbdd_tipo = "mysql";
if ($_SESSION['nivel'] == '' || $_SESSION['nivel']  < 3 ){exit;}

$op = $_POST['op']; 
$id_actual = $_POST['id_antiguo'];
$id = $_POST['id'];	
$ubicacion = $_POST['ubicacion'];
$usuario = $_SESSION['nombre'];
$now = gmdate('d-m-y H:i:s', time() - 3600 * 5);


if($bbdd_tipo=="sqlite"){
	$conexion = new PDO("sqlite:administracion/db/bbdd.sqlite");
	$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$resultado = $conexion->prepare("SELECT * from ubicacion where id = '".$id."'");
	$resultado->execute();
	$row = $resultado->fetch(PDO::FETCH_ASSOC);
}
if($bbdd_tipo=="mysql"){
	$conexion = new mysqli ("localhost","root","root","bbdd") or die("Error " . mysqli_error($conexion));
	$resultado = $conexion->query("SELECT * from ubicacion where id = '".$id."'");
	$row = $resultado->fetch_assoc();		
}
$ubicacion1 = $row['ubicacion'];
$id_1 = $row['id'];

if($bbdd_tipo=="sqlite"){
	$db3 = new PDO('sqlite:administracion/db/registros.sqlite');
	$db3->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
if($bbdd_tipo=="mysql"){
	$db3 = new mysqli ("localhost","root","root","registros");
}

if ($op=="actualizar"){
if ($id != $id_1 || $id_actual == $id_1){
		
	$update = "UPDATE ubicacion SET ubicacion = '".$ubicacion."' , id ='".$id."' WHERE id = '".$id_actual."'";
	
	$log = "INSERT INTO logs(`id`,`usuario`,`fecha`,`accion`,`descripcion`)
	VALUES
	(NULL,'".$usuario."','".$now."','actualizacion',
	'Actualizados lo valores de ubicacion ID $id_actual A-> $id
	Ubicacion DE $ubicacion1 A-> $ubicacion')";
	
if($bbdd_tipo=="sqlite"){
	$stmt=$conexion->prepare($update);
	$stmt->execute();
	$stmt2=$db3->prepare($log);
	$stmt2->execute();
}if($bbdd_tipo=="mysql"){
	$result = mysqli_query($conexion, $update);
   $result1 = mysqli_query($db3, $log);
}
	 }//fin del if $id_actual es igual a la consulta $id_1
echo '<script language="javascript">alert("Ubicación actualizado correctamente");</script>'; 
}//fin de del if es igual a update


if ($op=="insert"){	
		
if($id == $id_1){
	echo '<script language="javascript">alert("Ubicación ya existe");</script>'; 
	echo "<script> window.location = '?page=ubc';</script>";
	exit;
}
if($id != $id_1 || $id_1 == ''){	
	
$insertar = "INSERT INTO ubicacion (`id`,`ubicacion`) VALUES (NOT NULL,'".$ubicacion."')";	
if($bbdd_tipo=="sqlite"){
	$stmt=$conexion->prepare($insertar);
	$stmt->execute();	
	$id_antiguo=$conexion->lastInsertId();
	$conexion->exec("UPDATE ubicacion SET id = '".$id."' WHERE id = '".$id_antiguo."'");
	$insertar_log = $db3->query("INSERT INTO logs(`id`,`usuario`,`fecha`,`accion`,`descripcion`)VALUES(NULL,'".$usuario."','".$now."','agregado','agregado ubicacion id $id')");
	}
if($bbdd_tipo=="mysql"){
	$result = mysqli_query($conexion, $insertar);
	$id_antiguo=$conexion->insert_id;
	$update = "UPDATE ubicacion SET id = '".$id."' WHERE id = '".$id_antiguo."'";
	$result1 = mysqli_query($conexion, $update);
	$log = "INSERT INTO logs(`id`,`usuario`,`fecha`,`accion`,`descripcion`)VALUES(NULL,'".$usuario."','".$now."','agregado','agregado ubicacion id $id')";
	$result2 = mysqli_query($db3, $log);		
}

	}
	echo '<script language="javascript">alert("Ubicación insertado correctamente");</script>'; 

		}

include "administracion/vistas/ubi.php";

?>
	