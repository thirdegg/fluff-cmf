<?php 

function NewObjectView() {
    
    if (isset($_GET["template"])) {
        $template = Template::getByName($_GET["template"]);
        
        if ($_SERVER["REQUEST_METHOD"]=="POST") {
            $object = new FluffObject($template->getId());
            foreach ($template->getFields() as $field) {
                if ($field->getType()=="BooleanField") {
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
        }
    }
    
?>
<form id="new-object-form" action="?page=newobject&template=<?=$template->getName()?>" method="post">
    <div>
        <div class="title">
            <h1><a href="?page=objectslist">Обьекты</a> > <a href="?page=objects&template=<?=$template->getName()?>"><?=$template->getName()?></a> > Создать "<?=$template->getName()?>"</h1>
        </div>
        <div class="menu-buttons">
            <button>
                Создать
                <i class="fa fa-save" aria-hidden="true"></i>
            </button>
        </div>
    </div>
    <hr>
    <div id="object-fields" class="object-data" style="margin-top: 20px; margin-bottom: 20px;">
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

        $("#object-fields").on("click",".array-remove-value",function () {
            $(this).parent().remove();
        });

        $(document).ready(function () {
            fields.forEach(function (field) {
                if (!field.isArray) {
                    $('#object-field').tmpl({"field": field, "object": null}).appendTo('#field-'+field.id);
                } else {

                    $('#object-field-array').tmpl({"field": field}).appendTo('#field-'+field.id);

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
