<?php function NewUserView() {
    if ($_SERVER["REQUEST_METHOD"]=="POST") {
        $user = new User();
        $user->setLogin($_POST["login"]);
        $user->setUsername($_POST["username"]);
        $user->setEmail($_POST["email"]);
        $user->setGroup($_POST["group"]);
        $user->save($_POST["newpass"]);
        echo "<h1>Готово</h1>";
        return;
    }
    ?>
    <form id="add-user" method="post" action="?page=newuser">
        <div class="title">
            <h1>Добавить пользователя</h1>
        </div>
        <div class="menu-buttons">
            <button class="button">
                Сохранить
                <i class="fa fa-save" aria-hidden="true"></i>
            </button>
        </div>
        <hr>
        <div class="user-params">
            <div class="params-field">
                <label>Логин пользователя:</label>
                <input type="text" required="required" placeholder="Логин пользователя" name="login" value="">
            </div>
            <div class="params-field">
                <label>Пароль пользователя:</label>
                <input type="password" required="required" placeholder="Новый пароль" name="newpass" value="">
            </div>
            <div class="params-field">
                <label>Имя пользователя:</label>
                <input type="text" required="required" placeholder="Отображаемое имя пользователя" name="username" value="">
            </div>
            <div class="params-field">
                <label>Email пользователя:</label>
                <input type="text" required="required" placeholder="Email пользователя" name="email" value="">
            </div>
            <div class="params-field">
                <label>Группа пользователя:</label>
                <select name="group">
                    <?php foreach (Group::getGroupsList() as $group) {?>
                        <option value="<?=$group->getId()?>"><?=$group->getName()?></option>
                    <?php }?>
                </select>
            </div>
        </div>
    </form>
<?php }?>