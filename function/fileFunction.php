<?PHP
/**
 *  +--------------------------------------------------------------
 *  | Copyright (c) 2015 DZLZH All rights reserved.
 *  +--------------------------------------------------------------
 *  | Author: DZLZH <dzlzh@null.net>
 *  +--------------------------------------------------------------
 *  | Filename: function.php
 *  +--------------------------------------------------------------
 *  | Last modified: 2015-11-04 14:33
 *  +--------------------------------------------------------------
 *  | Description: getFilesName(),object_to_array(),unzip()
 *  +--------------------------------------------------------------
 */

/**
 *  获取目录中的文件
 *
 *  @param  string $path
 *  @return array  $files
 */

function getFilesName($path)
{
    $handle = opendir($path);
    $files = array();

    while (($file = readdir($handle)) != false) {

        if ($file != '.' && $file != '..') {
            $files[filemtime($path . DIRECTORY_SEPARATOR . $file)] = $file;
        }
    }
    closedir();
    sort($files);
    return $files;
}

/**
 *  对象转数组
 *
 *  @param   object $obj
 *  @return  array  $arr
 */

function object_to_array($obj)
{
    $arr = is_object($obj) ? get_Object_vars($obj) : $obj;

    foreach($arr as $key=>$value) {
        $value = is_array($value) || is_object($value) ? object_to_array($value) : $value;
        $arr[$key] = $value;
    }

    return $arr;
}


/**
 *  解压读取把XML转成数组
 *
 *  @param  string $path
 *  @return array  $xml
 */

function unzip($path)
{
    $xml = array();
    $zip = zip_open($path);

    if (is_resource($zip)) {

        while ($zip_entry = zip_read($zip)) {
            // echo "Name:               " . zip_entry_name($zip_entry) . "\n";
            // echo "Actual Filesize:    " . zip_entry_filesize($zip_entry) . "\n";
            // echo "Compressed Size:    " . zip_entry_compressedsize($zip_entry) . "\n";
            // echo "Compression Method: " . zip_entry_compressionmethod($zip_entry) . "\n";

            if(strstr(iconv("gbk", "UTF-8//TRANSLIT", zip_entry_name($zip_entry)),'案件查询\ajcx_') && zip_entry_open($zip, $zip_entry, "r") ){
                // echo "File Contents:\n";
                $buf = zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
                $xml[] = $buf;
                zip_entry_close($zip_entry);
                unset($buf);
            }

        }
        zip_close($zip);
    }
    return $xml;
}

function fileToString($file)
{
    $fileString = file_get_contents($file);
    return $fileString;
}


function fileUploadError($errorNum){

    switch($errorNum){
        case  4: $error .= "没有文件被上传"; break;
        case  3: $error .= "文件只被部分上传"; break;
        case  2: $error .= "上传文件超过了HTML表单中MAX_FILE_SIZE选项指定的值"; break;
        case  1: $error .= "上传文件超过了php.ini 中upload_max_filesize选项的值"; break;
        case -1: $error .= "末充许的类型"; break;
        case -2: $error .= "文件过大，上传文件不能超过5M"; break;
        case -3: $error .= "上传失败"; break;
        case -4: $error .= "建立存放上传文件目录失败，请重新指定上传目录"; break;
        case -5: $error .= "必须指定上传文件的路径"; break;
        default: $error .=  "末知错误";
    }

    return $error;
} 
