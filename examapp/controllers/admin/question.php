<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 考试类型相关级别操作<包含界面与模型操作>
 *
 *@date			2012-12-20 18:46:00
 *@database 
 */
final class Question extends CI_Controller
{
	
	public function __construct()
	{
		//header('Content-type: text/html;charset=utf-8');
		parent::__construct();
		
		$this->load->library('session');
		$this->load->model('check');
		$this->load->model('category_model');
		$this->load->model('question_model');
		$this->load->model('message');
		//$this->load->library('admin_cp');
	}

	public function index()
	{
		$categorylist = $this->category_model->getcategory();
		$data['catelist'] = $categorylist;
		$this->load->view('admin/exammanage/questioninfo',$data);
		
	}
	
	public function questionlist()
	{
		
		$list = $this->question_model->getques_all($_GET['page']);
		if($list){
		$data['queslist'] = $list[1];
		$data['pagestr'] = $list[0];
		$this->load->view('admin/exammanage/queslists',$data);
		}
		
		
	}
	public function deleteby_id() {
		
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
		
			if(!empty($_POST['ids'])){
				foreach($_POST['ids'] as $id){
					$id = intval($id);
					$result = $this->question_model->delete($id);
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
					$result = $this->question_model->delete($id);
					if($result){
						$this->message->showmessage('删除成功!',$this->input->server('HTTP_REFERER'));exit();
					}
					else{$this->message->showmessage('删除失败!',$this->input->server('HTTP_REFERER'));exit();}
			}
		}
	}
	
