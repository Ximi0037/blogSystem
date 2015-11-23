<?php
function runtime(){
	$files = require_once PHP_PATH.'/common/files.php';
	foreach ($files as $v) {
		if(is_file($v)){
			require $v;
		}
	}
	mkdirs();
	//框架常规配置项
	C(require PHP_PATH.'/libs/etc/init.config.php');
}


function mkdirs(){
	//检测目录是否存在
	if (!is_dir(TEMP_PATH)) {
		@mkdir(TEMP_PATH, 0777);
	}
	//检测目录是否有写权限
	if (!is_writable(TEMP_PATH)) {
		error("目录没有写权限，程序无法运行！");
	}
	if(!is_dir(CACHE_PATH))
		mkdir(CACHE_PATH, 0777);
	if(!is_dir(LOG_PATH))
		mkdir(LOG_PATH, 0777);
	if(!is_dir(CONFIG_PATH))
		mkdir(CONFIG_PATH, 0777);
	if(!is_dir(TEMPLETE_PATH))
		mkdir(TEMPLETE_PATH, 0777);
	if(!is_dir(TPL_PATH))
		mkdir(TPL_PATH, 0777);
	if(!is_dir(MODULE_PATH))
		mkdir(MODULE_PATH, 0777);

}