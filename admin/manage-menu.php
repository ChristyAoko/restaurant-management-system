<?php include('partials/menu.php'); ?>
<!-- Main Content Start-->
     <div class="main-content">
     <div class="wrapper">
        <h1>Manage Menu</h1>

        <br /><br /> 

        <!-- Button To Add Admin -->
        <a href="<?php echo SITEURL; ?>admin/add-menu.php" class="btn-primary">Add Food</a>

        <br /><br /><br /> 

        <?php
            if(isset($_SESSION['add'])) 
            {
               echo $_SESSION['add']; 
               unset($_SESSION['add']); 
            }

            if(isset($_SESSION['delete'])) 
            {
               echo $_SESSION['delete']; 
               unset($_SESSION['delete']); 
            }
			
			if(isset($_SESSION['upload'])) 
            {
               echo $_SESSION['upload']; 
               unset($_SESSION['upload']); 
            }

            if(isset($_SESSION['unauthorize'])) 
            {
               echo $_SESSION['unauthorize']; 
               unset($_SESSION['unauthorize']); 
            }

            if(isset($_SESSION['update'])) 
            {
               echo $_SESSION['update']; 
               unset($_SESSION['update']); 
            }

        ?>

      <table class="tbl-full">
         <tr>
            <th>Serial Number</th>
            <th>Title</th>
            <th>Price</th>
			<th>Image</th>
			<th>Featured</th>
			<th>Active</th>
			<th>Actions</th>
         </tr>

         <?php
            //SQL Query to get the food
            $sql = "SELECT * FROM tbl_menu";

            //Execute the query
            $res = mysqli_query($conn, $sql);

            //Count the rows
            $count = mysqli_num_rows($res);

            //Create Serial Number Variable and Set Default as 1
            $sn=1;

            if($count>0)
            {
               //Food in Database
               //Get Food from Database and Display
               while($row=mysqli_fetch_assoc($res))
               {
                  //Get values from individual columns
                  $id = $row['id'];
                  $title = $row['title'];
                  $price = $row['price'];
				  $image_name = $row['image_name'];
				  $featured = $row['featured'];
				  $active = $row['active'];
                  ?>

                  <tr>
                     <td><?php echo $sn++; ?></td>
                     <td><?php echo $title; ?></td>
                     <td>shs<?php echo $price; ?></td>
					
 					 <td>
						<?php 
							//Check whether there is an image 
							if($image_name=="")
							{
								//There is no image
								echo "<div class='error'>Image Not Added</div>";
							}
							else 
							{
								//Display image 
								?>
								<img src="<?php echo SITEURL; ?>img/food/<?php echo $image_name; ?>" width="100px">
								<?php
							}
						?>
					 </td>
					 <td><?php echo $featured; ?></td>
					 <td><?php echo $active; ?></td>
                     <td>
                        <a href="<?php echo SITEURL; ?>admin/update-menu.php?id=<?php echo $id; ?>" class="btn-secondary">Update Food</a>
                        <a href="<?php echo SITEURL; ?>admin/delete-menu.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-danger"> Delete Food</a>
                     </td>
                  </tr>

                  <?php
               
               }
            }
            else
            {
               //No Food in Database
               echo "<tr><td colspan='7' class='error'>Food Not Added</td></tr>";
            }

         ?>

      </table>

     </div>
     </div>
<!-- Main Section End-->
<?php include('partials/footer.php'); ?>