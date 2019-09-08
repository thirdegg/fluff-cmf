<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Unit tests</title>
        <script>
            function popup(event) {
                event.preventDefault();

                var w = window.open('popup.php','name','width=800,height=600');
                w.callback = function(data) {
                    console.log(data);
                };
            }
        </script>
    </head>
    <body>
        <table>
            <tr>
                <td>Тест шаблонов</td>
                <td><a href="_test_templates.php">></a></td>
            </tr>
            <tr>
                <td>Тест объектов</td>
                <td><a href="_test_objects.php">></a></td>
            </tr>
            <tr>
                <td>Тест пользователей</td>
                <td><a href="_test_users.php">></a></td>
            </tr>
            <tr>
                <td>Тест файлов</td>
                <td><a href="_test_files.php">></a></td>
            </tr>
            <tr>
                <td>Окно</td>
                <td><a href="#" class="button" target="popup" onclick="popup(event)">></a></td>
            </tr>
        </table>
        
    </body>
</html>