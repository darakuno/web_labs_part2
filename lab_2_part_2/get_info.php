<?php
require_once './lab_2_part_2/include/db.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Устанавливаем кодировку
header('Content-Type: application/json; charset=utf-8');

mysqli_set_charset($db, 'utf8');

$offset = (int)$_GET['offset'];
$news_amount = 1;

$result = mysqli_query($db, "
    SELECT card.URL, card.abstract AS title, card.date, t2.abstract AS news_text, card.picture_path  
    FROM (
        SELECT card_table.URL, card_table.id_card, card_table.abstract, t_date.abstract AS date, card_table.picture_path
        FROM (
            SELECT Text.URL, Text.id_card, picture.picture_path, Text.abstract  
            FROM Text
            CROSS JOIN site_db.picture ON picture.URL = Text.URL AND picture.picture_name = Text.abstract
            WHERE Text.URL = 'news.php'
            GROUP BY Text.id_card
            ORDER BY Text.id_card
        ) AS card_table
        JOIN Text t_date ON t_date.id_card = card_table.id_card
        WHERE t_date.abstract <> card_table.abstract
        GROUP BY card_table.id_card
    ) AS card
    JOIN Text t2 ON card.id_card= t2.id_card
    WHERE card.abstract <> t2.abstract AND t2.abstract <> card.date
    LIMIT $news_amount OFFSET $offset;") or die("Ошибка " . mysqli_error($db));


$news = [];
while ($row = mysqli_fetch_assoc($result)) {
    $news[] = array(
        "url" => $row['URL'],
        "title" => $row['title'],
        "date" => $row['date'],
        "news_text" => $row['news_text'],
        "picture_path" => $row['picture_path']
    );
}

echo json_encode($news, JSON_UNESCAPED_UNICODE);



