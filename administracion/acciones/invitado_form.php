
<?php 
session_start();
	$bbdd_tipo = "mysql";
if ($_SESSION['nivel'] == '' || $_SESSION['nivel']  < 0 ){exit;}

$direccion_ip="192.168.20.11";
if ($_SESSION['lector'] == "126")
{
	$direccion_ip="192.168.20.126";
}

if (isset($_GET))
{
	$id=$_GET['datos'];
	if ($id != "")
	{
		
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

$id = $res['id'];	
$nombre1 = $res['nombre'];	
$apellido1 = $res['apellido1'];
$apellido2 = $res['apellido2'];
$nacimiento = $res['fecha_nacimiento'];	
$fijo = $res['telefono_fijo'];
$celular = $res['telefono_celular'];
$rfid = $res['rfid'];
$visitante = $res['visitante'];
$ubicacion = $res['ubicacion'];
$sangre = $res['tipo_sangre'];	
$IMSS = $res['seguro_social'];
$llamar = $res['emergencias'];	
$fotografia = $res['fotografia'];	
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
			    <form class="form-horizontal" role="form" action="?page=personal_add" method="post" enctype="multipart/form-data">
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
      <label for="inputEmail" class="col-lg-2 control-label" >Nombres</label>
      <div class="col-lg-10">
        <input type="text" class="form-control" name="nombre" value="<?php echo $nombre1;?>" id="nombre" placeholder="Nombres" maxlength="30" required>
      </div>
    </div>
    <div class="form-group">
      <label for="inputEmail" class="col-lg-2 control-label">Apellido Materno</label>
      <div class="col-lg-10">
        <input type="text" class="form-control" name="apellido1" value="<?php echo $apellido1;?>" id="apellido1" placeholder="Apellido Materno" maxlength="20" required>
      </div>
    </div>

<div class="form-group">
      <label for="inputEmail" class="col-lg-2 control-label">Apellido Paterno</label>
      <div class="col-lg-10">
        <input type="text" class="form-control" name="apellido2" value="<?php echo $apellido2;?>" id="apellido2" placeholder="Apellido Paterno" maxlength="20" required>
      </div>
    </div>

<div class="form-group">
      <label for="inputEmail" class="col-lg-2 control-label">Fecha de nacimiento</label>
      <div class="col-lg-10">
        <input type="date" id="fecha_nacimiento" name="fecha_nacimiento"  value="<?php echo $nacimiento;?>" id="fecha_nacimiento" placeholder="Fecha de Nacimiento" required>
      </div>
    </div>
      <script>
  $(function() {
    $( "#fecha_nacimiento" ).datepicker();
  });
  </script>

<div class="form-group">
      <label for="inputEmail" class="col-lg-2 control-label">Telefono Fijo</label>
      <div class="col-lg-10">
        <input type="text" class="form-control" name="telefono_fijo" value="<?php echo $fijo;?>" id="telefono_fijo" placeholder="Telefono Fijo"  min="1" max="9999999999999999" required>
      </div>
    </div>

<div class="form-group">
      <label for="inputEmail" class="col-lg-2 control-label">Telefono Celular</label>
      <div class="col-lg-10">
        <input type="text" class="form-control" name="telefono_celular" value="<?php echo $celular;?>" id="telefono_celular" placeholder="Telefono Celular"   min="1" max="9999999999999999" requiered>
      </div>
    </div>

<div class="form-group">
      <label for="inputEmail" class="col-lg-2 control-label">RFID</label>
      <div class="col-lg-10">
        <input disabled="disabled" type="text" class="form-control" value="<?php echo $rfid;?>" name="rfid_visible" id="rfid_visible" placeholder="RFID">
        <input type="hidden" class="form-control" value="<?php echo $rfid;?>" name="rfid" id="rfid" placeholder="RFID">
      </div>
    </div>
    
<div class="form-group">
      <label for="inputEmail" class="col-lg-2 control-label">Visitante</label>
      <div class="col-lg-10">
	      <?php
		      
if ($_SESSION['nivel'] == 0 && $visitante == "SÍ"){
  echo "  <select disabled='disabled' class='form-control' id='visitante' name='visitante' values=''>
         <option>$visitante</option>
          <option>SÍ</option>
          <option>NO</option>
        </select>    	      
      </div>
    </div>
    ";
    }else{
  echo "  <select class='form-control' id='visitante' name='visitante' values=''>
         <option>$visitante</option>
          <option>SÍ</option>
          <option>NO</option>
        </select>    	      
      </div>
    </div>
    ";
    }
?>
<div class="form-group">
      <label for="inputEmail" class="col-lg-2 control-label">Ubicación</label>
      <div class="col-lg-10">
	      	 <input type="text" class="form-control" name="ubicacion" value="<?php echo $ubicacion;?>" id="ubicación" placeholder="Determinar ubicación exacta de la persona">
	 </div>
	 
    </div>
<div class="form-group">
      <label for="inputEmail" class="col-lg-2 control-label">IMMSS</label>
      <div class="col-lg-10">
	      	        <input type="text" class="form-control" name="seguro_social" value="<?php echo $IMSS;?>" id="seguro_social" placeholder="IMSSS">
	 </div>
    </div>
<div class="form-group">
      <label for="inputEmail" class="col-lg-2 control-label">Tipo de sangre</label>
      <div class="col-lg-10">
	   <select class="form-control" id="tipo_sangre" name="tipo_sangre" values="" placeholder="Seleccione si es visitante o trabajador">
          <option><?php echo $sangre ?></option>
          <option>A+</option>
          <option>A-</option>
          <option>B+</option>
          <option>AB+</option>
          <option>AB-</option>
          <option>O+</option>
          <option>O-</option>
        </select>    	      
	  </div>
    </div>
<div class="form-group">
      <label for="inputEmail" class="col-lg-2 control-label">Emergencias</label>
      <div class="col-lg-10">
	  <input type="text" class="form-control" name="emergencias" value="<?php echo $llamar;?>" id="emergencias" placeholder="A quien llamar en caso de emergencias Telefeno y nombre ">
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
        <input type="button" name="Cancelar" value="Cancelar" onclick="location='?page=per'">
        <button type="submit" class="btn btn-primary">Añadir</button>
      </div>
    </div>
  </fieldset>
</form>
<script>
var texto="nada";

function sondear_rfid()
{
        var client = new XMLHttpRequest();
	        client.open('GET', 'http://<?php echo $direccion_ip; ?>/servicios/ultimo_tag_plano.txt?'+Math.floor(Math.random()*100000001));
        client.onreadystatechange = function()
        {
                if (client.readyState == 4)
                {
	                
	                
                        if ((texto != client.responseText)&&(client.responseText != ''))
                        {
	                        if (texto != 'nada')
	                        	{
                                	document.getElementById('rfid').value=client.responseText;
                                	document.getElementById('rfid_visible').value=client.responseText;
								}
								texto=client.responseText;
                        }

                }
        }

        client.send();
        //alert('ciclo:');
}
window.setInterval("sondear_rfid()",1000);	
</script>
	</body>
</html>
