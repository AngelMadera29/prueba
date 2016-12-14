<?php		
   	session_start();
   	$bbdd_tipo = "mysql";
   	$nivel = $_SESSION['nivel'];
	$nivel_editar=1;
	
	
if ($_SESSION['nivel'] == ''){exit;}
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
$nombre = $_POST['nombre'];	
$apellido1 = $_POST['apellido1'];
$apellido2 = $_POST['apellido2'];
$nacimiento = $_POST['fecha_nacimiento'];	
$telefono_fijo = $_POST['telefono_fijo'];
$celular = $_POST['telefono_celular'];
$empresa = $_POST['codigoOP'];	
$rfid = preg_replace("/[^a-zA-Z0-9]+/", "", $_POST['rfid']);
$visitante = $_POST['visitante'];
$ubicacion = $_POST['ubicacion'];	
$sangre = $_POST['tipo_sangre'];	
$IMSS = $_POST['seguro_social'];	
$monta = $_POST['dc3_montacargas'];	
$gruas = $_POST['dc3_gruas'];	
$cargo = $_POST['cargo'];	
$llamar = $_POST['emergencias'];
$fotografia=$_POST['fotografia'];	
$id_empresa= $_POST['empresa'];
$nc_empresa = $_POST['nc_empresa'];

	
$usuario = $_SESSION['nombre'];
$now = gmdate('d-m-y H:i:s', time() - 3600 * 5);		

if($bbdd_tipo=="sqlite"){
	$conexion = new PDO("sqlite:administracion/db/bbdd.sqlite");
	$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$resultado = $conexion->query("SELECT * from personal where id = '".$id."'");
	$res = $resultado->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT);
}
if($bbdd_tipo=="mysql"){
	$conexion = new mysqli ("localhost","root","root","bbdd") or die("Error " . mysqli_error($conexion));
	$resultado = $conexion->query("SELECT * from personal where id = '".$id."'");
	$res = $resultado->fetch_assoc();		
}

$id_1 = $res['id'];	
$nombre1 = $res['nombre'];	
$apellido1_1 = $res['apellido1'];
$apellido2_2 = $res['apellido2'];
$nacimiento1 = $res['fecha_nacimiento'];	
$fijo_1 = $res['telefono_fijo'];
$celular_1 = $res['telefono_celular'];
$id_empresa_1= $res['id_empresa'];
$nc_empresa_1 = $res['nc_empresa'];
$codigo_OP_1 = $res['codigoOP'];
$empresa_1 = $res['NombreL'];
$rfid_1 = $res['rfid'];
$visitante_1 = $res['visitante'];
$ubicacion_1 = $res['ubicacion'];
$sangre_1 = $res['tipo_sangre'];	
$IMSS_1 = $res['seguro_social'];	
$monta_1 = $res['dc3_montacargas'];	
$gruas_1 = $res['dc3_gruas'];	
$cargo_1 = $res['cargo'];	
$llamar_1 = $res['emergencias'];	
$fotografia_1 = $res['fotografia'];