	public function editby_id(){
		
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			
			$imgpath="";
			$newvaluelist=array();
			$options="";
			$title="";
			$csid="";
			$cid="";
			$catid="";
			$editid=$_POST['editid'];
			if (!empty($_FILES["upfile"]["name"])) { //提取文件域内容名称，并判断 
			$path='upload/'; //上传路径 
			if(!file_exists($path)) 
			{ 
			//检查是否有该文件夹，如果没有就创建，并给予最高权限 
			  mkdir('$path', 0700); 
			}//END IF 
			//允许上传的文件格式 
			$tp = array("image/gif","image/pjpeg","image/jpeg","image/png"); 
			//检查上传文件是否在允许上传的类型 
			if(!in_array($_FILES["upfile"]["type"],$tp)) 
			{ 
			echo '<script>alert("格式不对");history.go(-1);</script>'; 
			exit; 
			}//END IF 
			$filetype = $_FILES['upfile']['type']; 
			if($filetype == 'image/jpeg'){ 
			$type = '.jpg'; 
			} 
			if ($filetype == 'image/jpg') { 
			$type = '.jpg'; 
			} 
			if ($filetype == 'image/pjpeg') { 
			$type = '.jpg'; 
			} 
			if($filetype == 'image/gif'){ 
			$type = '.gif'; 
			} 
			if($filetype == 'image/png'){ 
			$type = '.png'; 
			} 
			if($_FILES["upfile"]["name"]) 
			{ 
			$today=date('YmdHis'); //获取时间并赋值给变量 
			$file2 = $path.$today.$type; //图片的完整路径 
			$img = $today.$type; //图片名称 
			$flag=1; 
			}//END IF 
			if($flag){ 
			   $result=move_uploaded_file($_FILES["upfile"]["tmp_name"],$file2); 
			   $imgpath=$file2;
			}
			//特别注意这里传递给move_uploaded_file的第一个参数为上传到服务器上的临时文件 
			}
			else{
				$imgpath=$_POST['imgpath'];
			}
			//这里再将$img的值写入到数据库中对应的字段 
			if($_POST['modelid']!='-1'&&$_POST['level1']!='-1'&&$_POST['level2']!='-1'&&$_POST['level3']!='-1'&&$_POST['qtitle']!=''&&$_POST['selvalue']!=''){
				
				//print_r($_POST['seltext']);
				foreach($_POST['selvalue'] as $key=>$newname) {
				  $newvaluelist[$key] = array('s'=>$newname,'v'=>$_POST['seltext'][$key],'l'=>$_POST['sellevel'][$key]);//"('".$_POST['newsubnumid'][$key]."','".$_POST['fcate']."','','".$_POST['newsubdisplay'][$key]."', '$newname','"')";
				}
				$options=serialize($newvaluelist);
				$title=$_POST['qtitle'];
				$examtype=explode('-',$_POST['modelid']);
				$lone=explode('-',$_POST['level1']);
				$ltwo=explode('-',$_POST['level2']);
				$lthree=explode('-',$_POST['level3']);
				$noselset="-1,00";
				if($_POST['level4']!='-1'){
				  $lfour=explode('-',$_POST['level4']);
				  $cid=$lfour[0];
				}
				else{
				    $lfour=explode(',',$noselset);
					$cid=$lthree[0];
				}
				
				
				$csid=$examtype[1].$lone[1].$ltwo[1].$lthree[1].$lfour[1];
				$catid=$examtype[0].','.$lone[0].','.$ltwo[0].','.$lthree[0].','.$lfour[0];
				
				$status=$this->question_model->editquestion($editid,$csid,$catid,$cid,$options,$imgpath,$title);
				if($status){$this->message->showmessage('编辑成功!',$this->input->server('HTTP_REFERER'));exit();}
				else{$this->message->showmessage('编辑失败!',$this->input->server('HTTP_REFERER'));exit();};
			}
		}
		if(isset($_GET['id']) && !empty($_GET['id'])){
			$categorylist = $this->category_model->getcategory();
			//print_r($categorylist);
		    $data['catelist'] = $categorylist;
			$editid=$_GET['id'];
			$quesinfo = $this->question_model->getinfo_id($editid);
			$data['imgpath'] = $quesinfo['picture'];
			$data['title'] = $quesinfo['question'];
			$idlist=explode(',',$quesinfo['catid']);
			$data['options'] = unserialize($quesinfo['options']);
			$data['examid']= $idlist[0];
			//die($data['examid']);
			$data['select1'] = $this->category_model->edittree_byid(intval($idlist[0]),intval($idlist[1]));
			$data['select2'] = $this->category_model->edittree_byid(intval($idlist[1]),intval($idlist[2]));//需要加函数处理
			$data['select3'] = $this->category_model->edittree_byid(intval($idlist[2]),intval($idlist[3]));
			if($idlist[4]!='-1')
			{$data['select4'] = $this->category_model->edittree_byid(intval($idlist[3]),intval($idlist[4]));}
			else{$data['select4'] = '';}
			//print_r($data['selectcat']);
			$this->load->view('admin/exammanage/quesedit',$data);
		}
		
		
	}
	
	public function addquestion()
	{
		$imgpath="";
		$newvaluelist=array();
		$options="";
		$title="";
		$csid="";
		$cid="";
		$catid="";
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			if (!empty($_FILES["upfile"]["name"])) { //提取文件域内容名称，并判断 
			$path='upload/'; //上传路径 
			if(!file_exists($path)) 
			{ 
			//检查是否有该文件夹，如果没有就创建，并给予最高权限 
			  mkdir('$path', 0700); 
			}//END IF 
			//允许上传的文件格式 
			$tp = array("image/gif","image/pjpeg","image/jpeg","image/png"); 
			//检查上传文件是否在允许上传的类型 
			if(!in_array($_FILES["upfile"]["type"],$tp)) 
			{ 
			echo '<script>alert("格式不对");history.go(-1);</script>'; 
			exit; 
			}//END IF 
			$filetype = $_FILES['upfile']['type']; 
			if($filetype == 'image/jpeg'){ 
			$type = '.jpg'; 
			} 
			if ($filetype == 'image/jpg') { 
			$type = '.jpg'; 
			} 
			if ($filetype == 'image/pjpeg') { 
			$type = '.jpg'; 
			} 
			if($filetype == 'image/gif'){ 
			$type = '.gif'; 
			} 
			if($filetype == 'image/png'){ 
			$type = '.png'; 
			} 
			if($_FILES["upfile"]["name"]) 
			{ 
			$today=date('YmdHis'); //获取时间并赋值给变量 
			$file2 = $path.$today.$type; //图片的完整路径 
			$img = $today.$type; //图片名称 
			$flag=1; 
			}//END IF 
			if($flag){ 
			   $result=move_uploaded_file($_FILES["upfile"]["tmp_name"],$file2); 
			   $imgpath=$file2;
			}
			//特别注意这里传递给move_uploaded_file的第一个参数为上传到服务器上的临时文件 
			}//END IF 
			//这里再将$img的值写入到数据库中对应的字段 
			if($_POST['modelid']!='-1'&&$_POST['level1']!='-1'&&$_POST['level2']!='-1'&&$_POST['level3']!='-1'&&$_POST['qtitle']!=''&&$_POST['selvalue']!=''){
				
				//print_r($_POST['seltext']);
				foreach($_POST['selvalue'] as $key=>$newname) {
				  $newvaluelist[$key] = array('s'=>$newname,'v'=>$_POST['seltext'][$key],'l'=>$_POST['sellevel'][$key]);//"('".$_POST['newsubnumid'][$key]."','".$_POST['fcate']."','','".$_POST['newsubdisplay'][$key]."', '$newname','"')";
				}
				$options=serialize($newvaluelist);
				$title=$_POST['qtitle'];
				$examtype=explode('-',$_POST['modelid']);
				$lone=explode('-',$_POST['level1']);
				$ltwo=explode('-',$_POST['level2']);
				$lthree=explode('-',$_POST['level3']);
				$noselset="-1,00";
				if($_POST['level4']!='-1'){
				  $lfour=explode('-',$_POST['level4']);
				  $cid=$lfour[0];
				}
				else{
				    $lfour=explode(',',$noselset);
					$cid=$lthree[0];
				}
				
				
				$csid=$examtype[1].$lone[1].$ltwo[1].$lthree[1].$lfour[1];
				$catid=$examtype[0].','.$lone[0].','.$ltwo[0].','.$lthree[0].','.$lfour[0];
				
				$status=$this->question_model->addquestion($csid,$catid,$cid,$options,$imgpath,$title);
				if($status){$this->message->showmessage('试题添加成功!',$this->input->server('HTTP_REFERER'));exit();}
				else{$this->message->showmessage('添加失败!',$this->input->server('HTTP_REFERER'));exit();};
			}
			else
			{$this->message->showmessage('试题信息不完整!',$this->input->server('HTTP_REFERER'));exit();}
		}
		
	}
	
	
	
}