<?php include 'inc/header.php'; ?>
<?php
    if(!isset($_GET['proid']) || $_GET['proid'] == NULL){
        echo "<script>window.location = '404.php';</script>";
    }else{
        $id = preg_replace('/[^-a-zA-Z0-9_]/','', $_GET['proid']);     
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['buynow'])){
        $quantity= $_POST['quantity'];

        $addCart = $cart->addToCart($quantity, $id);
    }
?>

<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['compare'])){
    	$customerId =Session::get('customerId');

        $productId = preg_replace('/[^-a-zA-Z0-9_]/','', $_POST['productid']);

        $insertCompare = $product->insertCompareData($customerId,$productId);
    }
 ?>

 <div class="main">
    <div class="content">
    	<div class="section group">
			<div class="cont-desc span_1_of_2">	
			<?php 
				$getProduct = $product->getSingleProductById($id);
				if($getProduct){
					while ($result = $getProduct->fetch_assoc()) {
				
			?>

					<div class="grid images_3_of_2">
						<img src="admin/<?php echo $result['image'] ?>" alt="" />
					</div>
				<div class="desc span_3_of_2">
					<h2><?php echo $result['productName'] ?></h2>
					<div class="price">
						<p>Price: <span>$<?php echo $result['price'] ?></span></p>
						<p>Category: <span><?php echo $result['catName'] ?></span></p>
						<p>Brand:<span><?php echo $result['brandName'] ?></span></p>
					</div>
					<div class="add-cart">
						<form action="" method="post">
							<input type="number" class="buyfield" name="quantity" value="1"/>
							<input type="submit" class="buysubmit" name="buynow" value="Buy Now"/>
						</form>				
					</div>
				<?php 
					$login = Session::get('customerLogin');
					if($login == true){ ?>
						
					<div class="add-cart">
						<form action="" method="post">
							<input type="hidden" class="buyfield" name="productid" value="<?php echo $result['productId'] ?>"/>
							<input type="submit" class="buysubmit" name="compare" value="Add to compare"/>
						</form>				
					</div>
				<?php } ?>

					<span style="color: red; font-size: 18px">
						<?php
							if(isset($addCart)){
								echo $addCart;
							}
						?>

						<?php if (isset($insertCompare)): ?>
							<?php echo $insertCompare ?>
						<?php endif ?>
					</span>
				</div>
				<div class="product-desc">
					<h2>Product Details</h2>
					<p><?php echo $result['body'] ?> </p>
		    	</div>
		    <?php }} ?>
				
			</div>
				<div class="rightsidebar span_3_of_1">
					<h2>CATEGORIES</h2>
					<ul>
					<?php 
						$getCategory = $category->getAllCat($id);
						if($getCategory){
							while ($value = $getCategory->fetch_assoc()) {
						
					?>
				      <li><a href="productbycat.php?catId=<?php echo $value['catId'] ?>"> <?php echo $value['catName'] ?> </a></li>

				  	<?php }} ?>
				   
    				</ul>
    	
 				</div>
 		</div>
 	</div>


 <?php include 'inc/footer.php'; ?>