<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 考试类型相关级别操作<包含界面与模型操作>
 *
 *@date			2012-12-20 18:46:00
 *@database 
 */
final class Topic_info extends CI_Controller
{
	
	public function __construct()
	{
		
		parent::__construct();
		
		$this->load->library('session');
		$this->load->model('check');
		$this->load->model('bank_model');
		$this->load->model('cate_model');
		$this->load->model('chapter_model');
		$this->load->model('topic_model');
		$this->load->model('message');
		

	}
	
	public function index()
	{
		
		//$arrData = $this->topic_model->Getnextup(3);
		//print_r($arrData);
		//exit;
		//echo $this->config->item('SITEROOT');
		//var_dump(get_included_files());exit();
		$this->session->unset_userdata('upload_image');
		$this->session->unset_userdata('upload_thumb');
		if(isset($_GET['id']) && !empty($_GET['id'])){
			$data['catelist'] = $this->cate_model->Getcategory();
			$data['banklist'] = $this->bank_model->Getbanks();
			$data['chapterlist'] = $this->chapter_model->Getchapter();
			$tID = intval($_GET['id']);
			$topicDetail = $this->topic_model->Detail($tID);
			//print_r($topicDetail);exit;
		    $data['topic'] = $topicDetail;
			$this->load->view('admin/topic_info/edit_topic',$data);
		}
		else{
			$data['catelist'] = $this->cate_model->Getcategory();
			$data['banklist'] = $this->bank_model->Getbanks();
			$data['chapterlist'] = $this->chapter_model->Getchapter();
			$this->load->view('admin/topic_info/add_topic',$data);
		}
		
	}
	/*试题列表*/
	public function Topiclist(){
		$where = "";
		
		$cPage = isset($_GET['page'])? intval($_GET['page']) : 1;
		if($cPage == 1){
		   $this->session->unset_userdata('sersql');
		   $this->session->unset_userdata('s_like');
		   $this->session->unset_userdata('s_bank');
		   $this->session->unset_userdata('s_cate');
		    $this->session->set_userdata(array('s_type'=>'-1'));
		   $this->session->unset_userdata('s_chapter');
		}
		//试题检索
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
			$sLike = !empty($_POST['ser_tilte']) ? " `question` LIKE '%" . str_replace("\'", "\"", trim($_POST['ser_tilte'])) ."%' "  : "";
			if(empty($sLike))
			{$sBank = $_POST['ser_bank']!='-1' ? " `bankid` LIKE '%" .$_POST['ser_bank'].",%' " : "";}
			else{$sBank = $_POST['ser_bank']!='-1' ? " AND `bankid` LIKE '%" .$_POST['ser_bank'].",%' " : "";}
			if(empty($sBank) && empty($sLike))
			{$sCate = $_POST['ser_cate']!='-1' ? " `catalog`=" . intval($_POST['ser_cate']) : "";}
			else{$sCate = $_POST['ser_cate']!='-1' ? " AND `catalog`=" . intval($_POST['ser_cate']) : "";}
			if(empty($sBank) && empty($sLike) && empty($sCate))
			{$sType = $_POST['ser_type']!='-1' ? " `type`=" . intval($_POST['ser_type']) : "";}
			else{$sType = $_POST['ser_type']!='-1' ? " AND `type`=" . intval($_POST['ser_type']) : "";}
			if(empty($sBank) && empty($sLike) && empty($sCate) && empty($sType))
			{$schapter = $_POST['ser_chapter']!='-1' ? " `chapid`=" . intval($_POST['ser_chapter']) : "";}
			else{$schapter = $_POST['ser_chapter']!='-1' ? " AND `chapid`=" . intval($_POST['ser_chapter']) : "";}
			
			if(!(empty($sLike) && empty($sBank) && empty($sCate) && empty($sType) && empty($schapter))){
			   $where = ' WHERE ' . $sLike . $sBank . $sCate . $sType . $schapter;
			   $this->session->set_userdata(array('sersql'=>$where));
			   $this->session->set_userdata(array('s_like'=>$_POST['ser_tilte']));
			   $this->session->set_userdata(array('s_bank'=>$_POST['ser_bank']));
			   $this->session->set_userdata(array('s_cate'=>$_POST['ser_cate']));
			   $this->session->set_userdata(array('s_type'=>$_POST['ser_type']));
			   $this->session->set_userdata(array('s_chapter'=>$_POST['ser_chapter']));
			}
			else{$this->session->set_userdata(array('sersql'=>''));}
		
		}
		$answerArr = array();
		$arrAnswer = $this->config->item('Answer');
		foreach($arrAnswer as $key=>$value){
			$answerArr[$value] = $key;
		}
		
