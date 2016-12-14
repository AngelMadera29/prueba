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
	 <h3>Datos de Usuario</h3>
	 
	 	 	 <?php
 if ($nivel >= 0){	 
echo "<a href='?page=usuario_form' class='btn btn-primary'>Añadir nuevo usuario</a> "; 
	 }else{
echo "";
	 }
	 ?>
	  <?php
	 if ($nivel >= 0){	 
echo "<button id='show' class='btn btn-danger' disabled>Vaciar usuario</button>";
	 }else{
echo "";
	 }
	 ?>

	 <a href="#" onClick ="$('#table').tableExport({type:'pdf',escape:'false'});" class="btn btn-primary">PDF</a>
	 
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
             data-url="administracion/vistas/usuarios.php">
            <thead>

            <tr>         
	            <th data-field="state" data-checkbox="true"></th>
                <th data-field="id">id</th>
                <th data-formatter="dataFormater" data-width="90">Acción</th>
                 <th data-field="nombre" >Nombre</th>
                <th data-field="sha_pass">Contraseña</th>
				<th data-field="nivel" data-type="numeric">Nivel</th>
				<th data-column-id="commands" data-formatter="commands" data-sortable="true" data-visible="false">Acciones</th>
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
						
      borrar=confirm("Eliminar usuario seleccionado : " + ids);
       if(borrar)
       window.location = "index.php?page=del_usuario&datos=" + ids;
            else
      alert('No se ha podido eliminar el usuario..');
      
 $('#table').bootstrapTable('refresh', {url: 'administracion/vistas/usuarios.php'});
        });
    });
 });
</script>
    
<script>
    var $table = $('#table'),
        $button = $('#show');
        $edit = $('#edit');
            
    function dataFormater(value, row, index) {

        var id = row.id;

        var strHTML = "<div>";
       // <a href='?page=empresas_form' class='btn btn-primary'>Añadir empresas</a> 
         strHTML += "<a href='index.php?page=usuario_form&datos=" + id + "' class='btn btn-primary btn-sm'><span class='glyphicon glyphicon-edit'></span>&nbsp;&nbsp;Editar</a>";
        strHTML += "</div>";
        //<button type=\"button\" class=\"btn btn-xs btn-default command-edit\" data-row-id=\"" + row.id + "\"><span class=\"fa fa-pencil\">Editar</span></button><br><br> ";

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
    
 $('#table').bootstrapTable('refresh', {url: 'administracion/vistas/usuarios.php'});
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
