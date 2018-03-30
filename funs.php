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
?>