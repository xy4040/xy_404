/*
author:木马牛
 */
 var funs = {
 	init : function(){

 	},
 	/*
 	params:str(字符串)
 	return:返回去除空格后的str
 	 */
 	str_trim : function(str){
 		if(!str)return '';
		return str.replace(/\s/g,'');
 	}
 }