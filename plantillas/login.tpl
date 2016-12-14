<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Acceso a gestión de datos</title>
<style type="text/css">
<!--
#ttl {
	position:absolute;
	left:110px;
	top:13px;
	width:140px;
	height:138px;
	z-index:1;
}
#usr {
	position:absolute;
	left:50px;
	top:184px;
	width:253px;
	height:20px;
	z-index:2;
}
#cntr {
	position:absolute;
	left:50px;
	top:218px;
	width:252px;
	height:24px;
	z-index:3;
}
.entrada {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9px;
	font-weight: bold;
}
#acp {
	position:absolute;
	left:250px;
	top:260px;
	width:52px;
	height:13px;
	z-index:4;
}
#Pagina {
	left: 50%;
	position: absolute;
	margin-left: -215px;
}
-->
</style>
<script languaje='javascript'>
function checkEnter(e){ //e is event object passed from function invocation
	var characterCode;
	if(e && e.which){ //if which property of event object is supported (NN4)
		e = e;
		characterCode = e.which; //character code is contained in NN4's which property
	}
	else{
	e = event;
	characterCode = e.keyCode; //character code is contained in IE's keyCode property
	}

	if(characterCode == 13){ //if generated character code is equal to ascii 13 (if enter key)
		document.forms[0].submit(); //submit the form
		return false ;
	}
	else{
		return true ;
	}

}

</script>
</head>
<div id="Pagina">
<body>
<form method="post" action="login.php?op=auth&url_source={url_source}" name="login" id="login" onKeyPress="checkEnter(event)"  >
<div id="ttl"><img src="usuario.jpg"  height="140" /></div>
<div id="usr">
  <div align="right"><span class="entrada">USUARIO:</span>
    <input name="txtLogin" type="text" id="txtLogin" size="20" maxlength="15" />
  </div>
</div>
<div class="entrada" id="cntr">
  <div align="right">CONTRASE&Ntilde;A: 
    <input name="txtPassword" type="password" id="txtPassword" size="20" maxlength="15" />
  </div>
</div>
<div class="entrada" id="acp"><a href="#" onclick='login.submit()'>ACEPTAR</a></div>
</form>
</body>
</div>
</html>
