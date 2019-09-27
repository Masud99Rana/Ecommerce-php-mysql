<?php
	$filepath = realpath(dirname(__FILE__));
	include_once ($filepath.'/../lib/Database.php'); 
	include_once ($filepath.'/../helpers/Format.php'); 
?>
<?php
class Product
{
	
	private $db;
	private $fm;

	public function __construct()
	{
		$this->db = new Database();
		$this->fm = new Format();
	}

	public function productInsert($data, $file){

		$productName = $this->fm->validation($data['productName']);
		$productName = mysqli_real_escape_string($this->db->link, $productName);

		$catId 		 = mysqli_real_escape_string($this->db->link, $data['catId']);
		$brandId 	 = mysqli_real_escape_string($this->db->link, $data['brandId']);
		$body 		 = mysqli_real_escape_string($this->db->link, $data['body']);
		$price 		 = mysqli_real_escape_string($this->db->link, $data['price']);
		$type 		 = mysqli_real_escape_string($this->db->link, $data['type']);


		$permited  = array('jpg', 'jpeg', 'png', 'gif');
	    $file_name = $file['image']['name'];
	    $file_size = $file['image']['size'];
	    $file_temp = $file['image']['tmp_name'];

		$div = explode('.', $file_name);
		$file_ext = strtolower(end($div));
		$unique_image = substr(md5(time()), 0, 10).'.'.$file_ext;
		$uploaded_image = "upload/".$unique_image;

		if (empty($file_name) || $productName== "" || $catId== "" || $brandId== "" || $body== "" || $price== "" || $type== "" ) {
		    $msg = "<span class='error'>Field must not be empty.</span>";
			return $msg;
		}elseif ($file_size >1048567) {
		    $msg =  "<span class='error'>Image Size should be less then 1MB!
		    </span>";
		    return $msg;
		} elseif (in_array($file_ext, $permited) === false) {
		    $msg =  "<span class='error'>You can upload only:-"
		    .implode(', ', $permited)."</span>";
		    return $msg;
		} else{
		   move_uploaded_file($file_temp, $uploaded_image);

		   $query = "INSERT INTO tbl_product(productName, catId, brandId, body, price, image, type) 
		   VALUES('$productName','$catId','$brandId','$body', '$price','$uploaded_image','$type')";

		   $inserted_row = $this->db->insert($query);
		   
		   if ($inserted_row) {
		    	$msg =  "<span class='success'>Product Inserted Successfully.
		    </span>";
		    	return $msg;
		   }else {
		    	$msg =  "<span class='error'>Product Not Inserted !</span>";
		    	return $msg;
		   }
		}
	}
	public function getAllProduct(){

		$query = "SELECT p.*, c.catName,b.brandName
					FROM tbl_product as p, tbl_category as c, tbl_brand as b
					WHERE p.catId = c.catId AND p.brandId = b.brandId
					ORDER BY p.productId DESC";

		//Without Alias
		// $query = "SELECT tbl_product.*, tbl_category.catName, tbl_brand.brandName
		// 		FROM tbl_product
		// 		INNER JOIN tbl_category
		// 		ON tbl_product.catId = tbl_category.catId
		// 		INNER JOIN tbl_brand
		// 		ON tbl_product.brandId = tbl_brand.brandId
		// 		ORDER BY tbl_product.productId DESC";


		$result = $this->db->select($query);

		return $result;
	}
	public function getProductById($id){

		$query = "SELECT * FROM tbl_product WHERE productId = '$id' ";
		$result = $this->db->select($query);

		return $result;
	}
	public function productUpdate($data, $file, $id){

		$productName = $this->fm->validation($data['productName']);
		$productName = mysqli_real_escape_string($this->db->link, $productName);

		$catId 		 = mysqli_real_escape_string($this->db->link, $data['catId']);
		$brandId 	 = mysqli_real_escape_string($this->db->link, $data['brandId']);
		$body 		 = mysqli_real_escape_string($this->db->link, $data['body']);
		$price 		 = mysqli_real_escape_string($this->db->link, $data['price']);
		$type 		 = mysqli_real_escape_string($this->db->link, $data['type']);


		if ($file['image']['error']==4) {
			if ($productName== "" || $catId== "" || $brandId== "" || $body== "" || $price== "" || $type== "" ) {
			    $msg = "<span class='error'>Field must not be empty.</span>";
				return $msg;
			}

			$query = "UPDATE tbl_product
							SET
							productName ='$productName',
							catId ='$catId',
							brandId ='$brandId',
							body ='$body',
							price ='$price',
							type ='$type' 
						WHERE productId = $id";

			$updated_row = $this->db->update($query);
			
			if ($updated_row) {
			 	$msg =  "<span class='success'>Product Updated Successfully.
			 </span>";
			 	return $msg;
			}else {
			 	$msg =  "<span class='error'>Product Not Updated !</span>";
			 	return $msg;
			}
		}else{

			$permited  = array('jpg', 'jpeg', 'png', 'gif');
		    $file_name = $file['image']['name'];
		    $file_size = $file['image']['size'];
		    $file_temp = $file['image']['tmp_name'];

			$div = explode('.', $file_name);
			$file_ext = strtolower(end($div));
			$unique_image = substr(md5(time()), 0, 10).'.'.$file_ext;
			$uploaded_image = "upload/".$unique_image;

			if (empty($file_name)) {
			    $msg = "<span class='error'>Field must not be empty.</span>";
				return $msg;
			}elseif ($file_size >1048567) {
			    $msg =  "<span class='error'>Image Size should be less then 1MB!
			    </span>";
			    return $msg;
			} elseif (in_array($file_ext, $permited) === false) {
			    $msg =  "<span class='error'>You can upload only:-"
			    .implode(', ', $permited)."</span>";
			    return $msg;
			} else{
			   move_uploaded_file($file_temp, $uploaded_image);

			   $query = "UPDATE tbl_product
			   				SET
			   				productName ='$productName',
			   				catId ='$catId',
			   				brandId ='$brandId',
			   				body ='$body',
			   				price ='$price',
			   				image ='$uploaded_image',
			   				type ='$type' 
			   			WHERE productId = $id";

			   $updated_row = $this->db->update($query);
			   
			   if ($updated_row) {
			    	$msg =  "<span class='success'>Product Updated Successfully.
			    </span>";
			    	return $msg;
			   }else {
			    	$msg =  "<span class='error'>Product Not Updated !</span>";
			    	return $msg;
			   }
			}
		}
	}
	public function delProductById($id){

		$query = "SELECT * FROM tbl_product WHERE productId = '$id' ";
		$getData = $this->db->select($query);

		if($getData){
			while($delImg = $getData->fetch_assoc()){
				$dellink = $delImg['image'];
				unlink($dellink);
			}
		}

		$delQuery = "DELETE FROM tbl_product WHERE productId = '$id' ";
		$delData = $this->db->delete($delQuery);

		if($delData){
			$msg = "<span class='success'>Product deleted successfully.</span>";
			return $msg;			
		} else {
			$msg = "<span class='error'>Product not deleted.</span>";
			return $msg;
		}

	}

