<?php include 'inc/header.php'; ?>
<?php 
	$login = Session::get('customerLogin');
	if($login != true){
		header("Location: login.php");
	}	
?>
<style>
	.psuccess{
		width: 500px;
		min-height: 200px;
		text-align: center;
		border: 1px solid #ddd;
		margin: 0 auto;
		padding: 20px;
	}
	.psuccess h2{
		border-bottom: 1px solid #ddd;
		margin-bottom: 20px;
		padding-bottom: 10px;
	}
	.psuccess p{
		line-height: 25px;
		font-size: 18px;
		text-align: left;
	}

</style>
 <div class="main">
    <div class="content">
    	<div class="section group">
			<div class="psuccess">
				<h2>Success</h2>
				<?php
					$customerId = Session::get('customerId');

					$amount = $cart->payableAmount($customerId);
					if($amount){
						$sum = 0;
						while ($result = $amount->fetch_assoc()) {
							$sum += $result['price'];
						}
					}
				?>

				<p>Payment successful</p>
				<p style="color:red">Payment Payable Amount(Including Vat) : $
					<?php 
						$vat = $sum * 0.1;
						$sum += $vat;

						echo $sum;
					?>	
				</p>
				<p>Thanks for purchase. Receive your order successfully. We will contact you ASAP with delivery details.
					Here is your order details.. <a href="orderdetails.php">Visit Here..</a></p>
				
			</div>
			
 		</div>
 	</div>


 <?php include 'inc/footer.php'; ?>