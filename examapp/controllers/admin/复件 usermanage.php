<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 考试类型相关级别操作<包含界面与模型操作>
 *
 *@date			2012-12-20 18:46:00
 *@database 
 */
final class Usermanage extends CI_Controller
{
	
	public function __construct()
	{
		//header('Content-type: text/html;charset=utf-8');
		parent::__construct();
		
		$this->load->library('session');
		$this->load->model('check');
		$this->load->model('user_model');
		$this->load->model('exam_model');
		$this->load->model('message');
		$this->load->model('category_model');
		//$this->load->library('admin_cp');
	}

	public function index()
	{
		$exmaname=$this->category_model->getexamtype();
		//print_r($exmaname);
		if(is_array($exmaname)){
		
			$data['examlist'] = $exmaname;
		}
		$list = $this->user_model->getuser_all($_GET['page']);
		if($list){
		$data['userlist'] = $list[1];
		//print_r($list);
		$data['pagestr'] = $list[0];
		$this->load->view('admin/usermanger/userlists',$data);}
		
	}
	public function remark(){
		$data['category']="'Tokyo',
                    'Jakarta',
                    'New York',
                    'Seoul',
                    'Manila',
                    'Mumbai',
                    'Sao Paulo',
                    'Mexico City',
                    'Dehli',
                    'Osaka'";
				$this->load->view('admin/usermanger/user',$data);	
	}
	
	public function userexam(){
		$result=$this->exam_model->get_userexamlist();
		//print_r($exmaname);
		if($result){
			
			$data['userexamlist'] = $result;
			$this->load->view('admin/usermanger/userexam',$data);
		}
		
		 
	}
	public function lookexam_id(){
		if($_SERVER['REQUEST_METHOD'] == 'GET'){
			if(isset($_GET['uid']) && isset($_GET['cid']) && !empty($_GET['uid']) && !empty($_GET['cid'])){
				    $uid=intval($_GET['uid']);
					$cid=intval($_GET['cid']);
					$result = $this->exam_model->userexam_byid($uid,$cid);
					//print_r($result[0]);
					if($result){
					    $examinfo=$result[0];
						$data['examnames']=$examinfo['name'];
						//echo $examname;
						$catnamelist='';
						
						$data['catscore']='';
						
						$data['total']= 0;
							
						if(!empty($examinfo['evaluation'])){
							$arreval = unserialize($examinfo['evaluation']);
							foreach($arreval as $key=>$value){
								$catnamelist.=$key.',';
								$data['catscore'].=(intval($value['socres'])/10000).',';
								$data['total']+= (intval($value['socres'])/10000);
							}
							
							if(!empty($catnamelist)){
							$data['catlists']=$this->category_model->getname_byids($catnamelist);
							$data['catlists'] = substr($data['catlists'],0,-1);
							//echo $data['catlists'];
							}
							$this->load->view('admin/usermanger/user',$data);
						}
						
					    // print_r (explode(',',$data['catidlist']));
							
					}
					else{$this->message->showmessage('该会员还没有参加测评的记录!',$this->input->server('HTTP_REFERER'));exit();}
			}
		}
	}
	
	public function deleteby_id() {
		$qid=-1;
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
		
			if(!empty($_POST['ids'])){
				foreach($_POST['ids'] as $id){
					$id = intval($id);
					$result = $this->user_model->delete($id);
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
			if(isset($_GET['id']) && !empty($_GET['id'])){
				    $id = intval($_GET['id']);
					$result = $this->user_model->delete($id);
					if($result){
						$this->message->showmessage('删除成功!',$this->input->server('HTTP_REFERER'));exit();
					}
					else{$this->message->showmessage('删除失败!',$this->input->server('HTTP_REFERER'));exit();}
			}
		}
	}
	
	
}