	public function getFeatureProduct(){

		$query = "SELECT * FROM tbl_product WHERE type ='0' ORDER BY productId DESC LIMIT 4 ";
		$result = $this->db->select($query);
		return $result;
	}

	public function getNewProroduct(){

		$query = "SELECT * FROM tbl_product ORDER BY productId DESC LIMIT 4 ";
		$result = $this->db->select($query);
		return $result;
	}

	public function getSingleProductById($id){
		$query = "SELECT p.*, c.catName,b.brandName
					FROM tbl_product as p, tbl_category as c, tbl_brand as b
					WHERE p.catId = c.catId AND p.brandId = b.brandId AND p.productId ='$id' ";

		$result = $this->db->select($query);

		return $result;
	}

	public function latestFromIphone(){

		$query = "SELECT * FROM tbl_product WHERE brandId = '4'  ORDER BY productId DESC LIMIT 1 ";
		$result = $this->db->select($query);
		return $result;
	}

	public function latestFromSamsung(){

		$query = "SELECT * FROM tbl_product WHERE brandId = '2'  ORDER BY productId DESC LIMIT 1 ";
		$result = $this->db->select($query);
		return $result;
	}

	public function latestFromAcer(){

		$query = "SELECT * FROM tbl_product WHERE brandId = '1'  ORDER BY productId DESC LIMIT 1 ";
		$result = $this->db->select($query);
		return $result;
	}

