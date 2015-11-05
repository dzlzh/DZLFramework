<?PHP
/**
 *  +--------------------------------------------------------------
 *  | Copyright (c) 2015 DZLZH All rights reserved.
 *  +--------------------------------------------------------------
 *  | Author: DZLZH <dzlzh@null.net>
 *  +--------------------------------------------------------------
 *  | Filename: unzip.php
 *  +--------------------------------------------------------------
 *  | Last modified: 2015-11-02 12:16
 *  +--------------------------------------------------------------
 *  | Description: 
 *  +--------------------------------------------------------------
 */

include_once 'function.php';
$zipPath =  'hljsswyxjb' . DIRECTORY_SEPARATOR;
$unzipPath = 'hljsswyxj' . DIRECTORY_SEPARATOR;


$zipFilesName = getFilesName($zipPath);
if (count($zipFilesName)) {
    $flag = unzipFiles($zipFilesName, $zipPath, $unzipPath);
    if (!$flag) {
        echo "success!\n";
    } else {
        echo "failure code:" . $flag . "\n";
    }
} else {
    echo "no package!\n";
} 
