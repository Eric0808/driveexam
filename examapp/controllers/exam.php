<?php

final class Exam extends J_Controller
{
	public function __construct()
	{
		parent::__construct();
		define('EXAM', true);
		
		$this->load->model('exam_model', 'exam');
		$this->uid = $this->userstatus->getUserID();
	}
	
	public function index()
	{
		$this->load->model('subject_model', 'subject');
		
		
		$subjectid = (int)@$_COOKIE['subjectid'];
		$subjectinfo = $this->subject->getNameById($subjectid, true);
		
		if( empty($subjectinfo) ){
			exit("未能找到任何题库信息，请您联系管理员确认");
		}
		
		$id = $this->exam->start($this->uid);
		
		$num = array(
			'一' => array(
				array('type'=> 0, 'limit'=> 40),
				array('type'=> 1, 'limit'=> 60),
				),
			'三' => array(
				array('type'=> 0, 'limit'=> 20),
				array('type'=> 1, 'limit'=> 25),
				array('type'=> 2, 'limit'=> 5),
				),
			'all' => array(
				array('type'=> 0, 'limit'=> 40),
				array('type'=> 1, 'limit'=> 60),
				)
		);

		foreach($num as $case=>$info){
			if(strpos($subjectinfo['subject1'], $case)!==false){
				$data = $info;
			}
		}
		
		if( !isset($data) ){
			$data = $num['all'];
		}
		
		$this->load->model('topic_model', 'topic');
		$result = '';
		
		foreach($data as $filed){
			$tmpres = $this->topic->getTopicIdsByType($filed['type'], $filed['limit']);
			if( !empty($tmpres) ){
				$result .= ','. $tmpres;
			}
		}
		$result = trim($result, ',');
		
		$title = '模拟考试';
		if( ! isset($subjectinfo['maxtime']) )
			$subjectinfo['maxtime'] = 30;

		$data = array(
			'title' => $title,
			'ids'=> "[{$result}]",
			'examid' => "{$id}",
			'time' => $subjectinfo['maxtime'], // 分钟
			'subjectid' => $subjectinfo['id']
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

	
	public function submit($examid=null)
	{
		if( $_SERVER['REQUEST_METHOD'] !== 'POST' || empty($examid) ){
			$response = array('msg'=>"您似乎还没有提交任何考试数据");
			exit;
		}
		
		ini_set('display_errors', false);
		
		$this->load->model('subject_model', 'subject');
		$this->load->model('topic_model', 'topic');
		$this->load->model('answer_model', 'answer');
		
		
		$ids = implode(',', array_keys($_POST));
		// 获取每道题分值
		
		$rule = $this->subject->getRule(@$_COOKIE['subjectid']);
		
		if( count($_POST) > $rule['num']){
			$data = array_slice($_POST, 0, $rule['num'], true);
		}else{
			$data = $_POST;
		}
		
		$answers = $this->topic->getAnswerByIds($ids);
		
		$scores = 0;

		$this->answer->examid = $examid;

		foreach($data as $id=>$answer){
			$id = (int)$id;
			$answer = (int)$answer;
			$answers[$id] = (int)$answers[$id];

			$this->answer->add($id, $answer);
			
			if( $answers[$id] === $answer ){
				$scores += $rule['score'];
			}
		}

		$result = $this->exam->end($examid, $scores);
		echo json_encode($result);
	}	
	
}
