function addTemplateField(guid,templatefield) {
    $('#template-field').tmpl({"guid":guid,"templatefield":templatefield}).appendTo('#field-list');

    var block = $("#template-field-"+guid);
    block.find(".field-param").css('display', 'none');
    var selectedfield = $("#select-type-field-"+guid).val();
    if (selectedfield==="BooleanField") {block.find(".field-param-boolean").css('display', 'inline-block');}
    if (selectedfield==="IntegerField") {block.find(".field-param-int").css('display', 'inline-block');}
    if (selectedfield==="RealField") {block.find(".field-param-real").css('display', 'inline-block');}
    if (selectedfield==="StringField") {block.find(".field-param-string").css('display', 'inline-block');}
    if (selectedfield==="TextareaField") {block.find(".field-param-text").css('display', 'inline-block');}
    if (selectedfield==="SetField") {block.find(".field-param-dropdown").css('display', 'inline-block');}
    if (selectedfield==="EnumField") {block.find(".field-param-dropdown").css('display', 'inline-block');}
    if (selectedfield==="FileField") {block.find(".field-param-file").css('display', 'inline-block');}
    if (selectedfield==="ObjectField") {block.find(".field-param-object").css('display', 'inline-block');}
    if (selectedfield==="FileField") {block.find(".field-param-file").css('display', 'inline-block');}

    $("#remove-template-field-"+guid).click(function(e) {
        e.preventDefault();
        $("#template-field-"+guid).remove();
    });

    $("#dropdown-add-value-"+guid).click(function(e) {
        e.preventDefault();
        if ($("#dropdown-input-value-"+guid).val().length==0) return;
        $('#dropdown-list-item').tmpl({"value":$("#dropdown-input-value-"+guid).val(),"guid":guid}).appendTo("#dropdown-values-"+guid);
        $("#dropdown-input-value-"+guid).val("");
    });

    $("#select-type-field-"+guid).change(function(ee) {
        ee.preventDefault();
        console.log($("#select-type-field-"+guid).val());
        var block = $("#template-field-"+guid);
        block.find(".field-param").css('display', 'none');
        $("#massive-"+guid).prop('checked', false);
        $("#unique-"+guid).prop('checked', false);
        $("#requred-"+guid).prop('checked', false);
        var selectedfield = $("#select-type-field-"+guid).val();
        if (selectedfield==="BooleanField") {block.find(".field-param-boolean").css('display', 'inline-block');}
        if (selectedfield==="IntegerField") {block.find(".field-param-int").css('display', 'inline-block');}
        if (selectedfield==="RealField") {block.find(".field-param-real").css('display', 'inline-block');}
        if (selectedfield==="StringField") {block.find(".field-param-string").css('display', 'inline-block');}
        if (selectedfield==="TextareaField") {block.find(".field-param-text").css('display', 'inline-block');}
        if (selectedfield==="SetField") {block.find(".field-param-dropdown").css('display', 'inline-block');}
        if (selectedfield==="EnumField") {block.find(".field-param-dropdown").css('display', 'inline-block');}
        if (selectedfield==="ObjectField") {block.find(".field-param-object").css('display', 'inline-block');}
        if (selectedfield==="FileField") {block.find(".field-param-file").css('display', 'inline-block');}
    });

    $("#list-open-"+guid).click(function(e) {
        e.preventDefault();

        $(".list-close").css('display', 'none');
        $(".list-open").css('display', 'inline-block');
        $(".dropdown-list").removeClass("visible-list");

        $(this).css('display', 'none');
        $("#list-close-"+guid).css('display', 'inline-block');
        $("#dropdown-list-"+guid).addClass("visible-list");
    });

    $("#list-close-"+guid).click(function(e) {
        e.preventDefault();
        $(this).css('display', 'none');
        $("#list-open-"+guid).css('display', 'inline-block');
        $("#dropdown-list-"+guid).removeClass("visible-list");
    });

    $("#up-template-field-"+guid).click(function(e) {
        e.preventDefault();
        var pdiv = $("#template-field-"+guid);
        pdiv.insertBefore(pdiv.prev());
        $(".template-field").each(function(i,item) {
            $(this).find(".template-field-position").val($(".template-field").index(this));
        });
    });

    $("#down-template-field-"+guid).click(function(e) {
        e.preventDefault();
        var pdiv = $("#template-field-"+guid);
        pdiv.insertAfter(pdiv.next());
        $(".template-field").each(function(i,item) {
            $(this).find(".template-field-position").val($(".template-field").index(this));
        });
    });

    $(".template-field").each(function(i,item) {
        $(this).find(".template-field-position").val($(".template-field").index(this));
    });
}

$(document).ready(function() {

    if (fields!=null && Array.isArray(fields)) {
        fields.forEach(function (item) {
           var guid = $.generateUid();
           addTemplateField(guid,item);
        });
    }

    $(".tab-link").click(function(e) {
        e.preventDefault();
        $(".tab").removeClass("tab-selected");
        $(this).find(".tab").addClass("tab-selected");
        $(".template-block").css('display', 'none');
        $("."+$(this).attr("data-block")).css('display', 'block');
    });
    $(".template-block").css('display', 'none');
    $(".template-fields").css('display', 'block');

    $("#add-field").click(function(e) {
        e.preventDefault();
        var guid = $.generateUid();
        addTemplateField(guid,null);
    });

    $(".template-fields").on("click",".remove-value",function(e) {
        e.preventDefault();
        $(this).parent().remove();
        $(".template-field").each(function(i,item) {
            $(this).find(".template-field-position").val($(".template-field").index(this));
        });
    });

});
