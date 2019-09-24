<?php
	include_once '../lib/Database.php'; 
	include_once '../helpers/Format.php'; 
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