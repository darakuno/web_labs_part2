<aside>
    <div class="title">Список романов Мосян Тунсю:</div>
    <ol>
    <?php $result = mysqli_query($db, "SELECT * FROM `page` WHERE menu_item = 'Каталог' AND menu_item NOT LIKE page_name ORDER BY URL;") or die("Ошибка " . mysqli_error($db));
			foreach ($result as $row){
				$tmp = $row['page_name'];
				$path = "index.php?page=";
                $path .= substr($row['URL'], 0, 4); ?>
				<a href = "<?php echo $path ?>"><li> <?php echo $row['page_name'] ?> </li></a>
				<?php
			} ?>
    </ol>
    </div>
</aside>