<?php


final class wrong extends J_Controller
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function add($id)
	{
		if( !is_numeric($id) || !isset($_GET['answer']) ){
			exit('请告诉我哪些题要标为错题');
		}
		$uid = $this->userstatus->getUserID();
		$this->load->model('wrong_model', 'wrong');
		if( $this->wrong->add($uid, $id, $_GET['answer']) )
		{
			$this->load->library('session');
			$w_num = $this->session->userdata('wrong_num');
			$w_num = $w_num+1;
			$this->session->set_userdata('wrong_num',$w_num);
			if($this->session->userdata('wrong_num')==$this->session->userdata('wrong_max'))
			echo 'stop';
			else
			echo "已标记，您可以我的错题中查看并专门重做";
		}
			
		else{
			echo "未能标记，这很可能是因为您重复点击造成的";}
	}
	
	
	public function index()
	{
		$uid = $this->userstatus->getUserID();
		$this->load->model('wrong_model', 'wrong');
		$this->load->helper('showItem_helper');
		$page = (!isset($_GET['page']) || $_GET['page']<=1) ? 1 : (int)$_GET['page'];
		$limit = 5;
		$list = $this->wrong->getWrongTopicList($uid, $page, $limit);
		$data = array(
			'list'=>$list, 'page'=>$page, 'limit'=>$limit
		);
		if( empty($list) ){
			$content = $this->load->view('wrong/none', null, true);
		}else{
			$count = $this->wrong->getCount();
			$pages = $this->globalfunc->pages($count, $page, $limit, 6);
			$data['pages'] = $pages;
			$content = $this->load->view('wrong/list', $data, true);
		}
		$this->layout('我做错的题', $content);
	}

	public function clear($id=null)
    {
        $this->load->model('wrong_model', 'wrong');
		$uid = $this->userstatus->getUserID();
		$result = $this->wrong->clear($uid, $id);
		
		if( ! empty($result) ){
			$_SESSION['msg'] = $id ? '已清空这道试题' : '已清空所有试题';
		}else{
			$_SESSION['msg'] = '未能清空任何试题，请您刷新看看';
		}
		
		if( isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER']) ){
			$url = $_SERVER['HTTP_REFERER'];
		}else{
			$url = base_url().'wrong/';
		}
        header("Location: $url");
    }


    public function redo()
    {
        $title = '错题重做';
			
		$this->load->model('wrong_model', 'wrong');
		$uid = $this->userstatus->getUserID();
		$result = $this->wrong->getWrongTopicIds($uid);

   	    $this->load->model('remove_model', 'remove');
        $remove = $this->remove->getRemoveTopicIds($uid);
		
		$data = array(
            'title' => $title,
            'ids'=> "[{$result['ids']}]",
			'remove' => "[{$remove}]"
        );

        $setting = array(
            'css' => array(
                'study'
            ),
            'javascript'=>array(
                'topic', 'show'
            )
        );

        $content = $this->load->view('do', $data, true);
        $this->layout($title, $content, $setting);

    }
	
}
