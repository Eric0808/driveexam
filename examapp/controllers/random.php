<?php

final class random extends J_Controller
{
	public function __construct()
	{
		session_start();
		parent::__construct();
	}

	public function index()
	{
		if( ! isset($_GET['chapter']) ){
			if( ! isset($_SESSION['randtopicid']) ||
					empty($_SESSION['randtopicid']) ){
				$this->load->model('topic_model', 'topic');
				// rand
				$_SESSION['randtopicid'] = $this->topic->getTopicID(true);
			}
			$result = $_SESSION['randtopicid'];
		}else{
			$this->load->model('topic_model', 'topic');
			$result = $this->topic->getTopicID(true);
		}
		
		$uid = $this->userstatus->getUserID();
		
		$this->load->model('remove_model', 'remove');
		$remove = $this->remove->getRemoveTopicIds($uid);
		
		$title = '随机练习';
		$data = array(
			'title' => $title,
			'remove' => "[{$remove}]",
			'ids'=> "[{$result}]",
		);

		$setting = array(
			'css' => array('study'),
			'javascript'=>array(
				'topic', 'show'
			)
		);

		$content = $this->load->view('do', $data, true);
		$this->layout($title, $content, $setting);
	}

}
