<?php 
    $active = 'users';
    include 'Includes/Components/header.php';
    if(!isset($_GET['page'])){
        echo "<script>window.open(document.URL + '?page=1','_self');</script>";
    }
 ?>
    <!-- Users Box Started -->
    <div class="users" id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <?php 
                    include 'Includes/Components/sidebar.php'; 
                ?>
                <div class="col-md-9">
                    <div class="all-users">
                        <h4>كل المعلنين</h4>
                        <div class="content">
                            <div class="row">
                                <?php
                                    /*
                                        This code for get users by search
                                        if we have post data of search then get users by search
                                        else then get all users
                                    */
                                    $page = 12;
                                    if(isset($_GET['result'])){
                                        $found = true;
                                        $id = $_GET['result'];
                                        getUsersAdsBySearch($page,$found,$id);
                                    }
                                    else{
                                        getUsers($page);
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="pagintation">
                        <?php 
                            if(!isset($_GET['result'])){
                                $id = null;
                                $found = null;
                            }
                            pagantition($page,$found,$id); 
                        ?>
                    </div>
                    </div>
            </div>
        </div>
    </div>
    <!-- Users Box Finished -->
<?php include 'Includes/Components/footer.php'; ?>
<script src="Layout/Js/show-hide-category.js"></script>
</body>
</html>