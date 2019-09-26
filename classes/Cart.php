<?php
	$filepath = realpath(dirname(__FILE__));
	include_once ($filepath.'/../lib/Database.php'); 
	include_once ($filepath.'/../helpers/Format.php'); 
?>
<?php
class Cart
{
	
	private $db;
	private $fm;

	public function __construct()
	{
		$this->db = new Database();
		$this->fm = new Format();
	}

	public function addToCart($quantity, $id){

		$quantity = $this->fm->validation($quantity);
		$quantity = mysqli_real_escape_string($this->db->link, $quantity);
		$productId = mysqli_real_escape_string($this->db->link, $id);

		$sId = session_id();

		$selectQuery = "SELECT * FROM tbl_product WHERE productId = '$productId' ";
		$result = $this->db->select($selectQuery)->fetch_assoc();

		$productName = $result['productName'];
		$price 		 = $result['price'];
		$image 		 = $result['image'];

		$checkQuery = "SELECT * FROM tbl_cart WHERE productId = '$productId' AND sId ='$sId' ";
		$getPro = $this->db->select($checkQuery);

		if($getPro){
			$msg ="Product already added!";
			return $msg;
		}


		$query = "INSERT INTO tbl_cart(sId, productId, productName, price, quantity,image) 
		VALUES('$sId','$productId','$productName','$price','$quantity', '$image')";

		$inserted_row = $this->db->insert($query);

		if($inserted_row){
			header("Location: cart.php");	
		} else {
			$msg = "<span class='error'>Category not inserted.</span>";
			header("Location: 404.php");	
		}

	}

	public function getCartProduct(){
		
		$sId = session_id();
		$selectQuery = "SELECT * FROM tbl_cart WHERE sId = '$sId' ";
		$result = $this->db->select($selectQuery);
		return $result;
	}

	public function updateCartQuantity($cartId, $quantity){
		$cartId = $this->fm->validation($cartId);
		$cartId = mysqli_real_escape_string($this->db->link, $cartId);

		$quantity = mysqli_real_escape_string($this->db->link, $quantity);

		
		$query = "UPDATE tbl_cart SET quantity= '$quantity' WHERE cartId='$cartId' ";
		$quantityUpdate = $this->db->update($query);

		if($quantityUpdate){
			header("Location: cart.php");		
		} else {
			$msg = "<span class='error'>Cart not updated.</span>";
			return $msg;
		}
		
	}

	public function delCartById($id){
		$query = "DELETE FROM tbl_cart WHERE cartId = '$id' ";
		$delData = $this->db->delete($query);

		if($delData){
			echo "<script>window.location = 'cart.php';</script>";			
		} else {
			$msg = "<span class='error'>Product not deleted.</span>";
			return $msg;
		}

	}

	public function checkCartTable(){
		$sId = session_id();
		$selectQuery = "SELECT * FROM tbl_cart WHERE sId = '$sId' ";
		$result = $this->db->select($selectQuery);

		return $result;
	}
	public function delCustomerCart(){
		$sId = session_id();
		$query = "DELETE FROM tbl_cart WHERE sId ='$sId' ";
		$this->db->delete($query);
	}

	public function orderProduct($customerId){

		$sId = session_id();
		$selectQuery = "SELECT * FROM tbl_cart WHERE sId = '$sId' ";
		$getPro = $this->db->select($selectQuery);

		if($getPro){
			while($result = $getPro->fetch_assoc()){
				$productId = $result['productId'];
				$productName = $result['productName'];
				$quantity = $result['quantity'];
				$price = $result['price'] * $quantity;
				$image = $result['image'];

				$query = "INSERT INTO tbl_order(customerId, productId, productName, quantity, price,image) 
				VALUES('$customerId','$productId','$productName','$quantity','$price', '$image')";

				$inserted_row = $this->db->insert($query);
			}
		}

	}

	public function payableAmount($customerId){

		$selectQuery = "SELECT price FROM tbl_order WHERE customerId = '$customerId' AND date= now()";
		$result = $this->db->select($selectQuery);
		return $result;

	}
}
?>