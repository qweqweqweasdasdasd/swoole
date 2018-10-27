<?php 
	//实例化一个http 服务
	$http = new swoole_http_server('0.0.0.0',8811);

	//设置参数
	$http->set([
		'enable_static_handler'=>true,
		'document_root'=>'/var/www/html/demo/data',
	]);
	//监听request 请求
	$http->on('request',function($request , $response){
		//print_r($request->get);
		$content = [
			'date: '=>date('Ymd H:i:s'),
			'get: '=>$request->get,
			'post: '=>$request->post,
			'header: '=>$request->header,
		];
		//异步写入
		swoole_async_writefile(__DIR__.'/success.log',json_encode($content).PHP_EOL,function($filename){
			//todo

		},FILE_APPEND);

		$response->end('sss'.json_encode($request->get));
	});

	$http->start();
?>