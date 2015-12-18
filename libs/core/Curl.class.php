<?php
namespace Org\Util;
class Curl{
	public function postCurl($url, $data){
        $ch = curl_init();     
        $timeout = 3000;      
        curl_setopt($ch, CURLOPT_URL, $url);    
        curl_setopt($ch, CURLOPT_REFERER, 'http://192.168.2.93:18003/');   //构造来路   
        curl_setopt($ch, CURLOPT_POST, true);     
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);     
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);     
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);     
        $handles = curl_exec($ch);     
        curl_close($ch); 
        return $handles;
    }



    public function curl_post($data,$url){
    	$header = array("Host:127.0.0.1",
		  "Content-Type:application/x-www-form-urlencoded",
		  'Referer:http://127.0.0.1/toolindex.xhtml',
		  'User-Agent: Mozilla/4.0 (compatible; MSIE .0; Windows NT 6.1; Trident/4.0; SLCC2;)');

		$ch = curl_init();
		$res= curl_setopt ($ch, CURLOPT_URL,$url);
		//var_dump($res);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt ($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch,CURLOPT_HTTPHEADER,$header);
		$result = curl_exec ($ch);
		curl_close($ch);
		if ($result == NULL) {
			return 0;
		}
			return $result;
}

    public function getCurl($url,$type="GET"){
		$ch = curl_init();
		$header = "Accept-Charset: utf-8";
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $type);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$temp = curl_exec($ch);
		 //关闭URL请求
		curl_close($ch);
		return $temp;
	}
}
?>