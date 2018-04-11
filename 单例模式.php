<?php
/**
* notes（单例模式）
* 1、::操作符调用静态变量和方法（其它会报错）
* 2、一个静态的变量来保存类
* 3、一个私有的构造函数（防止new关键字实例化）
* 4、一个静态的方法来实例化自身
*/
class Danli{
	private static $ins = null;
	private function __construct(){
		echo '__construct <br>'.PHP_EOL;
	}

	static function getIns(){
		if(!self::$ins){
			self::$ins = new self();
		}
		return self::$ins;
	}

	function test(){
		echo 'Danli::test方法<br><hr>'.PHP_EOL;
	}
}

// $d = new Danli();	//因为__construct构造方法为private私有，不能实例化new
$d = Danli::getIns();	//::调用静态方法，调用public公共方法会报错
$d->test();

$f = Danli::getIns();
$f->test();

// 输出如下：
// __construct 
// Danli::test方法
// Danli::test方法
?>