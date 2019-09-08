<script id="object-item" type="text/x-jquery-tmpl">
     <tr>
     {{each(i,field) template.fields}}
        {{if (field.isArray)}}
            {{if (field.type=="ObjectField")}}
                <td>
                    {{each(j,item) sobject.data[field.name]}}
                        <a href="javascript:void(0)" target="popup" onclick="$.popupResult(window,'${sobject.id}')"><i class="fa fa-file"></i></a><br/>
                    {{/each}}
                </td>
            {{else (field.type=="FileField")}}
                <td>
                    {{each(j,item) sobject.data[field.name]}}
                        {{if (field.params=="images")}}
                            <a href="<?=SITE_URL."/"?>${item}" class="image-file"><i class="fa fa-image"></i></a>
                        {{else}}
                            <a href="<?=SITE_URL."/"?>${item}"><i class="fa fa-file"></i></a>
                        {{/if}}
                    {{/each}}
                </td>
            {{else}}
                <td>
                    {{each(j,item) sobject.data[field.name]}}
                        <a href="?page=editobject&template=${stemplate.name}&object=${item}">${item}</a>
                        <td><a href="javascript:void(0)" target="popup" onclick="$.popupResult(window,'${sobject.id}')">${item}</a></td>
                    {{/each}}
                </td>
            {{/if}}
        {{else}}
            {{if (field.type=="ObjectField")}}
                <td>
                    {{if (sobject.data[field.name]!="")}}
                        <a href="javascript:void(0)" target="popup" onclick="$.popupResult(window,'${sobject.id}')"><i class="fa fa-file"></i></a>
                    {{/if}}
                </td>
            {{else (field.type=="FileField")}}
                {{if (field.params=="images")}}
                    <td>
                        <a href="<?=SITE_URL."/"?>${sobject.data[field.name]}" class="image-file">
                            <img src="<?=SITE_URL."/"?>${sobject.data[field.name]}" width="40" height="40"/>
                        </a>
                    </td>
                {{else}}
                <td>
                    {{if (sobject.data[field.name]!="")}}
                        <a href="<?=SITE_URL."/"?>${sobject.data[field.name]}"><i class="fa fa-file"></i></a>
                    {{/if}}
                </td>
                {{/if}}
            {{else}}
                <td><a href="javascript:void(0)" target="popup" onclick="$.popupResult(window,'${sobject.id}')">${sobject.data[field.name]}</a></td>
            {{/if}}
        {{/if}}
    {{/each}}
    </tr>
</script>
