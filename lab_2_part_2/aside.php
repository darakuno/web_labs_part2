<aside>
    <div class="title">Список романов Мосян Тунсю:</div>
    <ol>
    <?php $result = mysqli_query($db, "SELECT * FROM `page` WHERE menu_item = 'Каталог' AND menu_item NOT LIKE page_name ORDER BY URL;") or die("Ошибка " . mysqli_error($db));
			foreach ($result as $row){
				$tmp = $row['page_name'];
				$path = "index.php?page=";
                $path .= basename($row['URL'], ".php"); ?>
				<a href = "<?php echo $path ?>"><li> <?php echo $row['page_name'] ?> </li></a>
				<?php
			} ?>
    </ol>
    <?php
        if ($_SESSION <> [])
        {
            ?> <div class='main_text'> <a href= "index.php?page=edit&act=add" > Добавить книгу </a> </div> <?php
        }
    ?>
    </div>
</aside>

<?php
/*
$login = $_SESSION['user_login'];
$result =  mysqli_query($db, "SELECT * FROM User WHERE login='$login';") or die("Ошибка " . mysqli_error($db));
$user = mysqli_fetch_array($result);
if (($user["user_type_id"] = 1) || ($user["user_type_id"] = 2))
{
    ?> <div class='main_text'> <a href= "index.php?page=edit&act=add" > Добавить книгу </a> </div> <?php
}
*/