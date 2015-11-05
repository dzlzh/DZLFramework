<?PHP
/**
 *  +--------------------------------------------------------------
 *  | Copyright (c) 2015 DZLZH All rights reserved.
 *  +--------------------------------------------------------------
 *  | Author: DZLZH <dzlzh@null.net>
 *  +--------------------------------------------------------------
 *  | Filename: function.php
 *  +--------------------------------------------------------------
 *  | Last modified: 2015-10-30 10:14
 *  +--------------------------------------------------------------
 *  | Description: 
 *  +--------------------------------------------------------------
 */

/**
 *  zip文件解压
 *
 *  @param  String $zipFilesName    压缩文件名
 *  @param  String $zipPath         压缩文件路径
 *  @param  String $unzipPath       解压文件路径
 *
 *  @return int $res                zipArchive:open错误码
 */ 


function unzipFiles($zipFilesName, $zipPath, $unzipPath)
{
    $zipObj = new ZipArchive();
    foreach ($zipFilesName as $zipFileName) {
        $zipFilePath = $zipPath . $zipFileName;
        $unzipFilePath = $unzipPath . substr($zipFileName, 0, -4);
        $res = $zipObj->open($zipFilePath);
        if ($res === true) {
            $zipObj->extractTo($unzipFilePath);
        } else {
            return $res;
        } 
        
    }
    $zipObj->close();
    return 0;
}

/**
 *  获取目录中的文件
 * 
 *  @param  String $path    路径
 *  @return Array  $files   文件名称
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
 *  检查ajcx文件
 * 
 *  @param  Array   $ajcxFiles
 *  @return Array   $ajcxNames
 */ 

function checkFilesName($files, $pcre)
{
    $fileNames = array();
    foreach ($files as $file) {
        if (preg_match($pcre, $file)) {
            $fileNames[] = $file;
        }
    }

    return $fileNames;
}



function getXmlArray($node)
{
    $array=false;
    if ($node->hasAttributes()) {
        foreach ($node->attributes as $attr) {
            $array[$attr->nodeName] = $attr->nodeValue;
        }
    }
    if ($node->hasChildNodes()) {
        if ($node->childNodes->length==1) {
            $array[$node->firstChild->nodeName] = getXmlArray($node->firstChild);
        } else {
            foreach ($node->childNodes as $childNode) {
                if ($childNode->nodeType != XML_TEXT_NODE) {
                    $array[$childNode->nodeName][] = getXmlArray($childNode);
                }
            }
        }
    } else {
        return $node->nodeValue;
    }
    return $array;
    
}
