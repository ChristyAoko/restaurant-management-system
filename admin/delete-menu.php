<?php
    //Include constants page
    include('../config/constants.php');

    //echo "Delete Food";
    if(isset($_GET['id']) && isset($_GET['image_name']))
    {
        //Process to Delete
        //echo "Process to delete";

        //1. Get the ID and Image Name
        $id = $_GET['id'];
		$image_name = $_GET['image_name'];
		
		//2. Remove the Image if available
		//Check whether the image is available or not and delete only if available
		if($image_name != "")
		{
			//It has image and need to remove from folder
			//Get image path 
			$path = "../img/food/".$image_name;
			
			//Physically remove the file 
			$remove = unlink($path);
			
			//Check whether the image has been removed
			if($remove==false)
			{
				//Failed to remove Image 
				 $_SESSION['upload'] = "<div class='error'>Failed to Remove Image File.</div>";
				//Redirect to Manage Food 
				header('location:'.SITEURL.'admin/manage-menu.php');
				//Stop the Process
				die();
			}
		}

        //3. Delete food from the database 
        $sql = "DELETE FROM tbl_menu WHERE id=$id";

        //Execute the Query
        $res = mysqli_query($conn, $sql);

        //Check whether the query executed successfully
        //4. Redirect to Manage Menu with Session Message
        if($res==true)
        {
            //Set Success Message and Redirect
            $_SESSION['delete'] = "<div class='success'>Food Deleted Successfully</div>";
            //Redirect to Manage Menu
            header('location:'.SITEURL.'admin/manage-menu.php');
        } 
        else 
        {
            //Failed to Delete Food 
            $_SESSION['delete'] = "<div class='error'>Failed to Delete Food</div>";
            header('location:'.SITEURL.'admin/manage-menu.php');
        }

    }
    else
    {
        //Redirect to Manage Menu Page
        //echo "Redirect";
        $_SESSION['unauthorize'] = "<div class='error'>Unauthorised Access</div>";
        header('location:'.SITEURL.'admin/manage-menu.php');
    }
?>