<?php include('partials/menu.php'); ?>


<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>

        <br /> <br />

        <?php
            if(isset($_SESSION['add'])) //Checking whether Session is set
            {
               echo $_SESSION['add']; //Display Session Message
               unset($_SESSION['add']); //Remove Session Message
            }
        ?>

        <form action="" method="POST">

            <table class="tbl-30">
                <tr>
                    <td>Full Name: </td>
                    <td>
                        <input type="text" name="full_name" placeholder="Enter your name">
                    </td>
                </tr>

                <tr>
                    <td>Username: </td>
                    <td>
                        <input type="text" name="username" placeholder="Enter your username">
                    </td>
                </tr>

                <tr>
                    <td>Password: </td>
                    <td>
                        <input type="password" name="password" placeholder="Enter your password">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                    </td>
                </tr>

            </table>

        </form>
    </div>
</div>

<?php include('partials/footer.php'); ?>

<?php
    //Process the value from the form and save in the database

    //Check whether the submit button is clicked or not
    if(isset($_POST['submit']))
    {
        //Button clicked
        //echo "Button is clicked";

        //1. Get data from the form
        $full_name = $_POST['full_name'];
        $username = $_POST['username'];
        $password = md5($_POST['password']); //Password encryption with MD5

        //2. SQL Query to save data in database
        $sql = "INSERT INTO tbl_admin SET
            full_name = '$full_name',
            username = '$username',
            password = '$password'
        ";

        //3. Execute Query and saving data into the Database
        $res = mysqli_query($conn, $sql) or die (mysqli_error());

        //4. Check whether the Query is executed and data is inserted and appropriate message is displayed
        if($res==TRUE)
        {
            //Data inserted
            //echo "Data inserted";
            //Create a Session Variable to display message
            $_SESSION['add'] = "Admin Added Successfully";
            //Redirect Page to Manage Admin
            header("location:".SITEURL."admin/manage-admin.php");
        }
        else
        {
            //Failed to insert data
            ///echo "Failed to insert data";
            //Create a Session Variable to display message
            $_SESSION['add'] = "Failed to Add Admin";
            //Redirect Page to Add Admin
            header("location:".SITEURL."admin/add-admin.php");
        }
    }
?>
