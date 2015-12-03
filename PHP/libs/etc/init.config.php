<?php

return  array(
	"SHOW_TIME" => 1,//显示运行时间
	"DEBUG" => 1,//开启调试模式
	"DEBUG_TPL"=>PHP_PATH."/tpl/debug.tpl.php",//错误异常处理模板
	"ERROR_MESSAGE"=>"页面出错！",//关闭调试模式显示的内容
	//项目配置项
	"DEFAULT_MODULE" => "index",
	"DEFAULT_CONTROL" => "index",
	"DEFAULT_ACTION" => "index",
	"CONTROL_FIX" => "Control",
	"CLASS_FIX" => ".class",
);