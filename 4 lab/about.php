<?php 
$current_page = $_GET['page'];

$current_page.='.php';
$result = mysqli_query($db, "SELECT * FROM `text` WHERE text.URL = '$current_page' ORDER BY abstract_id") or die("Ошибка " . mysqli_error($link));
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
            else if($row['text_class'] == 3)
            {
                ?>
                <a href="https://t.me/n31415629" class="main_text">
                    <?php echo  $row['abstract']; ?> </a> <?php
            }
            else if($row['text_class'] == 4)
            {
                ?>
                <a href="https://vk.com/not_yesterday" class="main_text">
                    <?php echo  $row['abstract']; ?> </a> <?php
            }
        } ?>
</article>