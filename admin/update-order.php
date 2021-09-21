<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Order</h1>
        <br /> <br />

        <?php
            //Check whether id is set or not
            if(isset($_GET['id']))
            {
                //Get the order details
                $id=$_GET['id'];

                //Get all other details based on this ID
                //SQL Query to get the order details
                $sql = "SELECT * FROM tbl_orders WHERE id=$id";
                //Execute Query
                $res = mysqli_query($conn, $sql);
                //Count the rows
                $count = mysqli_num_rows($res);
                
                if($count==1)
                {
                    //Details available
                    $row=mysqli_fetch_assoc($res);

                    $food = $row['food'];
                    $price = $row['price'];
                    $qty = $row['qty'];
                    $status = $row['status'];
                    $customer_name = $row['customer_name'];
                    $customer_contact = $row['customer_contact'];
                    $customer_email = $row['customer_email'];
                    $customer_address = $row['customer_address'];
                }
                else 
                {
                    //Details not available
                    //Redirect to Manage Order
                    header('location:'.SITEURL.'admin/manage-order.php');
                }
            }
            else 
            {
                //Redirect to Manage Order Page
                header('location:'.SITEURL.'admin/manage-order.php');
            }
        ?>

        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Food Name</td>
                    <td><?php echo $food; ?></td>
                </tr>

                <tr>
                    <td>Price</td>
                    <td>shs<?php echo $price; ?></td>
                </tr>

                <tr>
                    <td>Quantity</td>
                    <td>
                        <input type="number" name="qty" value="<?php echo $qty; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Status</td>
                    <td>
                        <select name="status">
                            <option <?php if($status=="Ordered"){echo "selected";} ?> value="Ordered">Ordered</option>
                            <option <?php if($status=="En Route"){echo "selected";} ?> value="En Route">En Route</option>
                            <option <?php if($status=="Delivered"){echo "selected";} ?> value="Delivered">Delivered</option>
                            <option <?php if($status=="Cancelled"){echo "selected";} ?> value="Cancelled">Cancelled</option>
                        </select> 
                    </td>
                </tr>

                <tr>
                    <td>Customer Name: </td>
                    <td>
                        <input type="text" name="customer_name" value="<?php echo $customer_name; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Customer Contact: </td>
                    <td>
                        <input type="text" name="customer_contact" value="<?php echo $customer_contact; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Customer Email: </td>
                    <td>
                        <input type="text" name="customer_email" value="<?php echo $customer_email; ?>">
                    </td>
                </tr>

                <tr>
                    <td>Customer Address: </td>
                    <td>
                        <textarea name="customer_address" id="" cols="30" rows="5"><?php echo $customer_address; ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>"> 
                        <input type="hidden" name="price" value="<?php echo $price; ?>"> 
                        <input type="submit" name="submit" value="Update Order" class="btn-secondary"> 
                    </td>
                </tr>
            </table>
        </form>

        <?php
            //Check whether Update Button is clicked
            if(isset($_POST['submit']))
            {
                //Get the values from the form
                $id = $_POST['id'];
                $price = $_POST['price'];
                $qty = $_POST['qty'];

                $total = $price * $qty;

                $status = $_POST['status'];

                $customer_name = $_POST['customer_name'];
                $customer_contact = $_POST['customer_contact'];
                $customer_email = $_POST['customer_email'];
                $customer_address = $_POST['customer_address'];


                //Update the values 
                $sql2 = "UPDATE tbl_orders SET 
                    qty = $qty,
                    total = $total,
                    status = '$status',
                    customer_name = '$customer_name',
                    customer_contact = '$customer_contact',
                    customer_email = '$customer_email',
                    customer_address = '$customer_address'
                    WHERE id = $id
                ";

                //Execute the Query
                $res2 = mysqli_query($conn, $sql2);

                //Check whether Updated or Not
                //Then Redirect to Manage Order with Message
                if($res2==true)
                {
                    //Updated Successfully
                    $_SESSION['update'] = "<div class='success'>Order Updated Successfully</div>";
                    header('location:'.SITEURL.'admin/manage-order.php');
                }
                else 
                {
                    //Failed To Update
                    $_SESSION['update'] = "<div class='error'>Failed To Update Order</div>";
                    header('location:'.SITEURL.'admin/manage-order.php');
                }
            }
        ?>

    </div>
</div>

<?php include('partials/footer.php'); ?>