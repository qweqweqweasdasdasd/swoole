<?php 
	//创建Server对象，监听 127.0.0.1:9501端口 
	$serv = new swoole_server("127.0.0.1", 9501);  
	 
	//设置参数
	$serv->set([
		'work_num'=>8,	//进程数量
		'max_request'=>10000,
	]);

	//监听连接进入事件 $fd 连接的标识 $reactor_id 线程 id
	$serv->on('connect', function ($serv, $fd ,$reactor_id) {   
	    echo "Client:{$reactor_id} - {$fd} - Connect.\n"; 
	}); 
	  
	//监听数据发送事件 
	$serv->on('receive', function ($serv, $fd, $reactor_id, $data) { 
	    $serv->send($fd, "Server:{$reactor_id} - {$fd}  ".$data); 
	}); 
	  
	//监听连接关闭事件 
	$serv->on('close', function ($serv, $fd) { 
	    echo "Client: Close.\n"; 
	}); 
	  
	//启动服务器 
	$serv->start();  
 ?>	