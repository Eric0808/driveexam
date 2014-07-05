<?php

final class Scores extends J_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->uid = $this->userstatus->getUserID();
	}

	public function index()
	{
		$this->load->model('exam_model', 'exam');
		
		$data = $this->exam->get($this->uid);
		
		$result = array();
		foreach($data as &$row){
			if( ! $this->exam->notend($row) ){
				$result[] = $row;
			}
		}
		
		$content = $this->load->view('scores/list', array('list'=>$result), true);
		
		$this->layout('历史成绩', $content);
	}
	
	
	public function detail($examid=null)
	{
		if( empty($examid) || !is_numeric($examid) ){
			$_SESSION['msg'] = '请选择要查看的考试';
			header('Location: '.base_url().'scores/');
			exit;
		}
		$this->load->model('exam_model', 'exam');
		$data = $this->exam->get(null, $examid);

		if( empty($data) ){
			$_SESSION['msg'] = '您未参加过本次考试，也可能是本次考试数据已经被删除了';
			header('Location: '.base_url().'scores/');
			exit;
		}
		
		
		$this->load->model('answer_model', 'answer');
		
		if( !isset($_GET['select']) )	$_GET['select'] = '';
		switch(@$_GET['select']){
			case 'error':
				$where = "`t`.`answer` != `a`.`answer` AND `a`.`answer`!='0' AND `a`.`examid`={$examid}";
			break;
			case 'right':
				$where = "`t`.`answer` = `a`.`answer` AND `a`.`examid`={$examid}";
			break;
			case 'none':
				$where = "`a`.`answer` = '0' AND `a`.`examid`={$examid}";
			break;
			default:
				$list = $this->answer->getByWhere($examid, false, false);
		}
		if( !isset($list) && !empty($where) ){
			$list = $this->answer->getAllTopic($where, '`t`.*, `a`.`answer` as useranswer');
		}
		
		
		$this->load->helper('showItem_helper');
		
		$where = "`t`.`answer` != `a`.`answer` AND `a`.`answer`!='0' AND `a`.`examid`={$examid}";
		$result = $this->answer->getAllTopic($where, 'COUNT(`topicid`) as `count`');
		$wrong = $result[0]['count'];
		
		$where = "`t`.`answer` = `a`.`answer` AND `a`.`examid`={$examid}";
		$result = $this->answer->getAllTopic($where, 'COUNT(`topicid`) as `count`');
		$right = $result[0]['count'];
		
		$where = "`a`.`answer`='0' AND `a`.`examid`={$examid}";
		$result = $this->answer->getAllTopic($where, 'COUNT(`topicid`) as `count`');
		$none = $result[0]['count'];
		
		
		$content = $this->load->view('scores/detail', 
			array('list'=>$list, 'examid'=>$examid, 'data'=>@$data[0],
				'right' => $right, 'wrong' => $wrong, 'none' => $none
				),
			true);
		
		$this->layout('历史考试详情', $content);
	}
	
	
	public function redo($examid=null)
    {
		if( empty($examid) || !is_numeric($examid) ){
			header('Location: '.base_url().'scores/');
			exit;
		}
        $title = '错题重做';
		
		$this->load->model('answer_model', 'answer');
		$where = "`t`.`answer` != `a`.`answer` AND `a`.`examid`={$examid}";
		$result = $this->answer->getAllTopic($where, 'GROUP_CONCAT(`topicid`) as `ids`');

		$data = array(
            'title' => $title,
            'ids'=> "[{$result[0]['ids']}]"
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
	
	public function addwrong($examid=null)
	{
		if( empty($examid) || !is_numeric($examid) ){
			header('Location: '.base_url().'scores/');
			exit;
		}
		
		$this->load->model('answer_model', 'answer');
		$where = "`t`.`answer` != `a`.`answer` AND `a`.`examid`={$examid}";
		$list = $this->answer->getAllTopic($where, '`t`.`id`, `a`.`answer`');

		$this->load->model('wrong_model', 'wrong');

		$uid = $this->userstatus->getUserID();

		
		if(is_array($list)){
			foreach($list as $item){
				$this->wrong->add($uid, $item['id'], $item['answer']) ? $success++ : $success--;
			}
		}
		
		$_SESSION['msg'] = "已成功将{$success}条错题和未答的题加入错题库";
		header('Location: '. base_url().'scores/detail/'.$examid);
	}
}