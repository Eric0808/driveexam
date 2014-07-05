<?php

final class Chapter extends J_Controller
{
	public function index()
	{
		$this->load->model('chapter_model', 'chapter');
		$this->load->model('subject_model', 'subject');
		
		$result = $this->subject->getNameById(@$_COOKIE['subjectid'], true);
		$charpters = '';
		$charpters .= $result['chaperid'].',';
		$charpters = explode(',', $charpters);
		$charpters = array_unique($charpters);
		
		$lists = $this->chapter->getListById($charpters);
		
		$content = $this->load->view('chapter/list', array('lists'=>$lists), true);
		$this->layout('章节练习', $content);
	}
	
}