<?php 
if ($_POST){

$db = new PDO('sqlite:administracion/db/bbdd.sqlite');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$nombre 	= $_POST['nombre'];
	$contrasena 	= $_POST['sha_pass'];
	$nivel = $_POST['nivel'];
	$session = $_POST['sessionkey'];
	$cliente = $_POST['id_cliente'];
		
		/* Create a prepared statement */
		$stmt = $db -> prepare("INSERT INTO usuarios (nombre,id_cliente,sha_pass,nivel, sessionkey) VALUES ('".$nombre."',".$cliente.", '".$contrasena."',".$nivel.",'".$session."')");
		$stmt -> execute();


}	
?>
<html>
	<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<style>
	label{width: 100px; float:left;}
</style>
<body>
	<form action="usuario.php" method="post">	
		<label>Nombre: </label><input type="text" name="nombre" /><br>	
		<label>Cliente: </label><input type="number" name="id_cliente" /><br>
		<label>Contraseña: </label><input type="password" name="sha_pass" /><br>
		<label>Nivel: </label><input type="number" name="nivel" /><br>
		<label>Session: </label><input type="text" name="sessionkey" /><br>
		<input type="submit" />
	</form>
</body>