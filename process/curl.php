<?php 
	echo "start-time".date('Ymd H:i:s',time());
	$workers = [];
	$urls = [
		'http://baidu.com',
		'http://sina.com',
		'http://qq.com',
		'http://123.com',
		'https://blog.csdn.net',
	];


	//开启进程
	for ($i=0; $i < 5; $i++) {

		$process = new swoole_process(function($worker) use($i,$urls){
			$content = curlData($urls[$i]);
			echo $content.PHP_EOL;
		},true);
		$pid = $process->start();
		$workers[$pid] = $process;
	}
	foreach ($workers as  $process) {
		echo $process->read();
	}

	function curlData($url)
	{
		sleep(3);
		return $url ."success".PHP_EOL;
	}

	//进程回收
	swoole_process::wait();

	echo "end-time".date('Ymd H:i:s',time());



