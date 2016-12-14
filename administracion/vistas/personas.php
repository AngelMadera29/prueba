<?php
session_start();
if ($_SESSION['nivel'] == '' || $_SESSION['nivel']  < 0 ){exit;}
$nivel = $_SESSION['nivel'];
?>
	<!DOCTYPE html>
<html>
<head>
    <title>Export</title>
    <meta charset="utf-8">
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
	 <h3>Datos del personal</h3>
	 
	 
	 	 <?php
	 if ($nivel == 0){	 
echo "<a href='?page=invitado_form' class='btn btn-primary'>Añadir invitado</a> "; 
	 }else{
echo "";
	 }
	 ?>
	 <?php
	 if ($nivel >= 1){	 
echo "<a href='?page=invitado_form' class='btn btn-info'>Añadir invitado</a> "; 
echo "<a href='?page=personal_form' class='btn btn-primary'>Añadir personal</a> ";
echo "<button id='show' class='btn btn-danger' disabled>Vaciar registros</button>";
	 }else{
echo "";
	 }
	 ?>
	 <a href="#" onClick ="$('#table').tableExport({type:'pdf',escape:'false'});" class="btn btn-success">PDF</a>

    <div class="container">
        </div>
        <table id="table"
             data-search="true"
          	 data-show-refresh="true"
          	 data-show-columns="true"
             data-show-toggle="true"
	     	 data-toggle="table"
		      data-cookie="true"
             data-show-refresh="true"
	         data-toolbar="#toolbar"
		     data-show-columns="true"
             data-query-params="queryParams"
             data-pagination="true"
	         data-page-list="[10, 25, 50, 100, ALL]"
	         data-filter-control="true" 
	         data-show-export="true"
		     data-maintain-selected="true"
			 data-toolbar="#show"
			 data-flat="true"
             data-url="administracion/vistas/personal.php">
         <thead>

            <tr>
	            <th data-field="state" data-checkbox="true"></th>
                <th data-field="id">id</th>
                
                <th data-formatter="dataFormater" data-width="90">Accion</th>
                
                <th data-field="fotografia"  data-formatter="imageFormatter">Foto</th>
                
				<th data-field="apellido1" data-filter-control="input">Apellido M.</th> 
				<th data-field="apellido2" data-filter-control="input">Apellido P.</th> 
				<th data-field="nombre" data-filter-control="input">Nombre personal</th> 
				<th data-field="cargo" data-filter-control="select" >Ocupación</th>
				<th data-field="telefono_fijo" >Telefono</th>
				<th data-field="telefono_celular" >Celular</th>
				<th data-field="nc_empresa" data-filter-control="select" >Empresa</th>	
				<th data-field="rfid" >RFID</th>
				<th data-field="visitante" >Visitante</th>
				<th data-field="ubicacion" data-filter-control="select">Ubicacion</th>
				<th data-field="codigoOP" >Codigo</th>
				<th data-field="seguro_social" >Seguro</th>
				<th data-field="tipo_sangre" >Sangre</th>
				<th data-field="dc3_montacargas" >DC3 Montacargas</th>
				<th data-field="dc3_gruas" >DC3 Gruas</th>
				<th data-field="emergencias" >Persona a cargo</th>
				
            </tr>
            </thead>
        </table> 
    </div>
    
     <script>
    var $table = $('#table'),
        $button = $('#show');
        
        $(function () {
        $table.on('check.bs.table uncheck.bs.table check-all.bs.table uncheck-all.bs.table', function () {
            $button.prop('disabled', !$table.bootstrapTable('getSelections').length);
        });

    $(function () {
        $button.click(function () {
            var ids = $.map($table.bootstrapTable('getSelections'), function (row) {
                return row.id;
            });
						
      borrar=confirm("Eliminar personal seleccionado : " + ids);
       if(borrar)
       window.location = "index.php?page=vaciado-personal&datos=" + ids;
       //enviar parametro post get 
            else
      alert('No se ha podido eliminar el personal..');
      
 $('#table').bootstrapTable('refresh', {url: 'administracion/vistas/personal.php'});
        });
    });
 });
</script>  


    <script>
    var $table = $('#table'),
        $button = $('#show');
        $edit = $('#edit');
        
	function imageFormatter(value, row) {
      return "<img width=50 src='administracion/db/imagenes/" + value + "'>";
    }
    
    function dataFormater(value, row, index) {

        var id = row.id;
        var visitante = row.visitante;

        var strHTML = "<div>";
         strHTML += "<a href='index.php?page=personal_form&datos=" + id + "&visitante="+ visitante +"' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-edit'></span>&nbsp;&nbsp;Editar</a>";
        strHTML += "</div>";

        var valReturn = strHTML;

        return valReturn;
    }
   
    $(function () {
        $table.on('check.bs.table uncheck.bs.table check-all.bs.table uncheck-all.bs.table', function () {
            $button.prop('disabled', !$table.bootstrapTable('getSelections').length);
    });
    
    $(function () {
        $button.click(function () {
            var ids = $.map($table.bootstrapTable('getSelections'), function (row) {
                return row.id;
            });
    
 $('#table').bootstrapTable('refresh', {url: 'administracion/vistas/personal.php'});
        });
    });
 });
</script>

   		
<script type="text/javascript" src="assets/export/tableExport.js"></script>
<script type="text/javascript" src="assets/export/jquery.base64.js"></script>
<script type="text/javascript" src="assets/export/libs/FileSaver/FileSaver.min.js"></script>
<!-- to pdf -->

<script type="text/javascript" src="assets/export/libs/jsPDF/jspdf.min.js"></script>
<script type="text/javascript" src="assets/export/libs/jsPDF-AutoTable/jspdf.plugin.autotable.js"></script>
</body>
</html>
