<?php 


final class City extends J_Controller
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function index()
	{
		$this->load->model('city_model', 'city');
		$data = $this->city->Getcitys();
		$citys = array();

		foreach($data as $info){
			$info = get_object_vars($info);
			$info['id'] = (int)$info['id'];
			$citys[$info['key']][] = array(
				$info['id']=>$info['name'] );
		}
		
		$this->load->view('area', array('citys'=>$citys));
	}
	
	public function change($id=null)
	{
		if( ! is_null($id) ){
			$this->load->model('city_model', 'city');
			$city = $this->city->Getcity($id);
		}
		if( !isset($city) || empty($city) )	$city = '全国';
		setcookie('city', $city, time()+3600*24*30, '/');
		echo $city;
	}
}