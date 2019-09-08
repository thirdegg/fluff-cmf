<script id="object-field" type="text/x-jquery-tmpl">
    <div class="value-item">
    {{if (field.type=="BooleanField")}}
        <input class="checkbox" type="checkbox" name="${field.name}" {{if (object!=null && object=="true")}}checked{{/if}} />
    {{else field.type=="IntegerField"}}
        <input type="number" name="${field.name}{{if (field.isArray)}}[]{{/if}}" value="{{if (object!=null)}}${object}{{/if}}" {{if (!field.isNullable)}}required{{/if}} />
    {{else field.type=="RealField"}}
        <input type="number" name="${field.name}{{if (field.isArray)}}[]{{/if}}" value="{{if (object!=null)}}${object}{{/if}}" {{if (!field.isNullable)}}required{{/if}} />
    {{else field.type=="StringField"}}
        <input type="text" name="${field.name}{{if (field.isArray)}}[]{{/if}}" value="{{if (object!=null)}}${object}{{/if}}" {{if (!field.isNullable)}}required{{/if}} />
    {{else field.type=="TextareaField"}}
        <textarea name="${field.name}{{if (field.isArray)}}[]{{/if}}" {{if (!field.isNullable)}}required{{/if}} >{{if (object!=null)}}${object}{{/if}}</textarea>
    {{else field.type=="EnumField"}}
        <select name="${field.name}">
            <option disabled {{if (object==null)}}selected{{/if}}></option>
            {{each field.params}}
                <option {{if (object!=null && object==this)}}selected{{/if}} value="${this}">${this}</option>
            {{/each}}
        </select>
    {{else field.type=="SetField"}}
        <select multiple name="${field.name}[]">
            <option disabled {{if (object==null)}}selected{{/if}}></option>
            {{each(i,pitem) field.params}}
                ${($data.sel = false),''}
                {{each(j,oitem) object}}
                    {{if (oitem!=null && oitem==pitem)}}${($data.sel = true),''}{{/if}}
                {{/each}}
                <option {{if (sel)}}selected{{/if}} value="${pitem}">${pitem}</option>
            {{/each}}
        </select>
    {{else field.type=="FileField"}}
        <a href="javascript:void(0)" class="button" target="popup" onclick="var input = $(this).parent().find('.file-input'); $.popup('?page=filespopup&filter=${field.params}','name',function(data) {input.val(data);});">
            Выбрать файл
            <i class="fa fa-edit" aria-hidden="true"></i>
        </a>
        <input class="file-input" name="${field.name}{{if (field.isArray)}}[]{{/if}}" type="text" value="{{if (object!=null)}}${object}{{/if}}" {{if (!field.isNullable)}}required{{/if}} tabindex="-1" data-readonly/>
    {{else field.type=="ObjectField"}}
        <a href="javascript:void(0)" class="button" target="popup" onclick="var input = $(this).parent().find('.obj-input'); $.popup('?page=objectspopup&template=${field.object}','name',function(data) {input.val(data);});">
            Выбрать
            <i class="fa fa-edit" aria-hidden="true"></i>
        </a>
        <input class="obj-input" name="${field.name}{{if (field.isArray)}}[]{{/if}}" type="text" value="{{if (object!=null)}}${object}{{/if}}" {{if (!field.isNullable)}}required{{/if}} tabindex="-1" data-readonly/>
    {{/if}}
    {{if (field.isArray)}}
        <a href="javascript:void(0)" class="array-remove-value">Удалить</a>
    {{/if}}
    </div>
</script>

<script id="object-field-array" type="text/x-jquery-tmpl">
    <a href="javascript:void(0)" class="array-add-value" id="add-item-array-${field.id}">Добавить</a>
</script>