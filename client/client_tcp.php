<?php 
	
	//连接swoole_tcp
	$client = new swoole_client(SWOOLE_SOCK_TCP);
	if(!$client->connect('127.0.0.1',9501)){
		exit("连接失败. Error: {$client->errCode}\n"); 
	}

	//PHP cli 常量
	fwrite(STDOUT,'请输入信息: ');
	$msg = trim(fgets(STDIN));
	//发送消息给tcp server
	$client->send($msg);

	//接受来自server的数据
	$result = $client->recv();

	echo $result;

?>