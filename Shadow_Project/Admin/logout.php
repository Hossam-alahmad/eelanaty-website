<?php 
    session_start(); // start session

    session_unset(); // reset session

    session_destroy(); // delete session

    header('Location:login.php');
?>
