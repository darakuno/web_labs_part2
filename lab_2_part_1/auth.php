<?php
/* Администратор - может редактировать, добавлять и удалять книги
   Редактор - может редактировать
   Неавт  */

   $act = $_GET['act'];
   if ($act == 'signin') {
        $login = trim($_POST['login']);
        $password = trim($_POST['password']);
        
        if (empty($login) || empty($password)) 
        {
            ?> <div class="title"> <?php echo "Вы заполнили не все поля"; ?> </div> <?php
        }
        else
        {
            $query = "SELECT login, password from User WHERE login = '$login' ";
            $result_vhod = mysqli_query($db, $query) or die("Ошибка " . mysqli_error($db));
		    $user = mysqli_fetch_array($result_vhod);
            
            if (!$user)
            {
                ?> <div class="title"> <?php echo "Аккаунт не зарегистрирован"; ?> </div> <?php
            }
            else if (!(password_verify($password, $user["password"])))
            {
                ?> <div class="title"> <?php echo "Неверный пароль"; ?> </div> <?php
            }
            else
            {
                $_SESSION['user_login'] = $user['login'];
                ?> <div class="title"> <?php echo "Добро пожаловать, ", $_SESSION['user_login']; ?> </div> 
                <div class="main_text"> <a href="index.php?page=auth&act=exit">Выйти из аккаунта</a> </div>
	            <div class="main_text"> <a href="index.php?page=auth&act=del">Удалить аккаунт</a> </div> <?php
            }
        }
   }
   else if ($act == 'registr')
   {
        $login = trim($_POST['login']);
        $password1 = trim($_POST['password1']);
        $password2 = trim($_POST['password2']);
        $user_type_name = $_POST['user_type'];

        if (empty($login) || empty($password1) || empty($password2) || empty($user_type_name)) 
        {
            ?> <div class="title"> <?php echo $login, "   ", $password1,"   ", $password2,"   ",  $user_type_name,"   ",  "Вы заполнили не все поля"; ?> </div> <?php
        }
        else if ($password1 != $password2)
        {
            ?> <div class="title"> <?php echo "Пароли не совпадают"; ?> </div> <?php
        }
        else
        {
            $query = "SELECT * FROM User WHERE login='$login';";
            $result = mysqli_query($db, $query) or die("Ошибка: " . mysqli_error($db));
            
            if (mysqli_num_rows($result) > 0)
            {
                ?> <div class="title"> <?php echo "Аккаунт с таким логином уже существует"; ?> </div> <?php
            }
            else
            {
                $query = "SELECT * FROM User_type WHERE user_type_name = '$user_type_name';";
                $result = mysqli_query($db, $query) or die("Ошибка: " . mysqli_error($db));
                $user_type = mysqli_fetch_array($result);
                $user_type_id = $user_type['user_type_id'];
                $password = password_hash($password1, PASSWORD_DEFAULT);
                $query = "INSERT INTO User VALUES ('$login', '$password', '$user_type_id');";
                $result = mysqli_query($db, $query) or die("Ошибка: " . mysqli_error($db));
                ?> <div class="title"> <?php echo "Вы зарегистрированы"; ?> </div> <?php
            }
        }
    }
    else if ($act == 'exit')
    {
        $_SESSION = [];
	    if(isset ($_COOKIE [session_name()])) 
        {
		    setcookie(session_name(), '', time()-3600, '/');
	    }
        session_destroy();
        ?>
        <script language="JavaScript"> 
            window.location = "index.php?page=signin";
        </script> <?php
    }
    else if ($act == 'del')
    {
       $user_login = $_SESSION['user_login'];
       $_SESSION = [];
       session_destroy();
       $query = "DELETE FROM User WHERE User.login = '$user_login';";
       $result = mysqli_query($db, $query) or die("Ошибка1 " . mysqli_error($db));
       ?> <div class="title"> <?php echo "Аккаунт удален"; ?> </div> <?php
    }


    