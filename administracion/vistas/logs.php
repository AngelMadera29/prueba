<?php
session_start();
if ($_SESSION['nivel'] == '' || $_SESSION['nivel']  < 3 ){exit;}
$nivel = $_SESSION['nivel'];
	?>
<!DOCTYPE html>
<html>
<head>
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
<h3>Registros</h3> 
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Desde&nbsp;&nbsp;&nbsp;<input type="date" id="fi"  /> </td>
	<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hasta&nbsp;&nbsp;<input type="date" id="ff"  /> <td>&nbsp;&nbsp;&nbsp;&nbsp;
<td>&nbsp;&nbsp;&nbsp;&nbsp;
	<a href="#" onClick ="$('#table').tableExport({type:'pdf',escape:'false'});" class="btn btn-primary">PDF</a>&nbsp;&nbsp;&nbsp;&nbsp;
  <?php
	  if ($nivel >= 1 ){
	 echo "  <button id='show' class='btn btn-danger' disabled>Vaciar logs</button>";
	 }else{
		 echo "";
	 }
	   ?>
     <div id="toolbar">
            <select class="form-control">
                <option value="">Export Basic</option>
                <option value="all">Export All</option>
                <option value="selected">Export Selected</option>
            </select>
</div>
   <script>
  $(function() {
    $( "#fi" ).datepicker();
    $( "#ff" ).datepicker();
  });
  </script> 


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
			 data-export-options='{"fileName": "logs","tableName": "logs"}'
             data-url="administracion/vistas/log.php">
            <thead>

            <tr>
	            <th data-field="state" data-checkbox="true"></th>
                <th data-field="id">id</th>
				<th data-field="usuario">Usuario</th> 
				<th data-field="fecha" data-filter-control="input">Fecha</th> 
				<th data-field="accion" data-filter-control="input">Acción</th> 
				<th data-field="descripcion" >Descripción</th>
		
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
						
      borrar=confirm("Eliminar logs seleccionados : " + ids);
       if(borrar)
       window.location = "index.php?page=vaciado_logs&datos=" + ids;
            else
      alert('No se han podido eliminar los registros..');
      
 $('#table').bootstrapTable('refresh', {url: 'administracion/vistas/logs.php'});
        });
    });
 });
</script>

<script>
    var $table = $('#table');
    $(function () {
        $('#toolbar').find('select').change(function () {
            $table.bootstrapTable('destroy').bootstrapTable({
                exportDataType: $(this).val()
            });
        });
    })
</script>
    
<script type="text/javascript">
var $table = $('#table');
$(document).ready(function(e) {
//$("#submitbutton").click(function() {
$("#ff").change(function() {

var fi = document.getElementById("fi").value;
var ff = document.getElementById("ff").value;

alert(ff);

var direccion="http://localhost:8888/administracion/vistas/registros.php?ff=" + ff + "&fi=" + fi;

$.ajax({
        type: "POST",
        url: direccion,
        data: {fecha_inicio: fi, fecha_fin: ff}
       })
        .done( function( msg ) {
	        //alert( "Data Saved: " + msg );
	      //  $table.bootstrapTable('refresh','administracion/vistas/movimientos.php' );
	     $('#table').bootstrapTable('refresh', {url: 'administracion/vistas/registros.php'});
	        });

});
});     
</script>
 <script type="text/javascript">
var $table = $('#table');
$(document).ready(function(e) {
//$("#submitbutton").click(function() {
$("#fi").change(function() {

var fi = document.getElementById("fi").value;
var ff = document.getElementById("ff").value;

alert(fi);

var direccion="http://localhost:8888/administracion/vistas/registros.php?ff=" + ff + "&fi=" + fi;

$.ajax({
        type: "POST",
        url: direccion,
        data: {fecha_inicio: fi, fecha_fin: ff}
       })
        .done( function( msg ) {
	        //alert( "Data Saved: " + msg );
	      //  $table.bootstrapTable('refresh','administracion/vistas/movimientos.php' );
	     $('#table').bootstrapTable('refresh', {url: 'administracion/vistas/registros.php'});
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
