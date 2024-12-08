<?php 

$current_page = isset($_GET['page']) ? $_GET['page'] : '';

if ($current_page == '') 
{
    $current_page = 'index';
}

if ($current_page == 'index') 
{
    $current_page = 'main';
}

$current_page.='.php';
$result = mysqli_query($db, "SELECT * FROM `text` WHERE text.URL = '$current_page' ORDER BY abstract_id") or die("Ошибка " . mysqli_error($link));
$row = mysqli_fetch_array($result);

$result_picture = mysqli_query($db, "SELECT * FROM `picture` WHERE picture.URL = '$current_page'") or die("Ошибка " . mysqli_error($link));
$row = mysqli_fetch_array($result); ?>
<article>
        <?php 
        foreach ($result as $row)
        {
            if ($row['text_class'] == 1)
            {    ?>
                <div class='title'> 
                <?php echo  $row['abstract']; ?> </div> <?php
            }
            else if($row['text_class'] == 2)
            {   ?>
                <div class='main_text'>
                <?php echo  $row['abstract']; ?> </div> <?php
            }
            else if($row['text_class'] == 7)
            {
                ?>
                <div class='review'>
                <?php echo  $row['abstract']; ?> </div> <?php
            }
            else if($row['text_class'] == 8)
            {
                ?>
                <div  class='cursive_review'> <i>
                <?php echo  $row['abstract']; ?> </i></div> <?php
            }
            else if($row['text_class'] == 9)
            {
                ?>
                <section class="info_xianxia">
                    <div  class='info_xianxia_text'> <?php echo $row['abstract']; ?></div> 
                    <?php foreach ($result_picture as $pic)
                        {   
                            ?>
                            <img src=" <?php echo $pic['picture_path'] ?>" alt=" <?php $pic['picture_name']?>">
                            <?php
                        }
                        ?>
                </section>
                <?php
            } 
            else if($row['text_class'] == 10)
            {
                ?>
                <a class="main_text" title="Читать подробнее" href="index.php?page=svss"><b><nobr> <?php echo $row['abstract']; ?> </nobr></b></a> <?php
            }
            else if($row['text_class'] == 11)
            {
                ?>
                <a class="main_text" title="Читать подробнее" href="index.php?page=mdzs"><b><nobr> <?php echo $row['abstract']; ?> </nobr></b></a> <?php
            }
            else if($row['text_class'] == 12)
            {
                ?>
                <a class="main_text" title="Читать подробнее" href="index.php?page=tgcf"><b><nobr> <?php echo $row['abstract']; ?> </nobr></b></a> <?php
            }
        } ?>
</article>
    