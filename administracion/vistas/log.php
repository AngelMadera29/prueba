<?php
session_start();
	$bbdd_tipo = "sqlite";
if ($_SESSION['nivel'] == '' || $_SESSION['nivel']  < 3 ){exit;}
$nivel = $_SESSION['nivel'];

$where =" 1=1 ";
$order_by="id";
$rows=25;
$current=1;
$limit_l=($current * $rows) - ($rows);
$limit_h=$limit_lower + $rows  ;


if ($_GET['ff'])
{ 
	// $_SESSION['fecha_inicio']='2016-07-01';
	$_SESSION["fecha_inicio"]=$_GET['fi'];
	$_SESSION["fecha_fin"]=$_GET['ff'];
	exit;
	// $_SESSION['fecha_fin']='2016-07-01';
}	 
	 if ($_SESSION['fecha_fin']!= "")
	 {
		 $fechas=" fecha between '".$_SESSION['fecha_inicio']."' AND '".$_SESSION['fecha_fin']."'";
	 }
	 else
	 	 $fechas="1";


//Handles Sort querystring sent from Bootgrid
if (isset($_REQUEST['sort']) && is_array($_REQUEST['sort']) )
  {
    $order_by="";
    foreach($_REQUEST['sort'] as $key=> $value)
		$order_by.=" $key $value";
	}

//Handles search  querystring sent from Bootgrid 
if (isset($_REQUEST['searchPhrase']) )
  {
    $search=trim($_REQUEST['searchPhrase']);
  	$where.= " AND ( id LIKE '".$search."%' OR 
  	  usuario LIKE '".$search."%' OR 
  	  fecha LIKE '".$search."%' OR
  	  accion LIKE '".$search."%' OR
  	  descripcion LIKE '".$search."%') "; 
	}

//Handles determines where in the paging count this result set falls in
if (isset($_REQUEST['rowCount']) )  
  $rows=$_REQUEST['rowCount'];

 //calculate the low and high limits for the SQL LIMIT x,y clause
  if (isset($_REQUEST['current']) )  
  {
   $current=$_REQUEST['current'];
	$limit_l=($current * $rows) - ($rows);
	$limit_h=$rows ;
   }

if ($rows==-1)
$limit="";  //no limit
else   
$limit=" LIMIT $limit_l,$limit_h  ";
   
//NOTE: No security here please beef this up using a prepared statement - as is this is prone to SQL injection.
$sql="SELECT id, usuario, fecha, accion, descripcion FROM logs WHERE $fechas";
if($bbdd_tipo=="sqlite"){
	$conn = new PDO("sqlite:../db/registros.sqlite");  // SQLite Database
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt=$conn->prepare($sql);
	$stmt->execute();
	$results_array=$stmt->fetchAll(PDO::FETCH_ASSOC);
	$json=json_encode( $results_array );
	$nRows=$conn->query("SELECT count(*) FROM logs WHERE $where AND $fechas")->fetchColumn();   /* specific search then how many match */
}if ($bbdd_tipo=="mysql"){
		$bbdd = new mysqli ("localhost","root","root","registros");
	$result = mysqli_query($bbdd, $sql) or die("Error in Selecting " . mysqli_error($bbdd));
	$emparray = array();
	    while($row = mysqli_fetch_assoc($result))
	    {
	        $emparray[] = array_map('utf8_encode', $row);;
	    }
	$numeros = "SELECT count(*) FROM logs WHERE $where";
	$numero = mysqli_query($bbdd, $numeros) or die(mysqli_error($bbdd));
	$nRows = $numero->fetch_row();
	$json = json_encode($emparray, JSON_UNESCAPED_UNICODE);
	$json = urldecode(stripslashes($json)); 
}


header('Content-Type: application/json'); //tell the broswer JSON is coming
if (isset($_REQUEST['rowCount']) )  //Means we're using bootgrid library
echo "{ \"current\":  $current, \"rowCount\":$rows,  \"rows\": ".$json.", \"total\": $nRows }";
else
echo $json;  //Just plain vanillat JSON output 
exit;

?>