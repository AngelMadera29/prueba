<?php 
	session_start();
	$bbdd_tipo = "mysql";
if ($_SESSION['nivel'] == '' || $_SESSION['nivel']  < 2 ){exit;}

$op = $_POST['op']; 
$id_actual = $_POST['id_antiguo'];
$id = $_POST['id'];	
$ubicacion1 = $_POST['ubicacion1'];
$ubicacion2 = $_POST['ubicacion2'];

$usuario = $_SESSION['nombre'];
$now = gmdate('d-m-y H:i:s', time() - 3600 * 5);


if($bbdd_tipo=="sqlite"){
	$conexion = new PDO("sqlite:administracion/db/bbdd.sqlite");
	$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$resultado = $conexion->query("SELECT * from lectores where id = '".$id."'");
	$row = $resultado->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT);
}
if($bbdd_tipo=="mysql"){
	$conexion = new mysqli ("localhost","root","root","bbdd") or die("Error " . mysqli_error($conexion));
	$resultado = $conexion->query("SELECT * from lectores where id = '".$id."'");
	$row = $resultado->fetch_assoc();	
}
$id_1 = $row['id'];
//resultado de la consulta de id en la table de lectores
if($bbdd_tipo=="sqlite"){
	$conexion2 = new PDO("sqlite:administracion/db/registros.sqlite");
	$conexion2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
if($bbdd_tipo=="mysql"){
	$conexion2 = new mysqli ("localhost","root","root","registros");
}

//metodo si la informacion comparada es igual 
if ($op=="actualizar"){
if ($id != $id_1 || $id_actual == $id_1){
	
	//sentencia sql para actualizar los valores del lector 	
	$actualizar = "UPDATE lectores SET ubicacion1 = '".$ubicacion1."',ubicacion2 = '".$ubicacion2."', id = '".$id."' WHERE id = '".$id_actual."'";	
//metodo para ejecutar sentencia sql a traves de una base de datos
if($bbdd_tipo=="sqlite"){		
	$update_sqlite=$conexion->prepare($actualizar);
	$update_sqlite->execute();
}
if($bbdd_tipo=="mysql"){
	$update_mysql = mysqli_query($conexion, $actualizar);
}//fin del metodo de actualizar personal	

	$log = "INSERT INTO logs(`id`,`usuario`,`fecha`,`accion`,`descripcion`)
	VALUES
	(NULL,'".$usuario."','".$now."','actualizacion',
	'Actualizados los valores de lectores  ID -> $id_1
	 Ubicacion1 DE $ubi_1 A-> $ubicacion1
	 Ubicacion2 DE $ubi_2 A-> $ubicacion2 
	 ')";	
	 
if ($bbdd_tipo=="sqlite"){
	$conexion2 = new PDO("sqlite:administracion/db/registros.sqlite");
	$conexion2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$insert_log_sqlite = $conexion2->query($log); //replace exec with query
}	
if($bbdd_tipo=="mysql"){
	$conexion2 = new mysqli ("localhost","root","root","registros");
	$insert_log_mysql = mysqli_query($conexion2,$log);	 
}//fin del try para agregar logs dentro de la base de datos
	 
	 }//fin del if $id_actual es igual a la consulta $id_1
echo '<script language="javascript">alert("Lector actualizado correctamente");</script>'; 
}//fin de del if es igual a update


if ($op=="insert"){	
		
if($id == $id_1){
	echo '<script language="javascript">alert("Lector ya existe");</script>'; 
	echo "<script> window.location = '?page=lec';</script>";
	exit;
}
if($id != $id_1 || $id_1 == ''){	
	
//sentencia sql para insertar un nuevo lector
	$insertar = "INSERT INTO lectores (`id`,`ubicacion1`,`ubicacion2`) VALUES (NOT NULL,'".$ubicacion1."','".$ubicacion2."')";
//metodo por el cual se va a agregar un nuevo lector
if($bbdd_tipo=="sqlite"){
	$stmt=$conexion->prepare($insertar);
	$stmt->execute();
	$id_antiguo=$conexion->lastInsertId();
	$conexion->exec("UPDATE lectores SET id = '".$id."' WHERE id = '".$id_antiguo."'");
	$insertar_log = $conexion2->exec("INSERT INTO logs('id','usuario','fecha','accion','descripcion')VALUES(NULL,'".$usuario."','".$now."','agregado','agregado lector id $id')");
}if($bbdd_tipo=="mysql"){
	$result = mysqli_query($conexion, $insertar);
	$id_antiguo=$conexion->insert_id;
	$update = "UPDATE lectores SET id = '".$id."' WHERE id = '".$id_antiguo."'";
	$result1 = mysqli_query($conexion, $update);
	$log = "INSERT INTO logs(`id`,`usuario`,`fecha`,`accion`,`descripcion`)VALUES(NULL,'".$usuario."','".$now."','agregado','agregado lector id $id')";
	$result2 = mysqli_query($conexion2, $log);
}
	}
echo '<script language="javascript">alert("Lector insertado correctamente");</script>'; 
	}//fin del if es

include "administracion/vistas/lec.php";

?>
