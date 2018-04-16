<?php
$pageNum = "3751";
$refrere = 'http://www.mm131.com/xinggan/';
$url = "http://www.mm131.com/xinggan/".$pageNum.".html";

$data = curl_cj($url);

$data = charSet($data);
$pattNum = "/<span class=\"page-ch\">\w(\d+)\w<\/span>/u";
preg_match($pattNum, $data, $match);
$pageCount = $match[1];
echo "There are ".$pageCount." pictures in total".PHP_EOL;
$dir = dirname(__FILE__).'/'.$pageNum;
if(!file_exists($dir) && !is_dir($dir)){
	mkdir($dir);
}

for($i = 0; $i <= $pageCount; $i++){
	$path = $dir."/".$i.".jpg";
	if(!file_exists($path)){
		$img = "http://img1.mm131.me/pic/".$pageNum."/".$i.".jpg";
		$data = curl_cj($img, $refrere);
		downPic($path, $data);
	}

}


function charSet($str){
	return mb_convert_encoding($str, 'utf-8', 'gb2312');
}

function curl_cj($url, $refrere = ""){
	$curl=curl_init();  
	//设置URL和相应的选项  
	curl_setopt($curl, CURLOPT_URL, $url);  
	curl_setopt($curl, CURLOPT_ENCODING, '');
	curl_setopt($curl, CURLOPT_REFERER, $refrere);//模拟来路
	// curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	// curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);  //将curl_exec()获取的信息以字符串返回，而不是直接输出。  
	//执行curl操作  
	$data = curl_exec($curl);
	return $data;
}

function downPic($path, $data){
	$fp = fopen($path, 'a');
	fwrite($fp, $data);
	fclose($fp);
	console($path);
}

function console($str){
	echo $str.PHP_EOL;
}

?>