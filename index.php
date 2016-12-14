<?php
include("auth/includes/config.php");
include("auth/header.php");
include("auth/header_registered.php");
 $_SESSION['nivel'];

	?>
<!DOCTYPE html>
<html lang="en">
  <head> 
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-sca le=1">
   
    <title>Información de la planta</title> 
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/js/jquery.bootgrid.css" rel="stylesheet">
	<link href="assets/js/bootstrap.min.js" rel="stylesheet">
  <link rel="stylesheet" href="assets/js/date/jquery-ui.css">
  
  <script src="assets/js/date/jquery-1.10.2.js"></script>
  <script src="assets/js/date/jquery-ui.js"></script>
  <link rel="stylesheet" href="assets/js/date/style.css">
	<!--<link href="assets/jquery.min.js" rel="stylesheet">-->
    
  </head>
  <body style="cursor: auto;" >
	  <div class="container-fluid">
			  <h1>Información de la planta</h1>
			  
  <nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php">Inicio</a>
      
    </div>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
<ul class="nav navbar-nav">	 
       <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="">Listado de contenido<span class="caret"></span></a>
        <ul class="dropdown-menu">
	     <?php  
	echo "	  <li><a href='?page=reg'>Lista de Registros</a></li>";
	echo "    <li><a href='?page=per'>Lista de Personal</a></li>";
	//echo "    <li><a href='?page=prueba'>prueba</a></li>";
	//mustra listado de usuarios y lectores a niveles mayores que 2 
if($_SESSION['nivel'] >= 2){
    echo "    <li><a href='?page=usr'>Lista de Usuarios</a></li>";
    echo "    <li><a href='?page=lec'>Lista de Lectores</a></li>";
}else{
	echo"<li></li>";
}
//muestra listado de ubicaciones a niveles mayores que 3
if($_SESSION['nivel'] >= 3){
	 echo "	  <li><a href='?page=ubc'>Lista de Ubicaciones</a></li>";
}else{
	echo"<li></li>";
}
	echo "	  <li><a href='?page=emp'>Lista de Empresas</a></li> ";
	echo " 	  <li><a href='?page=mov'>Lista de Movimientos</a></li>"; 
if($_SESSION['nivel'] >= 2){
	echo " 	  <li><a href='?page=logs'>Lista de Logs</a></li>"; 
	echo "	  <li><a href='?page=respaldo'>Respaldos</a></li>";
}else{
	echo"<li></li>";
}
	echo "	  <li><a href='?page=info'>Informes personal en planta</a></li> ";
		?>
		  	  
        </ul>
     </li>         
</ul>
           <ul class="nav navbar-nav navbar-right">
        <li><a href="auth/logout.phps">Cerrar Sesión</a></li>
      </ul>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

	  <?php 	  
		  
		   if ($_GET['lector']=="126")
                {
                        $_SESSION['lector']="126";
                }
		switch ($_GET['page']) {
			
			//caso de listado de personal y edicion 
			default:
			include "administracion/vistas/reg.php";
			break;
			
			
//inicia la seleccion de fomularios y gregar a la base de datos
			case 'personal_form':
			include "administracion/acciones/personal_form.php";
			break;	
//Este caso selecciona la pagina para agreger nuevo personal
			case 'personal_add':
			include "administracion/acciones/agregar_personal.php";
			break;		
			case 'del_personal':
			include "administracion/acciones/del_personal.php";
			break;		
			case 'invitado_form':
			include "administracion/acciones/invitado_form.php";
			break;	
//accion para abrir formulario de registro de nuevos usuarios
			case 'usuario_form':
			include "administracion/acciones/usuario_form.php";
			break;		
			case 'usuario_add':
			include "administracion/acciones/agregar_usuario.php";
			break;		
			case 'del_usuario':
			include "administracion/acciones/del_usuario.php";
			break;		
//accion para agregar nueva ubicacion
			case 'ubicacion_form':
			include "administracion/acciones/ubicacion_form.php";
			break;		
			case 'ubicacion_add':
			include "administracion/acciones/agregar_ubicacion.php";
			break;
			case 'del_ubicacion':
			include "administracion/acciones/del_ubicacion.php";
			break;		
	//opciones para administracion de empresas
			case 'empresas_form':
			include "administracion/acciones/empresas_form.php";
			break;		
			case 'empresas_add':
			include "administracion/acciones/agregar_empresas.php";
			break;
			case 'del_empresas':
			include "administracion/acciones/del_empresas.php";
			break;	
			//accion para agregar nuevos lectores
			case 'lectores':
			include "administracion/acciones/lectores_form.php";
			break;		
			case 'lectores_add':
			include "administracion/acciones/agregar_lectores.php";
			break;
			case 'del_lectores':
			include "administracion/acciones/del_lectores.php";
			break;		
			
			
			case 'vaciado_registros':
			include "administracion/acciones/vaciado_registros.php";
			break;		
			
			case 'vaciado-movimientos':
			include "administracion/acciones/vaciado-movimientos.php";
			break;	
			
			case 'vaciado-personal':
			include "administracion/acciones/vaciado_personal.php";
			break;	
			
			case 'vaciado-empresas':
			include "administracion/acciones/del_empresas.php";
			break;
			
			case 'vaciado_logs':
			include "administracion/acciones/vaciado_logs.php";
			break;	
			
				

			case 'consulta-movimientos':
			include "administracion/vistas/movimientos-informes.php";
			break;		


			case 'respaldo':
			include "administracion/db/descomprimir.php";
			break;
			
			case 'descomprimir':
			include "administracion/db/test.php";
			break;	
				
			
			
			
			case 'per':
			include "administracion/vistas/personas.php";
			break;		
		//casos de seleccion para agregar nuevas entradas a la base de datos
			case 'usr'://caso ustilizado para agregar en apartado de usurios
			include "administracion/vistas/usr.php";
			break;	
			case 'ubc'://caso ustilizado para agregar en apartado de ubicacion
			include "administracion/vistas/ubi.php";
			break;	
			case 'lec'://caso ustilizado para agregar en apartado de lectores
			include "administracion/vistas/lec.php";
			break;	
			case 'mov'://caso ustilizado para agregar en apartado de registos
			include "administracion/vistas/mov.php";
			break;		
			case 'personal'://caso ustilizado para agregar en apartado de registos
			include "administracion/vistas/lista.html";
			break;	
			case 'emp':
			include "administracion/vistas/emp.php";
			break;	
			case 'mov':
			include "administracion/vistas/mov.html";
			break;	
			case 'con':
			include "administracion/vistas/contenido.php";
			break;	
		
			case 'regs':
			include "administracion/vistas/registrossss.php";
			break;	
			
			case 'info':
			include "administracion/vistas/conte.php";
			break;	
			case 'logs':
			include "administracion/vistas/logs.php";
			break;	
				
			case 'informacion':
			include "informacion.php";
			break;	
			
					
			case 'editar'://caso ustilizado para agregar en apartado de registos
			include "administracion/vistas/reg.php";
			break;			
			
		}  
	   ?> 
     </div>
  </body>
</html>