if($bbdd_tipo=="sqlite"){
	$conexion2 = new PDO("sqlite:administracion/db/registros.sqlite");
	$conexion2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
if($bbdd_tipo=="mysql"){
	$conexion2 = new mysqli ("localhost","root","root","registros");
}

if ($op=="update"){
	if ($_POST["id"]!=''){
		if ($visitante == "NO" && $_SESSION['nivel'] == 0){exit;} //no se tiene permisos con nivel cero mas que para editar visitantes!!

		$actulizar = "UPDATE personal SET 		
		id = '".$id."', 
		nombre = '".$nombre."', 
		apellido1 = '".$apellido1."', 
		apellido2 = '".$apellido2."',
		fecha_nacimiento = '".$nacimiento."',
		telefono_fijo = '".$telefono_fijo."',
		telefono_celular = '".$celular."',
		visitante = '".$visitante."',
		rfid = '".$rfid."',
		tipo_sangre = '".$sangre."',
		seguro_social = '".$IMSS."',
		dc3_montacargas = '".$monta."',
		dc3_gruas = '".$gruas."',
		cargo = '".$cargo."',
		emergencias = '".$llamar."',
		id_empresa = '".$id_empresa."',
		nc_empresa = ''
		WHERE id = '".$id_antiguo."'";
		
//metodo para actualizar la informacion del personal de la base de datos		
if($bbdd_tipo=="sqlite"){		
	$stmt=$conexion->prepare($actulizar);
	$stmt->execute();
}
if($bbdd_tipo=="mysql"){
	$result = mysqli_query($conexion, $actulizar);
}//fin del metodo de actualizar personal	
			
		if ($_FILES["fotografia"]["tmp_name"]!="")
		{
		
			$upload_img = cwUpload('fotografia',"administracion/db/imagenes/fotografia_".$id.".jpg",'',TRUE,"administracion/db/imagenes/fotografia_".$id.".jpg",'200','160');
			$foto_id="fotografia_".$id.".jpg?".rand();
			$foto ="UPDATE personal SET fotografia = '".$foto_id."' WHERE id = '".$id."'";

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
		
//metodo para cosultar el nombre de la empresa seleccionada	
if($bbdd_tipo=="sqlite"){
	$resultado = $conexion->query("SELECT NombreC,NombreL FROM Empresas WHERE id = '".$id_empresa."'");
	$row = $resultado->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT);
}

if($bbdd_tipo=="mysql"){
	$resultado = $conexion->query("SELECT NombreC,NombreL FROM Empresas WHERE id = '".$id_empresa."'");
	$row = $resultado->fetch_assoc();	
}

	$nombre_C = $row['NombreC'];
	$NombreL = $row['NombreL'];
//fin de consulta de la empresa 		
$EMPRESA = "UPDATE personal SET codigoOP = '".$nombre_C."_".$id_empresa."',nc_empresa='".$nombre_C."' WHERE id = '".$id."'";


if($bbdd_tipo=="sqlite"){
	$stmt=$conexion->prepare($EMPRESA);
	$stmt->execute();
}
if ($bbdd_tipo=="mysql"){
	$result = mysqli_query($conexion, $EMPRESA);
}
		
			
$codigoop = "".$nombre_C."_".$id_empresa."";	

$logs = "INSERT INTO logs(`id`,`usuario`,`fecha`,`accion`,`descripcion`)
VALUES
(NOT NULL,'".$usuario."','".$now."','actualizacion',
'actualizados los valores de personal ID -> $id
 Nombres DE $nombre1 A-> $nombre
 Apellido1 DE $apellido1_1 A-> $apellido1
 Apellido2 DE $apellido2_2 A-> $apellido2 
 Nacimiento DE $nacimiento1 A-> $nacimiento 
 Telefono DE $fijo_1 A-> $telefono_fijo
 Celular DE $celular_1 A-> $celular 
 ID Empresa DE $id_empresa_1 A-> $id_empresa 
 NC Empresa DE $nc_empresa_1 A-> $nombre_C
 Codigo OP DE $codigo_OP_1 A-> $codigoop
 Empresa DE $nc_empresa_1 A-> $NombreL
 RFID DE $rfid_1 A->  $rfid 
 Visitante DE $visitante_1 A-> $visitante
 Ubicacion DE $ubicacion_1 A-> $ubicacion
 Tipo de sangre DE $sangre_1 A-> $sangre
 IMSS DE $IMSS_1 A-> $IMSS
 Montacargas DC3 DE $monta_1 A-> $monta
 Gruas DC3 DE $gruas_1 A-> $gruas
 Cargo DE $cargo_1 A-> $cargo 
 Emergencias DE $llamar_1 A-> $llamar
 Fotografia DE $fotografia_1 A-> $foto_id')";

if ($bbdd_tipo=="sqlite"){
	$conexion2 = new PDO("sqlite:administracion/db/registros.sqlite");
	$conexion2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$logs_personal = $conexion2->query($logs); //replace exec with query
}	
if($bbdd_tipo=="mysql"){
	$conexion2 = new mysqli ("localhost","root","root","registros");
	$logs_personal1 = mysqli_query($conexion2,$logs);	 
}//fin del try para agregar logs dentro de la base de datos
    
 
 
	}//fin de if post no esta vacio
echo '<script language="javascript">alert("Personal actualizado correctamente");</script>'; 
//else{
}	//fin del if update

if ($op=="insert"){
if ( $_SESSION['nivel'] < $nivel_editar){exit;}

$insertar = 'INSERT INTO personal (`id`,`nombre`,`apellido1`,`apellido2`,`fecha_nacimiento`,`telefono_fijo`,`telefono_celular`,rfid,`visitante`,`ubicacion`,`fotografia`,`seguro_social`,`tipo_sangre`,`dc3_montacargas`,`dc3_gruas`,`cargo`,`emergencias`,`id_empresa`,`nc_empresa`) VALUES
'." (NOT NULL,
'".$nombre."',
'".$apellido1."',
'".$apellido2."',
'".$nacimiento."',
'".$telefono_fijo."',
'".$celular."',
'".$rfid."',
'".$visitante."',
'".$ubicacion."',
'".$fotografia."',
'".$IMSS."',
'".$sangre."',
'".$monta."',
'".$gruas."',
'".$cargo."',
'".$llamar."',
'".$id_empresa."',
NULL)";

if($bbdd_tipo=="sqlite"){
	$stmt=$conexion->prepare($insertar);
	$stmt->execute();
	$id=$conexion->lastInsertId();
	$log1 = "INSERT INTO logs(`id`,`usuario`,`fecha`,`accion`,`descripcion`)VALUES(NULL,'".$usuario."','".$now."','agregado','agregado personal id $id')";
	$stmt1=$conexion2->prepare($log1);
	$stmt1->execute();
}if($bbdd_tipo=="mysql"){
	$result = mysqli_query($conexion, $insertar);
	$id=$conexion->insert_id;
    $log1 = "INSERT INTO logs(`id`,`usuario`,`fecha`,`accion`,`descripcion`)VALUES(NULL,'".$usuario."','".$now."','agregado','agregado personal id $id')";
	$result1 = mysqli_query($conexion2, $log1);
	
}
				
		if ($_FILES["fotografia"]["tmp_name"]!="")
		{
			$upload_img = cwUpload('fotografia',"administracion/db/imagenes/fotografia_".$id.".jpg",'',TRUE,"administracion/db/imagenes/fotografia_".$id.".jpg",'200','160');
			$foto_id="fotografia_".$id.".jpg?".rand();
		}else{
			$foto_id="sin_imagen.jpg";
		}
		
if($bbdd_tipo=="sqlite"){
		$conexion->query("UPDATE personal SET fotografia = '".$foto_id."' WHERE id = '".$id."'");
}if($bbdd_tipo=="mysql"){
		$conexion->query("UPDATE personal SET fotografia = '".$foto_id."' WHERE id = '".$id."'");
}
		
		
//metodo para cosultar el nombre de la empresa seleccionada	
if($bbdd_tipo=="sqlite"){
	$resultado = $conexion->query("SELECT NombreC,NombreL FROM Empresas WHERE id = '".$id_empresa."'");
	$row = $resultado->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT);
}

if($bbdd_tipo=="mysql"){
	$resultado = $conexion->query("SELECT NombreC,NombreL FROM Empresas WHERE id = '".$id_empresa."'");
	$row = $resultado->fetch_assoc();	
}

	$nombre_C = $row['NombreC'];
	$NombreL = $row['NombreL'];
//fin de consulta de la empresa 		
$EMPRESA = "UPDATE personal SET codigoOP = '".$nombre_C."_".$id_empresa."',nc_empresa='".$nombre_C."' WHERE id = '".$id."'";


if($bbdd_tipo=="sqlite"){
	$stmt=$conexion->prepare($EMPRESA);
	$stmt->execute();
}
if ($bbdd_tipo=="mysql"){
	$result = mysqli_query($conexion, $EMPRESA);
}
echo '<script language="javascript">alert("Personal insertado correctamente");</script>'; 
	}//fin del if si es insert
include "administracion/vistas/personas.php";

?>
