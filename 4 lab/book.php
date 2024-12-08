<section id=catalog>
    <?php include("aside.php"); ?>
    <article>
    <?php 
        $current_page = $_GET['page'];

        $current_page.='.php';
        $result = mysqli_query($db, "SELECT * FROM `text` WHERE text.URL = '$current_page' ORDER BY abstract_id") or die("Ошибка " . mysqli_error($link));
        $row = mysqli_fetch_array($result);

        $result_picture = mysqli_query($db, "SELECT * FROM `picture` WHERE picture.URL = '$current_page'") or die("Ошибка " . mysqli_error($link));
        $row = mysqli_fetch_array($result_picture);
    foreach ($result as $row)
        {
            if ($row['text_class'] == 1)
                {    ?>
                    <div class='title'> 
                    <?php echo  $row['abstract']; ?> </div> <?php
                }
        }
        foreach ($result_picture as $pic)
        {   
            ?>
            <img src=" <?php echo $pic['picture_path'] ?>" alt=" <?php $pic['picture_name']?>"> <?php
        }
        foreach ($result as $row)
        {
            if ($row['text_class'] == 2)
                {    ?>
                    <div class='main_text'> 
                    <?php echo  $row['abstract']; ?> </div> <?php
                }
        }
       ?>
        
    </article>
</section>