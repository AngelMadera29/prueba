<?php
if(INCLUDED!=true)exit;

class base_de_datos {
	var $_dbhost;
	var $_dbuser;
	var $_dbpass;
	var $_dbname;
	var $_db;
	
	function db_connect(){
		$this->_db = mysql_connect ($this->_dbhost, $this->_dbuser, $this->_dbpass)
			or die ('Se ha encontrado un error al intentar conectarse a la base de datos: '.
				mysql_error()); 
			mysql_select_db($this->_dbname,$this->_db);
 		return;
	}
		
	function db_close(){
		mysql_close($this->_db);
		return;
	}
	function init_data($dbhost, $dbuser, $dbpass, $dbname)
	{
		$this->_dbhost=$dbhost;
		$this->_dbuser=$dbuser;
		$this->_dbpass=$dbpass;
		$this->_dbname=$dbname;
	}
}
?>
