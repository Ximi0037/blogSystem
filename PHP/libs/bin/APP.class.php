<?php

/*项目处理类*/
class APP{
	static $module;//模块
	static $control;//控制器
	static $action;//动作方法
	static function run(){
		//配置自动加载类文件
		spl_autoload_register(array(__CLASS__, "autoload"));

		//注册错误处理函数
		set_error_handler(array(__CLASS__, "error"));

		self::init();
		if(C("DEBUG")){
			debug::show();
		}

//		echo C("DBHOST")."</br>";
//		echo C("USER");
	}
	//初始化配置
	static function init(){
		self::config();
		self::$module = self::module();
		self::$control = self::control();
		self::$action = self::action();
		$control_file = MODULE_PATH."/".self::$module."/".self::$control.C("CONTROL_FIX").C("CLASS_FIX").".php";
		if(loadfile($control_file)){
			$obj = O(self::$control.C("CONTROL_FIX"));
			$action = self::action();
			$obj->$action();
		}
	}

	//获得模块
	private static function module(){
		if(isset($_GET['m']) && !empty($_GET['m'])){
			return $_GET['m'];
		}
		return C("DEFAULT_MODULE");
	}

	//获得控制器
	private static function control(){
		if(isset($_GET['c']) && !empty($_GET['c'])){
			return $_GET['c'];
		}
		return C("DEFAULT_CONTROL");
	}

	//获得动作
	private static function action(){
		if(isset($_GET['a']) && !empty($_GET['a'])){
			return $_GET['a'];
		}
		return C("DEFAULT_ACTION");
	}
	//初始化配置文件处理
	static function config(){
		$config_file = CONFIG_PATH.'/config.php';
		if(is_file($config_file)){
			C(require $config_file);
		}
	}
	//自动加载类文件
	static function autoload($classname){
		$file = PHP_PATH.'/libs/bin/'.$classname.'.class.php';
		loadfile("$file");
	}

	static function error($errno, $errstr, $errfile, $errline){
		switch ($errno){
			case E_ERROR:
			case E_USER_ERROR:
				$errmsg = "ERROR:[$errno]<strong>$errstr</strong>File:$errfile:[$errline]";
				die($errmsg);
		}
	}
}