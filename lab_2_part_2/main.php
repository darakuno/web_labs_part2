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
    <div class="timer_and_button">
        <div id="timer">
            <script  defer src="js/timer.js"></script>
        </div>
        <button class="celebration_button">Праздник фонарей</button>
        <div class="modal">
            <div class="modal_content">
                <span class="close_modal_window">×</span>
                <p>В 15-й день 1-го месяца по лунному календарю в Китае отмечают праздник фонарей, знаменующий собой окончание праздника Весны или традиционного Нового года.</p>
            </div>
        </div>
    </div>
        
        <script language="JavaScript">
            var button = document.getElementsByClassName("celebration_button")[0];
            var modal =document.getElementsByClassName("modal")[0];
            var span = document.getElementsByClassName("close_modal_window")[0];

            button.onclick = function ()
            {
                modal.style.display = "block";
            }

            span.onclick = function () 
            {
				modal.style.display = "none";
			}
            
            window.onclick = function(event)
            {
                if (event.target == modal)
                {
                    modal.style.display = "none";
                }
            }

        </script>

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
    