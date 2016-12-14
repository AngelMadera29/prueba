<?php	
session_start();
$bbdd_tipo = "sqlite";
if ($_SESSION['nivel'] == '' || $_SESSION['nivel']  < 2 ){exit;}
	if (isset($_GET))
{
	$date=$_GET['datos'];
	if ($date != "")
	{	
		
$usuario = $_SESSION['nombre'];
$now =  date("Y-m-d H:i:s"); 

if($bbdd_tipo=="sqlite"){			
	$conexion = new PDO("sqlite:administracion/db/bbdd.sqlite");
	$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$resultado = $conexion->query("select id,id_persona,id_entrada,id_salida,id_lector,timestamp from movimientos where id in ($date) ");
	foreach($resultado as $valor){
	$id =$valor['id'];	
	$id_persona = $valor['id_persona'];	
	$id_entrada = $valor['id_entrada'];
	$id_salida = $valor['id_salida'];
	$id_lector = $valor['id_lector'];	
	$timestamp = $valor['timestamp'];
	
	$db3 = new PDO('sqlite:administracion/db/registros.sqlite');
	$db3->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	$replace = "REPLACE INTO 'movimientos' ('id','id_persona','id_entrada','id_salida','id_lector','timestamp') 
	VALUES ('".$id."','".$id_persona."','".$id_entrada."','".$id_salida."','".$id_lector."','".$timestamp."')";	
	
	$stmt=$db3->prepare($replace);
	$stmt->execute();	
			}//fin del foreach consulta 
	$log = "INSERT INTO logs(`id`,`usuario`,`fecha`,`accion`,`descripcion`)VALUES(NULL,'".$usuario."','".$now."','Vaciado','Vaciados los movimientos $date')";	
	$stmt1=$db3->prepare($log);
	$stmt1->execute();
	//$borrar = $conexion->query("DELETE from movimientos where id in ($date)");
}
if($bbdd_tipo=="mysql"){
	$conexion = new mysqli("localhost", "root", "root", "bbdd");
	$query = "select id,id_persona,id_entrada,id_salida,id_lector,timestamp from movimientos where id in ($date)  ";
	
	if ($resultado = $conexion->query($query))
	{
		 while ($row = $resultado->fetch_assoc()) 
		{	
				$id =$valor['id'];	
				$id_persona = $row['id_persona'];	
				$id_entrada = $row['id_entrada'];
				$id_salida = $row['id_salida'];
				$id_lector = $row['id_lector'];	
				$timestamp = $row['timestamp'];
							
				$db3 = new mysqli ("localhost","root","root","registros");
				$replace = "REPLACE INTO movimientos (`id`,`id_persona`,`id_entrada`,`id_salida`,`id_lector`,`timestamp`) 
	VALUES ('".$id."','".$id_persona."','".$id_entrada."','".$id_salida."','".$id_lector."','".$timestamp."')";
				$vaciado = mysqli_query($db3,$replace);		
		}
	$log = "INSERT INTO logs(`id`,`usuario`,`fecha`,`accion`,`descripcion`)VALUES(NULL,'".$usuario."','".$now."','Vaciado','Vaciados los movimientos $date')";	
	$logs = mysqli_query($db3,$log);	
	//$borrar = $conexion->query("DELETE from registros where id in ($date)");
	}
echo '<script language="javascript">alert("Registros vaciados correctamente");</script>'; 
}//fin de if base de datos es igual a mysql

	}//finn de if $date esta vacio
}
?>

<script type="text/javascript">
<!--
var answer = confirm("Movimientos guardados correctamente");
if (!answer){
window.location = "administracion/vistas/mov.php";
}
//-->
</script>

<?php
	include "administracion/vistas/mov.php";
	?>