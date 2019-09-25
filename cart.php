<?php include 'inc/header.php'; ?>
<?php
    if(isset($_GET['delcart'])){
        $delid = preg_replace('/[^-a-zA-Z0-9_]/','', $_GET['delcart']);

        $delCart = $cart->delCartById($delid);
    }
 ?>


<?php    
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $cartId= $_POST['cartId'];
        $quantity= $_POST['quantity'];
        if($quantity <= 0){       	
        	$delCart = $cart->delCartById($cartId);
        }else{
        	$updateCart = $cart->updateCartQuantity($cartId, $quantity);
        }      
    }
?>
<?php
	if (!isset($_GET['id'])) {
		echo "<meta http-equiv='refresh' content='0;URL=?id=live'/>";
	}
?>
 <div class="main">
    <div class="content">
    	<div class="cartoption">		
			<div class="cartpage">
			    	<h2>Your Cart</h2>
			    	<?php if (isset($updateCart)) {
			    		echo $updateCart;
			    	} ?>
			    	<?php if (isset($delCart)) {
			    		echo $delCart;
			    	} ?>
						<table class="tblone">
							<tr>
								<th width="5%">SL</th>
								<th width="30%">Product Name</th>
								<th width="10%">Image</th>
								<th width="15%">Price</th>
								<th width="15%">Quantity</th>
								<th width="15%">Total Price</th>
								<th width="10%">Action</th>
							</tr>

							<?php 
								$getPro = $cart->getCartProduct();

								if($getPro){
									$i = 0;
									$sum = 0;
									$qty = 0;
									while($result = $getPro->fetch_assoc()){
										$i++;
							?>
							<tr>
								<td><?php echo $i ?></td>
								<td><?php echo $result['productName'] ?></td>
								<td><img src="admin/<?php echo $result['image'] ?>" alt=""/></td>
								<td><?php echo $result['price'] ?></td>
								<td>
									<form action="" method="post">
										<input type="hidden" name="cartId" value="<?php echo $result['cartId'] ?>"/>
										<input type="number" name="quantity" value="<?php echo $result['quantity'] ?>"/>
										<input type="submit" name="submit" value="Update"/>
									</form>
								</td>
								<td><?php
										$total = $result['price']*$result['quantity'];
										echo $total;
									?></td>
								<td><a onclick="return confirm('Are you sure to delete?')" href="?delcart=<?php echo $result['cartId'] ?>">X</a></td>
							</tr>
							<?php
								$qty = $qty + $result['quantity'];

								$sum = $sum + $total;
								Session::set("qty", $qty);
								Session::set("sum", $sum);
							?>
							<?php }}?>
						
							
						</table>
						<table style="float:right;text-align:left;" width="40%">
							<?php $getData = $cart->checkCartTable();
										if ($getData) { ?>
							<tr>
								<th>Sub Total : </th>
								<td>$ <?php echo $sum; ?></td>
							</tr>
							<tr>
								<th>VAT : </th>
								<td>10%</td>
							</tr>
							<tr>
								<th>Grand Total :</th>
								<td>$ <?php 
									$vat = $sum * 0.1;
									$gtotal = $sum + $vat;
									echo $gtotal;
								?></td>
							</tr>
							<?php }else {

								header("Location: index.php");
								// echo "Cart is empty! Please shop now.";
							} ?>
					   </table>
					</div>
					<div class="shopping">
						<div class="shopleft">
							<a href="index.html"> <img src="images/shop.png" alt="" /></a>
						</div>
						<div class="shopright">
							<a href="login.html"> <img src="images/check.png" alt="" /></a>
						</div>
					</div>
    	</div>  	
       <div class="clear"></div>
    </div>
 </div>

 <?php include 'inc/footer.php'; ?>