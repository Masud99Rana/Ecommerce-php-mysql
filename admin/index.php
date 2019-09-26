<?php
	$filepath = realpath(dirname(__FILE__));
	include_once ($filepath.'/inc/header.php'); 
	include_once ($filepath.'/inc/sidebar.php'); 
	include_once ($filepath.'/../helpers/Format.php'); 
	include_once ($filepath.'/../classes/Cart.php');

	$cart = new Cart();
	$fm = new Format();
?>
<?php 

    if(isset($_GET['shiftid'])){
      
        $customerId = preg_replace('/[^-a-zA-Z0-9_]/','', $_GET['shiftid']);
        $orderid = preg_replace('/[^-a-zA-Z0-9_]/','', $_GET['orderid']);
        $price = preg_replace('/[^-a-zA-Z0-9_]/','', $_GET['price']);

        $shift = $cart->productShift($customerId,$orderid,$price);
    }

    if(isset($_GET['removeid'])){
      
        $customerId = preg_replace('/[^-a-zA-Z0-9_]/','', $_GET['removeid']);
        $orderid = preg_replace('/[^-a-zA-Z0-9_]/','', $_GET['orderid']);

        $remove = $cart->productRemove($customerId,$orderid);
    }
?>
        <div class="grid_10">
            <div class="box round first grid">
                <h2>Inbox</h2>
                <?php if (isset($shift)): ?>
                	<?php echo $shift ?>
                <?php endif ?>

                <?php if (isset($remove)): ?>
                	<?php echo $remove ?>
                <?php endif ?>
                <div class="block">        
                    <table class="data display datatable" id="example">
					<thead>
						<tr>
							<th>ID</th>
							<th>Date & Time</th>
							<th>Product</th>
							<th>Quantity</th>
							<th>Price</th>
							<th>Customer Id</th>
							<th>Address</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>

					<?php
						$getOrder = $cart->getAllOrderProduct();

				if ($getOrder) {
					while ($result = $getOrder->fetch_assoc()) {
					?>
						<tr class="odd gradeX">
							<td><?php echo $result['id'] ?></td>
							<td><?php echo $fm->formatDate($result['date']) ?></td>
							<td><?php echo $result['productName'] ?></td>
							<td><?php echo $result['quantity'] ?></td>
							<td>$<?php echo $result['price'] ?></td>
							<td><?php echo $result['customerId'] ?></td>
							<td><a href="customer.php?custId=<?php echo $result['customerId'] ?>">View Details</a></td>

							<?php if ($result['status'] == 0): ?>
								<td><a href="?shiftid=<?php echo $result['customerId'] ?>&price=<?php echo $result['price'] ?>&orderid=<?php echo $result['id'] ?>">Shifted</a></td>
							
							<?php elseif($result['status'] == 1): ?>
									<td>Pending</td>
							<?php else: ?>
								<td><a onclick="return confirm('Are you sure to remove?')" href="?removeid=<?php echo $result['customerId'] ?>&orderid=<?php echo $result['id'] ?>">Remove</a></td>
							<?php endif ?>
						</tr>

				<?php }} ?>
					</tbody>
				</table>
               </div>
            </div>
        </div>
<script type="text/javascript">
    $(document).ready(function () {
        setupLeftMenu();

        $('.datatable').dataTable();
        setSidebarHeight();
    });
</script>
<?php include 'inc/footer.php';?>
