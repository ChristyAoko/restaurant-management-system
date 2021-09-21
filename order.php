<?php include('partials-front/menu.php'); ?>

<?php
    //Check whether Food Id is set or not
    if(isset($_GET['food_id']))
    {
        //Get the Food Id and Details of the selected food
        $food_id = $_GET['food_id'];

        //Get the details of the selected food
        $sql = "SELECT * FROM tbl_menu WHERE id=$food_id";

        //Execute the Query
        $res = mysqli_query($conn, $sql);
        //Count the Rows
        $count = mysqli_num_rows($res);
        //Check whether the data is available or not
        if($count==1)
        {
            //There is data, Get the data from the database
            $row = mysqli_fetch_assoc($res);

            $title = $row['title'];
            $price =$row['price'];
			$image_name = $row['image_name'];
        }
        else 
        {
            //Food not available and redirect to Home
            header('location:'.SITEURL); 
        }
    }
    else 
    {
        //Redirect to Home Page
        header('location:'.SITEURL); 
    }
?>

<!-- Food Search Section Starts Here -->
<section class="food-menu">
    <div class="container">
    
    <h2 class="text-center text-white">Fill This Form To Confirm Your Order</h2>

    <form action="" method="POST" class="order">
        <fieldset>
            <legend>Selected Food</legend>

            <div class="food-menu-img">
				<?php
					//Check whether image is available
					if($image_name=="")
					{
						//Image Not Available
						echo "<div class='error'>Image Not Available</div>";
					}
					else 
					{
						//Image Is Available
					?>
					<img src="<?php echo SITEURL; ?>img/food/<?php echo $image_name; ?>" alt="Lunch" class="img-responsive img-curve">
					<?php 
					}
				?>
              
            </div>

            <div class="food-menu-desc">
                <h3><?php echo $title; ?></h3>
                <input type="hidden" name="food" value="<?php echo $title; ?>"> 

                <p class="food-price">shs <?php echo $price; ?></p>
                <input type="hidden" name="price" value="<?php echo $price; ?>">

                <div class="order-label">Quantity</div>
                <input type="number" name="qty" class="input-responsive" value="1" required>
            </div>
        </fieldset>

        <fieldset>
            <legend>Delivery Details</legend>
            <div class="order-label">Full Name</div>
            <input type="text" name="full-name" placeholder="E.g. Christy Aoko" class="input-responsive" required>

            <div class="order-label">Phone Number</div>
            <input type="tel" name="contact" placeholder="E.g. 07xxxxxxxx" class="input-responsive" required>

            <div class="order-label">Email</div>
            <input type="email" name="email" placeholder="E.g. hi@christyaoko.com" class="input-responsive" required>

            <div class="order-label">Address</div>
            <textarea name="address" rows="10" placeholder="E.g. Street, City, Country" class="input-responsive" required></textarea>

            <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
        </fieldset>

    </form>

    <?php
        //Check whether the submit button has been clicked
        if(isset($_POST['submit']))
        {
            //Get all the details from the form

            $food = $_POST['food'];
            $price = $_POST['price'];
            $qty = $_POST['qty'];

            $total = $price * $qty;

            $order_date = date("Y-m-d h:i:sa");

            $status = "Ordered"; //Ordered, En Route, Delivered, Cancelled

            $customer_name = $_POST['full-name'];
            $customer_contact = $_POST['contact'];
            $customer_email = $_POST['email'];
            $customer_address = $_POST['address'];

            //Save the order in the database
            //SQL to save the data
            $sql2 = "INSERT INTO tbl_orders SET 
                food = '$food',
                price = $price,
                qty = $qty,
                total = $total,
                order_date = '$order_date',
                status = '$status',
                customer_name = '$customer_name', 
                customer_contact = '$customer_contact',
                customer_email = '$customer_email',
                customer_address = '$customer_address'
            ";

            //  echo $sql2; die();

            //Execute The Query
            $res2 = mysqli_query($conn, $sql2);

            //Check whether query is executed successfully
            if($res2==true)
            {
                //Query Executed and Order Saved
                $_SESSION['order'] = "<div class='success'>Food Ordered Successfully</div>";
                header('location:'.SITEURL);  
            }
            else 
            {
                //Failed To Save Order
                $_SESSION['order'] = "<div class='error'>Failed To Order Food</div>";
                header('location:'.SITEURL);
            }
        }
    ?>

    </div>
</section>

<!-- Food Search Section Ends Here -->

<?php include('partials-front/footer.php'); ?>