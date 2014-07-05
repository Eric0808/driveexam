<?php

final class orderly extends J_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->load->model('topic_model', 'topic');
		$ids = $this->topic->getTopicID(false);

		$uid = $this->userstatus->getUserID();
        $this->load->model('remove_model', 'remove');
        $remove = $this->remove->getRemoveTopicIds($uid);

		$title = '顺序练习';
		$data = array(
			'title' => $title,
			'ids'=> "[{$ids}]",
			'remove' => "[{$remove}]"
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
