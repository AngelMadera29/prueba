<?php
session_start();
$bbdd_tipo = "sqlite";
if ($_SESSION['nivel'] == '' || $_SESSION['nivel']  < 1 ){exit;}
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
	
	$resultado = $conexion->query("SELECT id,nombre,apellido1,apellido2,fecha_nacimiento,telefono_fijo,telefono_celular,rfid,visitante,ubicacion,fotografia,seguro_social,tipo_sangre,dc3_montacargas,dc3_gruas,cargo,emergencias,id_empresa,nc_empresa from personal where id in ($date) ");
	
	foreach($resultado as $valor){
	$id = $valor['id'];	
	$nombre = $valor['nombre'];	
	$apellido1 = $valor['apellido1'];
	$apellido2 = $valor['apellido2'];
	$nacimiento = $valor['fecha_nacimiento'];	
	$telefono_fijo = $valor['telefono_fijo'];
	$celular = $valor['telefono_celular'];
	$empresa = $valor['codigoOP'];	
	$rfid = preg_replace("/[^a-zA-Z0-9]+/", "", $valor['rfid']);
	$visitante = $valor['visitante'];
	$ubicacion = $valor['ubicacion'];	
	$sangre = $valor['tipo_sangre'];	
	$IMSS = $valor['seguro_social'];	
	$monta = $valor['dc3_montacargas'];	
	$gruas = $valor['dc3_gruas'];	
	$cargo = $valor['cargo'];	
	$llamar = $valor['emergencias'];
	$fotografia=$valor['fotografia'];	
	$id_empresa= $valor['empresa'];
	$nc_empresa = $valor['nc_empresa'];	
	
	$db3 = new PDO('sqlite:administracion/db/registros.sqlite');
	$db3->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
$replace = "REPLACE INTO personal ('id','nombre','apellido1','apellido2','fecha_nacimiento','telefono_fijo','telefono_celular','rfid','visitante','ubicacion','seguro_social','tipo_sangre','dc3_montacargas','dc3_gruas','cargo','emergencias','id_empresa','nc_empresa')VALUES ('".$id."','".$nombre."','".$apellido1."','".$apellido2."','".$nacimiento."','".$fijo."','".$celular."',	'".$rfid."','".$visitante."','".$ubicacion."','".$IMSS."','".$sangre."','".$monta."','".$gruas."','".$cargo."','".$llamar."','".$id_empresa."','".$nc_empresa."')";

	$stmt=$db3->prepare($replace);
	$stmt->execute();	
		
	$buscar= $conexion->query("SELECT fotografia FROM personal WHERE id in ($id)");
	$bu = $buscar->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT);
	$foto=explode('?',$bu['fotografia']);
	unlink("administracion/db/imagenes/".$foto[0]);
	
			}//fin del ciclo foreach
	$log = "INSERT INTO logs('id','usuario','fecha','accion','descripcion')VALUES(NULL,'".$usuario."','".$now."','vaciado de personal','borrado personal $date')";
	$stmt1=$db3->prepare($log);
	$stmt1->execute();
			//$resultado = $conexion->query("DELETE FROM personal WHERE id in ($id)");
  		}//fin del if si es sqlite
  		
if($bbdd_tipo=="mysql"){
	$conexion = new mysqli("localhost", "root", "root", "bbdd");
	$query = "SELECT id,nombre,apellido1,apellido2,fecha_nacimiento,
	telefono_fijo,telefono_celular,rfid,visitante,ubicacion,fotografia,seguro_social,tipo_sangre,dc3_montacargas,dc3_gruas,cargo,emergencias,id_empresa,nc_empresa from personal where 		id in ($date) ";
	
	if ($resultado = $conexion->query($query))
	{
		 while ($valor = $resultado->fetch_assoc()) 
		{	
				$id = $valor['id'];	
				$nombre = $valor['nombre'];	
				$apellido1 = $valor['apellido1'];
				$apellido2 = $valor['apellido2'];
				$nacimiento = $valor['fecha_nacimiento'];	
				$telefono_fijo = $valor['telefono_fijo'];
				$celular = $valor['telefono_celular'];
				$empresa = $valor['codigoOP'];	
				$rfid = preg_replace("/[^a-zA-Z0-9]+/", "", $valor['rfid']);
				$visitante = $valor['visitante'];
				$ubicacion = $valor['ubicacion'];	
				$sangre = $valor['tipo_sangre'];	
				$IMSS = $valor['seguro_social'];	
				$monta = $valor['dc3_montacargas'];	
				$gruas = $valor['dc3_gruas'];	
				$cargo = $valor['cargo'];	
				$llamar = $valor['emergencias'];
				$fotografia=$valor['fotografia'];	
				$id_empresa= $valor['empresa'];
				$nc_empresa = $valor['nc_empresa'];	
				
				$db3 = new mysqli ("localhost","root","root","registros");
				
				$replace = "REPLACE INTO personal (`id`,`nombre`,`apellido1`,`apellido2`,`fecha_nacimiento`,`telefono_fijo`,`telefono_celular`,`rfid`,`visitante`,`ubicacion`,`seguro_social`,`tipo_sangre`,`dc3_montacargas`,`dc3_gruas`,`cargo`,`emergencias`,`id_empresa`,`nc_empresa`)VALUES ('".$id."','".$nombre."','".$apellido1."','".$apellido2."','".$nacimiento."','".$fijo."','".$celular."',	'".$rfid."','".$visitante."','".$ubicacion."','".$IMSS."','".$sangre."','".$monta."','".$gruas."','".$cargo."','".$llamar."','".$id_empresa."','".$nc_empresa."')";
				$vaciado = mysqli_query($db3,$replace);		
		}
	$log = "INSERT INTO logs(`id`,`usuario`,`fecha`,`accion`,`descripcion`)VALUES(NULL,'".$usuario."','".$now."','Vaciado','Vaciados el personal $date')";	
	$logs = mysqli_query($db3,$log);	
	//$borrar = $conexion->query("DELETE from registros where id in ($date)");
	}
echo '<script language="javascript">alert("Registros vaciados correctamente");</script>'; 
}//fin de if base de datos es igual a mysql

  				
  	}
}

?>
<script type="text/javascript">
<!--
var answer = confirm("Personal vaciado correctamente correctamente");
if (!answer){
window.location = "administracion/vistas/personas.php";
}
//-->
</script>

<?php
	include "administracion/vistas/personas.php";
	?>