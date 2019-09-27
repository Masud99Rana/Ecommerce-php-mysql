<?php include 'inc/header.php'; ?>
<?php 

	if(isset($_GET['proid'])){
    	$customerId =Session::get('customerId');

        $productId = preg_replace('/[^-a-zA-Z0-9_]/','', $_GET['proid']);

        $removeWishlist = $product->removeWishlistData($customerId,$productId);
    }

?>

<style>
	table.tblone img{
		height: 90px;
		width: 100px;
	}
	.tblone td {
	    vertical-align: middle;
	}
	.cartpage h2 {
		width: 100%;
	}
</style>

 <div class="main">
    <div class="content">
    	<div class="cartoption">		
			<div class="cartpage">
			    	<h2>Wishlist Product</h2>
			    	<?php if (isset($removeWishlist)): ?>
			    		<?php echo $removeWishlist ?>
			    	<?php endif ?>
			    	
					<table class="tblone">
						<tr>
							<th>SL</th>
							<th>Product Name</th>
							<th>Price</th>
							<th>Image</th>
							<th>Action</th>
						</tr>

						<?php
							$customerId =Session::get('customerId');
							$getPro = $product->getWishListData($customerId);

							if($getPro){
								$i = 0;
								while($result = $getPro->fetch_assoc()){
									$i++;
						?>
						<tr>
							<td><?php echo $i ?></td>
							<td><?php echo $result['productName'] ?></td>
							<td>$<?php echo $result['price'] ?></td>
							<td><img src="admin/<?php echo $result['image'] ?>" alt=""/></td>
							
							<td><a href="details.php?proid=<?php echo $result['productId']?>">Buy Now</a>||<a onclick="confirm('Are you sure want to remove?')" href="?proid=<?php echo $result['productId']?>">Remove</a></td>
						</tr>
						
						<?php }}?>
					
						
					</table>
						
			</div>
					
    	</div>  	
       <div class="clear"></div>
    </div>
 </div>

 <?php include 'inc/footer.php'; ?>