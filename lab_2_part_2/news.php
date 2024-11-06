<?php 
$current_page = $_GET['page'];
$current_page.='.php';

$total_result = mysqli_query($db,"SELECT COUNT(*) as total 
FROM (SELECT DISTINCT id_card FROM Text WHERE URL = 'news.php') 
AS total_table;") or die("Ошибка " . mysqli_error($link));
$total_row = mysqli_fetch_assoc($total_result);
$total_news = $total_row['total'];
?>

<div id="news-container"></div>

<script>
let offset = 0; 
let total_news = <?php echo $total_news ?>;
let isLoading = false; // Флаг загрузки

function loadMoreNews() {
    if (offset >= total_news || isLoading) {
        console.log('Больше новостей нет или идет загрузка.');
        return; 
    }

    isLoading = true; // Устанавливаем флаг загрузки

    fetch('get_info.php?offset=' + offset)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log("offset = " + offset);
            console.log(data);
            if (data.length > 0) {
                const newsContainer = document.getElementById('news-container');
                const card = data[0]; // Загружаем только первую новость

                const cardElement = document.createElement('div');
                cardElement.className = 'card';
                const titleElement = document.createElement('div');
                titleElement.className = 'news_title';
                titleElement.textContent = card.title;
                const dateElement = document.createElement('div');
                dateElement.className = 'news_date';
                dateElement.textContent = card.date;
                const imgElement = document.createElement('img');
                imgElement.src = card.picture_path;
                imgElement.alt = card.title;
                const textElement = document.createElement('p');
                textElement.textContent = card.news_text;
                cardElement.appendChild(titleElement);
                cardElement.appendChild(dateElement);
                cardElement.appendChild(imgElement);
                cardElement.appendChild(textElement);
                newsContainer.appendChild(cardElement);
                
                offset += 1; // Увеличиваем offset только после успешной загрузки
            } else {
                window.removeEventListener('scroll', handleScroll);
                console.log('Больше новостей нет.');
            }
        })
        .catch(error => {
            console.error('There has been a problem with your fetch operation:', error);
        })
        .finally(() => {
            isLoading = false; // Сбрасываем флаг загрузки после завершения
        });
}

function handleScroll() {
    const newsContainer = document.getElementById('news-container');
    const lastCard = newsContainer.lastElementChild;

    if (lastCard) {
        const lastCardOffset = lastCard.getBoundingClientRect().bottom;
        const pageOffset = window.innerHeight;

        // Проверяем, виден ли последний элемент
        if (lastCardOffset < pageOffset) {
            loadMoreNews();
        }
    }
}

window.addEventListener('scroll', handleScroll);
loadMoreNews();


</script>



 
