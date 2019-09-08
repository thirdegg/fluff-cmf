<?php function EditGroupView() {

    if (!isset($_GET["gid"])) {return;}
    $group = Group::getById($_GET["gid"]);
    if ($group==null) return;


    if ($_SERVER["REQUEST_METHOD"]=="POST") {
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
    }

    ?>
<form action="?page=editgroup&gid=<?=$group->getId()?>" method="post" id="edit-group">
    <div class="title">
        <h1>Редактировать группу</h1>
    </div>
    <div class="menu-buttons">
        <button class="button">
            Сохранить
            <i class="fa fa-save" aria-hidden="true"></i>
        </button>
        <a href="?page=removegroup&gid=<?=$group->getId()?>" class="button">
            Удалить
            <i class="fa fa-save" aria-hidden="true"></i>
        </a>
    </div>
    <hr>
    <div>
        <div class="group-param">
            <label>Название группы: </label>
            <input type="text" required="required" placeholder="Название группы" name="name" value="<?=$group->getName()?>"><br/>
        </div>
        <hr>
        <div class="group-param">
            <label>Редактирование групп: </label>
            <input type="checkbox" name="editgroups" <?php echo ($group->isEditGroups())?"checked":"";?>><br/>
        </div>
        <div class="group-param">
            <label>Редактирование пользователей: </label>
            <input type="checkbox" name="editusers" <?php echo ($group->isEditUsers())?"checked":"";?>><br/>
        </div>
        <div class="group-param">
            <label>Редактирование шаблонов: </label>
            <input type="checkbox" name="edittemplates" <?php echo ($group->isEditTemplates())?"checked":"";?>><br/>
        </div>
        <div class="group-param">
            <label>Редактирование объектов: </label>
            <input type="checkbox" name="editobjects" <?php echo ($group->isEditObject())?"checked":"";?>><br/>
        </div>
        <div class="group-param">
            <label>Редактирование страниц: </label>
            <input type="checkbox" name="editpages" <?php echo ($group->isEditPages())?"checked":"";?>><br/>
        </div>
        <div class="group-param">
            <label>Редактирование файлов: </label>
            <input type="checkbox" name="editfiles" <?php echo ($group->isEditFiles())?"checked":"";?>><br/>
        </div>
        <div class="group-param">
            <label>Редактирование опций: </label>
            <input type="checkbox" name="editoptions" <?php echo ($group->isEditOptions())?"checked":"";?>><br/>
        </div>
        <br/>


    </div>
</form>
<?php }?>