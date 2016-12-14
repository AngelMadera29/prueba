<?php 
date_default_timezone_set('America/Mexico_City');
$bbdd_tipo = "sqlite";
//$id_lector=file_get_contents('http://127.0.0.1/servicios/obtener_id.php');
$id_lector=$_GET['id_lector'];
if (isset($_GET))
{
	$rfid=$_GET['rfid'];
	if ($rfid != "")
	{	
		
if($bbdd_tipo=="sqlite"){		
	$conexion = new PDO("sqlite:administracion/db/bbdd.sqlite");
	$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$resultado = $conexion->query("
	SELECT personal.id, personal.rfid, ubicacion.ubicacion, ubicacion.id as ubicacion_id, personal.nombre, personal.apellido1, personal.apellido2,personal.codigoOP, personal.fotografia
	FROM personal
	LEFT JOIN ubicacion
	ON personal.ubicacion = ubicacion.id
	WHERE personal.rfid ='".$_GET['rfid']."'");
	$res = $resultado->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT);
}if($bbdd_tipo=="sqlite"){
	$conexion = new mysqli ("localhost","root","root","bbdd") or die("Error " . mysqli_error($conexion));
	$resultado = $conexion->query("
	SELECT personal.id, personal.rfid, ubicacion.ubicacion, ubicacion.id as ubicacion_id, personal.nombre, personal.apellido1, personal.apellido2,personal.codigoOP, personal.fotografia
	FROM personal
	LEFT JOIN ubicacion
	ON personal.ubicacion = ubicacion.id
	WHERE personal.rfid ='".$_GET['rfid']."'");
	$res = $resultado->fetch_assoc();
}
$id = $res['id'];
$nombre = $res['nombre'];	
$empresa = $res['codigoOP'];
$apellido1 = $res['apellido1'];
$apellido2 = $res['apellido2'];
$ubicacion = $res['ubicacion'];
$ubicacion_id= $res['ubicacion_id'];
$fotografia = $res['fotografia'];
$lector = $res['id_ubicacion'];
$now = gmdate('d-m-y H:i:s', time() - 3600 * 5);

    ini_set('display_errors', '1');
    
if($bbdd_tipo=="sqlite"){    
	$resultado2 = $conexion->query("SELECT ubicacion1,ubicacion2 FROM lectores WHERE id = $id_lector");
	$res2 = $resultado2->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT);}
if($bbdd_tipo=="mysql"){
	$resultado2 = $conexion->query("SELECT ubicacion1,ubicacion2 FROM lectores WHERE id = $id_lector");
	$res2 = $resultado2->fetch_assoc();
}

$ubicacion1 = $res2['ubicacion1'];
$ubicacion2 = $res['ubicacion2'];

if (isset($_GET))
{
	if ($id != "")
	{
		if($bbdd_tipo=="sqlite"){
			$conexion2 = new PDO("sqlite:administracion/db/registros.sqlite");
			$conexion2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}if($bbdd_tipo=="mysql"){
			$conexion2 = new mysqli ("localhost","root","root","registros");
		}
	$conexion2->query("INSERT INTO registros (`id_personal`,`id_rfid`,`id_zona`,`timestamp`)VALUES ('".$id."','".$rfid."','".$ubicacion_id."','".$now."')");

if ($ubicacion_id == $ubicacion1){
	
	$conexion2->query("INSERT INTO movimientos (`id_persona`,`id_entrada`,`id_salida`,`timestamp`) VALUES ('".$id."','".$ubicacion2."','".$ubicacion1."','".$now."') ");	 
	$conexion->query('UPDATE personal SET ubicacion = "'.$ubicacion2.'" WHERE id = "'.$id.'"');

}else{
	
	$conexion2->query("INSERT INTO movimientos (`id_persona`,`id_entrada`,`id_salida`,`timestamp`) VALUES ('".$id."','".$ubicacion1."','".$ubicacion2."','".$now."') ");	
	$conexion->query('UPDATE personal SET ubicacion = "'.$ubicacion1.'" WHERE id = "'.$id.'"');

}
	}else{
		$nombre="Personal no encontrado.";
	}

}

 
	}
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Información de personal</title>
<link rel="stylesheet" type="text/css" href="assets/css/styles.css" />
</head>
<center><canvas id="clock"></canvas></center>
<script src="assets/js/clock.js">	
</script>
<body>
<div id="wrapper">
<div id="content" action="registros.php" method="post">
<header>
<section id="contact-details">
<div class="header_1">
<?php
if ($fotografia=="")
{
	echo '<img src="administracion/db/usuario.jpg" width="200" height="200" alt="imagen" />';
}else{
	echo '<img src="administracion/db/imagenes/'.$fotografia.'" width="200" height="200" alt="imagen" />';
}
?>
</div>
<div class="header_2">
<h3 name="nombre"><span>Nombre:&nbsp;<?php echo $nombre;?></span></h3>
<h3 name="apellidos">Apellidos: &nbsp;<?php echo $apellido1;?>&nbsp;<?php echo $apellido2;?></h3>
<ul class="info_2">
<li name="empresa">Empresa:&nbsp;<?php echo $empresa;?></li>
<li name="rfid">ID:&nbsp;<?php echo $rfid;?></li>
<p>
<li name="ubicacion"><h4>Entrando en ubicación</h4><center><a>
<?php 
if($bbdd_tipo=="sqlite"){
	$resultado3 = $conexion->query("SELECT ubicacion FROM personal WHERE id = $id");
	$res3 = $resultado3->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT);
}
if($bbdd_tipo=="mysql"){
	$resultado3 = $conexion->query("SELECT ubicacion FROM personal WHERE id = $id");
	$res3 = $resultado3->fetch_assoc();	
}

$ubicacion3=$res3['ubicacion'];

echo $ubicacion3

 ?></a></center></li><p>

</ul>
<center><h2><?php echo $now; ?></h2></center>
</div>
</section>
</header>
<div class="clear">&nbsp;</div>
</div>
</div>
</body>

<script>
var texto="nada";
function sondear_rfid()
{
        var client = new XMLHttpRequest();
        client.open('GET', 'rfid.txt?'+Math.floor(Math.random()*100000001));
        client.onreadystatechange = function()
        {
                if (client.readyState == 4)
                {
                        if ((texto != client.responseText)&&(client.responseText != ''))
                        {
	                        if (texto != 'nada')
	                        	{
                                	document.getElementById('rfid').value=client.responseText;
								}
								texto=client.responseText;
                        }

                }
        }

        client.send();
        //alert('ciclo:');
}
window.setInterval("sondear_rfid()",500);	
</script>
</html>
