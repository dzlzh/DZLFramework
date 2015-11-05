<?PHP
/**
 *  +--------------------------------------------------------------
 *  | Copyright (c) 2015 DZLZH All rights reserved.
 *  +--------------------------------------------------------------
 *  | Author: DZLZH <dzlzh@null.net>
 *  +--------------------------------------------------------------
 *  | Filename: filename.php
 *  +--------------------------------------------------------------
 *  | Last modified: 2015-10-30 09:14
 *  +--------------------------------------------------------------
 *  | Description: 
 *  +--------------------------------------------------------------
 */
include_once 'function.php';

$xmldom = new DOMDocument();

$zipPath =  'hljsswyxjb' . DIRECTORY_SEPARATOR;
$unzipPath = 'hljsswyxj' . DIRECTORY_SEPARATOR;



$filesName = getFilesName($unzipPath);
$ajcxPaths  = array();

foreach ($filesName as $fileName) {
    $ajcxPath = $unzipPath . $fileName . DIRECTORY_SEPARATOR;
    $ajcxFiles = getFilesName($ajcxPath);
    $ajcxs = checkFilesName($ajcxFiles, '/^ajcx_\d\.xml$/i');
    if (count($ajcxs)) {
        foreach ($ajcxs as $ajcx) {
            $ajcxPaths[] = $unzipPath . $fileName . DIRECTORY_SEPARATOR . $ajcx;
        }
    }
}

$ajcxPath = 'hljsswyxj\sfgk-all-201508251013-320\ajcx_1.xml';
// foreach ($ajcxPaths as $ajcxPath) {

    $xmldom->load($ajcxPath) or die("error");
    $xmlStart = $xmldom->documentElement;
    $xml = getXmlArray($xmlStart);
// print_r($xml);
    echo $ajcxPath . "\t\t" . count($xml['AjList']['0']['ZxAjInfo']) . "\n";
// }
