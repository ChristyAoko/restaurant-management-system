<?php include('partials-front/menu.php'); ?>



    <!-- Food Search Section Start-->
    <section class="food-search text-center">
        <div class="container">
            <form action="<?php echo SITEURL; ?>food-search.php" method="POST">
                <input type="search" name="search" placeholder="Search For Food...">
                <input type="submit" name="submit" value="Search" class="btn btn-primary">
            </form>
        </div>

    </section>
    <!-- Food Search Section End -->

    <?php
        if(isset($_SESSION['order']))
        {
            echo $_SESSION['order'];
            unset($_SESSION['order']);
        }
    ?>

    <!-- About Us Section Start  -->
    <section class="about-us">
        <div class="container">
            <h2 class="text-center">About Us</h2>
            <p class="text-center">Welcome to our little Kenyan restaurant in the center of the vibrant city of <b>Nairobi</b></p>
        </div>
    </section>
    <!-- About Us Section End -->

    <!-- Categories Section Start-->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Explore Foods</h2>

            <?php
                //Create SQL Query to display data from the database
                $sql = "SELECT * FROM tbl_category WHERE active='Yes' AND featured='Yes' LIMIT 3";
                //Execute the Query
                $res = mysqli_query($conn, $sql);
                //Count rows to check whether the Category exists
                $count = mysqli_num_rows($res);

                if($count>0)
                {
                    //Categories available
                    while($row=mysqli_fetch_assoc($res))
                    {
                        //Get the values i.e. id, title and image_name 
                        $id = $row['id'];
                        $title = $row['title'];
						$image_name = $row['image_name'];
                        ?>

                        <a href="<?php echo SITEURL; ?>categories-foods.php?category_id=<?php echo $id; ?>">
                            <div class="box-3 float-container">
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
										<img src="<?php echo SITEURL; ?>img/category/<?php echo $image_name; ?>" alt="Lunch" class="img-responsive img-curve">
										<?php 
									}
								?>                                
								
                                
                                <h3><?php echo $title; ?></h3>
                            </div>
                        </a>   

                        <?php 
                    }
                }
                else 
                {
                    //Categories not available
                    echo "<div class='error'>Category Not Added</div>";
                }
            ?>

            <div class="clearfix"></div>
        </div>

    </section>
    <!-- Categories Section End -->



    <!-- Menu Section Start-->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

            <?php
                //Display All the Foods from the Database
                //SQL Query to display data from the database
                $sql2 = "SELECT * FROM tbl_menu WHERE active='Yes' AND featured='Yes' LIMIT 6";

                //Execute the Query
                $res2 = mysqli_query($conn, $sql2);   

                //Count rows 
                $count2 = mysqli_num_rows($res2);

                //Check whether the food is available or not

                if($count2>0)
                {
                    //Foods available
                    while($row=mysqli_fetch_assoc($res2))
                    {
                        //Get the values 
                        $id = $row['id'];
                        $title = $row['title'];
                        $price = $row['price'];
                        $description = $row['description'];
						$image_name = $row['image_name']; 
                        ?>

                        <div class="food-menu-box">
                            <div class="food-menu-img">
								<?php
									//Check whether image is available
									if($image_name=="")
									{
										//Image is not available
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
                                <p class="food-price">shs<?php echo $price; ?></p>
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
                    //Food not available
                    echo "<div class='error'>Food Not Found</div>";
                }
            ?>
    
            <div class="clearfix"></div>

        </div>

        <p class="text-center">
            <a href="foods.php">See All Foods</a>
        </p>

    </section>
    <!-- Menu Section End -->

    <?php include('partials-front/footer.php'); ?>
