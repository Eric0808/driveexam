<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends J_Controller 
{
	public function __construct()
	{
		parent::__construct();
		
	}
	
	
	public function index()
	{
		$this->load->model('subject_model', 'subject');
		$this->load->model('news_model', 'news');
		$this->load->model('link_model', 'link');	
		
		$this->load->library('globalfunc');
		
		$news = $this->news->getBankList(6);
		$links = $this->link->Getlinks();
		
		$data = $this->subject->getAll();
		foreach($data as &$row){
			$row = array_keys($row['subjects']);
		}
		$subjectinfo = json_encode($data);

		$content = $this->load->view('index', 
					array(
						'subjectinfo'=>$subjectinfo,
						'newslist' => $news,
						'links' => $links
					), true);
				
		$this->layout(null, $content);
	}
	
}
