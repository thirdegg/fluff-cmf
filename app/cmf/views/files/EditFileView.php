<?php function EditViewView() { 
    
    chdir($_SERVER['DOCUMENT_ROOT']);
    
    if ($_SERVER["REQUEST_METHOD"]=="POST") {
        File::WriteModel($_POST["path"], $_POST["data"]);
    }

?>
<!doctype html>
<head>
    <script src="js/codemirror.js"></script>
    <link rel="stylesheet" type="text/css" href="js/codemirror.css">
    <script src="js/mode/css/css.js"></script>
    <script src="js/mode/xml/xml.js"></script>
    <script src="js/mode/javascript/javascript.js"></script>
    <script src="js/mode/htmlmixed/htmlmixed.js"></script>
    <script src="//code.jquery.com/jquery-3.2.1.min.js"></script>
</head>
<body>
    <form id="edit-file" action="?page=editview&path=<?php echo isset($_GET["path"])?$_GET["path"]:""?>" method="post">
        <div id="head-menu">
            <button id="submit">Сохранить</button>
        </div>
        <hr>
        <input type="hidden" name="path" value="<?php echo isset($_GET["path"])?$_GET["path"]:""?>">
        <textarea name="data" id="textarea"><?php if (isset($_GET["path"])) echo File::readFile($_GET["path"]);?></textarea>
    </form>
    <script>
        $(document).ready(function() {
            var cm = CodeMirror.fromTextArea(document.getElementById("textarea"), {
                lineNumbers: true,
                mode: "htmlmixed"
            });
            
            $("#submit").click(function() {
                cm.toTextArea();
                $("#edit-file").submit();
            });
        });
    </script>
</body>
<?php }?>