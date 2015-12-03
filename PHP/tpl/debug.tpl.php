<html>
<head>
	<title>后盾框架--调试页面</title>
	<style type="text/css">
		*{margin:0px;padding:0px;}
		body{margin:20px;}
		#debug{width:880px;border:solid 1px red;margin-top: 20px;padding:10px;}
		fieldset{padding:10px;font-size:14px;}
		legend{padding:5px;}
	</style>
</head>
<body>
	<div id="debug">
		<h2>DEBUG</h2>
		<?php if(isset($e['message'])) { ?>
		<fieldset>
			<legend>ERROR</legend>
			<?php echo $e['message']; ?>
		</fieldset>
		<?php } ?>
		<?php if(isset($e['info'])) { ?>
		<fieldset>
			<legend>TRACE</legend>
			<?php echo $e['info']; ?>
		</fieldset>
		<?php } ?>
	</div>
</body>
</html>