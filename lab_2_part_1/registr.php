<section>
    <form class="login-form" action="index.php?page=auth&act=registr" method="post">
        <br>
        <input class="small_pole" type="text" name="login" placeholder='Введите логин'  />
        <br>
        <input class="small_pole" type="password" name="password1" placeholder='Введите пароль' />
        <br>
        <input class="small_pole" type="password" name="password2" placeholder='Повторно введите пароль' />
        <br>
        <select class="user_type" name="user_type">
            <option value="Администратор">Администратор</option>
            <option value="Редактор">Редактор</option>
        </select>
        <br>
        <button class="submittion_button" type="submit" name="button">Зарегистрироваться</button>
    </form>
</section>
