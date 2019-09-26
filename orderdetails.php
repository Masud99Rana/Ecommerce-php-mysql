 <?php include 'inc/header.php'; ?>

 <?php 
 	$login = Session::get('customerLogin');
 	if($login != true){
 		header("Location: login.php");
 	}

    if(isset($_GET['confirmid'])){
      
        $orderId = preg_replace('/[^-a-zA-Z0-9_]/','', $_GET['confirmid']);
        $customerId = preg_replace('/[^-a-zA-Z0-9_]/','', $_GET['customerid']);

        $confirmShift = $cart->productShiftConfirm($customerId,$orderId);
    }

    if(isset($_GET['removeid'])){
      
        $customerId = preg_replace('/[^-a-zA-Z0-9_]/','', $_GET['removeid']);
        $orderid = preg_replace('/[^-a-zA-Z0-9_]/','', $_GET['orderid']);

        $remove = $cart->productRemove($customerId,$orderid);
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
                    <?php if (isset($confirmShift)): ?>
                        <?php echo $confirmShift ?>
                    <?php endif ?>

                    <?php if (isset($remove)): ?>
                        <?php echo $remove ?>
                    <?php endif ?>

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
    						<td>$<?php
    								echo $result['price'];
    							?>	
    						</td>
    						<td><?php echo $fm->formatDate($result['date']) ?></td>
    						<td>
    							<?php
    								if ($result['status']==0) {
    									echo "Pending";
    								}else if($result['status']==1){ 
                                        echo "Shifted";
                                    }else{
                                        echo "OK";
                                    }

                                ?>
    						
    						</td>
    						<td>
    					<?php if ($result['status'] == 1) { ?>

                            <a href="?confirmid=<?php echo $result['id'] ?>&price=<?php echo $result['price'] ?>&customerid=<?php echo $result['customerId'] ?>">Confirm</a>
                        
                        <?php }else if ($result['status']== 3) { ?>
    						<a onclick="return confirm('Are you sure to remove?')" href="?removeid=<?php echo $result['customerId'] ?>&orderid=<?php echo $result['id'] ?>">Remove</a>
    					<?php } else{?>
    						N/A
    					<?php }?>
                            </td>
    					</tr>
    				<?php }}?>
    				
    					
    				</table>
    			</div>
    		</div> 	
       <div class="clear"></div>
    </div>
 </div>

 <?php include 'inc/footer.php'; ?>