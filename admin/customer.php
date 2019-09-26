<?php
    $filepath = realpath(dirname(__FILE__));
    include_once ($filepath.'/inc/header.php'); 
    include_once ($filepath.'/inc/sidebar.php'); 
    include_once ($filepath.'/../helpers/Format.php'); 
    include_once ($filepath.'/../classes/Customer.php'); 
?>
<?php 

    if(!isset($_GET['custId']) || $_GET['custId'] == NULL){
        echo "<script>window.location = 'index.php';</script>";
    }else{
        $id = preg_replace('/[^-a-zA-Z0-9_]/','', $_GET['custId']);
    }
?>

<style>
    .tblone{
        width: 550px;
        margin: 0 auto;
    }
    .tblone tr td{
        text-align: justify;
    }
</style>


        <div class="grid_10">
            <div class="box round first grid">
                <h2>Customer Details</h2>
               <div class="block copyblock"> 
                    <?php
                        $customer = new Customer();
                        $getData = $customer->getCustomerData($id);

                        if($getData){
                            while ($result = $getData->fetch_assoc()) {
                    ?>
                    <table class="tblone">
                        <tr>
                            <td colspan="3"><h2>Your Profile Details</h2></td>
                        </tr>
                        <tr>
                            <td width="20%">Name</td>
                            <td width="5%">:</td>
                            <td><?php echo $result['name'] ?></td>
                        </tr>
                        <tr>
                            <td>Phone</td>
                            <td>:</td>
                            <td><?php echo $result['phone'] ?></td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>:</td>
                            <td><?php echo $result['email'] ?></td>
                        </tr>
                        <tr>
                            <td>Address</td>
                            <td>:</td>
                            <td><?php echo $result['address'] ?></td>
                        </tr>

                        <tr>
                            <td>City</td>
                            <td>:</td>
                            <td><?php echo $result['city'] ?></td>
                        </tr>
                        <tr>
                            <td>Zipcode</td>
                            <td>:</td>
                            <td><?php echo $result['zip'] ?></td>
                        </tr>
                        <tr>
                            <td>Country</td>
                            <td>:</td>
                            <td><?php echo $result['country'] ?></td>
                        </tr>
                    </table>
                <?php }} ?>

                </div>
            </div>
        </div>
<?php include 'inc/footer.php';?>