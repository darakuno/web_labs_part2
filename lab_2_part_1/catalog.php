<section id="catalog">
    <?php include("aside.php");
    $current_page = $_GET['page'];

    $current_page.='.php';
    $result = mysqli_query($db, "SELECT * FROM `text` WHERE text.URL = '$current_page' ORDER BY abstract_id") or die("Ошибка " . mysqli_error($link));
    $row = mysqli_fetch_array($result); 

    ?>
    <div class='title'> 
    <?php echo  $row['abstract']; ?> </div> <?php
    ?>
</section>
