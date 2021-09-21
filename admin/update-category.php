<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
    <h1>Update Category</h1>

    <br /> <br />
	
	<?php
            //Check whether the id is set or not
			if(isset($_GET['id'])) 
            {
				//Get the ID and other details
               //echo "Getting the Data"; 
			   $id = $_GET['id'];
			   //Create SQL Query to get all other details 
			   $sql = "SELECT * FROM tbl_category WHERE id=$id";
			   
			   
			   //Execute the Query 
			   $res = mysqli_query($conn, $sql);
			   
			   //Count the Rows to check whether the id is valid or not 
			   $count = mysqli_num_rows($res);
			   
			   if($count==1)
			   {
				   //Get all the data 
				   $row = mysqli_fetch_assoc($res);
				   $title = $row['title'];
				   $current_image = $row['image_name'];
				   $featured = $row['featured'];
				   $active = $row['active'];
			   }
			   else 
			   {
				   //Redirect to manage category with session message
				    $_SESSION['no-category-found'] = "<div class='error'>Category Not Found.</div>";
					header("location:".SITEURL."admin/manage-category.php");
			   }
            }
			else
            {
				//Redirect to Manage Categories
				header("location:".SITEURL."admin/manage-category.php");
            }

    ?>
	
<form action="" method="POST" enctype="multipart/form-data">
	<table class="tbl-30">
		<tr>
			<td>Title: </td>
			<td>
				<input type="text" name="title" value="<?php echo $title; ?>">
			</td>
		</tr>
		
		<tr>
			<td>Current Image: </td>
			<td>
				<?php 
					if($current_image != "")
					{
						//Display the image 
						?>
						<img src="<?php echo SITEURL; ?>img/category/<?php echo $current_image; ?>" width="150px">
						<?php 
					}
					else
					{
						//Display the message
						echo "<div class='error'>Image Not Added.</div>";
					}
				?>
			</td>
		</tr>
		
		<tr>
			<td>New Image: </td>
			<td>
				<input type="file" name="image"> 
			</td>
		</tr>
		
		<tr>
            <td>Featured: </td>
            <td>
                <input <?php if($featured=="Yes"){echo "checked";} ?> type="radio" name="featured" value="Yes">Yes
				
                <input <?php if($featured=="No"){echo "checked";} ?> type="radio" name="featured" value="No">No
            </td>
        </tr>
		
		<tr>
            <td>Active: </td>
            <td>
                <input  <?php if($active=="Yes"){echo "checked";} ?> type="radio" name="active" value="Yes">Yes
				
                <input <?php if($active=="No"){echo "checked";} ?> type="radio" name="active" value="No">No
            </td>
        </tr>
		
		<tr>
            <td>
				<input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
				<input type="hidden" name="id" value="<?php echo $id; ?>">
                <input type="submit" name="submit" value="Update Category" class="btn-secondary">
            </td>
        </tr>
	</table>
</form>

<?php 
	if(isset($_POST['submit']))
	{
		//echo "Clicked";
		//1. Get all the values from the form 
		$id = $_POST['id']; 
		$title = $_POST['title'];
		$current_image = $_POST['current_image'];
		$featured = $_POST['featured'];
		$active = $_POST['active'];
		
		//2. Update new image if selected
		//Check whether the image is selected
		if(isset($_FILES['image']['name']))
		{
			//Get image details 
			$image_name = $_FILES['image']['name'];
			
			//Check whether the image is available or not 
			if($image_name != "")
			{
				//Image is available
				//A. Upload new image 
				
				//Automatically rename the image 
				//Get the extension of the image e.g. (jpg, png) e.g. food.jpg 
				//Use of explode function 
				$ext = end(explode('.', $image_name));
				
				//Rename the image 
				$image_name = "Food_Category_".rand(000, 999).'.'.$ext; //Result e.g. Food_Category_834.jpg 
				
				$source_path = $_FILES['image']['tmp_name'];
				
				$destination_path = "../img/category/".$image_name;
				
				//Upload the image 
				$upload = move_uploaded_file($source_path, $destination_path);
				
				//Check whether the image has been uploaded
				//If not uploaded, stop the process and redirect with error message
				if($upload==false)
				{
					//Set Message
					$_SESSION['upload'] = "<div class='error'>Failed To Upload Image </div>";
					//Redirect to Add Category Page 
					header("location:".SITEURL."admin/manage-category.php");
					//Stop the Process so that data is not entered into the database 
					die();
				}
				
				//B. Remove the current image if available
				if($current_image != "")
				{
					$remove_path = "../img/category/".$current_image;
				
					$remove = unlink($remove_path);
					
					//Check whether the image has been removed 
					//If not, display message and stop the process 
					if($remove==false)
					{
						//Failed to remove image 
						$_SESSION['failed-remove'] = "<div class='error'>Failed to Remove Image</div>";
						header('location:'.SITEURL.'admin/manage-category.php');
						die();
					}
				}
				
			}
			else 
			{
				$image_name = $current_image;
			}
		}
		else 
		{
			$image_name = $current_image;
		}
		
		//3. Update the database
		$sql2 = "UPDATE tbl_category SET 
			title = '$title',
			image_name = '$image_name',
			featured= '$featured',
			active = '$active'
			WHERE id=$id
			";
		
		
		//Execute the Query 
		$res2 = mysqli_query($conn, $sql2); 
		
		//4. Redirect to Manage Category with Message
		//Check whetherquery executed or not 
		if($res2==true)
		{
			//Category Added
			$_SESSION['update'] = "<div class='success'>Category Updated Successfully.</div>";
			header('location:'.SITEURL.'admin/manage-category.php');
		}
		else 
		{
			//Failed to update Category
			$_SESSION['update'] = "<div class='error'>Failed to Update Category.</div>";
			header('location:'.SITEURL.'admin/manage-category.php');
		}
	}
?>
	
	</div>
</div>

<?php include('partials/footer.php'); ?>