<?php
class Check extends CI_Model { 
   
    function __construct()
     {
         parent::__construct();
		 $this->load->database();
		 //$this->load->library('session');
		 //$this->load->model('message');
		
		 if($this->session->userdata('manager')=="")
		 {
		    echo '<script type="text/javascript"> if (top.location !== self.location) {top.location = "'.site_url('admin/login').'";}else{window.location.href = "'.site_url('admin/login').'";}</script>';
		 	exit();
		 }
     }
}