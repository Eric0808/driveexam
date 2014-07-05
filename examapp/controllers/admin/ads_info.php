<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 考试类型相关级别操作<包含界面与模型操作>
 *
 *@date			2012-12-20 18:46:00
 *@database 
 */
final class Ads_info extends CI_Controller
{
	
	public function __construct()
	{
		
		parent::__construct();
		
		$this->load->library('session');
		$this->load->model('check');
		$this->load->model('ads_model');
		$this->load->model('message');
		

	}
	
	public function index()
	{
		
		//$arrData = $this->topic_model->Getnextup(3);
		//print_r($arrData);
		//exit;
		//echo $this->config->item('SITEROOT');
		//var_dump(get_included_files());exit();
		//$data['banklist'] = $this->bank_model->Getbanks();
		if(isset($_GET['id']) && !empty($_GET['id'])){
			$id = intval($_GET['id']);
			$adsInfo = $this->ads_model->demail_byID($id);
			$data['ads_info'] = $adsInfo;
			$this->load->view('admin/ads_info/edit_ads',$data);
		}
		else{
		   $this->load->view('admin/ads_info/add_ads');
		}
		
	}
	public function Adslist()
	{
		
		$adsList = $this->ads_model->Getallads($_GET['page'], 20, 10 ,'', ' ORDER BY adsid DESC ');
		if(is_array($adsList)){
		$data['adslist'] = $adsList[1];
		$data['pagestr'] = $adsList[0];
		$this->load->view('admin/ads_info/ads_list',$data);}
		
	}
	
	//发布广告位
	public function Addads()
	{
		$placename = !empty($_POST['ads_place']) ? trim($_POST['ads_place']) : $this->message->showmessage('请填写位置描述!',$this->input->server('HTTP_REFERER'));
		$adsname = !empty($_POST['ads_name']) ? trim($_POST['ads_name']) : $this->message->showmessage('请填写广告描述!',$this->input->server('HTTP_REFERER'));
		$width = !empty($_POST['ads_width']) ? intval($_POST['ads_width']) : 0;
		$height = !empty($_POST['ads_height']) ? intval($_POST['ads_height']) : 0;
		$text = !empty($_POST['ads_text']) ? stripslashes($_POST['ads_text']) : "暂无广告代码";
		$addtime = time();
		
		$valueStr1 = "('".$placename."', '".$adsname."', '".$width."', '".$height."', '".$text."', '".$addtime."')";
		$sqlStr1 = 'INSERT INTO table_info'." (`placename`,`adsname`,`width`,`height`,`text`,`addtime`) VALUES ".$valueStr1.";";
		
		$reId = $this->ads_model->Addads($sqlStr1);
		if($reId)$this->message->showmessage('添加成功!',$this->input->server('HTTP_REFERER'));
		else $this->message->showmessage('添加失败!',$this->input->server('HTTP_REFERER'));
		
	}
	
	public function deleteby_id() {
		
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
		
			if(!empty($_POST['ids'])){
				foreach($_POST['ids'] as $id){
					$id = intval($id);
					$result = $this->ads_model->delads_byID($id);
					if(!$result){
						$this->message->showmessage('删除出错，终止操作!',$this->input->server('HTTP_REFERER'));exit();
					}
				}
				$this->message->showmessage('删除成功!',$this->input->server('HTTP_REFERER'));exit();
			}
			else{
				$this->message->showmessage('你还没有选择任何项!',$this->input->server('HTTP_REFERER'));exit();
			}
		}
		if($_SERVER['REQUEST_METHOD'] == 'GET'){
			if(isset($_GET['ids']) && !empty($_GET['ids'])){
				    $id = intval($_GET['ids']);
					$result = $this->ads_model->delads_byID($id);
					if($result){
						$this->message->showmessage('删除成功!',$this->input->server('HTTP_REFERER'));exit();
					}
					else{$this->message->showmessage('删除失败!',$this->input->server('HTTP_REFERER'));exit();}
			}
		}
	}
	
	public function edit_byid(){
	
		$adsID = !empty($_POST['edit_id']) ? (int)$_POST['edit_id'] : $this->message->showmessage('广告ID丢失无法编辑!',$this->input->server('HTTP_REFERER'));
		$placename = !empty($_POST['ads_place']) ? trim($_POST['ads_place']) : $this->message->showmessage('请填写位置描述!',$this->input->server('HTTP_REFERER'));
		$adsname = !empty($_POST['ads_name']) ? trim($_POST['ads_name']) : $this->message->showmessage('请填写广告描述!',$this->input->server('HTTP_REFERER'));
		$width = !empty($_POST['ads_width']) ? intval($_POST['ads_width']) : 0;
		$height = !empty($_POST['ads_height']) ? intval($_POST['ads_height']) : 0;
		$text = !empty($_POST['ads_text']) ? stripslashes($_POST['ads_text']) : "暂无广告代码";
		
		$updateadsArr = array('placename'=>$placename,
		                        'adsname'=>$adsname,
								'width'=>$width,
								'height'=>$height,
								'text'=>$text);
		
		
		$update_statu = $this->ads_model->edit_byID($updateadsArr, $adsID);
		
		if($update_statu)$this->message->showmessage('编辑成功!',$this->input->server('HTTP_REFERER'));
		else $this->message->showmessage('编辑失败!',$this->input->server('HTTP_REFERER'));
	}
	
	
}