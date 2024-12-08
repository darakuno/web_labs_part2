<?php 
$current_page = $_GET['page'];

$current_page.='.php';
$result = mysqli_query($db, "SELECT card.URL, card.abstract AS title, card.date, t2.abstract AS news_text, card.picture_path  FROM(SELECT card_table.URL, card_table.id_card, card_table.abstract, t_date.abstract AS date, card_table.picture_path
FROM (SELECT Text.URL, Text.id_card, picture.picture_path, Text.abstract  FROM Text
      CROSS JOIN site_db.picture ON picture.URL = Text.URL AND picture.picture_name = Text.abstract
           WHERE Text.URL = 'news.php'
           GROUP BY Text.id_card
           ORDER BY Text.id_card) AS card_table
      JOIN Text t_date ON t_date.id_card = card_table.id_card
           WHERE t_date.abstract <> card_table.abstract
      GROUP BY card_table.id_card) AS card
JOIN Text t2 ON card.id_card= t2.id_card
WHERE card.abstract <> t2.abstract AND t2.abstract <> card.date;") or die("Ошибка " . mysqli_error($link));
$row = mysqli_fetch_array($result);
?>

    <?php foreach ($result as $card)
    {   ?>
        <div class="card">
        <div class="news_title"> <?php echo  $card['title']; ?> </div>
        <div class="news_date"> <?php echo  $card['date']; ?> </div>
        <img src="<?php echo $card['picture_path'] ?>" alt="<?php echo $card['title'] ?>" class="fakeimg">
        <p> <?php echo $card['news_text'] ?> </p>
        </div>
        <?php
    }
    ?>

 
