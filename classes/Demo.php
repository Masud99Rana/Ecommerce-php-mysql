<?php
	$filepath = realpath(dirname(__FILE__));

	include_once ($filepath.'/../lib/Session.php'); 
	Session::checkLogin();
	include_once ($filepath.'/../lib/Database.php'); 
	include_once ($filepath.'/../helpers/Format.php');	 
?>
<?php
class Demo
{
	
	private $db;
	private $fm;

	public function __construct()
	{
		$this->db = new Database();
		$this->fm = new Format();
	}
}
?>