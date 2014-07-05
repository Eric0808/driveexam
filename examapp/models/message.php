<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Message extends CI_Model { 
   
    function __construct()
     {
         parent::__construct();
     }
	
	
	/**
 * 提示信息页面跳转，跳转地址如果传入数组，页面会提示多个地址供用户选择，默认跳转地址为数组的第一个值，时间为5秒。
 * showmessage('登录成功', array('默认跳转地址'=>'http://www.phpcms.cn'));
 * @param string $msg 提示信息
 * @param mixed(string/array) $url_forward 跳转地址
 * @param int $ms 跳转等待时间
 */
	function showmessage($msg, $url_forward = 'goback', $ms = 2500, $dialog = '', $returnjs = '') {
		if($this->session->userdata('manager_id')) {
			//die($this->input->server('HTTP_REFERER'));
			//include(admin::admin_tpl('showmessage', 'admin'));
			$this->load->view('admin/showmessage',array('msg'=>$msg,'url_forward'=>$url_forward,'ms'=>$ms,'dialog'=>$dialog,'returnjs'=>$returnjs));
			echo $this->output->get_output();
		} else {
			//include(template('content', 'message'));
		}
		exit();
	}
}
