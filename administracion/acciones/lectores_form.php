
<?php 	
	session_start();
	$bbdd_tipo = "mysql";
if ($_SESSION['nivel'] == '' || $_SESSION['nivel']  < 2 ){exit;}
if (isset($_GET))
{
	$id=$_GET['datos'];
	if ($id != "")
	{
if($bbdd_tipo=="sqlite"){		
	$conexion = new PDO("sqlite:administracion/db/bbdd.sqlite");
	$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$resultado = $conexion->query("SELECT * FROM lectores WHERE id = '$id' ");
	$res = $resultado->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT);
}
if($bbdd_tipo=="mysql"){
	$conexion = new mysqli ("localhost","root","root","bbdd") or die("Error " . mysqli_error($conexion));
	$resultado = $conexion->query("SELECT * FROM lectores WHERE id = '$id' ");
	$res = $resultado->fetch_assoc();
}

$id = $res['id'];
$ubicacion1 = $res['ubicacion1'];	
$ubicacion2 = $res['ubicacion2'];		
	}
}
if ($id!=''){
	$accion="actualizar";
}else{
	$accion="insert";
	}
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
			<form class="form-horizontal" role="form" action="?page=lectores_add" method="post">
				<input type="hidden" name="op" value="<?php echo $accion;?>">
				<input type="hidden" name="id" value="<?php echo $id;?>">
				

  <fieldset>
    <legend>Agregar nueva ubicación del lector </legend>
     <div class="form-group">
      <label for="inputEmail" class="col-lg-2 control-label" >ID Lector</label>
      <div class="col-lg-10">
        <input type="text" class="form-control" name="id" value="<?php echo $id;?>" id="id" placeholder="Id" maxlength="3" >
          <input type="text"  hidden="hidden" name="id_antiguo" value="<?php echo $id;?>" id="id_antiguo" maxlength="30" >
      </div>
    </div>
<div class="form-group">
      <label for="inputEmail" class="col-lg-2 control-label">Ubicación 1</label>
      <div class="col-lg-10">
	     <?php
if($bbdd_tipo=="sqlite"){		     
$db = new PDO('sqlite:administracion/db/bbdd.sqlite');
$result = $db->query("SELECT * FROM ubicacion ORDER by id ASC "); //replace exec with query
echo '<select name="ubicacion1" id="ubicacion1" >';
        foreach ($result as $row){
	        echo '<option value="'.$row['id'].'" ';
	        if ($row['id']==$ubicacion1)
            {
	            echo " selected='selected'";
            }

            echo ' placeholder="Empresa">';
            echo $row['ubicacion'];
                        echo '</option>';  
        } 
     echo '   </select></p> '; 
     }
if($bbdd_tipo=="mysql"){
$mysqli = new mysqli("localhost", "root", "root", "bbdd");
$query = "SELECT * FROM ubicacion ORDER by id ASC ";
if ($result = $mysqli->query($query)) {
  echo '<select name="ubicacion1" id="ubicacion1" >';
    while ($row = $result->fetch_assoc()) {
	        echo '<option value="'.$row['id'].'" ';
	        if ($row['id']==$ubicacion1)
            {
	            echo " selected='selected'";
            }

            echo ' placeholder="Empresa">';
            echo $row['ubicacion'];
                        echo '</option>';  
        } 
     echo '   </select></p> ';
           }
}
     ?>
      </div>
    </div>

<div class="form-group">
      <label for="inputEmail" class="col-lg-2 control-label">Ubicación 2</label>
      <div class="col-lg-10">
	     <?php
if($bbdd_tipo=="sqlite"){		     
$db = new PDO('sqlite:administracion/db/bbdd.sqlite');
$result = $db->query("SELECT * FROM ubicacion ORDER by id ASC "); //replace exec with query
echo '<select name="ubicacion2" id="ubicacion2" >';
        foreach ($result as $row){
	        echo '<option value="'.$row['id'].'" ';
	        if ($row['id']==$ubicacion2)
            {
	            echo " selected='selected'";
            }

            echo ' placeholder="Empresa">';
            echo $row['ubicacion'];
                        echo '</option>';  
        } 
     echo '   </select></p> '; 
    }
if($bbdd_tipo=="mysql"){
	$mysqli = new mysqli("localhost", "root", "root", "bbdd");
$query = "SELECT * FROM ubicacion ORDER by id ASC ";
if ($result = $mysqli->query($query)) {
  echo '<select name="ubicacion2" id="ubicacion2" >';
    while ($row = $result->fetch_assoc()) {
	        echo '<option value="'.$row['id'].'" ';
	        if ($row['id']==$ubicacion2)
            {
	            echo " selected='selected'";
            }

            echo ' placeholder="Empresa">';
            echo $row['ubicacion'];
                        echo '</option>';  
        } 
     echo '   </select></p> ';
           }
}
     
     ?>
      </div>
    </div>


        <div class="form-group">
      <div class="col-lg-10 col-lg-offset-2">
       <input type="button" name="Cancelar" value="Cancelar" onclick="location='?page=lec'">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </div>
  </fieldset>
</form>
	</body>
</html>