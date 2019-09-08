<?php function NewPageView() {
    
    if ($_SERVER["REQUEST_METHOD"]=="POST") {
        $page = new Page();
        $page->setName($_POST["pagename"]);
        $page->setUrl($_POST["pageurl"]);
        $page->setFilePath($_POST["associatedfile"]);
        $page->setLastEdit(date("Y-m-d H:i:s"));
        $page->save();

        echo '<h2>Готово</h2><br/><a href="?page=pages">Вернуться к списку</a>';
        return;

    }

?>
<form action="?page=newpage" method="post">
    <div style="overflow: hidden;">
        <div style="float: left; line-height: 50px;">
            <h1 style="margin: 0">Страницы</h1>
        </div>
        <div style="width: 100%; text-align: right; line-height: 30px;">
            <a href="#" class="button" target="popup" onclick="event.preventDefault(); window.open('?page=editview&vid=1','name','width=800,height=600')">
                Редактировать
                <i class="fa fa-edit" aria-hidden="true"></i>
            </a>
            <button>
                Сохранить
                <i class="fa fa-save" aria-hidden="true"></i>
            </button>
        </div>
    </div>
    <hr>
    <div style="margin-top: 20px; margin-bottom: 20px;">
        <div class="horisontal-label-input large">
            <label>Имя страницы:</label>
            <input type="text" name="pagename" placeholder="Имя шаблона" value="<?php echo isset($_POST["pagename"])?$_POST["pagename"]:""?>">
        </div>
        <div class="horisontal-label-input mid">
            <label>URL:</label>
            <input type="text" name="pageurl" placeholder="URL" value="<?php echo isset($_POST["pageurl"])?$_POST["pageurl"]:""?>">
        </div>
        <div class="field-block">
            <div class="field-title">
                <h2>Привязать к файлу</h2>
            </div>
            <div class="field-value">
                <a href="javascript:void(0)" class="button" target="popup" onclick="var input = $('#associatedfile'); $.popup('?page=filespopup&callback=fileresult&filter=scripts','name',function(data) {input.val(data)})">
                    Выбрать файл
                    <i class="fa fa-edit" aria-hidden="true"></i>
                </a>
                <input id="associatedfile" name="associatedfile" type="text" value="<?php echo isset($_POST["associatedfile"])?$_POST["associatedfile"]:""?>" readonly/>
            </div>
        </div>
    </div>
    <hr>
</form>
<?php } ?>
