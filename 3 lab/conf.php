<?php
    $route = [
        "index" => "index.php",
        "main" => "main.php",
        "catalog" => "catalog.php",
        "about" => "about.php",
        "news" => "news.php",
        "svss" => "books/svss.php",
        "mdzs" => "books/mdzs.php",
        "tgcf" => "books/tgcf.php"
    ];

    $current_page = isset($_GET['page']) ? $_GET['page'] : '';

    if ($current_page == '') {
        $current_page = 'index';
    }    

    $CURRENT_PAGE = $current_page;
?>