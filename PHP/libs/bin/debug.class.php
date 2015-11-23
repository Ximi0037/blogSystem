<?php

class debug{
	static $debug = array();//错误信息

	static function msg($msg){
		self::$debug[] = $msg;
	}
	static function show(){
		self::$debug[] = "运行时间:".run_time("start", "end")."s";
		echo "<div style='border:solid 2px #dcdcdc;width:700px;'><ul style='list-style:none;padding:0px;margin:0px;'>";
		foreach (self::$debug as $v) {
			echo "<li>".$v."</li>";
		}
		echo "</ul></div>";
	}
}