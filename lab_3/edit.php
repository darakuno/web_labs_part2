<section id=catalog>
    <?php include("aside.php"); 
    $current_page = $_GET['act'];
    if ($current_page == 'add') {
    ?>
    <article>
        <div class='title'>Добавление новой книги в каталог</div>
        <form action='index.php?page=edit_trig&act=add' method="post">
            <input class="small_pole" type="text" name="title" placeholder="Название книги" />
            <br>
            <input class="small_pole" type="text" name="picturepath" placeholder="URL картинки" />
            <br>
            <input class="wide_small_pole" type="text" name="url" placeholder="URL страницы (Например, svss.php)" />
            <br>
            <textarea class="big_pole" type="text" name="abstract" placeholder="Текст статьи" ></textarea>
            <br>
            <button class="submittion_button" type="submit" name="button">Сохранить</button>
        </form>
    </article>
    <?php 
    }
    else {
        $current_book = $_GET['book'];
        $current_book_url = $current_book;
        $current_book_url .= ".php";
        $result = mysqli_query($db, "SELECT page_name AS title, picture_path, abstract, Page.URL AS URL FROM `page`
        INNER JOIN `picture` ON page.URL = picture.URL
        INNER JOIN `text` ON text.URL = picture.URL
        WHERE Picture.URL = '$current_book_url' && page_name <> Text.abstract") or die("Ошибка " . mysqli_error($db));
        
		$row = mysqli_fetch_array($result); ?>
        <article>
            <div class='title'>Редактирование статьи</div>
            <form action='index.php?page=edit_trig&act=edit&book=<?php echo $current_book ?>' method="post">
                <input class="wide_small_pole" type="text" name="title" placeholder="Название книги" value="<?php echo $row['title']?>" />
                <br>
                <input class="small_pole" type="text" name="picturepath" placeholder="URL картинки" value="<?php echo $row['picture_path']?>" />
                <br>
                <input class="wide_small_pole" type="text" name="url" placeholder="URL страницы (Например, svss.php)" value="<?php echo $row['URL']?>" />
                <br>
                <textarea class="big_pole" type="text" name="abstract" placeholder="Текст статьи"><?php echo $row['abstract']?></textarea>
                <br>
                <button class="submittion_button" type="submit" name="button">Сохранить</button>
            </form>
        </article>
        <?php
    }
    ?>

</section>
