<?php include('partials/menu.php'); ?>
<!-- Main Content Start-->
     <div class="main-content">
     <div class="wrapper">
        <h1>Manage Category</h1>

        <?php
            if(isset($_SESSION['add'])) 
            {
               echo $_SESSION['add']; 
               unset($_SESSION['add']); 
            }
			
			if(isset($_SESSION['remove'])) 
            {
               echo $_SESSION['remove']; 
               unset($_SESSION['remove']); 
            }
			
            if(isset($_SESSION['delete'])) 
            {
               echo $_SESSION['delete']; 
               unset($_SESSION['delete']); 
            }
			
			if(isset($_SESSION['no-category-found'])) 
            {
               echo $_SESSION['no-category-found']; 
               unset($_SESSION['no-category-found']); 
            }
			
			if(isset($_SESSION['update'])) 
            {
               echo $_SESSION['update']; 
               unset($_SESSION['update']); 
            }
			
			if(isset($_SESSION['upload'])) 
            {
               echo $_SESSION['upload']; 
               unset($_SESSION['upload']); 
            }
			
			if(isset($_SESSION['failed-remove'])) 
            {
               echo $_SESSION['failed-remove']; 
               unset($_SESSION['failed-remove']); 
            }
        ?> 
        <br /><br />

        <!-- Button To Add Category -->
        <a href="<?php echo SITEURL; ?>admin/add-category.php" class="btn-primary">Add Category</a>

        <br /><br />

      <table class="tbl-full">
         <tr>
            <th>Serial Number</th>
            <th>Title</th>
			<th>Image</th>
			<th>Featured</th>
			<th>Active</th>
			<th>Actions</th>
         </tr>

         <?php
            //Query to get all data from the database
            $sql = "SELECT * FROM tbl_category";  

            //Execute query
            $res = mysqli_query($conn, $sql);

            //Count Rows
            $count = mysqli_num_rows($res);
			
            //Check if there is data in the database

            //Create Serial Number Variable and Assign Value as 1
            $sn=1;

            if ($count>0)
            {
               //There is data in the database and displayed
               while($row=mysqli_fetch_assoc($res))
               {
                  $id = $row['id'];
				  $title = $row['title'];
				  $image_name = $row['image_name'];
				  $featured = $row['featured'];
				  $active = $row['active']; 

                  ?>

                     <tr>
                        <td><?php echo $sn++; ?></td>
                        <td><?php echo $title; ?></td> 
						
						<td>
							<?php
								//Check whether image name is available
								if($image_name!="")
								{
									//Display the image 
									?>
									
									<img src="<?php echo SITEURL; ?>img/category/<?php echo $image_name; ?>" width="100px"> 
									
									<?php 
								}
								else
								{
									//Display the message
									echo "<div class='error'>Image not Added.</div>";
								}
							?>
						</td>
						
						<td><?php echo $featured; ?></td>
						<td><?php echo $active; ?></td>
                        <td>
						   <a href="<?php echo SITEURL; ?>admin/update-category.php?id=<?php echo $id; ?>" class="btn-secondary"> Update Category</a>	
                           <a href="<?php echo SITEURL; ?>admin/delete-category.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-danger"> Delete Category</a>
                        </td>
                     </tr>

                  <?php 
               }
            }  
            else  
            {
               //There is no data in the database
               //Display message in the table
               ?>

               <tr>
                  <td colspan="6"><div class="error">No Category Added</div></td>
               </tr>

               <?php   
            }

         ?>  

      </table>
        
     </div>
     </div>
<!-- Main Section End-->
<?php include('partials/footer.php'); ?>