<?php
	$filepath = realpath(dirname(__FILE__));
	include_once ($filepath.'/../lib/Database.php'); 
	include_once ($filepath.'/../helpers/Format.php'); 
?>
<?php
class Customer
{
	
	private $db;
	private $fm;

	public function __construct()
	{
		$this->db = new Database();
		$this->fm = new Format();
	}

	public function customerRegistration($data){
		$name = $this->fm->validation($data['name']);
		$name = mysqli_real_escape_string($this->db->link, $name);

		$city 		 	 = mysqli_real_escape_string($this->db->link, $data['city']);
		$zip 	 		 = mysqli_real_escape_string($this->db->link, $data['zip']);
		$email 		 	 = mysqli_real_escape_string($this->db->link, $data['email']);
		$address 		 = mysqli_real_escape_string($this->db->link, $data['address']);
		$country 		 = mysqli_real_escape_string($this->db->link, $data['country']);
		$phone 		 	 = mysqli_real_escape_string($this->db->link, $data['phone']);
		
		$password 		 = mysqli_real_escape_string($this->db->link, md5($data['password']));


		if (empty($name) || $city== "" || $zip== "" || $email== "" || $address== "" || $country== "" || $phone== ""|| $password== "" ) {
		    $msg = "<span class='error'>Field must not be empty.</span>";
			return $msg;
		}

		$mailquery = "SELECT * FROM tbl_customer WHERE email= '$email' LIMIT 1";
		$mailCheck = $this->db->select($mailquery);

		if($mailCheck != false){
			$msg = "<span class='error'>Email already Exist.</span>";
			return $msg;
		}else{

			$query = "INSERT INTO tbl_customer(name, city, zip, email, address, country, phone,password) 
			VALUES('$name','$city','$zip','$email', '$address','$country','$phone','$password')";

			$inserted_row = $this->db->insert($query);
			
			if ($inserted_row) {
			 	$msg =  "<span class='success'>New user created Successfully.
			 </span>";
			 	return $msg;
			}else {
			 	$msg =  "<span class='error'>New user not created!</span>";
			 	return $msg;
			}			
		}


	}


	public function customerLogin($data){
		$email = $this->fm->validation($data['email']);
		$password = $this->fm->validation($data['password']);

		$email = mysqli_real_escape_string($this->db->link, $email);
		$password = mysqli_real_escape_string($this->db->link, $password);


		if (empty($email) || empty($password)) {

			$loginmsg = "<span class='error'>Field must not be empty.</span>";

			return $loginmsg;
		}else{
			$password = md5($password);
			
			$query = "SELECT * FROM tbl_customer WHERE email = '$email' AND password='$password'";
			$result = $this->db->select($query);

			if($result != false){
				$value = $result->fetch_assoc();

				Session::set("customerLogin", true);
				Session::set("customerId", $value['id']);
				Session::set("customerName", $value['name']);

				header("Location: order.php");
			
			} else {
				$loginmsg = "<span class='error'>Username or Password not match.</span>";
				return $loginmsg;
			}
		}

	}

}
?>