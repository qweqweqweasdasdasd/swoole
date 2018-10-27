<?php 
	
	//异步读取文件
	$result = swoole_async_readfile(__DIR__.'/1.txt',function($filename, $content){
		echo 'filename:' . $filename.PHP_EOL;	// \r\n
		echo 'content:' . $content.PHP_EOL; 
	});
	var_dump($result);

	echo "start".PHP_EOL;
?>