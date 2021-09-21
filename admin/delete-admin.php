<?php

    //Include constants file
    include('../config/constants.php');

    //1. Get ID of Admin to be deleted
     $id = $_GET['id'];

    //2. Create SQL Query to delete Admin
     $sql = "DELETE FROM tbl_admin WHERE id=$id";

    //Execute the Query
     $res = mysqli_query($conn, $sql);

     //Check whether the query executed successfully
     if($res==true)
     {
         //Query Executed Successfully and Admin Deleted
         //echo "Admin Deleted";
         //Create session variable to display message
         $_SESSION['delete'] = "<div class='success'>Admin Deleted Successfully</div>";
         //Redirect to Manage Admin Page
         header('location:'.SITEURL.'admin/manage-admin.php');
     }
     else
     {
         //Failed To Delete Admin
         //echo "Failed To Delete Admin";

         $_SESSION['delete'] = "<div class='error'>Failed to Deleted Admin. Try Again Later</div>";
         header('location:'.SITEURL.'admin/manage-admin.php');
     }

    //3. Redirect to Manage Admin with Success or Error Message

?>
