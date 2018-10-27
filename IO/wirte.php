<?php 
	$content = date('Ymd H:i:s') .PHP_EOL;
	swoole_async_writefile(__DIR__.'/test.log', $content, function($filename) { 

	    echo "success".	PHP_EOL; 
	},FILE_APPEND);

	echo 'start'. PHP_EOL;

?>