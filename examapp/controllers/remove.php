<?php


final class remove extends J_Controller
{
	public function __construct()
	{
		parent::__construct();
		isset($_SESSION) || session_start();
	}
	
	public function add($id=null)
	{
		if( !is_numeric($id) ){
			exit('请选择要排除的题');
		}
		$uid = $this->userstatus->getUserID();
		$this->load->model('remove_model', 'remove');
		if( $this->remove->add($uid, $id) )
			echo '已排除此题，您可以在<b>排除的题</b>里看到这些题';
		else
			echo '未能排除，这可能是由您重复点击造成的';
	}
	
	
	public function index()
	{
		$uid = $this->userstatus->getUserID();
		$this->load->model('remove_model', 'remove');
		$this->load->helper('showitem_helper');
		$page = (!isset($_GET['page']) || $_GET['page']<=1) ? 1 : (int)$_GET['page'];
		$limit = 20;
		$list = $this->remove->getRemoveTopicList($uid, $page, $limit);
		$data = array(
			'list'=>$list, 'page'=>$page, 'limit'=>$limit
		);
		
		if( empty($list) ){
			$content = $this->load->view('remove/none', $data, true);
		}else{
			$pages = $this->globalfunc->pages($this->remove->getCount(), $page, $limit, 6);
			$data['pages'] = $pages;
			$content = $this->load->view('remove/list', $data, true);
		}
		$this->layout('我排除的题', $content);
	}

	public function clear($id=null)
    {
        $this->load->model('remove_model', 'remove');
		$uid = $this->userstatus->getUserID();
		$result = $this->remove->clear($uid, $id);
		
		if( ! empty($result) ){
			$_SESSION['msg'] = $id ? '已清空这道试题' : '已清空所有试题';
		}else{
			$_SESSION['msg'] = '未能清空任何试题，请您刷新看看';
		}
		if( isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER']) ){
			$url = $_SERVER['HTTP_REFERER'];
		}else{
			$url = base_url().'remove/';
		}
        header("Location: $url");
    }
	
}
