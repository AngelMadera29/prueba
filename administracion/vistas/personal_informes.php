<?php
session_start();
	$bbdd_tipo = "sqlite";
if ($_SESSION['nivel'] == '' || $_SESSION['nivel']  < 0 ){exit;}
$nivel = $_SESSION['nivel'];

date_default_timezone_set('America/Mexico_City');

  // $DBH = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass); //MYSQL database
$sql="SELECT id, nombre, apellido1, apellido2, telefono_fijo, telefono_celular, rfid, visitante,ubicacion, fotografia, codigoOP,seguro_social,tipo_sangre,dc3_montacargas,dc3_gruas,cargo,emergencias,nc_empresa
FROM personal";
if($bbdd_tipo=="sqlite"){
$conn = new PDO("sqlite:../db/bbdd.sqlite");  // SQLite Database
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$stmt=$conn->prepare($sql);
$stmt->execute();
$results_array=$stmt->fetchAll(PDO::FETCH_ASSOC);
$json=json_encode($results_array );
}
if($bbdd_tipo=="mysql"){
	$bbdd = new mysqli ("localhost","root","root","bbdd");
	$result = mysqli_query($bbdd, $sql) or die("Error in Selecting " . mysqli_error($bbdd));
	$emparray = array();
	    while($row = mysqli_fetch_assoc($result))
	    {
	        $emparray[] = array_map('utf8_encode', $row);;
	    }
	$json = json_encode($emparray, JSON_UNESCAPED_UNICODE);
	$json = urldecode(stripslashes($json)); 
}
header('Content-Type: application/json');
{
	echo $json;  //Just plain vanillat JSON output 
}
exit;


?>
