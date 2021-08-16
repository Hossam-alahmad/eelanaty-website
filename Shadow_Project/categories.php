<?php
    $active = "categories";
    include 'Includes/Components/header.php'; 
?>
    <!-- categories Box Started -->
    <div class="categories" id="page-wrapper">
        <div class="container-fluid">
            
            <div class="title">
                <h2>أقسام تساعدك على توفير وقتك</h2>
                <p>
                    نوفر لك مجموعة من الاقسام التي تساعدك في توفير وقتك وبحثك عن احتياجاتك ولتساعدك في الوصول الى المعلن بكل سهولة
                </p>
            </div>
            <div class="row">
                <?php getCategory(); ?>
            </div>
        </div>
    </div>
    <!-- categories Box Finished -->
<?php include 'Includes/Components/footer.php'; ?>
</body>
</html>