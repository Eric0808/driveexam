<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 考试类型相关级别操作<包含界面与模型操作>
 *
 *@date			2012-12-20 18:46:00
 *@database 
 */
final class Nextup extends CI_Controller
{
	
	public function __construct()
	{
		
		parent::__construct();
		
		$this->load->model('topic_model');

	}
	
	public function index()
	{	
		
	}
	
	
	
	/*获取当前题解的上一条和下一条*/
	public function Getnextup(){
		$eId = isset($_GET['eid']) ? intval($_GET['eid']) : 2;
		$aboutData = $this->topic_model->Getnextup($eId);
		$baseUrl = base_url();
		$uptitle = $nextTitle = $reStr = '';
		if(count($aboutData)==2 && count($aboutData[0])!=0){
			$uptitle = "上一篇: <a href=\"{$baseUrl}jieshi/{$aboutData[0]['id']}.html\" title=\"{$aboutData[0]['question']}\">{$aboutData[0]['question']}</a><br />";
		}
		if(count($aboutData)==2 && count($aboutData[1])!=0){
			$nextTitle = "下一篇: <a href=\"{$baseUrl}jieshi/{$aboutData[1]['id']}.html\" title=\"{$aboutData[1]['question']}\">{$aboutData[1]['question']}</a><br />";
		}
		$reStr = $uptitle . $nextTitle;
		echo 'document.write("'.addcslashes($reStr, '"').'");';
		
	}
	
	
	
	
	
}