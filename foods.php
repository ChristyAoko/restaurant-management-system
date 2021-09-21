<?php include('partials-front/menu.php'); ?>

    <!-- Food Search Section Start-->
    <section class="food-search text-center">
        <div class="container">

            <form action="<?php echo SITEURL; ?>food-search.php" method="POST">
                <input type="search" name="search" placeholder="Search For Food..." required>
                <input type="submit" name="submit" value="Search" class="btn btn-primary">
            </form>
        </div>

    </section>
    <!-- Food Search Section End -->

    <!-- Menu Section Start-->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Featured Menu</h2>

            <?php
                //Display All the foods that are active 
                //SQL Query to display data from the database
                $sql = "SELECT * FROM tbl_menu WHERE active='Yes'";

                //Execute the Query
                $res = mysqli_query($conn, $sql);   

                //Count rows to check whether the foods are available 
                $count = mysqli_num_rows($res);
				
				//Check whether the foods are available
                if($count>0)
                {
                    //Food is available
                    while($row=mysqli_fetch_assoc($res))
                    {
                        //Get the values 
                        $id = $row['id'];
                        $title = $row['title'];
                        $description = $row['description'];
                        $price = $row['price'];
						$image_name = $row['image_name'];
                        ?>

                        <div class="food-menu-box">
                            <div class="food-menu-img">
								<?php
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
                                <h4><?php echo $title; ?></h4>
                                <p class="food-price"><?php echo $price; ?></p>
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

    </section>
    <!-- Menu Section End -->

    <?php include('partials-front/footer.php'); ?>