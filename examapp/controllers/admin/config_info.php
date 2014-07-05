<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 考试类型相关级别操作<包含界面与模型操作>
 *
 *@date			2012-12-20 18:46:00
 *@database 
 */
final class Config_info extends CI_Controller
{
	
	public function __construct()
	{
		
		parent::__construct();
		
		$this->load->library('session');
		$this->load->model('check');
		$this->load->model('cate_model');
		$this->load->model('message');

	}
	
	public function index()
	{
		//echo dirname(__FILE__).APPPATH;exit;
		//$data['siteurl'] = $this->config->item('Domain');
		//$data['sitename'] = $this->config->item('site_name');
		//$data['site_keyword'] = $this->config->item('site_keyword');
		//$data['site_descrip'] = $this->config->item('site_description');
		//$data['catelist'] = $this->cate_model->Getcategory();
		$this->load->view('admin/config_info');
		
	}
	
	public function update(){
	
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
		
		$config = array('Domain'=>trim($_POST['site_url']), 'site_name'=>trim($_POST['site_name']),'index_site_name'=>trim($_POST['index_site_name']),'texam_site_name'=>trim($_POST['texam_site_name']),'site_keyword'=>trim($_POST['keywords']), 'site_description'=>trim($_POST['descrip']));
		$configfile = $_SERVER['DOCUMENT_ROOT'].ROOT_PATH.APPPATH.'config/config.php';
		if(!is_writable($configfile)) $this->message->showmessage('设置 '.$configfile.' 的权限为 0777 !',$this->input->server('HTTP_REFERER'));
		$pattern = $replacement = array();
		foreach($config as $k=>$v) {
			
				$v = trim($v);
				$configs[$k] = $v;
				$pattern[$k] = "/config\['".$k."'\]\s*=\s*([']?)[^']*([']?)(\s*);/is";
	        	$replacement[$k] = "config['".$k."'] = \${1}".$v."\${2}\${3};";			
			
		}
		$str = file_get_contents($configfile);
		
		$str = preg_replace($pattern, $replacement, $str);
		
		if(file_put_contents($configfile, $str))
			{
				$this->message->showmessage('更新成功!',$this->input->server('HTTP_REFERER'));
			}
		}
	}
	
	
	
	
	
}