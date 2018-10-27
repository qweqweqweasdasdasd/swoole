<?php 
	
	$server = new swoole_websocket_server("0.0.0.0", 8812); 
  	
  	//设置参数
	$server->set([
		'enable_static_handler'=>true,
		'document_root'=>'/var/www/html/demo/data',
	]);
	
  	//监听websocket打开事件
	$server->on('open','onOpen'); 

	function onOpen(swoole_websocket_server $server, $request){

		print_r($request->fd);
	}
	//监听websocket 消息事件
	$server->on('message', function (swoole_websocket_server $server, $frame) { 
	    echo "receive from {$frame->fd}:{$frame->data},opcode:{$frame->opcode},fin:{$frame->finish}\n"; 
	    $server->push($frame->fd, "singwa--push--success"); 
	}); 
	  
	$server->on('close', function ($ser, $fd) { 
	    echo "client {$fd} closed\n"; 
	}); 
	  
	$server->start();

?>