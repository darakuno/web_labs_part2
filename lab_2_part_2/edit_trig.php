<section id=catalog>
    <?php include("aside.php") ?>
    <article>
        <?php
        $current_page = $_GET['act'];
        require_once 'include/db.php';
        if ($current_page == 'add') {
            $URL = TRIM($_POST['url']);
            $title = trim($_POST['title']);
			$picturepath = trim($_POST['picturepath']);
            $abstract = trim($_POST['abstract']);

            if (empty($URL) || empty($title) || empty($picturepath) || empty($abstract))
            {
             ?> <div class="title"> <?php echo "Вы заполнили не все поля"; ?> </div> <?php
            } 
            else
            {
                $book_path = '../../index.php?page=';
                if ((str_ends_with($URL, '.php')))
                {
                    $tmp =  basename($URL, ".php");
                }
                else
                {
                    $tmp = $URL;
                    $URL .= ".php";
                }
                $book_path .= $tmp;
                $query = "DELETE FROM `page` WHERE page.URL ='$URL';";
				$result_upd = mysqli_query($db, $query) or die("Ошибка1 " . mysqli_error($db));		
                $query = "INSERT INTO `page` VALUES ('$URL','$title','Каталог');";
                $result_upd = mysqli_query($db, $query) or die("Ошибка2 " . mysqli_error($db));
                $query = "INSERT INTO `picture` VALUES (NULL, '$picturepath', '$title', '$URL');";
				$result_upd = mysqli_query($db, $query) or die("Ошибка3 " . mysqli_error($db));
                $query = "INSERT INTO `text` VALUES(NULL,'$title','$URL', 1, NULL);";
				$result_upd = mysqli_query($db, $query) or die("Ошибка4 " . mysqli_error($db));
				$query = "INSERT INTO `text` VALUES(NULL,'$abstract','$URL', 2, NULL);";
				$result_upd = mysqli_query($db, $query) or die("Ошибка4 " . mysqli_error($db));
				echo "Статья успешно добавлена"; ?>	
                <script>
                var path_of_page = '<?php echo $book_path; ?>'
                window.location = path_of_page;
                </script> <?php 
            } 
        }
        else if ($current_page == 'edit') {
            $edit_book = $_GET['book'];
            
            $new_URL = trim($_POST['url']); // новое url
            $title = trim($_POST['title']);
			$picturepath = trim($_POST['picturepath']);
            $abstract = trim($_POST['abstract']);
            
            if (empty($new_URL) || empty($title) || empty($picturepath) || empty($abstract))
            {
             ?> <div class="title"> <?php echo "Вы заполнили не все поля"; ?> </div> <?php
            } 
            else
            {
                if ((str_ends_with($new_URL, '.php')))
                {
                    $tmp2 =  basename($new_URL, ".php");
                }
                else
                {
                    $tmp2 = $new_URL;
                    $new_URL .= '.php';
                }
                $old_URL = $edit_book;
                $old_URL .= ".php";
                $book_path="../../index.php?page=";
                $book_path .= $tmp2;
                $query = "DELETE FROM `picture` WHERE picture.URL ='$old_URL';";
				$result_upd = mysqli_query($db, $query) or die("Ошибка1" . mysqli_error($db));	
                $query = "DELETE FROM `text` WHERE text.URL ='$old_URL';";
				$result_upd = mysqli_query($db, $query) or die("Ошибка2" . mysqli_error($db));
                $query = "DELETE FROM `page` WHERE page.URL ='$old_URL';";
				$result_upd = mysqli_query($db, $query) or die("Ошибка3" . mysqli_error($db));
                $query = "DELETE FROM `page` WHERE page.URL ='$new_URL';";
				$result_upd = mysqli_query($db, $query) or die("Ошибка1 " . mysqli_error($db));			
                $query = "INSERT INTO `page` VALUES ('$new_URL','$title','Каталог');";
                $result_upd = mysqli_query($db, $query) or die("Ошибка4 " . mysqli_error($db));
                $query = "INSERT INTO `picture` VALUES (NULL, '$picturepath', '$title', '$new_URL');";
				$result_upd = mysqli_query($db, $query) or die("Ошибка5 " . mysqli_error($db));
                $query = "INSERT INTO `text` VALUES(NULL,'$title','$new_URL', 1, NULL);";
				$result_upd = mysqli_query($db, $query) or die("Ошибка6 " . mysqli_error($db));
				$query = "INSERT INTO `text` VALUES(NULL,'$abstract','$new_URL', 2, NULL);";
				$result_upd = mysqli_query($db, $query) or die("Ошибка7 " . mysqli_error($db));
				echo "Статья успешно изменена"; ?>	
                <script>
                var path_of_page = '<?php echo $book_path; ?>'
                window.location = path_of_page;
                </script><?php 
            }
        }
        else if ($current_page == 'del') {
            $edit_book = $_GET['book'];
            $URL = $edit_book;
            $URL .= '.php';
            
            $query = "DELETE FROM `picture` WHERE picture.URL ='$URL';";
            $result_upd = mysqli_query($db, $query) or die("Ошибка1" . mysqli_error($db));	
            $query = "DELETE FROM `text` WHERE text.URL ='$URL';";
            $result_upd = mysqli_query($db, $query) or die("Ошибка2" . mysqli_error($db));
            $query = "DELETE FROM `page` WHERE page.URL ='$URL';";
            $result_upd = mysqli_query($db, $query) or die("Ошибка3" . mysqli_error($db));
            
            echo "Статья успешно удалена"; ?>	
            <script>
            window.location = './../index.php?page=catalog';
            </script><?php 
        }

        ?>
    </article>
</section>