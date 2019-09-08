<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 08.06.15
 * Time: 18:16
 */

class FileUtils {

    public static function WriteModel($data)
    {
        $fp = fopen("file.txt", "w");
        fwrite($fp, $data);
        fclose($fp);
    }

    //отсканировать и добавить все файлы через инклуд модели/контроллеры/утилсы

    public static function scandirs($start)
    {
        $files = array();
        $handle = opendir($start);
        while (false !== ($file = readdir($handle)))
        {
            if ($file != '.' && $file != '..')
            {
                if (is_dir($start.'/'.$file))
                {
                    $dir = scandirs($start.'/'.$file);
                    $files[$file] = $dir;
                }
                else
                {
                    array_push($files, $file);
                }
            }
        }
        closedir($handle);
        return $files;
    }

}
