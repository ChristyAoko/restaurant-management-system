<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
    <h1>Add Category</h1>

    <br /> <br />

    <?php
            if(isset($_SESSION['add'])) 
            {
               echo $_SESSION['add']; 
               unset($_SESSION['add']); 
            }
			if(isset($_SESSION['upload'])) 
            {
               echo $_SESSION['upload']; 
               unset($_SESSION['upload']); 
            }

    ?>

    <br /><br />

    <!--Add Category Form Start-->
    <form action="" method="POST" enctype="multipart/form-data">
        <table class="tbl-30">
            <tr>
                <td>Title: </td>
                <td>
                    <input type="text" name="title" placeholder="Category Title">
                </td>
            </tr>
			
			<tr>
				<td>Select Image: </td>
				<td>
					<input type="file" name="image">
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
                    <input type="submit" name="submit" value="Add Category" class="btn-secondary">
                </td>
            </tr>
        </table>
    </form>
    <!--Add Category Form End-->

    <?php
    //Process the value from the form and save in the database

    //Check whether the submit button is clicked or not 
    if(isset($_POST['submit']))
    {
        //Button clicked
        //echo "Button is clicked";
        
        //1. Get data from the form
        $title = $_POST['title'];

        //For radio input, check whether the button is selected or not
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
        
		//Check whether the image is selected or not and set the value for the image name 
		//print_r($_FILES['image']);  //Used instead of echo to display the value of an array
		
		//die(); //Break the code to see the value of the file selected
		
		if(isset($_FILES['image']['name']))
		{
			//Upload the image 
			//Use image name, source path and destination path to Upload the image 
			$image_name = $_FILES['image']['name'];
			
			//Upload the image only if image is selected 
			if($image_name != "")
			{
				
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
					header("location:".SITEURL."admin/add-category.php");
					//Stop the Process so that data is not entered into the database 
					die();
				}
			}
		}
		else 
		{
			//Don't Upload image and set the image_name value as blank
			$image_name="";
		}
		
        //2. SQL Query to save data in database
        $sql = "INSERT INTO tbl_category SET
            title = '$title', 
			image_name = '$image_name',
            featured = '$featured',
            active = '$active'
            ";

        //3. Execute Query and save data into the Database
        $res = mysqli_query($conn, $sql); 

        //4. Check whether the Query is executed and data is inserted and appropriate message is displayed
        if($res==true)
        {
            //Query executed and Category added
            $_SESSION['add'] = "<div class='success'>Category Added Successfully</div>";

            //Redirect Page to Manage Category Page
            header("location:".SITEURL."admin/manage-category.php");
        }
        else
        {
            //Failed to add Category
            $_SESSION['add'] = "<div class='error'>Failed To Add Category</div>";

            //Redirect Page to Manage Category Page
            header("location:".SITEURL."admin/add-category.php");
        }

        
    }
?>

    </div>
</div>

<?php include('partials/footer.php'); ?>