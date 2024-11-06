<?php 
$current_page = $_GET['page'];
$current_page.='.php';

$total_result = mysqli_query($db,"SELECT COUNT(*) as total 
FROM (SELECT DISTINCT id_card FROM Text WHERE URL = 'news.php') 
AS total_table;") or die("Ошибка " . mysqli_error($link));
$total_row = mysqli_fetch_assoc($total_result);

$news_amount = 3;
$total_news = $total_row['total'];
$total_pages = ceil($total_news / $news_amount);
$current_page = 1;
$offset = ($current_page - 1) * $news_amount;

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

$cards = [];
while ($card = mysqli_fetch_array($result)) {
    $cards[] = $card; 
}

$counter = 0; 
foreach ($cards as $card) {
    if ($counter >= $offset && $counter < $offset + $news_amount) { 
        ?>
        <div class="card card-<?php echo $counter?>">
            <div class="news_title title-<?php echo $counter?>"> <?php echo $card['title']; ?> </div>
            <div class="news_date news_date-<?php echo $counter?>"> <?php echo $card['date']; ?> </div>
            <img class="img-<?php echo $counter?>" src="<?php echo $card['picture_path']; ?>" alt="<?php echo $card['title']; ?>" class="fakeimg">
            <p class="text-<?php echo $counter?>"> <?php echo $card['news_text']; ?> </p>
        </div>
        <?php
    }
    $counter++;
}

$titleArray = json_encode(array_column($cards, 'title'));
$datesArray = json_encode(array_column($cards, 'date'));
$imgArray = json_encode(array_column($cards, 'picture_path'));
$textArray = json_encode(array_column($cards, 'news_text'));
?>

<div class="pagination">
    <a href="#" class="left-arrow" data-page="<?php echo $current_page - 1 == 0 ? $current_page : $current_page -1; ?>" onclick="changePage(<?php echo $current_page - 1 == 0 ? $current_page : $current_page -1; ?>)"> &#8592</a>
    <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
        <a href="#" class="<?php echo ($i == $current_page) ? 'active' : 'non-active'; ?>" data-page="<?php echo $i; ?>" onclick="changePage(<?php echo $i; ?>)"><?php echo $i; ?></a>
    <?php } ?>
    <a href="#" class="right-arrow" data-page="<?php echo $current_page + 1 == $total_pages ? $current_page : $current_page + 1; ?>" onclick="changePage(<?php echo $current_page + 1 == $total_pages ? $current_page : $current_page + 1; ?>)"> &#8594</a>
</div>

<script>
function changePage(page) {
    let offset = <?php echo $offset; ?>;
    let news_amount = <?php echo $news_amount; ?>; 
    let titles = <?php echo $titleArray; ?>;
    let dates = <?php echo $datesArray; ?>;
    let imgs = <?php echo $imgArray; ?>;
    let texts = <?php echo $textArray; ?>;

    for (let i = 0; i <= 2; i++) { 
        let newIndex = (page - 1) * news_amount + i;
    
        let card = document.getElementsByClassName("card-" + i);
        let title_card = document.getElementsByClassName("title-" + i);
        let date_card = document.getElementsByClassName("news_date-" + i);
        let img_card = document.getElementsByClassName("img-" + i);
        let text_card = document.getElementsByClassName("text-" + i);

        if (newIndex < titles.length) {
            let newTitle = titles[newIndex];
            title_card[0].innerText = newTitle;
            title_card[0].style.display = "block";
            card[0].style.display = "block"; 
        } else {
            title_card[0].style.display = "none"; 
            card[0].style.display = "none"; 
        }
        
        if (newIndex < dates.length) {
            let newDate = dates[newIndex];
            date_card[0].innerText = newDate;
            date_card[0].style.display = "block"; 
        }
        else {
            date_card[0].style.display = "none"; 
        }
        
        if (newIndex < texts.length) {
            let newText = texts[newIndex];
            text_card[0].innerText = newText;
            text_card[0].style.display = "block";
        }
        else {
            text_card[0].style.display = "none";
        }
        
        if (newIndex < imgs.length) {
            let newImg = imgs[newIndex];
            img_card[0].src = newImg;
            img_card[0].style.display = "block";
        }
        else {
            img_card[0].style.display = "none";
        }
    }

    let active_number = document.getElementsByClassName("active");
    active_number[0].classList.add("non-active");
    active_number[0].classList.remove("active");

    let non_active_numbers = document.getElementsByClassName("non-active");
    for (let i = 0; i < non_active_numbers.length; i++) {
        if (non_active_numbers[i].dataset.page == page){
            non_active_numbers[i].classList.add("active");
        }
    }

    let left_arrow = document.getElementsByClassName("left-arrow");
    if (page - 1 > 0) {
        left_arrow[0].dataset.page = page - 1;
        left_arrow[0].onclick = function() { changePage(page - 1); };
    }
    let rigth_arrow = document.getElementsByClassName("right-arrow");
    if (page + 1 <= <?php echo $total_pages ?>) {
        rigth_arrow[0].dataset.page = page + 1;
        
        rigth_arrow[0].onclick = function() { changePage(page + 1); };
    } 
}
</script>


 
