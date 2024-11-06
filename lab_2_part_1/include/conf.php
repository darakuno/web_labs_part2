<?php
    require_once 'db.php';
    $page_list = mysqli_query($db, "SELECT * FROM `page`;") or die("Ошибка " . mysqli_error($db));
    $route = array();
    foreach ($page_list as $page) {
        $page_name = basename($page['URL'], ".php");
        //echo $page['URL'];
        if ($page['menu_item'] == 'Каталог') 
        {
            $route += [ $page_name => 'book.php'];
        }
        else $route += [$page_name => $page['URL']];

    }

    $current_page = isset($_GET['page']) ? $_GET['page'] : '';

    if ($current_page == '') {
        $current_page = 'index';
    }    

    $CURRENT_PAGE = $current_page;
