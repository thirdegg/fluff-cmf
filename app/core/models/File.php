<?php

class File {

    private $name;
    private $path;
    private $parentpath;
    private $mime;   
    private $size;
    private $date;

    public function getName() {
        return $this->name;
    }

    public function getPath() {
        return $this->path;
    }
    
    public function getParentPath() {
        return $this->parentpath;
    }
    
    public function getMime() {
        return $this->mime;
    }
    
    public function getSize() {
        return $this->size;
    }
    
     public function getDate() {
        return $this->date;
    }
    
    public static function WriteModel($name,$data) {
        $fp = fopen($name, "w");
        fwrite($fp, $data);
        fclose($fp);
    }

    public static function readFile($name) {
        return file_get_contents($name);
    }
    
    private static function scanDirect($path) {
        $files = array();
        if ($handle = opendir($path)) {
            while (false !== ($name = readdir($handle)))   {
                if ($name != "." && $name != "..") {
                    $file = new File();
                    $file->name = $name;
                    $file->path = $path."/".$name;
                    $file->parentpath = $path;
                    $file->mime = finfo_file(finfo_open(FILEINFO_MIME_TYPE),$path);
                    $file->date = date("F d Y H:i:s.", filemtime($path));
                    $file->size = filesize($file->path);
                    $files[] = $file;
                }
            }
            closedir($handle);
        }
        return $files;
    }
    
    public static function scanDir($path) {
        $path = "";
        if (isset($_GET["path"])) {
            $path=$_GET["path"];
        }

        $path=realpath($_SERVER['DOCUMENT_ROOT']."/".$path);
        if (strlen($path)<strlen($_SERVER['DOCUMENT_ROOT'])) {
            $path=$_SERVER['DOCUMENT_ROOT'];
        }

        echo $path."<br/>";
        return File::scanDirect($path);
    }
    
    public static function getTree($start,$catalog) {
        $files = array();
        $handle = opendir($start);
        while (false !== ($file = readdir($handle))) {
            if ($file != '.' && $file != '..') {
                $path = $start.'/'.$file;
                if (is_dir($path)) {
//                    if (file_exists($path.'/.notvisible')) return;
                    $array = File::getTree($path,$catalog);
                    $files = array_merge($files, $array);
                }

                if ($start!=$catalog) continue;
                
                $fileobj = new File();
                $fileobj->name = $file;
                $fileobj->path = $path;
                $fileobj->parentpath = $path;
                $fileobj->mime = finfo_file(finfo_open(FILEINFO_MIME_TYPE),$path);
                $fileobj->date = date("F d Y H:i:s.", filemtime($path));
                $fileobj->size = filesize($path);
                
                array_push($files, $fileobj);
                
            }
        }
        closedir($handle);
        sort($files);
        
        
        
        return $files;
    }

    static function copyTempFile($temppath, $filepath) {

        print_r($temppath." - ".$filepath."<br/>");
        if (!copy($temppath, $filepath)) {
            throw new Exception("Error");
        }

        //unlink($temppath);
    }
}

?>