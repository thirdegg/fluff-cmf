<?php function OptionsView() {

    if ($_SERVER["REQUEST_METHOD"]=="POST") {

        Option::deleteAll();

        if (isset($_POST["param"]) && is_array($_POST["param"])) {

            for ($i = 0; $i < sizeof($_POST["param"]); $i++) {
                $option = new Option();
                $option->setParam($_POST["param"][$i]);
                $option->setValue($_POST["value"][$i]);
                $option->save();
            }

            echo '<h2>Готово</h2>';
        }

    }

    ?>
<form action="?page=options" method="post" id="options">
    <div class="title">
        <h1>Опции</h1>
    </div>
    <div class="menu-buttons">
        <button class="button">
            Сохранить
            <i class="fa fa-save" aria-hidden="true"></i>
        </button>
    </div>
    <hr>
    <div class="horisontal-label-input">
        <label>Добавить параметр:</label>
        <input class="new-param-name" type="text" placeholder="Название" >
        <a class="add-param" href="javascript:void(0)"><i class="fa fa-plus" aria-hidden="true"></i></a>
        <hr>
    </div>
    <div id="params">
        
    </div>
</form>
<script id="options-item" type="text/x-jquery-tmpl">
    <div class="param-item">
        <label class="name-param">${param}</label>
        <input type="hidden" name="id[]" value="${id}" >
        <input type="hidden" name="param[]" value="${param}" >
        <textarea name="value[]">${value}</textarea>
        <a class="remove-param" href="javascript:void(0)"><i class="fa fa-minus" aria-hidden="true"></i></a>
    </div>
</script>
<script>

    var options = <?=Option::getAllJson()?>;

    $(document).ready(function() {

        options.forEach(function (item) {
            console.log(item);
            $("#options-item").tmpl({"id":-1,"param":item.param,"value":item.value}).appendTo("#params");
        });

       $(".add-param").click(function(e) {
            e.preventDefault();
            console.log($(".new-param-name").val());
            if ($(".new-param-name").val()=="") return;
            for (i=0;i<$(".name-param").length;i++) {
                if ($($(".name-param").get(i)).text() === $(".new-param-name").val()) return;
            }
            $("#options-item").tmpl({"id":-1,"param":$(".new-param-name").val(),"value":""}).appendTo("#params");
            $(".new-param-name").val("");
       });
        $("#params").on("click",".remove-param",(function(e) {
            $(this).parent().remove();
        }));
    });
</script>
<?php }?>