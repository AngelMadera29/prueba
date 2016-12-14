
<?php 	
	session_start();
	$bbdd_tipo = "sqlite";
if ($_SESSION['nivel'] == '' || $_SESSION['nivel']  < 1 ){
	echo '<script language="javascript">alert("No tiene permisos para editar esta empresa");</script>'; 
	echo "<script> window.location = '?page=emp';</script>";
	exit;}

if (isset($_GET))
{
	$id=$_GET['datos'];
	if ($id != "")
	{
if($bbdd_tipo=="sqlite"){	
$conexion = new PDO("sqlite:administracion/db/bbdd.sqlite");
$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$resultado = $conexion->query("SELECT * FROM Empresas where id = ".$id);
$res = $resultado->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT);
}if($bbdd_tipo=="mysql"){
	$conexion = new mysqli ("localhost","root","root","bbdd") or die("Error " . mysqli_error($conexion));
	$resultado = $conexion->query("SELECT * FROM Empresas where id = ".$id);
	$res = $resultado->fetch_assoc();
}
$id = $res['id'];	
$nombrec = $res['NombreC'];	
$nombrel = $res['NombreL'];
$nopersonas = $res['NoPersonas'];
$fechaspactadas = $res['FechasPactadas'];	
$infocontacto = $res['InfoContacto'];
$servicio = $res['Servicio'];
$rliderasgo = $res['RLiderasgo'];
$pdescansos = $res['PDescansos'];
$rlanzamiento = $res['RLanzamientos'];
$lherramientas = $res['LHerramientas'];
$eriesgos = $res['ERiesgos'];
$hddatos = $res['HDDatos'];
$andamios = $res['Andamios'];
$cresponsiva = $res['CResponsiva'];	
$pvehiculos = $res['PVehiculos'];	
$pedido = $res['Pedido'];	
$letocaa = $res['LeTocaA'];	
$carpetaarchivos = $res['CarpetaArchivos'];	
$fotografia= $res['fotografia'];	
$notase = $res['NotasE'];	
	}
}
if ($id!='')
	$accion="update";
else
	$accion="insert";
?>
<!DOCTYPE html>
<html>
	<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/bootstrap-table/src/bootstrap-table.css">
    <link rel="stylesheet" href="assets/examples.css">
    <script src="assets/jquery.min.js"></script>  
    <link rel="stylesheet" href="assets/js/date/jquery-ui.css">
	<script src="assets/js/date/jquery-ui.js"></script> 
	<link rel="stylesheet" href="assets/js/date/style.css">
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/bootstrap-table/src/bootstrap-table.js"></script>
    <script src="assets/bootstrap-table/src/extensions/export/bootstrap-table-export.js"></script>
     <script src="assets/bootstrap-table/src/extensions/editable/bootstrap-table-editable.js"></script>    
    <script src="assets/bootstrap-table/src/extensions/filter-control/bootstrap-table-filter-control.js"></script>
    <script src="assets/bootstrap-table/src/extensions/export/bootstrap-table-export.js"></script>
        <script src="assets/ga.js"></script>
	</head>
	<body>
			    <form class="form-horizontal" role="form" action="?page=empresas_add" method="post" enctype="multipart/form-data">
				<input type="hidden" name="op" value="<?php echo $accion;?>">
				<input type="hidden" name="id" value="<?php echo $id;?>">
  <fieldset>
    <legend>Agregar personal</legend>
    
     <div class="form-group">
      <label for="inputEmail" class="col-lg-2 control-label" >ID</label>
      <div class="col-lg-10">
        <input type="text" class="form-control" name="id" value="<?php echo $id;?>" id="id" placeholder="Id" maxlength="30" >
        <input type="text"  hidden="hidden" name="id_antiguo" value="<?php echo $id;?>" id="id_antiguo" maxlength="30" >
      </div>
    </div>

    <div class="form-group">
      <label for="inputEmail" class="col-lg-2 control-label">Nombre Corto:</label>
      <div class="col-lg-10">
        <input type="text" class="form-control" name="nombrec" value="<?php echo $nombrec;?>" id="nombrec" placeholder="Nombres">
      </div>
    </div>
    <div class="form-group">
      <label for="inputEmail" class="col-lg-2 control-label">Nombre Completo:</label>
      <div class="col-lg-10">
        <input type="text" class="form-control" name="nombrel" value="<?php echo $nombrel;?>" id="nombrel" placeholder="">
      </div>
    </div>

<div class="form-group">
      <label for="inputEmail" class="col-lg-2 control-label">No. Personas:</label>
      <div class="col-lg-10">
        <input type="text" class="form-control" name="nopersonas" value="<?php echo $nopersonas;?>" id="nopersonas" placeholder="Ej. 1 30 40 100">
      </div>
    </div>

<div class="form-group">
      <label for="inputEmail" class="col-lg-2 control-label">Fechas Pactadas:</label>
      <div class="col-lg-10">
<input type="text" class="form-control" name="fechaspactadas" value="<?php echo $fechaspactadas;?>" id="fechaspactadas" placeholder="Desde - Hasta">
      </div>
    </div>

<div class="form-group">
      <label for="inputEmail" class="col-lg-2 control-label">Contacto:</label>
      <div class="col-lg-10">
<input type="text" class="form-control" name="infocontacto" value="<?php echo $infocontacto;?>" id="infocontacto" placeholder="Información del contacto">
      </div>
    </div>

<div class="form-group">
      <label for="inputEmail" class="col-lg-2 control-label">Servicios:</label>
      <div class="col-lg-10">
        <input type="text" class="form-control" name="servicio" value="<?php echo $servicio;?>" id="servicio" placeholder="Telefono Celular">
      </div>
    </div>
