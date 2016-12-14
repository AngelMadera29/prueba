<?php 
	session_start();
$bbdd_tipo = "mysql";
if ($_SESSION['nivel'] == '' || $_SESSION['nivel']  < 2 ){exit;}
$op = $_POST['op']; 
$id = $_POST['id'];
$nombre = $_POST['nombre'];	
$contrasena = $_POST['sha_pass'];
$nivel = $_POST['nivel'];

$str = "$nombre:$contrasena";
$sha1 = sha1($str);

if($bbdd_tipo=="sqlite"){
	$conexion = new PDO("sqlite:administracion/db/bbdd.sqlite");
	$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$resultado = $conexion->query("SELECT * FROM usuarios WHERE id = '$id' ");
	$res = $resultado->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT);
}
if($bbdd_tipo=="mysql"){
	$conexion = new mysqli ("localhost","root","root","bbdd") or die("Error " . mysqli_error($conexion));
	$resultado = $conexion->query("SELECT * FROM usuarios WHERE id = '$id' ");
	$res = $resultado->fetch_assoc();		
}
$nombre_1 = $res['nombre'];
$sha_pass_1 = $res['sha_pass'];
$nivel_1 = $res['nivel'];

if($bbdd_tipo=="sqlite"){
	$db3 = new PDO('sqlite:administracion/db/registros.sqlite');
	$db3->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
if($bbdd_tipo=="mysql")
{
	$db3 = new mysqli ("localhost","root","root","registros");
}

$usuario = $_SESSION['nombre'];
$now = gmdate('d-m-y H:i:s', time() - 3600 * 5);


if($op=="actualizar"){
	if($_POST['id']!=''){
$update = "UPDATE usuarios SET nombre = '".$nombre."', sha_pass = '".$sha1."', nivel = '".$nivel."' WHERE id = '".$id."'";

if($bbdd_tipo=="sqlite"){		
	$update_sqlite=$conexion->prepare($update);
	$update_sqlite->execute();
}
if($bbdd_tipo=="mysql"){
	$update_mysql = mysqli_query($conexion, $update);
}//fin del metodo de actualizar personal	


$log = "INSERT INTO logs(`id`,`usuario`,`fecha`,`accion`,`descripcion`)
VALUES
(NOT NULL,'".$usuario."','".$now."','actualizacion',
'actualizados los valores usuario ID -> $id 
nombre DE $nombre_1 A-> $nombre 
contraseña DE $sha_pass_1 A-> $contrasena 
nivel DE $nivel_1 A-> $nivel')";

if($bbdd_tipo=="sqlite")
{
	$stmt2=$db3->prepare($log);
	$stmt2->execute();
}
if($bbdd_tipo=="mysql")
{
	$result1 = mysqli_query($db3, $log);	 
}//fin de if mysql 
	}//fin de if post no esta vacio 
echo '<script language="javascript">alert("Usuario actualizado correctamente");</script>'; 
}//fin de si post es actualizar

if ($op=="insert"){
$insertar = "INSERT INTO usuarios (`id`,`nombre`,`sha_pass`,`nivel`,`sessionkey`) VALUES (NOT NULL,'".$nombre."','".$sha1."','".$nivel."','')";

if($bbdd_tipo=="sqlite")
{	
	$stmt=$conexion->prepare($insertar);
	$stmt->execute();	
	$id=$conexion->lastInsertId();
	$logs = "INSERT INTO logs (`id`,`usuario`,`fecha`,`accion`,`descripcion`)VALUES(NULL,'".$usuario."','".$now."','agregado','insertado nuevo usuario ID = $id')";
	$stmt1=$db3->prepare($logs);
	$stmt1->execute();	
}
if($bbdd_tipo=="mysql")
		{
	$result = mysqli_query($conexion, $insertar);	
	$id=$conexion->insert_id;
	$logs = "INSERT INTO logs (`id`,`usuario`,`fecha`,`accion`,`descripcion`)VALUES(NULL,'".$usuario."','".$now."','agregado','insertado nuevo usuario ID = $id')";
	$result1 = mysqli_query($db3, $logs);	
         }
    echo '<script language="javascript">alert("Usuario insertado correctamente");</script>'; 
} //fin del if uodate

include "administracion/vistas/usr.php";
	
?>
	