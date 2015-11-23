<?php

function error($msg){
	echo "<div style='border:solid 2px #3333;width:500px;height:100px;>$msg<div>";
	exit();
}

//生成唯一序列号
function _md5($string){
	return md5(serialize($string));
}

//实例化对象或执行方法
function O($class, $method=null, $args=array()){
	static $result = array();
	$name = empty($args)?$class.$method:$class.$method._md5($args);
	if(!isset($result[$name])){
		$obj = new $class();
		if(!is_null($method) && method_exists($obj, $method)){
			if(!empty($args)){
				$result[$name] = call_user_func_array(array(&$obj, $method), array($args));
			}else{
				$result[$name] = $obj->$method();
			}
		}else{
			$result[$name] = $obj;
		}
	}
	return $result[$name];
}
//载入文件
function loadfile($file){
	static $fileArr = array();
	if(!isset($fileArr[$file])){
		if(!is_file($file)){
			$msg = "<span style = 'color:#f00;'>文件{$file}不存在！</span>";
		}else{
			require $file;
			$fileArr[$file] = true;
			$msg = "<span style = 'color:#f00;'>文件{$file}载入成功！</span>";
		}
		if(C("DEBUG")){
		call_user_func_array(array("debug", "msg"),array($msg));
	}
		return $fileArr[$file];
	}
}

//配置文件处理
function C($name = null, $value = null){
	static $config = array();
	if(is_null($name)){
		return $config;
	}
	if(is_string($name)){
		$name = strtolower($name);
		if(!strstr($name, ".")){
			if(is_null($value)){
				return isset($config[$name])?$config[$name]:null;
			}else{
				$config[$name] = $value;
				return;
			}
		}
		$name = explode(".", $name);
		if(is_null($value)){
			return isset($config[$name[0][1]])?config[$name[0][1]]:null;
		}else{
			$config[$name[0][1]] = $value;
			return;
		}
	}
	if(is_array($name)){
		$config = array_merge($config, array_change_key_case($name));
		return true;
	}
}