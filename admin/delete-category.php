<?php

    //Include constants file
    include('../config/constants.php');

    //echo "Delete Page";
    //Check whether the id and image_name is set
    if(isset($_GET['id']) AND isset($_GET['image_name']))
    {
        //Get the Value and Delete
        //echo "Get the Value and Delete";
        $id = $_GET['id'];
		$image_name = $_GET['image_name'];
		
		//Remove image file if available
		if($image_name != "") //If image is not empty
		{
			//Image is available and remove
			$path = "../img/category/".$image_name;
			//Physically remove the file 
			$remove = unlink($path);
			
			//If failed to remove image, add error message and stop the process
			if($remove==false)
			{
				//Set the session message
				 $_SESSION['remove'] = "<div class='error'>Failed to Remove Category Image.</div>";
				//Redirect to Manage Category
				header('location:'.SITEURL.'admin/manage-category.php');
				//Stop the Process
				die();
			}	
		}	

        //Delete Data from the Database
        $sql = "DELETE FROM tbl_category WHERE id=$id";

        //Execute the Query
        $res = mysqli_query($conn, $sql);

        //Check whether the query executed successfully
        if($res==true)
        {
            //Set Success Message and Redirect
            $_SESSION['delete'] = "<div class='success'>Category Deleted Successfully</div>";
            //Redirect to Manage Category
            header('location:'.SITEURL.'admin/manage-category.php');
        }
        else
        {
            //Set Fail Message and Redirect   
            $_SESSION['delete'] = "<div class='error'>Failed to Delete Category.</div>";
            //Redirect to Manage Category
            header('location:'.SITEURL.'admin/manage-category.php');
        }
        
    }
    else
    {
        //Redirect to Manage Category
        header('location:'.SITEURL.'admin/manage-category.php');

    }
?>
