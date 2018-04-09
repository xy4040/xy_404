/*
author:木马牛
 */
 var funs = {
 	init : function(){

 	},
 	/*
 	去除字符串的空格
 	params:str(字符串)
 	return:str
 	 */
 	str_trim : function(str){
 		if(!str)return '';
		return str.replace(/\s/g,'');
 	}
 	/*
 	判断一个变量是否为数字类型
 	param:str(字符串)
 	return:blooen	true/false(是数字/不是数字)
 	 */
 	isNumber : function(str){
 		if(isNaN(str)){
 			return false;
 		}
 		return true;
 	}
 }