		$topicList = $this->topic_model->Getalltopics($cPage, 20, 10 , $this->session->userdata('sersql'), ' ORDER BY t.id DESC ');
		if(is_array($topicList)){
		$data['topiclist'] = $topicList[1];
		$data['pagestr'] = $topicList[0];
		$data['answer'] = $answerArr;
		$data['catelist'] = $this->cate_model->Getcategory();
		$data['banklist'] = $this->bank_model->Getbanks();
		$data['chapterlist'] = $this->chapter_model->Getchapter();
		//$data['s_like'] = $sLike;
		//$data['s_bank'] = $sBank;
		//$data['s_cate'] = $sCate;
		//$data['s_type'] = $sType;
		//$data['s_chapter'] = $schapter;
		$this->load->view('admin/topic_info/topic_lists',$data);}
	}
	
	/*试题详情*/
	public function Detailby_id(){
		$tID = isset($_GET['id']) ? intval($_GET['id']) : die('缺失参数！');
		$answerArr = array();
		$arrAnswer = $this->config->item('Answer');
		foreach($arrAnswer as $key=>$value){
			$answerArr[$value] = $key;
		}
		$topicDetail = $this->topic_model->Detail($tID);
		$data['topic'] = $topicDetail;
		$data['answer'] = $answerArr;
		$data['imgurl'] = ROOT_PATH . 'uploads/';
		$this->load->view('admin/topic_info/topic_detail',$data);
	
	}
	
	public function Makestaticfile()
	{
		if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['domake']=='1'){
			$num = 0;
			$this->load->helper('file');
			if(!delete_files($this->config->item('SITEROOT').'/jieshi/'))
			{
				echo '文件或目录没有权限';EXIT();
			}
			//exit;
			$topicAll = $this->topic_model->Detail('ALL');
			foreach($topicAll as $key=>$topicArr)
			{	
				$topicArr['explianId'] = $this->topic_model->GetexplainID_bytid($topicArr['id']);
				$content = $this->load->view('admin/topic_info/explain_info',$topicArr, true);
					if ( !write_file($this->config->item('SITEROOT').'/jieshi/'.$topicArr['explianId'].'.html', $content))//生成html题解文件
					  {
						echo '文件或目录不可写';EXIT();
					  }
					  $num++;
			}
			$this->message->showmessage('生成成功!共生成'.$num.'个题解文件',$this->input->server('HTTP_REFERER'));exit();
		}
		else{$this->load->view('admin/topic_info/makeexplain');}
	}
	
	/*删除试题和题解*/
	public function Deletetopic(){
		
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
		
			if(!empty($_POST['ids'])){
				foreach($_POST['ids'] as $id){
					$id = intval($id);
					$explainID = $this->topic_model->GetexplainID_bytid($id);
					$result = $this->topic_model->Delete_bytid($id);
					if(!$result){
						$this->message->showmessage('删除出错，终止操作!',$this->input->server('HTTP_REFERER'));exit();
					}
					else{
						//删除文件
						$this->globalfunc->Delete_File($this->config->item('SITEROOT').'/data/question/'.$id.'.txt');
						$this->globalfunc->Delete_File($this->config->item('SITEROOT').'/jieshi/'.$explainID.'.html');
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
					$explainID = $this->topic_model->GetexplainID_bytid($id);
					$result = $this->topic_model->Delete_bytid($id);
					if($result){
						//删除文件
						$this->globalfunc->Delete_File($this->config->item('SITEROOT').'/data/question/'.$id.'.txt');
						$this->globalfunc->Delete_File($this->config->item('SITEROOT').'/jieshi/'.$explainID.'.html');
						$this->message->showmessage('删除成功!',$this->input->server('HTTP_REFERER'));exit();
					}
					else{$this->message->showmessage('删除失败!',$this->input->server('HTTP_REFERER'));exit();}
			}
		}
	
	}
	
	/*发布新的试题*/
	public function Addtopic()
	{	
		$arrAnswer = $this->config->item('Answer');
		$topicName = !empty($_POST['topic_name']) ? trim($_POST['topic_name']) : $this->message->showmessage('题目不能为空!',$this->input->server('HTTP_REFERER'));
		$bankId = ($_POST['bankid']!='-1') ? implode(',', $_POST['bankid']).',' : $this->message->showmessage('请选择题库!',$this->input->server('HTTP_REFERER'));//debug
		$cateId = ($_POST['cateid']!='-1') ? $_POST['cateid'] : $this->message->showmessage('请选择题型!',$this->input->server('HTTP_REFERER'));
		$chapId = ($_POST['chapterid']!='-1') ? $_POST['chapterid'] : $this->message->showmessage('请选择章节!',$this->input->server('HTTP_REFERER'));
		$answer = 0;
		$item1 = $item2 = $item3 = $item4 = $image = $thumb = $explain = "";
		//单选or多选
		if(!in_array('', $_POST['answer']) && isset($_POST['yes']) && !isset($_POST['yes_no'])){
			$item1 = trim($_POST['answer'][0]);
			$item2 = trim($_POST['answer'][1]);
			$item3 = trim($_POST['answer'][2]);
			$item4 = trim($_POST['answer'][3]);
			$explain = trim($_POST['explain']);
			if(count($_POST['yes'])== 1){
			   $answer = $arrAnswer[$_POST['yes'][0]];
			   $type = 1;
			   }
			else{
				$answerStr = implode('', $_POST['yes']);
				$answer = $arrAnswer[$answerStr];
				$type = 2;
				 }
			
			if($this->session->userdata('upload_image')!='' && $this->session->userdata('upload_thumb')!=''){
			   $image = $this->session->userdata('upload_image');
			   $thumb = $this->session->userdata('upload_thumb');
			}
		}
		//什么都没选
		if(!isset($_POST['yes']) && !isset($_POST['yes_no'])){$this->message->showmessage('请选择正确答案!',$this->input->server('HTTP_REFERER'));}
		//正确or错误
		
		if(implode('', $_POST['answer'])=="" && !isset($_POST['yes']) && isset($_POST['yes_no'])){
			$item1 = '正确';
			$item2 = '错误';
			$explain = trim($_POST['explain']);
			$answer = intval($_POST['yes_no'][0]);
			$type = 0;
			if($this->session->userdata('upload_image')!='' && $this->session->userdata('upload_thumb')!=''){
			   $image = $this->session->userdata('upload_image');
			   $thumb = $this->session->userdata('upload_thumb');
			}
		}
		
		$valueStr1 = "('".$topicName."', '".$answer."', '".$image."', '".$thumb."', '".$type."', '".$item1."', '".$item2."', '".$item3."', '".$item4."', '".$cateId."', '".$bankId."', '".$chapId."')";
		$sqlStr1 = 'INSERT INTO table_info'." (`question`,`answer`,`image`,`thumb`,`type`,`item1`,`item2`,`item3`,`item4`,`catalog`,`bankid`,`chapid`) VALUES ".$valueStr1.";";
		
		$topicId = $this->topic_model->Addtopic($sqlStr1);
		if($topicId){
		
			$valueStr2 = "('".$topicId."', '".$explain."')";
		    $sqlStr2 = 'INSERT INTO table_info'." (`topicid`,`explain`) VALUES ".$valueStr2.";";
			$explianId = $this->topic_model->Addexplain($sqlStr2);
			
			if($explianId){
			
				$arrData = array('id'=>$topicId, 'question'=>$topicName, 'answer'=>$answer, 'image'=>$image, 'thumb'=>$thumb, 'type'=>$type, 'item1'=>$item1, 'item2'=>$item2, 'item3'=>$item3, 'item4'=>$item4, 'explain'=>$explain, 'explainid'=>$explianId);
				$jsonData = json_encode($arrData);
				$this->globalfunc->Createtxt($this->config->item('SITEROOT').'/data/question', $topicId, $jsonData);//生成txt文件
				
				$content = $this->load->view('admin/topic_info/explain_info',$arrData, true);
				$this->load->helper('file');
				
				if ( !write_file($this->config->item('SITEROOT').'/jieshi/'.$explianId.'.html', $content))//生成html题解文件
				  {
					echo '文件或目录不可写';EXIT();
				  }
			    $this->message->showmessage('试题添加成功!',$this->input->server('HTTP_REFERER'));
			}
			else{$this->message->showmessage('添加失败!',$this->input->server('HTTP_REFERER'));}
			 
		}
		else{$this->message->showmessage('添加失败!',$this->input->server('HTTP_REFERER'));}
		
	}
	
	/*批量导入章节*/
	public function Movechapter(){
		
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
		
			if(!empty($_POST['ids'])){
				$updatearr = array();
				if($_POST['mov_chapter']=='-1' && $_POST['mov_cate']=='-1'){$this->message->showmessage('请选择要导入的章节或者题型类别!',$this->input->server('HTTP_REFERER'));exit();}
				if($_POST['mov_chapter']!='-1'){$updatearr['chapid'] = (int)$_POST['mov_chapter']; }
				if($_POST['mov_cate']!='-1'){$updatearr['catalog'] = (int)$_POST['mov_cate']; }

				foreach($_POST['ids'] as $id){
					$id = intval($id);
					$result = $this->topic_model->Updatechapter_byid($updatearr, $id);
					if(!$result){
						$this->message->showmessage('导入出错，终止操作!',$this->input->server('HTTP_REFERER'));exit();
					}
				}
				$this->message->showmessage('导入成功!',$this->input->server('HTTP_REFERER'));exit();
			}
			else{
				$this->message->showmessage('你还没有选择任何项!',$this->input->server('HTTP_REFERER'));exit();
			}
		}
	}
	
	/*编辑试题*/
	public function Edit_topic()
	{	
		
		$topicID = !empty($_POST['edit_id']) ? (int)$_POST['edit_id'] : $this->message->showmessage('试题ID丢失无法编辑!',$this->input->server('HTTP_REFERER'));
		$explainID = $this->topic_model->GetexplainID_bytid($topicID);
		//编辑之前先删除文件
		$this->globalfunc->Delete_File($this->config->item('SITEROOT').'/data/question/'.$topicID.'.txt');
		$this->globalfunc->Delete_File($this->config->item('SITEROOT').'/jieshi/'.$explainID.'.html');
		
		$arrAnswer = $this->config->item('Answer');
		$topicName = !empty($_POST['topic_name']) ? trim($_POST['topic_name']) : $this->message->showmessage('题目不能为空!',$this->input->server('HTTP_REFERER'));
		$bankId = ($_POST['bankid']!='-1') ? implode(',', $_POST['bankid']).',' : $this->message->showmessage('请选择题库!',$this->input->server('HTTP_REFERER'));//debug
		$cateId = ($_POST['cateid']!='-1') ? $_POST['cateid'] : $this->message->showmessage('请选择题型!',$this->input->server('HTTP_REFERER'));
		$chapId = ($_POST['chapterid']!='-1') ? $_POST['chapterid'] : $this->message->showmessage('请选择章节!',$this->input->server('HTTP_REFERER'));
		$answer = 0;
		$item1 = $item2 = $item3 = $item4 = $image = $thumb = $explain = "";
		//单选or多选
		if(!in_array('', $_POST['answer']) && isset($_POST['yes']) && !isset($_POST['yes_no'])){
			$item1 = trim($_POST['answer'][0]);
			$item2 = trim($_POST['answer'][1]);
			$item3 = trim($_POST['answer'][2]);
			$item4 = trim($_POST['answer'][3]);
			$explain = trim($_POST['explain']);
			if(count($_POST['yes'])== 1){
			   $answer = $arrAnswer[$_POST['yes'][0]];
			   $type = 1;
			   }
			else{
				$answerStr = implode('', $_POST['yes']);
				$answer = $arrAnswer[$answerStr];
				$type = 2;
				 }
			
			if($this->session->userdata('upload_image')!='' && $this->session->userdata('upload_thumb')!=''){
			   $image = $this->session->userdata('upload_image');
			   $thumb = $this->session->userdata('upload_thumb');
			}
			else{
				$image = $_POST['edit_image'];
			    $thumb = $_POST['edit_thumb'];
			}
		}
		//什么都没选
		if(!isset($_POST['yes']) && !isset($_POST['yes_no'])){$this->message->showmessage('请选择正确答案!',$this->input->server('HTTP_REFERER'));}
		//正确or错误
		if(implode('', $_POST['answer'])=="" && !isset($_POST['yes']) && isset($_POST['yes_no'])){
			$item1 = '正确';
			$item2 = '错误';
			$explain = trim($_POST['explain']);
			$answer = intval($_POST['yes_no'][0]);
			$type = 0;
			if($this->session->userdata('upload_image')!='' && $this->session->userdata('upload_thumb')!=''){
			   $image = $this->session->userdata('upload_image');
			   $thumb = $this->session->userdata('upload_thumb');
			}
			else{
				$image = $_POST['edit_image'];
			    $thumb = $_POST['edit_thumb'];
			}
		}
		$updatetopicArr = array('question'=>$topicName,
		                        'answer'=>$answer,
								'image'=>$image,
								'thumb'=>$thumb,
								'type'=>$type,
								'item1'=>$item1,
								'item2'=>$item2,
								'item3'=>$item3,
								'item4'=>$item4,
								'catalog'=>$cateId,
								'bankid'=>$bankId,
								'chapid'=>$chapId);
		
		
		$update_statu = $this->topic_model->Updatetopic_byid($updatetopicArr, $topicID);
		if($update_statu){
		
			$updateexplainArr = array('explain'=>$explain);
			$statu = $this->topic_model->Updateexplain_byid($updateexplainArr, $explainID);
			
			if($statu){
			
				$arrData = array('id'=>$topicID, 'question'=>$topicName, 'answer'=>$answer, 'image'=>$image, 'thumb'=>$thumb, 'type'=>$type, 'item1'=>$item1, 'item2'=>$item2, 'item3'=>$item3, 'item4'=>$item4, 'explain'=>$explain, 'explainid'=>$explainID);
				$jsonData = json_encode($arrData);
				$this->globalfunc->Createtxt($this->config->item('SITEROOT').'/data/question', $topicID, $jsonData);//生成txt文件
				
				$content = $this->load->view('admin/topic_info/explain_info',$arrData, true);
				$this->load->helper('file');
				
				if ( !write_file($this->config->item('SITEROOT').'/jieshi/'.$explainID.'.html', $content))//生成html题解文件
				  {
					echo '文件或目录不可写';EXIT();
				  }
			    $this->message->showmessage('试题编辑成功!',$this->input->server('HTTP_REFERER'));
			}
			else{$this->message->showmessage('试题编辑失败!',$this->input->server('HTTP_REFERER'));}
			 
		}
		else{$this->message->showmessage('试题编辑失败!',$this->input->server('HTTP_REFERER'));}
		
	}
	
	/*采集试题数据*/
	public function Topicspider(){exit('暂不可用');
		set_time_limit(0);
		header("Content-Type: text/html; charset=UTF-8");
		$arr1 = array(
		array('min'=>1,'max'=>365,'bankid'=>'1,3,5,','chapter'=>1),
		array('min'=>366,'max'=>677,'bankid'=>'1,3,5,','chapter'=>2),
		array('min'=>678,'max'=>864,'bankid'=>'1,3,5,','chapter'=>3),
		array('min'=>865,'max'=>973,'bankid'=>'1,3,5,','chapter'=>4),
		array('min'=>974,'max'=>1025,'bankid'=>'5,','chapter'=>14),
		array('min'=>1026,'max'=>1091,'bankid'=>'3,','chapter'=>13)
	)
	
	$arr2 = array(
		array('min'=>1537,'max'=>1573,'bankid'=>'2,','chapter'=>5),
		array('min'=>1574,'max'=>1765,'bankid'=>'2,','chapter'=>6),
		array('min'=>1766,'max'=>1980,'bankid'=>'2,','chapter'=>7),
		array('min'=>1981,'max'=>2042,'bankid'=>'2,','chapter'=>8),
		array('min'=>2043,'max'=>2207,'bankid'=>'2,','chapter'=>9),
		array('min'=>2208,'max'=>2301,'bankid'=>'2,','chapter'=>10),
		array('min'=>2302,'max'=>2336,'bankid'=>'2,','chapter'=>11)
	)
	
	$arr3 = array(
		array('min'=>1,'max'=>33,'bankid'=>'4,6,','chapter'=>5),
		array('min'=>34,'max'=>300,'bankid'=>'4,6,','chapter'=>6),
		array('min'=>301,'max'=>492,'bankid'=>'4,6,','chapter'=>7),
		array('min'=>493,'max'=>595,'bankid'=>'4,6,','chapter'=>8),
		array('min'=>596,'max'=>847,'bankid'=>'4,6,','chapter'=>9),
		array('min'=>848,'max'=>981,'bankid'=>'4,6,','chapter'=>10),
		array('min'=>982,'max'=>1023,'bankid'=>'4,6,','chapter'=>11)
	)	
		foreach($arr1 as $value){
		
			for($i= $value['min']; $i<=$value['max'];$++){
			
				$txtUrl = "http://vip.jxedt.com/vip2013/GetQuestion?id=$i";
				$getContent = @file_get_contents($txtUrl);
				$getContent = trim($getContent, chr(239) . chr(187) . chr(191));
				if(!empty($getContent)){
				   $arrData = json_decode($getContent,true);
				   if(is_array($arrData)){$this->PostTopic($arrData, $value['bankid'],$value['chapter']);}
				   else continue;
				}
				else{continue;}
				}
		}
	
	}
	/*抓取试题并入库*/
	public function PostTopic($arrData, $bankId,$cid)
	{
		$arrAnswer = $this->config->item('Answer1');
		$topicName = $arrData['question'];
		$bankId = $bankId;
		$cateId = 1;
		$answer = $arrAnswer[$arrData['ta']];
		$item1 = $item2 = $item3 = $item4 = $image = $thumb = $explain = "";
		//单选or多选
		$item1 = $arrData['a'];
		$item2 = $arrData['b'];
		$item3 = $arrData['c'];
		$item4 = $arrData['d'];
		$explain = $arrData['bestanswer'];
		if($arrData['type']=='1'){$type = 0;}
		if($arrData['type']=='2'){$type = 1;}
		if($arrData['type']=='3'){$type = 2;}
		
		$image = $arrData['imageurl']!="" ? $this->DownFile($arrData['imageurl'], "") : "";
	   
		$valueStr1 = "('".$topicName."', '".$answer."', '".$image."', '".$cid."', '".$type."', '".$item1."', '".$item2."', '".$item3."', '".$item4."', '".$cateId."', '".$bankId."')";
		$sqlStr1 = 'INSERT INTO table_info'." (`question`,`answer`,`image`,`chapid`,`type`,`item1`,`item2`,`item3`,`item4`,`catalog`,`bankid`) VALUES ".$valueStr1.";";
		
		$topicId = $this->topic_model->Addtopic($sqlStr1);
		
		if($topicId){
		
			$valueStr2 = "('".$topicId."', '".$explain."')";
		    $sqlStr2 = 'INSERT INTO table_info'." (`topicid`,`explain`) VALUES ".$valueStr2.";";
			$explianId = $this->topic_model->Addexplain($sqlStr2);
			if($explianId){
			
				$arrData = array('id'=>$topicId, 'question'=>$topicName, 'answer'=>$answer, 'image'=>$image, 'thumb'=>$thumb, 'type'=>$type, 'item1'=>$item1, 'item2'=>$item2, 'item3'=>$item3, 'item4'=>$item4, 'explain'=>$explain, 'explainid'=>$explianId);
				$jsonData = json_encode($arrData);
				$this->globalfunc->Createtxt($this->config->item('SITEROOT').'/data/question', $topicId, $jsonData);//生成txt文件
				}
		}
		
	}
	/*抓取文件下载*/
	public function DownFile($url, $filename){
		$targetFolder = '/uploads';
		$targetPath = $this->config->item('SITEROOT') . $targetFolder;
		if($url==""):return '';endif; 
		if($filename=="") { 
			$ext=strrchr($url,"."); 
			if($ext!=".gif" && $ext!=".jpg" && $ext!=".swf"):return '';endif; 
			
			$time = date('YmdHis');
			$string = 'abcdefghijklmnopgrstuvwxyz0123456789';
			$rand = '';
			for ($x=0;$x<5;$x++){
				$rand .= substr($string,mt_rand(0,strlen($string)-1),1);}
			$newFile = $time . $rand;
			
			$filename=$newFile.$ext; 
			$truename = rtrim($targetPath,'/') . '/' . $filename;
		}
		else{
			$arrname = explode('.', $filename);
			$arrname[0].='_thumb';
			$filename = implode('.',$arrname);
			$truename = rtrim($targetPath,'/') . '/' . $filename;
        }		
		ob_start(); 
		readfile($url);
		$img = ob_get_contents(); 
		ob_end_clean();
		//$size = strlen($img); 
		$fp2=@fopen($truename, "a"); 
		fwrite($fp2,$img); 
		fclose($fp2); 
		return $filename; 
	
	}
	
	
	/*获取当前题解的上一条和下一条*/
	public function Getnextup(){
		$eId = isset($_GET['eid']) ? intval($_GET['eid']) : 2;
		$aboutData = $this->topic_model->Getnextup($eId);
		$baseUrl = base_url();
		$uptitle = $nextTitle = $reStr = '';
		if(count($aboutData)==2 && count($aboutData[0])!=0){
			$uptitle = "上一篇: <a href=\"{$baseUrl}jieshi/{$aboutData[0]['id']}.html\" title=\"{$aboutData[0]['question']}\">{$aboutData[0]['question']}</a><br />";
		}
		if(count($aboutData)==2 && count($aboutData[1])!=0){
			$nextTitle = "下一篇: <a href=\"{$baseUrl}jieshi/{$aboutData[1]['id']}.html\" title=\"{$aboutData[1]['question']}\">{$aboutData[1]['question']}</a><br />";
		}
		$reStr = $uptitle . $nextTitle;
		echo 'document.write("'.addcslashes($reStr, '"').'");';
		
	}
	
	/*试题图片上传*/
	public function Uploadify()
	{
		$targetFolder = '/uploads';

		$verifyToken = md5('unique_salt' . $_POST['timestamp']);

		if (!empty($_FILES) && $_POST['token'] == $verifyToken) {
			$tempFile = $_FILES['Filedata']['tmp_name'];
			$targetPath = $this->config->item('SITEROOT') . $targetFolder;
			$newFile = explode('.', $_FILES['Filedata']['name']);
			$time = date('YmdHis');
			$string = 'abcdefghijklmnopgrstuvwxyz0123456789';
			$rand = '';
			for ($x=0;$x<5;$x++){
				$rand .= substr($string,mt_rand(0,strlen($string)-1),1);}
			$newFile[0] = $time . $rand;
			$uploadName = implode('.', $newFile);
			$targetFile = rtrim($targetPath,'/') . '/' . $uploadName;
			
			// Validate the file type
			$fileTypes = array('jpg','jpeg','gif','png','swf'); // File extensions
			$fileParts = pathinfo($_FILES['Filedata']['name']);
			
			if (in_array($fileParts['extension'],$fileTypes)) {
				@chmod($targetPath, 0777);
				move_uploaded_file($tempFile,$targetFile);
				
				if($this->session->userdata('upload_image')!='' && $this->session->userdata('upload_thumb')!=''){
					$this->session->unset_userdata('upload_image');
					$this->session->unset_userdata('upload_thumb');
					if($newFile[1] == "swf"){
						$this->session->set_userdata(array('upload_image'=>$uploadName));
						$this->session->set_userdata(array('upload_thumb'=>''));
					}
					else{
						$this->session->set_userdata(array('upload_image'=>$uploadName));
						$this->session->set_userdata(array('upload_thumb'=>str_replace('.', '_thumb.', $uploadName)));
					}
				}
				else{
					if($newFile[1] == "swf"){
						$this->session->set_userdata(array('upload_image'=>$uploadName));
						$this->session->set_userdata(array('upload_thumb'=>''));
					}
					else{
						$this->session->set_userdata(array('upload_image'=>$uploadName));
						$this->session->set_userdata(array('upload_thumb'=>str_replace('.', '_thumb.', $uploadName)));
					}
				}
				echo '1';
			} else {
				echo 'Invalid file type.';
			}
		}
	}
	
	////////////////////////////
	
	
	
	
}