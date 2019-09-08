<script id="template-field" type="text/x-jquery-tmpl">
    <div class="template-field" id="template-field-${guid}">
        <input type="hidden" name="fields-ids[]" value="${guid}">
        <input type="hidden" class="template-field-name" name="field-id-${guid}" value="{{if (templatefield!=null)}}${templatefield.id}{{else}}-1{{/if}}"/>
        <input type="hidden" class="template-field-position" name="field-position-${guid}"/>
        <div class="field-label">
            <div class="field-name">
                <label>Имя поля</label>
                <input type="text" placeholder="Имя поля" name="fieldname-${guid}" value="{{if (templatefield!=null)}}${templatefield.name}{{/if}}" required/>
            </div>
            <div class="field-type">
                <label>Тип поля</label>
                <select name="fieldtype-${guid}" id="select-type-field-${guid}">
                    <option value="BooleanField" {{if (templatefield!=null && templatefield.type=="BooleanField")}}selected{{/if}}>Флаг</option>
                    <option value="IntegerField" {{if (templatefield!=null && templatefield.type=="IntegerField")}}selected{{/if}}>Число</option>
                    <option value="StringField" {{if (templatefield!=null && templatefield.type=="StringField")}}selected{{/if}}>Строка</option>
                    <option value="TextareaField" {{if (templatefield!=null && templatefield.type=="TextareaField")}}selected{{/if}}>Текстовое поле</option>
                    <option value="SetField" {{if (templatefield!=null && templatefield.type=="SetField")}}selected{{/if}}>Значение из списка</option>
                    <option value="EnumField" {{if (templatefield!=null && templatefield.type=="EnumField")}}selected{{/if}}>Значения из списка</option>
                    <option value="FileField" {{if (templatefield!=null && templatefield.type=="FileField")}}selected{{/if}}>Файл</option>
                    <option value="ObjectField" {{if (templatefield!=null && templatefield.type=="ObjectField")}}selected{{/if}}>Объект</option>
                </select>
            </div>

            <div class="outher-params outher-param-${guid} dropdown-list field-param field-param-dropdown" id="dropdown-list-${guid}">
                <label>Возможные значения</label>
                <a id="list-open-${guid}" class="list-open" href="#"><i class="fa fa-arrow-down" aria-hidden="true"></i></a>
                <a id="list-close-${guid}" class="list-close" style="display:none;" href="#"><i class="fa fa-arrow-up" aria-hidden="true"></i></a>
                <div class="dropdown-input">
                    <input id="dropdown-input-value-${guid}" type="text" placeholder="Значение"/>
                    <a class="add-value" id="dropdown-add-value-${guid}" href="#"><i class="fa fa-plus" aria-hidden="true"></i></a>
                </div>
                <div class="dropdown-values" id="dropdown-values-${guid}">
                    {{if (templatefield!=null && (templatefield.type=="SetField" || templatefield.type=="EnumField") && templatefield.params)}}
                        {{each templatefield.params}}
                            <div class="dropdown-value">
                                <input type="text" value="${this}" name="dropdown-item-${guid}[]" readonly/>
                                <a class="remove-value" href="#"><i class="fa fa-remove" aria-hidden="true"></i></a>
                            </div>
                        {{/each}}
                    {{/if}}
                </div>
            </div>

            <div class="outher-params outher-param-${guid} file-filter field-param field-param-file" id="file-filter-${guid}">
                <label>Тип файла</label>
                <select name="filetype-${guid}">
                    <option {{if (templatefield!=null && templatefield.type=="FileField" && templatefield.params=='all')}}selected{{/if}} value="all">Любой</option>
                    <option {{if (templatefield!=null && templatefield.type=="FileField" && templatefield.params=='images')}}selected{{/if}} value="images">Изображения</option>
                    <option {{if (templatefield!=null && templatefield.type=="FileField" && templatefield.params=='documents')}}selected{{/if}} value="documents">Документы</option>
                    <option {{if (templatefield!=null && templatefield.type=="FileField" && templatefield.params=='archives')}}selected{{/if}} value="archives">Архивы</option>
                </select>
            </div>

            <div class="outher-params outher-param-${guid} object-select field-param field-param-object" id="object-select-${guid}">
                <label>Объект</label>
                <select name="object-${guid}">
                    <?php foreach (Template::getAllTemplates() as $template) {?>
                    <option {{if (templatefield!=null && templatefield.type=="ObjectField" && templatefield.object=='<?=$template->getId()?>')}}selected{{/if}} value="<?=$template->getId()?>"><?=$template->getName()?></option>
                    <?php }?>
                </select>
            </div>

            <a class="remove-template-field" id="remove-template-field-${guid}" href="#"><i class="fa fa-remove" aria-hidden="true"></i></a>
            <a class="up-template-field" id="up-template-field-${guid}" href="#"><i class="fa fa-arrow-up" aria-hidden="true"></i></a>
            <a class="down-template-field" id="down-template-field-${guid}" href="#"><i class="fa fa-arrow-down" aria-hidden="true"></i></a>
        </div>
        <div class="field-settings">
            <div class="setting field-param field-param-object field-param-file field-param-string">
                <input type="checkbox" id="massive-${guid}" name="massive-${guid}" {{if (templatefield!=null && templatefield.isArray)}}checked{{/if}}> Массив
            </div>
            <div class="setting field-param field-param-int field-param-real field-param-string field-param-text field-param-object field-param-file">
                <input type="checkbox" id="requred-${guid}" name="requred-${guid}" {{if (templatefield!=null && !templatefield.isNullable)}}checked{{/if}}> Обязательное поле
            </div>
            <div class="setting field-param field-param-string">
                <input type="checkbox" id="unique-${guid}" name="unique-${guid}" {{if (templatefield!=null && templatefield.isUnique)}}checked{{/if}}> Уникальное поле
            </div>

        </div>
    </div>
</script>

<script id="dropdown-list-item" type="text/x-jquery-tmpl">
    <div class="dropdown-value">
        <input type="text" value="${value}" name="dropdown-item-${guid}[]" readonly/>
        <a class="remove-value" href="#"><i class="fa fa-remove" aria-hidden="true"></i></a>
    </div>      
</script>