<?php	

session_start();
$bbdd_tipo = "sqlite";
if ($_SESSION['nivel'] == '' || $_SESSION['nivel']  < 2 ){exit;}
	if (isset($_POST))
{
	$date=$_POST['datos'];
	if ($date != "")
	{		
		
$usuario = $_SESSION['nombre'];
$now =  date("Y-m-d H:i:s"); 	

if($bbdd_tipo=="sqlite"){				
	$conexion = new PDO("sqlite:administracion/db/bbdd.sqlite");
	$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$resultado = $conexion->query("select id,id_personal,id_rfid,timestamp,id_lector,id_zona from registros where id in ($date) ");
	foreach($resultado as $valor){
	
	$id =$valor['id'];	
	$id_personal = $valor['id_personal'];	
	$id_rfid = $valor['id_rfid'];
	$timestamp = $valor['timestamp'];
	$id_lector = $valor['id_lector'];	
	$id_zona = $valor['id_zona'];
	
	$db3 = new PDO('sqlite:administracion/db/registros.sqlite');
	$db3->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	
	$replace = "REPLACE INTO 'registros' ('id','id_personal','id_rfid','timestamp','id_lector','id_zona') 
	VALUES ('".$id."','".$id_personal."','".$id_rfid."','".$timestamp."','".$id_lector."','".$id_zona."')";
	
	$stmt=$db3->prepare($replace);
	$stmt->execute();
	
			}//fin del foreach
	$log = "INSERT INTO logs(`id`,`usuario`,`fecha`,`accion`,`descripcion`)VALUES(NULL,'".$usuario."','".$now."','Vaciado','Vaciados los registros $date')";	
	$stmt1=$db3->prepare($log);
	$stmt1->execute();
	//$borrar = $conexion->query("DELETE from registros where id in ($date)");
	echo '<script language="javascript">alert("Registros vaciados correctamente");</script>'; 
}

if($bbdd_tipo=="mysql"){
	$conexion = new mysqli("localhost", "root", "root", "bbdd");
	$query = "select id,id_personal,id_rfid,timestamp,id_lector,id_zona from registros where id in ($date) ";
	
	if ($resultado = $conexion->query($query))
	{
		 while ($row = $resultado->fetch_assoc()) 
		{	
				$id =$row['id'];	
				$id_personal = $row['id_personal'];	
				$id_rfid = $row['id_rfid'];
				$timestamp = $row['timestamp'];
				$id_lector = $row['id_lector'];	
				$id_zona = $row['id_zona']; 
				
				$db3 = new mysqli ("localhost","root","root","registros");
				$replace = "REPLACE INTO registros (`id`,`id_personal`,`id_rfid`,`timestamp`,`id_lector`,`id_zona`) 
	VALUES ('".$id."','".$id_personal."','".$id_rfid."','".$timestamp."','".$id_lector."','".$id_zona."')";
				$vaciado = mysqli_query($db3,$replace);		
		}
	$log = "INSERT INTO logs(`id`,`usuario`,`fecha`,`accion`,`descripcion`)VALUES(NULL,'".$usuario."','".$now."','Vaciado','Vaciados los registros $date')";	
	$logs = mysqli_query($db3,$log);	
	//$borrar = $conexion->query("DELETE from registros where id in ($date)");
	}
echo '<script language="javascript">alert("Registros vaciados correctamente");</script>'; 
}//fin de if base de datos es igual a mysql

 }//fin del if si $date esta vacia
}//fin del session es idfertente a 2
?>

<script type="text/javascript">
<!--
var answer = confirm("registros guardados correctamente");
if (!answer){
window.location = "administracion/vistas/reg.php";
}
//-->
</script>

<?php
	include "administracion/vistas/reg.php";
	?>