<?php
	session_start();
	$bbdd_tipo = "sqlite";
if ($_SESSION['nivel'] == '' || $_SESSION['nivel']  < 1 ){exit;}
function cwUpload($field_name = '', $target_folder = '', $file_name = '', $thumb = FALSE, $thumb_folder = '', $thumb_width = '', $thumb_height = ''){
	//folder path setup
	$target_path = $target_folder;
	$thumb_path = $thumb_folder;
	
	//file name setup
	$filename_err = explode(".",$_FILES[$field_name]['tmp_name']);
	$filename_err_count = count($filename_err);
	$file_ext = $filename_err[$filename_err_count-1];
		
	//upload image path
	$upload_image = $target_path.basename($fileName);
	
	//upload image
	if(move_uploaded_file($_FILES[$field_name]['tmp_name'],$upload_image))
	{
		//thumbnail creation
		if($thumb == TRUE)
		{
			$thumbnail = $thumb_path.$fileName;
			list($width,$height) = getimagesize($upload_image);
			$thumb_create = imagecreatetruecolor($thumb_width,$thumb_height);
			switch($file_ext){
				case 'jpg':
					$source = imagecreatefromjpeg($upload_image);
					break;
				case 'jpeg':
					$source = imagecreatefromjpeg($upload_image);
					break;
				case 'png':
					$source = imagecreatefrompng($upload_image);
					break;
				case 'gif':
					$source = imagecreatefromgif($upload_image);
					break;
				default:
					$source = imagecreatefromjpeg($upload_image);
			}
			imagecopyresized($thumb_create,$source,0,0,0,0,$thumb_width,$thumb_height,$width,$height);
			switch($file_ext){
				case 'jpg' || 'jpeg':
					imagejpeg($thumb_create,$thumbnail,100);
					break;
				case 'png':
					imagepng($thumb_create,$thumbnail,100);
					break;
				case 'gif':
					imagegif($thumb_create,$thumbnail,100);
					break;
				default:
					imagejpeg($thumb_create,$thumbnail,100);
			}
		}

		return $fileName;
	}
	else
	{
		return false;
	}
}
	
$op = $_POST['op']; 
$id_antiguo = $_POST['id_antiguo'];

$id = $_POST['id'];	
$nombrec = $_POST['nombrec'];	
$nombrel = $_POST['nombrel'];
$nopersonas = $_POST['nopersonas'];
$fechaspactadas = $_POST['fechaspactadas'];	
$infocontacto = $_POST['infocontacto'];
$servicio = $_POST['servicio'];
$rliderasgo = $_POST['rliderasgo'];
$pdescansos = $_POST['pdescansos'];
$rlanzamiento = $_POST['rlanzamiento'];
$lherramientas = $_POST['lherramientas'];
$eriesgos = $_POST['eriesgos'];
$hddatos = $_POST['hddatos'];
$andamios = $_POST['andamios'];
$cresponsiva = $_POST['cresponsiva'];	
$pvehiculos = $_POST['pvehiculos'];	
$pedido = $_POST['pedido'];	
$letocaa = $_POST['letocaa'];	
$carpetaarchivos = $_POST['carpetaarchivos'];	
$fotografia= $_POST['fotografia'];	
$notase = $_POST['notase'];	
					
$usuario = $_SESSION['nombre'];
$now = gmdate('d-m-y H:i:s', time() - 3600 * 5);

if($bbdd_tipo=="sqlite"){
	$conexion = new PDO("sqlite:administracion/db/bbdd.sqlite");
	$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$resultado = $conexion->query("SELECT * FROM Empresas where id = '$id'");
	$res = $resultado->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT);
}
if($bbdd_tipo=="mysql"){
	$conexion = new mysqli ("localhost","root","root","bbdd") or die("Error " . mysqli_error($conexion));
	$resultado = $conexion->query("SELECT * FROM Empresas where id = '$id'");
	$res = $resultado->fetch_assoc();		
}

