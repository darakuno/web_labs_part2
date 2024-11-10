<?php 
$current_page = $_GET['page'];
$current_page .= '.php';
$total_result = mysqli_query($db, "SELECT COUNT(*) as total 
FROM (SELECT DISTINCT id_card FROM Text WHERE URL = 'news.php') AS total_table;") or die("Ошибка " . mysqli_error($link));
$total_row = mysqli_fetch_assoc($total_result);
$total_news = $total_row['total'];
?>
<div id="news-container"></div>
<script>
let offset = 0; 
let total_news = <?php echo $total_news ?>;
let isLoading = false; // Флаг загрузки

function createCardElement(card) {
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

    return cardElement;
}

function loadMoreNewsUsingFetch() {
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
            if (data.length > 0) {
                const newsContainer = document.getElementById('news-container');
                data.forEach(card => {
                    const cardElement = createCardElement(card);
                    newsContainer.appendChild(cardElement);
                });
                offset += data.length; // Увеличиваем offset на количество загруженных новостей
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

function loadMoreNewsUsingXHR() {
    if (offset >= total_news || isLoading) {
        console.log('Больше новостей нет или идет загрузка.');
        return; 
    }

    isLoading = true; // Устанавливаем флаг загрузки
    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'get_info.php?offset=' + offset, true);
    
    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 300) {
            const data = JSON.parse(xhr.responseText);
            if (data.length > 0) {
                const newsContainer = document.getElementById('news-container');
                data.forEach(card => {
                    const cardElement = createCardElement(card);
                    newsContainer.appendChild(cardElement);
                });
                offset += data.length; 
            } else {
                window.removeEventListener('scroll', handleScroll);
                console.log('Больше новостей нет.');
            }
        } else {
            console.error('Ошибка загрузки: ' + xhr.statusText);
        }
        isLoading = false; // Сбрасываем флаг загрузки после завершения
    };

    xhr.onerror = function() {
        console.error('Произошла ошибка при выполнении запроса.');
        isLoading = false; // Сбрасываем флаг загрузки в случае ошибки
    };

    xhr.send();
}

function loadMoreNews() {
    loadMoreNewsUsingFetch(); //loadMoreNewsUsingXHR();//
}

function handleScroll() {
    const newsContainer = document.getElementById('news-container');
    const lastCard = newsContainer.lastElementChild;

    if (lastCard) {
        const lastCardOffset = lastCard.getBoundingClientRect().bottom;
        const pageOffset = window.innerHeight;
        if (lastCardOffset < pageOffset) {
            loadMoreNews();
        }
    }
}

window.addEventListener('scroll', handleScroll);
loadMoreNews();
</script>
