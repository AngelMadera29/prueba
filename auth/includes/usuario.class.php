<?php
if(INCLUDED!=true)exit;

class usuario_web {
	var $_nombre;
	var $_admin;
	var $_SID;

	
	function init_data($nombre, $admin, $SID)
	{
		$this->_nombre=$nombre;
		$this->_admin=$admin;
		$this->_SID=$SID;
	}
	function get_nombre()
	{
		return $this->_nombre;
	}	
	function get_url()
	{
		$_SERVER['FULL_URL'] =$_SERVER['SCRIPT_NAME'];
		if($_SERVER['QUERY_STRING']>' '){$_SERVER['FULL_URL'] .=  '?'.$_SERVER['QUERY_STRING'];}
		$url = $_SERVER['FULL_URL'];
		return $url;
	}
	
	function validate_user($user)
	{
		if (!strcmp($user,$this->_nombre))
		return true;
		return false;
	}
	
	function validate_rank($rank)
	{
		if ($this->_admin>=$rank)
		return true;
		return false;
	}
}
?>
