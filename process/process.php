<?php 
	
	$process = new swoole_process(function(swoole_process $worker){
		//todo
		$worker->exec("/usr/bin/php",[__DIR__.'/../server/http_server.php']);
	},true);

	$pid = $process->start();

	echo $pid.PHP_EOL;
	swoole_process::wait();//回收

?>