	public function latestFromCanon(){

		$query = "SELECT * FROM tbl_product WHERE brandId = '3'  ORDER BY productId DESC LIMIT 1 ";
		$result = $this->db->select($query);
		return $result;
	}

	public function productByCat($id){
		$query = "SELECT * FROM tbl_product WHERE catId = '$id'  ORDER BY productId DESC ";
		$result = $this->db->select($query);
		return $result;
	}

	public function insertCompareData($customerId,$productId){


		$customerId = $this->fm->validation($customerId);
		$customerId = mysqli_real_escape_string($this->db->link, $customerId);
		$productId = mysqli_real_escape_string($this->db->link, $productId);

		$selectQuery = "SELECT * FROM tbl_product WHERE productId = '$productId' ";
		$result = $this->db->select($selectQuery)->fetch_assoc();

		$productName = $result['productName'];
		$price 		 = $result['price'];
		$image 		 = $result['image'];


		$checkQuery = "SELECT * FROM tbl_compare WHERE productId = '$productId' AND customerId ='$customerId' ";
		$getPro = $this->db->select($checkQuery);

		if($getPro){
			$msg ="<span class='error'>Already added!</span>";
			return $msg;
		}

		$query = "INSERT INTO tbl_compare(customerId,productId, productName, price,image) 
		VALUES('$customerId','$productId','$productName','$price', '$image')";

		$inserted_row = $this->db->insert($query);

		if($inserted_row){
			// header("Location: .php")
			return $msg = "<span class='success'>Added to compare.</span>";
		} else {
			return $msg = "<span class='error'>Not added to compare.</span>";
		}
	}	

	public function getCompareData($customerId){

		$query = "SELECT * FROM tbl_compare WHERE customerId='$customerId' ORDER BY id DESC";
		$result = $this->db->select($query);
		return $result;
	}

	public function delCompareDataCart($customerId){

		$query = "DELETE FROM tbl_compare WHERE customerId ='$customerId' ";
		$this->db->delete($query);
	}

	public function insertWishlistData($customerId,$productId){


		$customerId = $this->fm->validation($customerId);
		$customerId = mysqli_real_escape_string($this->db->link, $customerId);
		$productId = mysqli_real_escape_string($this->db->link, $productId);

		$selectQuery = "SELECT * FROM tbl_product WHERE productId = '$productId' ";
		$result = $this->db->select($selectQuery)->fetch_assoc();

		$productName = $result['productName'];
		$price 		 = $result['price'];
		$image 		 = $result['image'];


		$checkQuery = "SELECT * FROM tbl_wishlist WHERE productId = '$productId' AND customerId ='$customerId' ";
		$getPro = $this->db->select($checkQuery);

		if($getPro){
			$msg ="<span class='error'>Already added!</span>";
			return $msg;
		}

		$query = "INSERT INTO tbl_wishlist(customerId,productId, productName, price,image) 
		VALUES('$customerId','$productId','$productName','$price', '$image')";

		$inserted_row = $this->db->insert($query);

		if($inserted_row){
			// header("Location: .php")
			return $msg = "<span class='success'>Added to wishlist.</span>";
		} else {
			return $msg = "<span class='error'>Not added to wishlist.</span>";
		}
	}

	public function getWishListData($customerId){

		$query = "SELECT * FROM tbl_wishlist WHERE customerId='$customerId' ORDER BY id DESC";
		$result = $this->db->select($query);
		return $result;
	}
	public function removeWishlistData($customerId,$productId){

		$query = "DELETE FROM tbl_wishlist WHERE customerId ='$customerId' AND productId ='$productId' ";
		$removed_row = $this->db->delete($query);

		if($removed_row){
			// header("Location: .php")
			return $msg = "<span class='success'>Removed from wishlist.</span>";
		} else {
			return $msg = "<span class='error'>Not removed from wishlist.</span>";
		}
	}

}


?>