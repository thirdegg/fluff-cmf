<?php function NewGroupView() {    
    if ($_SERVER["REQUEST_METHOD"]=="POST") {
        $group = new Group();
        $group->setName($_POST["name"]);

        $priv = 0;
        if (isset($_POST["editgroups"]) && $_POST["editgroups"]=="on")      $priv |= 0b0000001;
        if (isset($_POST["editusers"]) && $_POST["editusers"]=="on")        $priv |= 0b0000010;
        if (isset($_POST["edittemplates"]) && $_POST["edittemplates"]=="on") $priv |= 0b0000100;
        if (isset($_POST["editobjects"]) && $_POST["editobjects"]=="on")    $priv |= 0b0001000;
        if (isset($_POST["editpages"]) && $_POST["editpages"]=="on")        $priv |= 0b0010000;
        if (isset($_POST["editfiles"]) && $_POST["editfiles"]=="on")        $priv |= 0b0100000;
        if (isset($_POST["editoptions"]) && $_POST["editoptions"]=="on")    $priv |= 0b1000000;

        $group->setPrivileges($priv);
        $group->save();

        echo "<h1>Готово</h1>";
        return;
    }
    
    ?>
<form action="?page=newgroup" method="post" id="add-group">
    <div class="title">
        <h1>Добавить группу</h1>
    </div>
    <div class="menu-buttons">
        <button class="button">
            Сохранить
            <i class="fa fa-save" aria-hidden="true"></i>
        </button>
    </div>
    <hr>
    <div>
        <div class="group-param">
            <label>Название группы: </label>
            <input type="text" required="required" placeholder="Название группы" name="name" value="<?php echo isset($_POST["name"])?$_POST["name"]:""?>"><br/>
        </div>
        <hr>
        <div class="group-param">
            <label>Редактирование групп: </label>
            <input type="checkbox" name="editgroups"><br/>
        </div>
        <div class="group-param">
            <label>Редактирование пользователей: </label>
            <input type="checkbox" name="editusers"><br/>
        </div>
        <div class="group-param">
            <label>Редактирование шаблонов: </label>
            <input type="checkbox" name="edittemplates"><br/>
        </div>
        <div class="group-param">
            <label>Редактирование объектов: </label>
            <input type="checkbox" name="editobjects"><br/>
        </div>
        <div class="group-param">
            <label>Редактирование страниц: </label>
            <input type="checkbox" name="editpages"><br/>
        </div>
        <div class="group-param">
            <label>Редактирование файлов: </label>
            <input type="checkbox" name="editfiles"><br/>
        </div>
        <div class="group-param">
            <label>Редактирование опций: </label>
            <input type="checkbox" name="editoptions"><br/>
        </div>
        <br/>

    </div>
</form>

<?php }?>