$nombrec_1 = $res['NombreC'];	
$nombrel_1 = $res['NombreL'];
$nopersonas_1 = $res['NoPersonas'];
$fechaspactadas_1 = $res['FechasPactadas'];	
$infocontacto_1 = $res['InfoContacto'];
$servicio_1 = $res['Servicio'];
$rliderasgo_1 = $res['RLiderasgo'];
$pdescansos_1 = $res['PDescansos'];
$rlanzamiento_1 = $res['RLanzamientos'];
$lherramientas_1 = $res['LHerramientas'];
$eriesgos_1 = $res['ERiesgos'];
$hddatos_1 = $res['HDDatos'];
$andamios_1 = $res['Andamios'];
$cresponsiva_1 = $res['CResponsiva'];	
$pvehiculos_1 = $res['PVehiculos'];	
$pedido_1 = $res['Pedido'];	
$letocaa_1 = $res['LeTocaA'];	
$carpetaarchivos_1 = $res['CarpetaArchivos'];	
$fotografia_1 = $res['fotografia'];	
$notase_1 = $res['NotasE'];	

if($bbdd_tipo=="sqlite"){
	$conexion2 = new PDO('sqlite:administracion/db/registros.sqlite');
	$conexion2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
if($bbdd_tipo=="mysql")
{
	$conexion2 = new mysqli ("localhost","root","root","registros");
}

if ($op=="update"){
	if ($_POST["id"]!='')
{


		$update = "UPDATE Empresas SET 		
		id = '".$id."', 
		NombreC = '".$nombrec."', 
		NombreL = '".$nombrel."', 
		NoPersonas = '".$nopersonas."',
		FechasPactadas = '".$fechaspactadas."',
		InfoContacto = '".$infocontacto."',
		Servicio = '".$servicio."',
		RLiderasgo = '".$rliderasgo."',
		PDescansos = '".$pdescansos."',
		RLanzamiento = '".$rlanzamiento."',
		LHerramientas = '".$lherramientas."',
		ERiesgos = '".$eriesgos."',
		HDDatos = '".$hddatos."',
		Andamios = '".$andamios."',
		CResponsiva = '".$cresponsiva."',
		PVehiculos = '".$pvehiculos."',
		Pedido = '".$pedido."',
		LeTocaA = '".$letocaa."',
		CarpetaArchivos = '".$carpetaarchivos."',
		NotasE = '".$notase."'
		WHERE id = '".$id_antiguo."'";
		
if($bbdd_tipo=="sqlite"){
	$stmt=$conexion->prepare($update);
	$stmt->execute();
						}
if($bbdd_tipo=="mysql"){
	$result = mysqli_query($conexion, $update);
}//fin de if mysql 
			
	if ($_FILES["fotografia"]["tmp_name"]!="")
		{
		
			$upload_img = cwUpload('fotografia',"administracion/db/empresas/fotografia_".$id.".jpg",'',TRUE,"administracion/db/empresas/fotografia_".$id.".jpg",'200','160');
			$foto_id="fotografia_".$id.".jpg?".rand();
			$foto ="UPDATE Empresas SET fotografia = '".$foto_id."' WHERE id = '".$id."'";

//metodo para agregar nombre de fotografia a la base de datos		
if($bbdd_tipo=="sqlite"){	
			$stmt1=$conexion->prepare($foto);
			$stmt1->execute();
}
if ($bbdd_tipo=="mysql"){ 
			//metdodo de actualizacion de fotografia mediante mysqli	
			$result1 = mysqli_query($conexion,$foto);
}//fin del metodo para agregar fotografia en la base de datos
	
				}//fin de if FILE from fotografia		
			
$logs = "INSERT INTO logs(`id`,`usuario`,`fecha`,`accion`,`descripcion`)
VALUES
(NOT NULL,'".$usuario."','".$now."','actualizacion',
'actualizados los valores de Empresa:$id
 Nombre Corto DE $nombrec A-> $nombrec_1
 Nombre Largo DE $nombrel A-> $nombrel_1
 Nº de Personas DE $nopersonas_1 A-> $nopersonas 
 Fechas pactadas DE $fechaspactadas_1 A-> $fechaspactadas 
 Informacion de contacto DE $infocontacto_1  A-> $infocontacto
 Servicio DE $servicio_1  A-> $servicio 
 P. Descansos DE $pdescansos_1 A-> $pdescansos 
 Lanzamientos DE $rlanzamiento_1 A-> $rlanzamiento
 L. Herramientas OP DE $lherramientas_1  A-> $lherramientas
 Riesgos DE $eriesgos_1 A-> $eriesgos
 Datos DE $hddatos_1 A->  $hddatos 
 Andamios DE $andamios_1  A-> $andamios
 Responsiva DE $cresponsiva_1  A-> $cresponsiva_
 P. Vehicular DE $pvehiculos_1 A-> $pvehiculos
 Pedidos DE $pedido_1 A-> $pedido
 Le Toca A: DE $letocaa_1 A-> $letocaa
 C. Archivos DE $carpetaarchivos_1  A-> $carpetaarchivos
 Fotografia DE $fotografia_1 A-> $fotografia 
 Notas DE $notase_1 A-> $notase')";	
 
if ($bbdd_tipo=="sqlite"){
$result = $conexion2->query($logs); //replace exec with query
}	
if($bbdd_tipo=="mysql"){
$result = mysqli_query($conexion2,$logs);	 
}//fin del try para agregar logs dentro de la base de datos

		}//fin del if de files		

	echo '<script language="javascript">alert("Empresa actualizada correctamente");</script>'; 
	}
//else{
if ($op=="insert"){
	
$insertar = 'INSERT INTO Empresas 
(`id`,
`NombreC`,
`NombreL`,
`NoPersonas`,
`FechasPactadas`,
`InfoContacto`,
`Servicio`,
RLiderasgo,
`PDescansos`,
`RLanzamiento`,
`LHerramientas`,
`ERiesgos`,
`HDDatos`,
`Andamios`,
`CResponsiva`,
`PVehiculos`,
`Pedido`,
`LeTocaA`,
`CarpetaArchivos`,
`fotografia`,
`NotasE`) VALUES'.
" (NOT NULL,
'".$nombrec."',
'".$nombrel."',
'".$nopersonas."',
'".$fechaspactadas."',
'".$infocontacto."',
'".$servicio."',
'".$rliderasgo."',
'".$pdescansos."',
'".$rlanzamiento."',
'".$lherramientas."',
'".$eriesgos."',
'".$hddatos."',
'".$andamios."',
'".$cresponsiva."',
'".$pvehiculos."',
'".$pedido."',
'".$letocaa."',
'".$carpetaarchivos."',
'".$fotografia."',
'".$notase."')";

if($bbdd_tipo=="sqlite"){
	$stmt=$conexion->prepare($insertar);
	$stmt->execute();
	$id=$conexion->lastInsertId();
	$insert_log = "INSERT INTO logs('id','usuario','fecha','accion','descripcion') VALUES (NOT NULL,'".$usuario."','".$now."','actualizacion','Agregada empresa id $id')";	
	$result1 = $conexion2->query($insert_log);
}if($bbdd_tipo=="mysql"){
	$result = mysqli_query($conexion, $insertar);
	$id=$conexion->insert_id;
	$insert_log = "INSERT INTO logs(`id`,`usuario`,`fecha`,`accion`,`descripcion`) VALUES (NULL,'".$usuario."','".$now."','actualizacion','Agregada empresa id $id')";
	$result2 = mysqli_query($conexion2, $insert_log);
}
				
		if ($_FILES["fotografia"]["tmp_name"]!="")
		{
			$upload_img = cwUpload('fotografia',"administracion/db/empresas/fotografia_".$id.".jpg",'',TRUE,"administracion/db/empresas/fotografia_".$id.".jpg",'200','160');
			$foto_id="fotografia_".$id.".jpg?".rand();
			}else{
				$foto_id="sin_imagen.jpg";
			}
			$foto = "UPDATE Empresas SET fotografia = '".$foto_id."' WHERE id = '".$id."'";
			//metdodo de actualizacion de fotografia mediante sqlite	
			
if($bbdd_tipo=="sqlite"){
	$stmt1=$conexion->prepare($foto);
	$stmt1->execute();
}
if ($bbdd_tipo=="mysql"){ 	
	$result1 = mysqli_query($conexion,$foto);
}
	
	
echo '<script language="javascript">alert("Empresa insertada correctamente");</script>'; 
	}//fin del if es
include "administracion/vistas/emp.php";
	
?>
	
