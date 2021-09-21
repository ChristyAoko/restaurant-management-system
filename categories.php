<?php include('partials-front/menu.php'); ?>

    <!-- Categories Section Start-->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Featured Categories</h2>

            <?php
                //Display All the categories that are active
                //SQL Query to display data from the database
                $sql = "SELECT * FROM tbl_category WHERE active='Yes'";

                //Execute the Query
                $res = mysqli_query($conn, $sql);   

                //Count rows to check whether the Category exists
                $count = mysqli_num_rows($res);

                if($count>0)
                {
                    //Categories available
                    while($row=mysqli_fetch_assoc($res))
                    {
                        //Get the values i.e. id and title
                        $id = $row['id'];
                        $title = $row['title'];
						$image_name = $row['image_name'];
                        ?>

                        <a href="<?php echo SITEURL; ?>categories-foods.php?category_id=<?php echo $id; ?>">
                            <div class="box-3 float-container">
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
									<img src="<?php echo SITEURL; ?>img/category/<?php echo $image_name; ?>" alt="Lunch" class="img-responsive img-curve">
									<?php 
								}
								?>
                                
                            
                                <h3 class="float-text text-white"><?php echo $title; ?></h3>
                            </div>
                         </a>

                        <?php 
                    }
                }
                else 
                {
                    //Categories not available
                    echo "<div class='error'>Category Not Found</div>";
                }
            ?>

            <div class="clearfix"></div>
        </div>

    </section>
    <!-- Categories Section End -->

    <?php include('partials-front/footer.php'); ?>  