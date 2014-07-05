<?php


final class clear extends J_Controller
{
	public function index()
	{
		$file = sys_get_temp_dir().'/gc.log';
		
		ini_set('display_errors', false);
		// 删除7天之前的数据
		define('TIME', time()-(3600*24*30));
		@ob_start();
		$this->load->model('gcclear_model', 'clear');
		$this->clear->clear();
		$s = @ob_get_contents();
		@file_put_contents($file, $s, FILE_APPEND);
		@ob_end_clean();
	}
}
