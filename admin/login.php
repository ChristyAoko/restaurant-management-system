<?php include('../config/constants.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Restaurant Management System</title>
    <link rel="stylesheet" href="../css/admins.css">
</head>
<body>

    <div class="login">
        <h1 class="text-center">Login</h1>
        <br /><br />

        <?php
            if(isset($_SESSION['login']))
            {
                echo $_SESSION['login'];
                unset ($_SESSION['login']);
            }

            if(isset($_SESSION['no-login-message']))
            {
                echo $_SESSION['no-login-message'];
                unset ($_SESSION['no-login-message']);
            }
        ?>
        <br /><br />

        <!-- Login Form Starts Here -->
        <form action="" method="POST" class="text-center">
        Username: <br />
        <input type="text" name="username" placeholder="Enter Username"><br /><br />

        Password: <br />
        <input type="password" name="password" placeholder="Enter Password"><br /><br />

        <input type="submit" name="submit" value="Login" class="btn-primary">
        <br /><br />
        </form>
        <!-- Login Form Ends Here -->

        <p class="text-center">&copy; 2021 - Designed by Christy Aoko</p>
    </div>

</body>
</html>

<?php
    
    //Check whether the submit button has been clicked
    if(isset($_POST['submit']))
    {
        //Process To Login
        //1. Get the data from the login form
        $username = $_POST['username'];
        $password = md5($_POST['password']);

        //2. SQL to check whether the user with the username and password exist
        $sql = "SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";

        //3. Execute the query
        $res = mysqli_query($conn, $sql);

        //4. Count rows to check whether the user exists
        $count = mysqli_num_rows($res);

        if($count==1)
        {
            //User exists and login is successful
            $_SESSION['login'] = "<div class='success'>Login Successful</div>";
            $_SESSION['user'] = $username; //Check whether the user is logged in or not
            //Redirect to Dashboard Homepage
            header('location:'.SITEURL.'admin/');
        }
        else
        {
            //User does not exist and login failed
            $_SESSION['login'] = "<div class='error text-center'>Username or Password did not match</div>";
            //Redirect to Dashboard Homepage
            header('location:'.SITEURL.'admin/login.php');
        }
    }

?>