<?php
session_start();
	$bbdd_tipo = "sqlite";
if ($_SESSION['nivel'] == '' || $_SESSION['nivel']  < 0 ){exit;}
$nivel = $_SESSION['nivel'];

  // $DBH = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass); //MYSQL database


$where =" 1=1 ";
$order_by= "id";
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
		 $fechas="movimientos.timestamp between '".$_SESSION['fecha_inicio']."' AND '".$_SESSION['fecha_fin']."'";
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
  	$where.= " AND ( 
  	id LIKE '".$search."%' OR 
  	id_persona	 LIKE '".$search."%' OR  
  	id_entrada	 LIKE '".$search."%' OR 
  	id_salida LIKE '".$search."%'OR 
  	id_lector LIKE '".$search."%'OR 
  	timestamp	 LIKE '".$search."%') ".$fechas; 
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
$sql="select 
movimientos.id,
P.nombre as nombres, 
P.apellido1 as apellido1,
P.apellido2 as apellido2,
E.ubicacion as id_entrada, 
S.ubicacion as id_salida, 
movimientos.id_lector, 
movimientos.timestamp

from movimientos 

inner join ubicacion E on E.id = movimientos.id_entrada
inner join ubicacion S on S.id = movimientos.id_salida
inner join personal  P on P.id = movimientos.id_persona
where $fechas";
//$_SESSION['sql']=$sql;
/*$directorio=getcwd();
chdir($_SERVER['DOCUMENT_ROOT']);
file_put_contents('datos.txt', $sql);
chdir($directorio);
*/
if($bbdd_tipo=="sqlite"){
	$conn = new PDO("sqlite:../db/bbdd.sqlite");  // SQLite Database
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt=$conn->prepare($sql);
	$stmt->execute();
	$results_array=$stmt->fetchAll(PDO::FETCH_ASSOC);
	$nRows=$conn->query("SELECT count(*) FROM movimientos WHERE $where AND $fechas ")->fetchColumn();   /* specific search then how many match */
	$json=json_encode( $results_array );
}
if($bbdd_tipo=="mysql"){
		$bbdd = new mysqli ("localhost","root","root","bbdd");
	$result = mysqli_query($bbdd, $sql) or die("Error in Selecting " . mysqli_error($bbdd));
	$emparray = array();
	    while($row = mysqli_fetch_assoc($result))
	    {
	        $emparray[] = array_map('utf8_encode', $row);;
	    }
	$numeros = "SELECT count(*) FROM movimientos WHERE $where AND $fechas ";
	$numero = mysqli_query($bbdd, $numeros) or die(mysqli_error($bbdd));
	$nRows = $numero->fetch_row();
	$json = json_encode($emparray, JSON_UNESCAPED_UNICODE);
	$json = urldecode(stripslashes($json)); 
}

header('Content-Type: application/json'); //tell the broswer JSON is coming
if (isset($_REQUEST['rowCount']) )  //Means we're using bootgrid library
{
	$salida="{ \"current\":  $current, \"rowCount\":$rows,  \"rows\": ".$json.", \"total\": $nRows }";
	//file_put_contents('out.txt', $salida);
	//echo $salida;
}
else
{
	echo $json;  //Just plain vanillat JSON output 
}
exit;
?>
