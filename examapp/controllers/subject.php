<?php 


final class Subject extends J_Controller
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{
		$this->load->model('subject_model', 'subject');
		$data = $this->subject->getAll();
		
		$this->load->view('subject', array('subjects'=>$data));
	}
	
	public function change($id=null)
	{
		if( !isset($_SESSION) ){
			session_start();
		}
		unset($_SESSION['randtopicid']);
		
		$this->load->model('subject_model', 'subject');
		$response = $this->subject->getNameById($id);
		if( !is_array($response) || empty($response) ){
			$response = array('id'=>1, 'response'=>'C1科目一');
		}
		echo json_encode($response);
	}
}