<div class="form-group">
      <label for="inputEmail" class="col-lg-2 control-label">R Liderazgo:</label>
      <div class="col-lg-10">
	   <select class="form-control" id="rliderasgo" name="rliderasgo" values="">
          <option><?php echo $rliderasgo?></option>
          <option>SI</option>
          <option>NO</option>
        </select>    	      
	  </div>
    </div>
    <div class="form-group">
      <label for="inputEmail" class="col-lg-2 control-label">P Descansos:</label>
      <div class="col-lg-10">
	   <select class="form-control" id="pdescansos" name="tipo_sangpdescansosre" values="">
          <option><?php echo $pdescansos ?></option>
          <option>SI</option>
          <option>NO</option>
        </select>    	      
	  </div>
    </div>
<div class="form-group">
      <label for="inputEmail" class="col-lg-2 control-label">R Lanzamientos:</label>
      <div class="col-lg-10">
	   <select class="form-control" id="rlanzamiento" name="rlanzamiento" values="">
          <option><?php echo $rlanzamiento ?></option>
          <option>SI</option>
          <option>NO</option>
        </select>    	      
	  </div>
    </div>
<div class="form-group">
      <label for="inputEmail" class="col-lg-2 control-label">L Herramientas:</label>
      <div class="col-lg-10">
	   <select class="form-control" id="lherramientas" name="lherramientas" values="">
          <option><?php echo $lherramientas ?></option>
          <option>SI</option>
          <option>NO</option>
        </select>    	      
	  </div>
    </div>
<div class="form-group">
      <label for="inputEmail" class="col-lg-2 control-label">E Riesgos:</label>
      <div class="col-lg-10">
	   <select class="form-control" id="eriesgos" name="eriesgos" values="">
          <option><?php echo $eriesgos?></option>
          <option>SI</option>
          <option>NO</option>
        </select>    	      
	  </div>
    </div>
<div class="form-group">
      <label for="inputEmail" class="col-lg-2 control-label">HD Datos:</label>
      <div class="col-lg-10">
	   <select class="form-control" id="hddatos" name="hddatos" values="">
          <option><?php echo $hddatos ?></option>
          <option>SI</option>
          <option>NO</option>
        </select>    	      
	  </div>
    </div>
<div class="form-group">
      <label for="inputEmail" class="col-lg-2 control-label">Andamios:</label>
      <div class="col-lg-10">
	   <select class="form-control" id="andamios" name="andamios" values="">
          <option><?php echo $andamios ?></option>
          <option>SI</option>
          <option>NO</option>
        </select>    	      
	  </div>
    </div>
<div class="form-group">
      <label for="inputEmail" class="col-lg-2 control-label">C Responsiva:</label>
      <div class="col-lg-10">
	   <select class="form-control" id="cresponsiva" name="cresponsiva" values="">
          <option><?php echo $cresponsiva ?></option>
          <option>SI</option>
          <option>NO</option>
        </select>    	      
	  </div>
    </div>
    <div class="form-group">
      <label for="inputEmail" class="col-lg-2 control-label">P Vehiculos:</label>
      <div class="col-lg-10">
	   <select class="form-control" id="pvehiculos" name="pvehiculos" values="">
          <option><?php echo $pvehiculos ?></option>
          <option>SI</option>
          <option>NO</option>
        </select>    	      
	  </div>
    </div>

<div class="form-group">
      <label for="inputEmail" class="col-lg-2 control-label">Pedidos:</label>
      <div class="col-lg-10">
	      	        <input type="text" class="form-control" name="pedido" value="<?php echo $pedido;?>" id="pedido" placeholder="Gruas">
	 </div>
    </div>
<div class="form-group">
      <label for="inputEmail" class="col-lg-2 control-label">Asignado A:</label>
      <div class="col-lg-10">
	      	        <input type="text" class="form-control" name="letocaa" value="<?php echo $letocaa;?>" id="letocaa" placeholder="Montacargas">
	 </div>
    </div><div class="form-group">
      <label for="inputEmail" class="col-lg-2 control-label">Carpeta Archivos:</label>
      <div class="col-lg-10">
	  <input type="text" class="form-control" name="carpetaarchivos" value="<?php echo $carpetaarchivos;?>" id="carpetaarchivos" placeholder="A quien llamar en caso de emergencias Telefeno y nombre ">
	 </div>
    </div>
 <div class="form-group">
      <label for="inputEmail" class="col-lg-2 control-label">Notas E:</label>
      <div class="col-lg-10">
	  <input type="text" class="form-control" name="notase" value="<?php echo $notase;?>" id="notase" placeholder="A quien llamar en caso de emergencias Telefeno y nombre ">
	 </div>
    </div>
<div class="form-group">
      <label for="inputEmail" class="col-lg-2 control-label">Fotografia</label>
      <div class="col-lg-10">
	 	      
	      <input type="file" name="fotografia" id="fotografia" onchange="previewFile()"  >
	      
	     <img src=".$ruta." height="200" alt="Previsualizar imagen..">

<script type="text/javascript">
        function previewFile() {
  var preview = document.querySelector('img');
  var file    = document.querySelector('input[type=file]').files[0];
  var reader  = new FileReader();

  reader.onloadend = function () {
    preview.src = reader.result;
  }

  if (file) {
    reader.readAsDataURL(file);
  } else {
    preview.src = "";
  }
}
    </script> 
      </div>

<div class="form-group">
      <div class="col-lg-10 col-lg-offset-2">
        <input type="button" name="Cancelar" value="Cancelar" onclick="location='?page=emp'">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </div>
  </fieldset>
</form>
	</body>
</html>
