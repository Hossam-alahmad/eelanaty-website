<?php 
    // this file for update user status if online or offline
    session_start();
    include "connection.php";
    if(isset($_POST['page'])){
        $per_page = 10;
        $ids = "";
        if($_POST['ids'] != ""){
            $ids = $_POST['ids'];
        }
        if($_POST['page'] != 0){
            $page = $_POST['page'];
        }
        else{
            $page = 1;
        }
        $start = ($page - 1) * $per_page;
        $number = $start;
        try{
            if($ids != ""){
                $query = $con->prepare("SELECT * FROM users where user_id IN ($ids) order by 1 DESC LIMIT $start,$per_page");
                $query->execute();
            }
            else{
                $query = $con->prepare("SELECT * FROM users order by 1 DESC LIMIT $start,$per_page");
                $query->execute();
            }
            while($result = $query->fetch(PDO::FETCH_ASSOC)){
                $user_id        = $result['user_id'];
                $user_name      = $result['username'];
                $user_email     = $result['user_email'];
                $user_gender    = $result['user_gender'];
                $user_location  = $result['user_location'];
                $last_login     = $result['last_login'];
                $account_date     = $result['create_account'];
                $number++;
                $status = "غير متصل";
                $class  = "danger";
                if($last_login > time()){
                    $status = "متصل";
                    $class  = "success";
                }
                $user_status = "حظر";
                if($result['status'] =="panned"){
                    $user_status = "فك الحظر";
                }   
                echo "
                        <tr>
                            <td>$number</td>
                            <td>$user_name</td>
                            <td>$user_email</td>
                            <td>$user_gender</td>
                            <td>$user_location</td>
                            <td>$account_date</td>
                            <td><a><button class='btn btn-$class btn-block'>$status</button></a></td>
                            <td><a href='index.php?view_users&user_id=$user_id'><button type='submit' name='delete' class='btn btn-danger btn-block'>$user_status</button></a></td>
                        </tr>
                ";
            }
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }
    }

?>