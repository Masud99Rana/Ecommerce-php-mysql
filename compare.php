<?php include 'inc/header.php'; ?>
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
			    	<h2>Product Compare</h2>
			    	
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
							$getPro = $product->getCompareData($customerId);

							if($getPro){
								$i = 0;
								while($result = $getPro->fetch_assoc()){
									$i++;
						?>
						<tr>
							<td><?php echo $i ?></td>
							<td><?php echo $result['productName'] ?></td>
							<td><?php echo $result['price'] ?></td>
							<td><img src="admin/<?php echo $result['image'] ?>" alt=""/></td>
							
							<td><a href="details.php?proid=<?php echo $result['productId']?>">View</a></td>
						</tr>
						
						<?php }}?>
					
						
					</table>
						
			</div>
					
    	</div>  	
       <div class="clear"></div>
    </div>
 </div>

 <?php include 'inc/footer.php'; ?>