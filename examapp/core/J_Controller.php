<?php

class J_Controller extends CI_Controller 
{
	private $data = array();

	public function __construct()
	{
		parent::__construct();
		
		$this->load->library('UserStatus');
		$this->load->helper('url');
		$this->data = array();
	}
	
	public function layout($title, $content, array $setting=array(), $common=TRUE)
	{
		if( $content === 404 ){
			show_404();
			exit;
		}
		if($common){
			$this->load->model('menu_model');
			$this->data['menu'] = $this->menu_model->getMenu();
		    $this->data['current'] = strtolower(get_class($this));
			
		}
		else{ $this->data['current'] = 'exam';}
		
		if(strtolower(get_class($this))=='main')
		{
			$this->data['index_sname'] = $this->config->item('index_site_name');
		}
		
		$this->data['status'] = $this->userstatus->getCode();
		
		$this->data['title'] = $title;
		$this->data['content'] = $content;
		
		$this->data['css'] = array(
			'style', 'box', 'cms'
		);
		$this->data['javascript'] = array(
			'select', 'message', 'load'
		);
		if( isset($this->config->config['keyword']) )
			$this->data['keyword'] = $this->config->config['keyword'];
		if( isset($this->config->config['description']) )
			$this->data['description'] = $this->config->config['description'];
			
		if( isset($_SESSION) && isset($_SESSION['msg']) ){
			$this->data['msg'] = $_SESSION['msg'];
			unset($_SESSION['msg']);
		}
		if( isset($_COOKIE['subjectid']) ){
			$this->load->model('subject_model', 'subject');
			$subjectinfo = $this->subject->getNameById($_COOKIE['subjectid']);
			$this->data['subjectname'] = $subjectinfo['name'];
		}
		foreach($setting as $name=>&$value){
			if( isset($this->data[$name]) ){
				if( is_array($this->data[$name]) ){
					if( is_array($value) ){
						$this->data[$name] = array_merge($this->data[$name], $value);
					}else{
						$this->data[$name][] = $value;
					}
					continue;
				}
			}
			$this->data[$name] = $value;
		}

		if( method_exists($this, 'loadViewBefore') ){
			$this->loadViewBefore($this->data);
		}
		if($common){
		    $this->load->view('layout', $this->data);
		}
		else{
			$this->load->view('t_layout', $this->data);
		}
	}
	
}
