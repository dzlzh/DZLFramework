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
 *  ��ȡĿ¼�е��ļ�
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
            $files[] = $file;
        }
    }
    closedir();
    return $files;
}

/**
 *  ����ת����
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
 *  ��ѹ��ȡ��XMLת������
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

            if(strstr(zip_entry_name($zip_entry),'������ѯ\ajcx_') && zip_entry_open($zip, $zip_entry, "r") ){
                // echo "File Contents:\n";
                $buf = zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
                $xml[] = object_to_array(simplexml_load_string($buf));
                zip_entry_close($zip_entry);
                unset($buf);
            }

        }
        zip_close($zip);
    }
    return $xml;
}