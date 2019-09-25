 <?php include 'inc/header.php'; ?>

 <?php 
 	$login = Session::get('customerLogin');
 	if($login != true){
 		header("Location: login.php");
 	}	
 ?>
	<style type="text/css">
		
		.notfound{}
		.notfound h2{
			font-synthesis: 100px;
			line-height: 130px;
			text-align: center;
		}
		.notfound h2 span{
			display: block;
			color: red;
			font-size: 170px;
		}
	</style>
 <div class="main">
    <div class="content">
    		<div class="section group">
    			<div class="order">
    				<h2><span>Order Page</span></h2>
    			</div>
    		</div> 	
       <div class="clear"></div>
    </div>
 </div>

 <?php include 'inc/footer.php'; ?>