<?php include('partials-front/menu.php'); ?>

<?php
    //Check whether ID is passed
    if(isset($_GET['category_id']))
    {
        //Category ID is set and get the ID
        $category_id = $_GET['category_id'];
        //Get the category title based on the Category ID
        $sql = "SELECT title FROM tbl_category WHERE id=$category_id";

        //Execute the query
        $res = mysqli_query($conn, $sql);

        //Get the value from database
        $row = mysqli_fetch_assoc($res);
        //Get the title
        $category_title = $row['title'];
    }
    else 
    {
        //Category not passed
        //Redirect to home page
        header('location:'.SITEURL);
    }
?>

    <!-- Food Search Section Start-->
    <section class="food-search text-center">
        <div class="container">

            <h2 style="color:white";>Foods on <a href="#" class="text-white">"<?php echo $category_title; ?>"</a></h2>   

        </div>

    </section>
    <!-- Food Search Section End -->

    <!-- Menu Section Start-->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

            <?php
            
                //SQL Query to get foods based on selected query
                $sql2 = "SELECT * FROM tbl_menu WHERE category_id=$category_id";

                //Execute the Query
                $res2 = mysqli_query($conn, $sql2);

                //Count the Rows
                $count2 = mysqli_num_rows($res2);

                //Check whether food is available or not
                if($count2>0)
                {
                    //Food Is Available
                    while($row2=mysqli_fetch_assoc($res2))
                    {
                        //Get the details
                        $id = $row2['id'];
                        $title = $row2['title'];
                        $price = $row2['price'];
                        $description = $row2['description'];
						$image_name = $row2['image_name'];
                        ?>

                        <div class="food-menu-box">
                            <div class="food-menu-img">
								<?php
									//Check whether image is available
									if($image_name=="")
									{
										//Display the message
										echo "<div class='error'>Image Not Available</div>";
									}
									else 
									{
										//Image available
										?>
										<img src="<?php echo SITEURL; ?>img/food/<?php echo $image_name; ?>" alt="Lunch" class="img-responsive img-curve">
										<?php 
									}
								?>      
                                
                            </div>

                            <div class="food-menu-desc">
                                <h4><?php echo $title; ?></h4>
                                <p class="food-price">shs <?php echo $price; ?></p>
                                <p class="food-detail">
                                    <?php echo $description; ?>
                                </p>
                                <br />
                                <a href="<?php echo SITEURL; ?>order.php?food_id=<?php echo $id; ?>" class="btn btn-primary">Order Now</a>
                            </div>
                        </div>

                        <?php 

                    }
                }
                else 
                {
                    //Food Not Available
                    echo "<div class='error'>Food Not Available.</div>";
                }
                
            ?>

            <div class="clearfix"></div>

        </div>

    </section>
    <!-- Menu Section End -->

    <?php include('partials-front/footer.php'); ?> 