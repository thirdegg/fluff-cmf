<?php 


function EditObjectView() {



    if (isset($_GET["template"]) && isset($_GET["object"])) {
        $template = Template::getByName($_GET["template"]);
        $object = FluffObject::getById($template->getId(),$_GET["object"]);
        
        if ($_SERVER["REQUEST_METHOD"]=="POST") {
            try {
                foreach ($template->getFields() as $field) {
                    if ($field->getType() == "BooleanField") {
                        if (isset($_POST[$field->getName()])) {
                            $object[$field->getName()] = "true";
                            continue;
                        } else {
                            $object[$field->getName()] = "false";
                            continue;
                        }
                    }

                    if (isset($_POST[$field->getName()])) {
                        $object[$field->getName()] = $_POST[$field->getName()];
                    } else {
                        if ($field->isArray()) {
                            $object[$field->getName()] = array();
                        } else {
                            $object[$field->getName()] = "";
                        }
                    }
                }
                $object->save();
                echo '<h2>Готово</h2><br/><a href="?page=objects&template='.$_GET["template"].'">Вернуться к списку</a>';
                return;
            } catch (Exception $e) {
                echo '<h2>Ошибка $e</h2>';
            }
        }
    } else {
        return;
    }
    
?>
<form id="edit-object-form" action="?page=editobject&template=<?=$template->getName()?>&object=<?=$object->getId()?>" method="post">
    <div>
        <div class="title">
            <h1><a href="?page=objectslist">Обьекты</a> > <a href="?page=objects&template=<?=$template->getName()?>"><?=$template->getName()?></a> > Редактировать "<?=$template->getName()?>"</h1>
        </div>
        <div class="menu-buttons">
            <button>
                Сохранить
                <i class="fa fa-save" aria-hidden="true"></i>
            </button>
            <a href="?page=removeobject&object=<?=$object->getId()?>&template=<?=$template->getName()?>" class="button">
                Удалить
                <i class="fa fa-remove" aria-hidden="true"></i>
            </a>
        </div>
    </div>
    <hr>
    <div id="object-fields">
        <input type="hidden" name="template" value="<?=$template->getName()?>">
        <?php foreach ($template->getFields() as $field) {?>
            <div class="object-field">
                <label><?=$field->getName()?> :</label>
                <div class="object-field-value" id="field-<?=$field->getId()?>"></div>
            </div>
        <?php }?>
    </div>
    <hr>
    <?php require_once("views/objects/ObjectFields.php");?>
    <script>
        var fields = <?=$template->getFieldsJson()?>;
        var object = <?=$object->toJson()?>;

        $("#object-fields").on("click",".array-remove-value",function () {
            $(this).parent().remove();
        });

        $(document).ready(function () {
            fields.forEach(function (field) {
                if (!field.isArray) {
                    $('#object-field').tmpl({"field": field, "object": object.data[field.name]}).appendTo('#field-'+field.id);
                } else {
                    $('#object-field-array').tmpl({"field": field}).appendTo('#field-'+field.id);

                    if (Array.isArray(object.data[field.name])) {
                        object.data[field.name].forEach(function (item) {
                            $('#object-field').tmpl({"field": field, "object": item}).appendTo('#field-' + field.id);
                        });
                    }

                    $("#add-item-array-"+field.id).click(function () {
                        $('#object-field').tmpl({"field": field, "object": null}).appendTo('#field-'+field.id);
                    });

                }
            });
            $("input[data-readonly]").on('keydown paste', function(e){
                e.preventDefault();
            });
        });
    </script>
</form>
<?php } ?>
