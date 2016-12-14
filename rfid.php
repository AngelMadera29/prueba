<?php
$datos = $_GET['datos'];	
	
$db = new PDO('sqlite:administracion/db/bbdd.sqlite');
$result = $db->query("SELECT * FROM registros WHERE id in ()"); //replace exec with query

foreach($result as $valor){
	
$id = $valor['id'];
$id_personal = $valor['id_personal'];
$id_rfid = $valor['id_rfid'];
$timestamp = $valor['timestamp'];
$id_lector = $valor['id_lector'];
$id_zona = $valor['id_zona'];

$db3 = new PDO('sqlite:administracion/db/registros.sqlite');
$db3->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$insertar = $db3->exec("REPLACE INTO 'registros' ('id','id_personal','id_rfid','timestamp','id_lector','id_zona') 
VALUES ('".$id."','".$id_personal."','".$id_rfid."','".$timestamp."','".$id_lector."','".$id_zona."')");
}
?>

<script type="text/javascript">
<!--
var answer = confirm("Registros vaciados correctamente");
if (!answer){
window.location = "administracion/vistas/reg.php";
}
//-->
</script>

<?php
	include "administracion/vistas/reg.php";
	?>
