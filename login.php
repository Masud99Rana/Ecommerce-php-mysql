<?php include 'inc/header.php'; ?>

<?php 
	$login = Session::get('customerLogin');
	if($login == true){
		header("Location: order.php");
	}	
?>
<?php

	if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])){

	    $customerReg = $customer->customerRegistration($_POST);
	}

	if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])){

	    $customerLogin = $customer->customerLogin($_POST);
	}
?>
 <div class="main">
    <div class="content">
    	<div class="login_panel">
        	<h3>Existing Customers</h3>
        	<p>Sign in with the form below.</p>
        	<?php if(isset($customerLogin)) {
    				echo $customerLogin;
    			}?>
        	<form action="" method="post"  id="member">
                	<input name="email" type="text" placeholder="Email">
                    <input name="password" type="password" placeholder="Password" class="field">
                    <div class="buttons"><div><button class="grey" name="login">Sign In</button></div></div>
                 </form>
        </div>


    	<div class="register_account">
    		<h3>Register New Account</h3> <span>
    			<?php if(isset($customerReg)) {
    				echo $customerReg;
    			}?>
    			
    		</span>
    		<form accept="" method="post">
		   			 <table>
		   				<tbody>
						<tr>
						<td>
							<div>
								<input type="text" name="name" placeholder="Name">
							</div>
							<div>
								<input type="text" name="city" placeholder="City">
							</div>
							<div>
								<input type="text" name="zip" placeholder="Zip-code">
							</div>
							<div>
								<input type="email" name="email" placeholder="Email">
							</div>
							
							
							
		    			 </td>
		    			<td>
						
		    		<div>
		         		<div>
		         			<input type="text" name="address" placeholder="Address">
		         		</div>
		         		<div>
		         			<input type="text" name="country" placeholder="Country">
		         		</div>
		         		<div>
		         			<input type="text" name="phone" placeholder="Phone">
		         		</div>
		         		<div>
		         			<input type="password" name="password" placeholder="Password">
		         		</div>
				 </div>		        
	
		          
		    	</td>
		    </tr> 
		    </tbody></table> 
		   <div class="search"><div><button class="grey" name="register">Create Account</button></div></div>
		    </form>
    	</div>  	
       <div class="clear"></div>
    </div>
 </div>
<?php include 'inc/footer.php'; ?>