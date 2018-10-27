<?php 
/*
*	ws 优化基础类库
*	
*/
	/**
	 * 
	 */
	class Ws 
	{
		
		CONST HOST = '0.0.0.0';
		CONST PORT = 8812;
		public $ws = null;

		public function __construct()
		{
			//实例化对象
			$this->ws = new swoole_websocket_server('0.0.0.0', 8812);
			//设置参数
			$this->ws->set([
				'worker_num'=>2,
				'task_worker_num'=>2,
			]);
			//连接事件
			$this->ws->on("open",[$this,"onOpen"]);
			$this->ws->on("message",[$this,"onMessage"]);
			$this->ws->on("task",[$this,"onTask"]);
			$this->ws->on("finish",[$this,"onFinish"]);
			$this->ws->on("close",[$this,"onClose"]);
			$this->ws->start(); 
		}

		//监听ws 连接事件
		public function onOpen($ws,$request)
		{
			var_dump($request->fd);
			if($request->fd == 1){
				swoole_timer_tick(2000,function($timer_id){
					echo "2s: timer_id: {$timer_id}\n";
				});
			}
		}

		//监听  当服务器收到客户端数据时会回调这个事件
		public function onMessage($ws,$frame)
		{
			echo "receive from {$frame->fd}:{$frame->data},opcode:{$frame->opcode},fin:{$frame->finish}\n"; 
			//耗时的操作 todo 10s
			$data = [
				'task'=>1,
				'fd'=>$frame->fd,
			];
			//$ws->task($data);
			//每隔5秒触发定时器
			swoole_timer_after(5000,function() use($ws,$frame){
				echo '5s-after\n';
				$ws->push($frame->fd,"server-time-after:");
			});
	    	$ws->push($frame->fd, "singwa--push--success"); 
		}

		//投递task 任务
		public function onTask( $serv,  $task_id,  $src_worker_id,  $data)
		{
			print_r($data);
			sleep(10);
			return 'on task finish';	//告诉worker
		}

		//
		public function onFinish( $serv,  $task_id,  $data)
		{
			echo "taskid:{$task_id}\n";
			echo "finish-data-success:{$data}\n";
		}

		//监听关闭
		public function onClose($ws,$fd)
		{
			echo "client {$fd} closed\n";
		}

	}

	$obj = new Ws();
?>