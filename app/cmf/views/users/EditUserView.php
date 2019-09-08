<?php function EditUserView() {

    if (!isset($_GET["user"])) return;

    $user = User::getById($_GET["user"]);

    if ($_SERVER["REQUEST_METHOD"]=="POST") {
        $user = User::getById($_POST["id"]);
        $user->setLogin($_POST["login"]);
        $user->setUsername($_POST["username"]);
        $user->setEmail($_POST["email"]);
        $user->setGroup($_POST["group"]);
        if (isset($_POST["oldpass"]) && isset($_POST["newpass"]) && $_POST["oldpass"]!="" && $_POST["newpass"]!="") {
            try {
                $user->newPassword($_POST["oldpass"], $_POST["newpass"]);
            } catch (Exception $e) {
                echo $e->getMessage();
                echo "<h1>Неверный пароль</h1>";
            }
        }
        $user->save($_POST["newpass"]);
        echo "<h1>Готово</h1>";
    }
    
    ?>
    <form id="edit-user" method="post" action="?page=edituser&user=<?=$user->getId()?>">
        <div class="title">
            <h1>Редактировать пользователя</h1>
        </div>
        <div class="menu-buttons">
            <button class="button">
                Сохранить
                <i class="fa fa-save" aria-hidden="true"></i>
            </button>
        </div>
        <hr>
        <div class="user-params">
            <input type="hidden" name="id" value="<?=$user->getId()?>">
            <div class="params-field">
                <label>Логин пользователя:</label>
                <input type="text" required="required" placeholder="Логин пользователя" name="login" value="<?=$user->getLogin()?>">
            </div>
            <div class="params-field">
                <label>Пароль пользователя:</label>
                <input type="password" required="required" placeholder="Старый пароль" name="oldpass" value="">
                <input type="password" required="required" placeholder="Новый пароль" name="newpass" value="">
            </div>
            <div class="params-field">
                <label>Имя пользователя:</label>
                <input type="text" required="required" placeholder="Отображаемое имя пользователя" name="username" value="<?=$user->getUsername()?>">
            </div>
            <div class="params-field">
                <label>Email пользователя:</label>
                <input type="text" required="required" placeholder="Email пользователя" name="email" value="<?=$user->getEmail()?>">
            </div>
            <div class="params-field">
            <label>Группа пользователя:</label>
            <select name="group">
                <?php foreach (Group::getGroupsList() as $group) {?>
                    <option <?php echo ($user->getGroup()->getId()==$group->getId())?"selected":""?> value="<?=$group->getId()?>"><?=$group->getName()?></option>
                <?php }?>
            </select>
        </div>
        </div>
    </form>
<?php }?>