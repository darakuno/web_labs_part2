<?php if(isset($_SESSION['user_login']) )
    {   ?>
        <div class="title"> Вы вошли как <?php echo $_SESSION['user_login']; ?> </div>
	    <div class="main_text"> <a href="index.php?page=auth&act=exit">Выйти из аккаунта</a> </div>
	    <div class="main_text"> <a href="index.php?page=auth&act=del">Удалить аккаунт</a> </div> <?php
    } 
    else
    {
        ?> 
        <section>
            <form class="login-form" action="index.php?page=auth&act=signin" method="post">
                <br>
                <input class="small_pole" type="text" name="login" placeholder='Введите логин'  />
                <br>
                <input class="small_pole" type="password" name="password" placeholder='Введите пароль' />
                <br>
                <button class="submittion_button" type="submit" name="button">Войти</button>
                <br>
                <div class="form_reg"> Ещё нет аккаунта? <a href="index.php?page=registr">Зарегистрироваться</a></div>
            </form>
        </section>
        <?php
    }
