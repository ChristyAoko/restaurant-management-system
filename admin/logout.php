<?php
    //Include constants.php for site
    include('../config/constants.php');

    //1. Destroy the session
    session_destroy();//Unsets $_SESSION['user'] and logout of the system

    //2. Redirect to login page
    header('location:'.SITEURL.'admin/login.php');
?>