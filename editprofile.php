<?php include 'inc/header.php'; ?>
<?php 
	$login = Session::get('customerLogin');
	if($login != true){
		header("Location: login.php");
	}

    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])){

        $customerId = Session::get('customerId');
        $updateCustomer = $customer->customerUpdate($_POST, $customerId);
    }	
?>

<style>
	.tblone{
		width: 550px;
		margin: 0 auto;
		border: 2px solid #ddd;
	}
	.tblone tr td{
		text-align: justify;
	}
    .tblone input[type="text"]{
        width: 400px;
        font-size: 15px;
        padding: 5px;
    }
</style>
 <div class="main">
    <div class="content">
    	<div class="section group">

    		<?php
    			$id = Session::get("customerId");
    			$getData = $customer->getCustomerData($id);

    			if($getData){
    				while ($result = $getData->fetch_assoc()) {
    		?>
        <form action="" method="post">
    		<table class="tblone">
    			<tr>
    				<td colspan="3"><h2>Update Profile Details</h2>
                        <?php if (isset($updateCustomer)): ?>
                            <?php echo $updateCustomer ?>
                        <?php endif ?>
                    </td>
    			</tr>
    			<tr>
    				<td width="20%">Name</td>
    				<td><input type="text" value="<?php echo $result['name'] ?>" name="name"></td>
    			</tr>
    			<tr>
    				<td>Phone</td>
                    <td><input type="text" value="<?php echo $result['phone'] ?>" name="phone"></td>
    			</tr>
    			<tr>
    				<td>Address</td>
                    <td><input type="text" value="<?php echo $result['address'] ?>" name="address"></td>
    			</tr>

    			<tr>
    				<td>City</td>
                    <td><input type="text" value="<?php echo $result['city'] ?>" name="city"></td>
    			</tr>
    			<tr>
    				<td>Zipcode</td>
                    <td><input type="text" value="<?php echo $result['zip'] ?>" name="zip"></td>
    			</tr>
    			<tr>
    				<td>Country</td>
                    <td><input type="text" value="<?php echo $result['country'] ?>" name="country"></td>
    			</tr>
    			<tr>
    				<td></td>
    				<td><input type="submit" value="Save" name="update"></td>
    			</tr>
    		</table>
    	<?php }} ?>
        </form>
 		</div>
 	</div>


 <?php include 'inc/footer.php'; ?>