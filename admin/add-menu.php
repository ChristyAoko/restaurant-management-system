<?php include('partials/menu.php'); ?>

<div class="main-content">
	<div class="wrapper">
		<h1>Add Food</h1>
        <br /><br />
	
		<?php
			if(isset($_SESSION['upload'])) 
            {
               echo $_SESSION['upload']; 
               unset($_SESSION['upload']); 
            }

		?>
		
		<form action="" method="POST" enctype="multipart/form-data">
		
			<table class="tbl-30">
			
				<tr>
					<td>Title: </td>
					<td>
						<input type="text" name="title" placeholder="Name of the food">
					</td>
				</tr>
				
				<tr>
					<td>Description: </td>
					<td>
						<textarea name="description" cols="30" rows="5" placeholder="Description of the food"></textarea>
					</td>
				</tr>
				
				<tr>
					<td>Price: </td>
					<td>
						<input type="number" name="price">
					</td>
				</tr>
				
				<tr>
					<td>Select Image: </td>
					<td>
						<input type="file" name="image">
					</td>
				</tr>
				
				<tr>
					<td>Category: </td>
					<td>
						<select name="category">

							<?php 
								//Display Categories from Database
								//1. SQL to get Categories
								$sql = "SELECT * FROM tbl_category WHERE active='Yes'";

								//Execute query
								$res = mysqli_query($conn, $sql);

								//Count rows to check whether there are categories
								$count = mysqli_num_rows($res);

								//Display categories if count is greaater than zero
								if($count>0)
								{
									//There are categories
									while($row=mysqli_fetch_assoc($res))
									{
										//Get category details
										$id = $row['id'];
										$title = $row['title'];

										?>
                                    
										<option value="<?php echo $id; ?>"><?php echo $title; ?></option>

										<?php 
									}
								}
								else
								{
									//There are No Categories
									?>
									<option value="0">No Category Found</option>
									<?php  
								}
                    
							?>

						</select>
					</td>
				</tr> 

				<tr>
					<td>Featured: </td>
					<td>
						<input type="radio" name="featured" value="Yes">Yes
						<input type="radio" name="featured" value="No">No
					</td>
				</tr>
				
				<tr>
					<td>Active: </td>
					<td>
						<input type="radio" name="active" value="Yes">Yes
						<input type="radio" name="active" value="No">No
					</td>
				</tr>
				
				<tr>
					<td colspan="2">
						<input type="submit" name="submit" value="Add Food" class="btn-secondary">
					</td>
				</tr> 
				
			</table>
			
		</form>
		
		<?php

			//Check whether the button is clicked
			if(isset($_POST['submit']))
			{
                //Add the food in the database
                //echo "Clicked";

                //1. Get the data from the form
                $title = $_POST['title'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $category = $_POST['category'];
				
				//Check whether radio button for featured and active are clicked 
				if(isset($_POST['featured']))
				{
					//Get the value from form
					$featured = $_POST['featured'];
				}
				else 
				{
					//Set the default value
					$featured = "No";
				}
				
				if(isset($_POST['active']))
				{
					$active = $_POST['active'];  
				}
				else 
				{
					$active = "No";
				}
				//2. Upload the image if selected
				//Check whether the selected image has been clicked or not
				//Upload only if image has been selected
				if(isset($_FILES['image']['name']))
				{
					$image_name = $_FILES['image']['name'];
					
					//Check whether image is selected and upload only if selected
					if($image_name!="")
					{
						$ext = end(explode('.', $image_name));
						
						$image_name = "Food-Name-".rand(0000, 9999).".".$ext;
						
						$src=$_FILES['image']['tmp_name'];
				
						$dst = "../img/food/".$image_name;
						
						$upload = move_uploaded_file($src, $dst);
						
						if($upload==false)
						{
							$_SESSION['upload'] = "<div class='error'>Failed To Upload Image</div>";
							
							header("location:".SITEURL."admin/add-menu.php");
							
							die();
						}
					}
				}
				else 
				{
					$image_name = "";
				}
				
				//3. Insert into database
                //Create SQL Query to Save or Add Food
				$sql2 = "INSERT INTO tbl_menu SET 
                    title = '$title', 
                    description = '$description', 
                    price = $price, 
					image_name = '$image_name',
                    category_id = $category,
					featured = '$featured',
					active = '$active'
                ";
				
				//Execute the query
                $res2 = mysqli_query($conn, $sql2);
				
				//Check whether data has been inserted
                //4. Redirect with message to Manage Food Page
                if($res2 == true)
				{
					//Data inserted successfully
                    $_SESSION['add'] = "<div class='success'>Food Added Successfully</div>";
                    header('location:'.SITEURL.'admin/manage-menu.php');
				}
				 else
                {
                    //Failed to insert data
                    $_SESSION['add'] = "<div class='error'>Failed To Add Food</div>";
                    header('location:'.SITEURL.'admin/manage-menu.php');
                }
			}
			?>
	</div>
</div>

<?php include('partials/footer.php'); ?>