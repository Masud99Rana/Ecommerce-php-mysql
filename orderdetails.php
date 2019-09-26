 <?php include 'inc/header.php'; ?>

 <?php 
 	$login = Session::get('customerLogin');
 	if($login != true){
 		header("Location: login.php");
 	}	
 ?>
	<style type="text/css">
		
		.tblone tr td{
			text-align: justify;
		}
	</style>
 <div class="main">
    <div class="content">
    		<div class="section group">
    			<div class="order">
    				<h2>Your Ordered Details</h2>

    				<table class="tblone">
    					<tr>
    						<th >SL</th>
    						<th >Product Name</th>
    						<th >Image</th>
    						<th >Quantity</th>
    						<th >Price</th>
    						<th >Date</th>
    						<th >Status</th>
    						<th >Action</th>
    					</tr>

    					<?php 
    						$customerId = Session::get('customerId');
    						$getPro = $cart->getOrderProduct($customerId);

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
    						<td><?php echo $result['quantity'] ?></td>
    						<td><?php
    								echo $result['price'];
    							?>	
    						</td>
    						<td><?php echo $fm->formatDate($result['date']) ?></td>
    						<td>
    							<?php
    								if ($result['status']==0) {
    									echo "Pending";
    								}else{
    									echo "Shifted";
    								}
    							?>
    						
    						</td>
    					<?php if ($result['status']== 1) { ?>
    						<td>
    							<a onclick="return confirm('Are you sure to delete?')" href="?delcart=<?php ?>">X</a>
    						</td>
    					<?php } else{?>
    							<td>N/A</td>
    					<?php }?>
    					</tr>
    				<?php }}?>
    				
    					
    				</table>
    			</div>
    		</div> 	
       <div class="clear"></div>
    </div>
 </div>

 <?php include 'inc/footer.php'; ?>