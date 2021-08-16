<?php   
        include 'Includes/Components/header.php'; 
?>
<div class="condition-terms" id="page-wrapper">
    <div class="container-fluid">
        <div class="content text-right view">
            <?php 
                $query = $con->prepare("SELECT terms_content FROM condition_terms");
                $query->execute();
                $result = $query->fetch(PDO::FETCH_ASSOC);
                echo $result['terms_content'];
            ?>
        </div>
    </div>
</div>
<?php   
        include 'Includes/Components/footer.php'; 
?>