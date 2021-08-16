<?php 
    session_start(); // start session
    include "Admin/Includes/Components/connection.php";
    if(!isset($_GET['open_chat'])){
        $user_email = "";
        if(isset($_COOKIE['user_login'])){
            $user_email = $_COOKIE['user_login'];
        }
        else if(isset($_SESSION['user_email'])){
            $user_email = $_SESSION['user_email'];
        }
        try{
            $query = $con->prepare("SELECT user_id FROM users where user_email = '$user_email'");
            $query->execute();
            $result = $query->fetch(PDO::FETCH_ASSOC);
            $user1_id = $result['user_id'];
            $query = $con->prepare("SELECT * FROM chat_session where user1_id = '$user1_id'");
            $query->execute();
            if($query->rowCount() > 0){
                $query = "DELETE FROM chat_session where user1_id = '$user1_id'";
                $con->exec($query);
                $query = "ALTER TABLE chat_session AUTO_INCREMENT = 1";
                $con->exec($query);
            }
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }
    }
    

    session_unset(); // reset session

    session_destroy(); // delete session

    unset($_COOKIE['user_login']); // reset cookie
    setcookie('user_login', null, -1, '/'); 
?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="google-signin-client_id" content="711355041326-4l6igginacg4n2lik1kuigp7ap7d4b9o.apps.googleusercontent.com">
    </head>
    <body>
        <script src="https://apis.google.com/js/platform.js?onload=onLoadCallback" async defer></script>
        <script>
            // this script for logout from google api
            window.onLoadCallback = function(){
                gapi.load('auth2',function(){
                    gapi.auth2.init().then(function(){
                        var auth2 = gapi.auth2.getAuthInstance();
                            auth2.signOut().then(function () {
                                window.open('index.php','_self');
                        });
                    });
                });
            };
        </script>
    </body>

</html>
