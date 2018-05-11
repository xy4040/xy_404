<?php
	/*
	*空目录创建文件（使用svn提交代码时空文件夹无法提交并报错）
	*params $dir 目录路径
	 */
	function  emptyDirCreateFile($dir = null){
		if(empty($dir))die('目录为空~');
		if(!is_dir($dir))die($dir.':不是一个合法目录');
		if(@$hd = opendir($dir)){
			$a = count(scandir($dir));
			if($a > 2){
				while (($file = readdir($hd)) !== false) {
					if($file != '.' && $file != ".."){
						if(is_dir($dir.'/'.$file)){
							emptyDirCreateFile($dir.'/'.$file);
						}
					}
				}				
			}else{
				file_put_contents($dir.'/index.html', '');
			}
		}else{
			die($dir.':不是一个合法目录！');
		}
	}

	// 创建随机数
	function createNonceStr($length = 16) {
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$str = "";
		for ($i = 0; $i < $length; $i++) {
		  $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
		}
		return $str;
	}

	// httpGet
	function httpGet($url){
		$curl = curl_init();
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($curl, CURLOPT_TIMEOUT, 500);
	    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
	    curl_setopt($curl, CURLOPT_URL, $url);

	    $res = curl_exec($curl);
	    curl_close($curl);
	    return $res;
	}

	// httpPost
	function httpPost($data, $url){
		$res = array();
		// //初始化
		$ch = curl_init();
		// curl_setopt($ch,CURLOPT_SAFE_UPLOAD, false);
		curl_setopt($ch,CURLOPT_URL, $url);
		// curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,TRUE);
		// curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,2);//严格校验
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
		curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);//严格校验2
		//设置header
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		//要求结果为字符串且输出到屏幕上
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		//post提交方式
		// $xml = $data;
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		//运行curl
		$res['data'] = curl_exec($ch);
		//返回结果
		if($res){
			$res['error'] = true;
		} else {
			$res['error'] = false;
		}
		curl_close($ch);
		return $res;
	}

	// httpPostSSL，用于微信红包（证书验证）
	function httpPostSSL($data, $url){
		// //初始化
		$ch = curl_init();
		// curl_setopt($ch,CURLOPT_SAFE_UPLOAD, false);
		curl_setopt($ch,CURLOPT_URL, $url);
		// curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,TRUE);
		// curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,2);//严格校验
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
		curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);//严格校验2
		// curl_setopt($ch,CURLOPT_SSLCERT,dirname(__FILE__).DIRECTORY_SEPARATOR.'cert'.DIRECTORY_SEPARATOR.'apiclient_cert.pem');
		// curl_setopt($ch,CURLOPT_SSLKEY,dirname(__FILE__).DIRECTORY_SEPARATOR.'cert'.DIRECTORY_SEPARATOR.'apiclient_key.pem');
		// curl_setopt($ch,CURLOPT_CAINFO,dirname(__FILE__).DIRECTORY_SEPARATOR.'cert'.DIRECTORY_SEPARATOR.'rootca.pem');

		curl_setopt($ch,CURLOPT_SSLCERT,CONFIG_ROOT.DIRECTORY_SEPARATOR.'cert'.DIRECTORY_SEPARATOR.'apiclient_cert.pem');
		curl_setopt($ch,CURLOPT_SSLKEY,CONFIG_ROOT.DIRECTORY_SEPARATOR.'cert'.DIRECTORY_SEPARATOR.'apiclient_key.pem');
		curl_setopt($ch,CURLOPT_CAINFO,CONFIG_ROOT.DIRECTORY_SEPARATOR.'cert'.DIRECTORY_SEPARATOR.'rootca.pem');

		//设置header
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		//要求结果为字符串且输出到屏幕上
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		//post提交方式
		$xml = $data;
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
		//运行curl
		$data = curl_exec($ch);
		//返回结果
		if($data){
			curl_close($ch);
			return $data;
		} else { 
			$error = curl_errno($ch);
			curl_close($ch);
			return $error."---*";
		}
	}

	// 下载网络图片
	function curlDownImg($url, $thumbName){
		$curl = curl_init($url);
		$filename = $thumbName.".jpg";
		curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);	
		curl_setopt($curl,CURLOPT_CONNECTTIMEOUT,5);
		$imageData = curl_exec($curl);
		curl_close($curl);
		$tp = @fopen($filename, 'a');
		fwrite($tp, $imageData);
		fclose($tp);
	}

	// 下载微信图片（二维码）推荐
	function downloadImageFromWeiXin($url,$thumbName){
	    $ch = curl_init($url);
	    curl_setopt($ch, CURLOPT_HEADER, 0);
	    curl_setopt($ch, CURLOPT_NOBODY, 0);    //只取body头
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    $package = curl_exec($ch);
	    $httpinfo = curl_getinfo($ch);
	    curl_close($ch);
	    $imageInfo = array_merge(array("body"=>$package),array("header"=>$httpinfo));
	    $local_file = fopen($thumbName.".jpg", "w");
	    if(false !== $local_file){
	        if(false !== fwrite($local_file, $imageInfo["body"])){
	            fclose($local_file);
	        }
	    }
	}

	//sina接口归属地
	function getIPLoc_sina($queryIP){
	    $url = 'http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=json&ip='.$queryIP;
	    $ch = curl_init($url); 
	    //curl_setopt($ch,CURLOPT_ENCODING ,'utf8');
	    curl_setopt($ch, CURLOPT_TIMEOUT, 10); 
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ; // 获取数据返回 
	    $location = curl_exec($ch); 
	    $location = json_decode($location);
	    curl_close($ch);     
	     
	    $loc = ""; 
	    if($location===FALSE) return ""; 
	    if (empty($location->desc)) { 
	        $loc = $location->province.$location->city.$location->district.$location->isp; 
	    }else{ 
	        $loc = $location->desc; 
	    } 
	    return $loc; 
	}

	//获取IP
	function GetIP(){
		if(!empty($_SERVER["HTTP_CLIENT_IP"])){
		  $cip = $_SERVER["HTTP_CLIENT_IP"];
		}
		elseif(!empty($_SERVER["HTTP_X_FORWARDED_FOR"])){
		  $cip = $_SERVER["HTTP_X_FORWARDED_FOR"];
		}
		elseif(!empty($_SERVER["REMOTE_ADDR"])){
		  $cip = $_SERVER["REMOTE_ADDR"];
		}
		else{
		  $cip = "127.0.0.1";
		}
		return $cip;
	}

	// toXml
	function toXml($data){
		if(!is_array($data) && count($data) <= 0){
			return "数据异常~";exit();
		}
		$xml = "<xml>";
		foreach ($data as $key => $val) {
			if (is_numeric($val)){
				$xml.="<".$key.">".$val."</".$key.">";
			}else{
				$xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
			}
			// $xml .= "<".$k."><![CDATA[".$v."]]></".$k.">";
		}
		$xml .= "</xml>";
		return $xml;
	}

	// 随机生成中文
	function RandomChinese($num = 1){
		$str = '';
		for($i = 0; $i < $num; $i++){
			$random = chr(mt_rand(0xB0,0xD0)).chr(mt_rand(0xA1, 0xF0));
			$str .= iconv('gb2312', 'utf-8', $random);
		}
		return $str;
	}
?>
