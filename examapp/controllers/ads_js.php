<?php


final class Ads_js extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('ads_model');
	}
	
	
	public function index()
	{
		$adsID = isset($_GET['id']) ? intval($_GET['id']) : exit("document.write(\"此广告不存在\")");
		$adsInfo = $this->ads_model->demail_byID($adsID);
		if(count($adsInfo)==0 || $adsInfo==FALSE) exit("document.write(\"此广告不存在\")");
		//echo $adsInfo['text'];exit;
		//$str = addcslashes($adsInfo['text'], '"');
		//$str = str_replace(array("\r\n", "\n"), "\\\n", $str);
		//$str = str_replace('\\\\', '\\', $str);
		//echo 'document.write("'.$str.'");';
		echo 'document.write(\''.preg_replace("/\r\n|\n|\r/", '\n', addcslashes($adsInfo['text'], "'\\")).'\');';
		
		
	}

	
}
