<?php
session_start();
$bbdd_tipo = "sqlite";
if ($_SESSION['nivel'] == '' || $_SESSION['nivel']  < 0 ){exit;}
$nivel = $_SESSION['nivel'];
	?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="assets/jqwidgets/styles/jqx.base.css" type="text/css" />
	<link href="assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/js/jquery.bootgrid.css" rel="stylesheet">
	<link href="assets/js/bootstrap.min.js" rel="stylesheet">
    <script type="text/javascript" src="assets/js/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="assets/jqwidgets/jqxcore.js"></script>
    <script type="text/javascript" src="assets/jqwidgets/jqxbuttons.js"></script>
    <script type="text/javascript" src="assets/jqwidgets/jqxscrollbar.js"></script>
    <script type="text/javascript" src="assets/jqwidgets/jqxmenu.js"></script>
    <script type="text/javascript" src="assets/jqwidgets/jqxgrid.js"></script>
    <script type="text/javascript" src="assets/jqwidgets/jqxgrid.grouping.js"></script>
    <script type="text/javascript" src="assets/jqwidgets/jqxgrid.selection.js"></script>
    <script type="text/javascript" src="assets/jqwidgets/jqxdata.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>       
    
    <script type="text/javascript">
        $(document).ready(function () {
            // prepare the data
             var url = "administracion/vistas/personal_informes.php";
            // prepare the data
               var source =
            {
                datatype: "json",
                datafields: [
                    { name: 'nombre', type: 'string' },
                    { name: 'apellido1', type: 'string' },
                    { name: 'apellido2', type: 'string' },
                    { name: 'nc_empresa', type: 'string' },
                    { name: 'ubicacion', type: 'int' }
                ],
                id: 'id',
                url: url
            };
			var dataAdapter = new $.jqx.dataAdapter(source);

            $("#jqxgrid").jqxGrid(
            {
                autoheight:  true,
				autowidth: true,
                source: dataAdapter,
                groupable: true,
                columns: [
                  { text: 'Nombres', datafield: 'nombre', width: 200 },
                  { text: 'Ap Paterno', datafield: 'apellido1' },
                  { text: 'Ap Materno', datafield: 'apellido2' },
                  { text: 'empresa', datafield: 'nc_empresa' },
                  { text: 'ub', datafield: 'ubicacion' }
                  
                ],
                groups: ['ubicacion', 'nc_empresa']
                
            });
        });
    </script>
</head>
<body class='default'>
<?php 
if($bbdd_tipo=="sqlite"){
    $db = new PDO('sqlite:administracion/db/bbdd.sqlite');
    $result = $db->query('select * from personal where ubicacion > 0');
    $personal_dentro=count($result->fetchAll());
    echo "Personal en planta: ".$personal_dentro."<br>";
    $result = $db->query('select * from personal where ubicacion = 0');
    $personal_fuera=count($result->fetchAll());
    echo "Personal fuera de planta: ".$personal_fuera."<br>";
}if($bbdd_tipo=="mysql"){
	$db= new mysqli ("localhost","root","root","bbdd");
    $result = $db->query('select * from personal where ubicacion > 0');
    $personal_dentro = $result->fetch_row();
    echo "Personal en planta: ".$personal_dentro."<br>";
    $result = $db->query('select * from personal where ubicacion = 0');
    $personal_fuera=$result->fetch_row();
    echo "Personal fuera de planta: ".$personal_fuera."<br>"; 
}
    
?>
    <div id='jqxWidget' style="font-size: 13px; font-family: Verdana; float: left;">
        <div id="jqxgrid"></div>
    </div>
</body>
</html>  
