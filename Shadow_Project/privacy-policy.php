<?php   
        include 'Includes/Components/header.php'; 
?>
<div class="privacy-policy" id="page-wrapper">
    <div class="container-fluid">
        <div class="content text-right view">
            <?php 
                $query = $con->prepare("SELECT privacy_content FROM privacy_policy");
                $query->execute();
                $result = $query->fetch(PDO::FETCH_ASSOC);
                echo $result['privacy_content'];
            ?>
        </div>
    </div>
</div>
<?php   
        include 'Includes/Components/footer.php'; 
?>