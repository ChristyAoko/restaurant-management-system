<?php include('partials-front/menu.php'); ?>

    <!-- Food Search Section Start-->
    <section class="food-search text-center">
        <div class="container">
        <?php 

            //Get the search keyword
            $search = $_POST['search'];

        ?>
            <h2 style="color:white";>Foods on Your Search <a href="#" class="text-white">"<?php echo $search;  ?>"</a></h2> 
        </div>

    </section>
    <!-- Food Search Section End -->

    <!-- Menu Section Start-->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>
            
            <?php

                //SQL Query to get foods based on search keyword
                $sql = "SELECT * FROM tbl_menu WHERE title LIKE '%$search%' OR description LIKE '%$search%'";

                //Execute the Query
                $res = mysqli_query($conn, $sql); 

                //Count Rows
                $count = mysqli_num_rows($res);

                //Check whether food is available or not
                if($count>0)
                {
                    //Food Available
                    while($row=mysqli_fetch_assoc($res))
                    {
                        //Get the details
                        $id = $row['id'];
                        $title = $row['title'];
                        $price = $row['price'];
                        $description = $row['description'];
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
                                <p class="food-price">shs <?php echo $price; ?></p>
                                <p class="food-detail">
                                    <?php echo $description; ?>
                                </p>
                                <br />
                                <a href="<?php echo SITEURL; ?>order.php?food_id=<?php echo $id; ?>" class="btn btn-primary">Order Now</a>
                            </div>
                            <div class="clearfix"></div>
                        </div>

                        <?php 

                    }
                }
                else 
                {
                    //Food Not Available
                    echo "<div class='error'>Food Not Found.</div>";
                }

            
            ?>

            <div class="clearfix"></div>

        </div>

    </section>
    <!-- Menu Section End -->

    <?php include('partials-front/footer.php'); ?>