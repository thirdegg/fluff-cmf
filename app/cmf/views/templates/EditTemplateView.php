<?php function EditTemplateView() {
    
    if (!isset($_GET["template"])) return;
    
    function str($length = 10) {
        $characters = '0123456789abcdef';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    $template = Template::getByName($_GET["template"]);
    
    if ($_SERVER["REQUEST_METHOD"]=="POST") {
        
        if (isset($_POST["nametemplate"])) {
            
            $fields = array();
            
            $template->setName($_POST["nametemplate"]);
            $template->setDescription($_POST["description"]);
            $template->save();
            
            
            if (isset($_POST["fields-ids"]) && is_array($_POST["fields-ids"])) {
                foreach ($_POST["fields-ids"] as $fieldid) {
                    
                    if (isset($_POST["field-id-".$fieldid]) && $_POST["field-id-".$fieldid]==-1) {
                        $type = $_POST["fieldtype-".$fieldid];
                        $field = new $type($template->getId());
                        $field->setName($_POST["fieldname-".$fieldid]);
                        $field->setPosition($_POST["field-position-".$fieldid]);

                        if (method_exists($field,'setIsNullable')) {
                            if (isset($_POST["requred-" . $fieldid]) && $_POST["requred-" . $fieldid] == "on") {
                                $field->setIsNullable(false);
                            } else {
                                $field->setIsNullable(true);
                            }
                        }

                        if (method_exists($field,'setUnique')) {
                            if (isset($_POST["unique-" . $fieldid]) && $_POST["unique-" . $fieldid] == "on") {
                                $field->setUnique(true);
                            } else {
                                $field->setUnique(false);
                            }
                        }

                        if (method_exists($field,'setIsArray')) {
                            if (isset($_POST["massive-" . $fieldid]) && $_POST["massive-" . $fieldid] == "on") {
                                $field->setIsArray(true);
                            } else {
                                $field->setIsArray(false);
                            }
                        }


                        if ($type=="SetField" || $type=="EnumField") {
                            $field->setParams($_POST["dropdown-item-".$fieldid]);
                        } else if ($type=="FileField") {
                            $field->setParams($_POST["filetype-".$fieldid]);
                        } else if ($type=="ObjectField") {
                            $field->setObject($_POST["object-".$fieldid]);
                        }
                        $field->save();
                    } else {

                        $type = $_POST["fieldtype-".$fieldid];
                        $field = TemplateField::getById($_POST["field-id-".$fieldid]);
                        $field->setName($_POST["fieldname-".$fieldid]);
                        $field->setPosition($_POST["field-position-".$fieldid]);

                        if (method_exists($field,'setIsNullable')) {
                            if (isset($_POST["requred-" . $fieldid]) && $_POST["requred-" . $fieldid] == "on") {
                                $field->setIsNullable(false);
                            } else {
                                $field->setIsNullable(true);
                            }
                        }

                        if (method_exists($field,'setUnique')) {
                            if (isset($_POST["unique-" . $fieldid]) && $_POST["unique-" . $fieldid] == "on") {
                                $field->setUnique(true);
                            } else {
                                $field->setUnique(false);
                            }
                        }

                        if (method_exists($field,'setIsArray')) {
                            if (isset($_POST["massive-" . $fieldid]) && $_POST["massive-" . $fieldid] == "on") {
                                $field->setIsArray(true);
                            } else {
                                $field->setIsArray(false);
                            }
                        }

                        if ($type=="SetField" || $type=="EnumField") {
                            $field->setParams($_POST["dropdown-item-".$fieldid]);
                        } else if ($type=="FileField") {
                            $field->setParams($_POST["filetype-".$fieldid]);
                        } else if ($type=="ObjectField") {
                            $field->setObject($_POST["object-".$fieldid]);
                        }


                        $field->save();

                    }
                }
            }
            echo '<h2>Готово</h2><br/><a href="?page=objectslist">Вернуться к списку</a>';
            return;

        }

        return;
    }

    ?>
       <form id="new-template-form" action="?page=edittemplate&template=<?=$_GET['template']?>" method="post">
            <div>
                <h1>Редактировать шаблон</h1>
            </div>
            <div id="template-label">
                <div id="template-name">
                    <div class="horisontal-label-input large">
                        <label>Имя шаблона:</label>
                        <input type="text" name="nametemplate" placeholder="Имя шаблона" autocomplete="off" value="<?=$template->getName()?>" required>
                    </div>
                    <div class="horisontal-label-input mid">
                        <label>Описание:</label>
                        <input type="text" name="description" placeholder="Описание" autocomplete="off" value="<?=$template->getDescription()?>" required>
                    </div>
                    <div id="button-save">
                        <button>
                            Сохранить
                            <i class="fa fa-save" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
                <div class="tabs">
                    <a class="tab-link" href="#" data-block="template-fields">
                        <div class="tab tab-selected">Поля шаблона</div>
                    </a>
                    <a class="tab-link" href="#" data-block="template-rights">
                        <div class="tab">Права</div>
                    </a>
                </div>
                <div class="template-block template-fields">
                    <a class="button" id="add-field" href="#">
                        Добавить поле
                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                    </a>
                </div>
                <div class="template-block template-rights">
                    <a class="button" href="#">
                        Добавить правило
                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                    </a>
                </div>
            </div>
            <div class="template-block template-fields">        
                <div id="field-list">

                </div>
            </div>
            <div class="template-block template-rights">
                <div id="rights-list">

                </div>
            </div>
        </form>
        <script>
            fields = <?=$template->getFieldsJson();?>
        </script>
        <script src="js/template-utils.js"></script>
        <?php require_once("views/templates/TemplateField.php");?>
        
<?php }?>