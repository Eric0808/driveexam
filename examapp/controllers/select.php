<?php

final class Select extends J_Controller
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{
		$title = '筛选练习';
		if( $_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST) ){
			if( $_SERVER['REQUEST_METHOD'] === 'POST' ){
				$_SESSION['msg'] = '请您选择要练习的题型';
			}
			$this->load->model('cate_model', 'cate');
			$wherein = $this->cate->getWherein($_COOKIE['subjectid']);
			$cates = $this->cate->Getcategory($wherein);
			$data = array('categorys'=>$cates);
			$content = $this->load->view('select/index', $data, true);
			$this->layout($title, $content);
		}else{
			$this->load->model('topic_model', 'topic');
			if( isset($_POST['categroy']) ){
				$result = $this->topic->getTopicIDLengthByCatid($_POST['categroy']);
			}elseif( isset($_POST['catalogval']) ){
				switch((int)$_POST['catalogval']){
					case 1:
					case 2:
					case 3:
					case 4:
						$type = 1;
						$answer = $_POST['catalogval'];
					break;
					case 5:
					case 6:
						$type = 0;
						$answer = $_POST['catalogval']-4;
					break;
					case 7:
						$type = 2;
						$answer = null;
					break;
				}
				$result = $this->topic->getTopicIDLengthByType($type, $answer);
			}
			$uid = $this->userstatus->getUserID();
			$this->load->model('remove_model', 'remove');
			$remove = $this->remove->getRemoveTopicIds($uid);
			$data = array(
				'title' => $title,
				'ids'=> "[{$result}]",
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

	
}
