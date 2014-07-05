<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 考试类型相关级别操作<包含界面与模型操作>
 *
 *@date			2012-12-20 18:46:00
 *@database 
 */
final class News_info extends CI_Controller
{
	
	public function __construct()
	{
		
		parent::__construct();
		
		$this->load->library('session');
		$this->load->model('check');
		$this->load->model('bank_model');
		$this->load->model('news_model');
		$this->load->model('message');
		

	}
	
	public function index()
	{
		
		//$arrData = $this->topic_model->Getnextup(3);
		//print_r($arrData);
		//exit;
		//echo $this->config->item('SITEROOT');
		//var_dump(get_included_files());exit();
		
		$data['banklist'] = $this->bank_model->Getbanks();
		if(isset($_GET['id']) && !empty($_GET['id'])){	
			$data['editid'] = (int)$_GET['id'];
			$data['newsinfo'] = $this->news_model->Detail_byID(intval($_GET['id']));
			$this->load->view('admin/news_info/edit_news',$data);
		}
		else{
		   $this->load->view('admin/news_info/post_news',$data);
		}
		
		
	}
	public function Newslist()
	{
		
		$newsList = $this->news_model->Getallnews($_GET['page'], 20, 10 ,'', ' ORDER BY n.updatetime DESC ');
		if(is_array($newsList)){
		$data['newslist'] = $newsList[1];
		$data['pagestr'] = $newsList[0];
		$this->load->view('admin/news_info/news_list',$data);}
		
	}
	
	//发布文章
	public function Postnews()
	{
		$title = !empty($_POST['title']) ?  htmlspecialchars(trim($_POST['title']),ENT_QUOTES) : $this->message->showmessage('请填写标题!',$this->input->server('HTTP_REFERER'));
		if(isset($_POST['isbank']) && $_POST['bankid'] == '-1') $this->message->showmessage('您选择了发布题库，但未选择绑定的题库!',$this->input->server('HTTP_REFERER'));
		if(trim($_POST['elm1']) == '' && !isset($_POST['isbank']) ) $this->message->showmessage('没有选择发布题库时文章内容不能为空!',$this->input->server('HTTP_REFERER'));
		$isBank = isset($_POST['isbank']) ? 1 : 0;
		$bankID = $_POST['bankid'] != '-1' ? intval($_POST['bankid']) : 0;
		$isTop = isset($_POST['istop']) ? 1 : 0;
		$content = addslashes($_POST['elm1']);
		$inputTime = time();
		$updateTime = time();
		$postUser = !empty($_POST['postuser']) ? trim($_POST['postuser']) : '管理员';
		
		$valueStr1 = "('".$title."', '".$isBank."', '".$isTop."', '".$bankID."', '".$content."', '".$inputTime."', '".$updateTime."', '".$postUser."')";
		$sqlStr1 = 'INSERT INTO table_info'." (`title`,`isbank`,`istop`,`bankid`,`content`,`inputtime`,`updatetime`,`postuser`) VALUES ".$valueStr1.";";
		
		$reId = $this->news_model->Addnews($sqlStr1);
		if($reId)$this->message->showmessage('发布成功!',$this->input->server('HTTP_REFERER'));
		else $this->message->showmessage('发布失败!',$this->input->server('HTTP_REFERER'));
		
	}
	
	//编辑文章
	public function Updatenews()
	{
		$editID = !empty($_POST['edit_id']) ? (int)$_POST['edit_id'] : $this->message->showmessage('信息丢失无法编辑!',$this->input->server('HTTP_REFERER'));
		$title = !empty($_POST['title']) ?  htmlspecialchars(trim($_POST['title']),ENT_QUOTES) : $this->message->showmessage('请填写标题!',$this->input->server('HTTP_REFERER'));
		if(isset($_POST['isbank']) && $_POST['bankid'] == '-1') $this->message->showmessage('您选择了发布题库，但未选择绑定的题库!',$this->input->server('HTTP_REFERER'));
		if(trim($_POST['elm1']) == '' && !isset($_POST['isbank']) ) $this->message->showmessage('没有选择发布题库时文章内容不能为空!',$this->input->server('HTTP_REFERER'));
		$isBank = isset($_POST['isbank']) ? 1 : 0;
		$bankID = $_POST['bankid'] != '-1' ? intval($_POST['bankid']) : 0;
		$isTop = isset($_POST['istop']) ? 1 : 0;
		$content = $_POST['elm1'];
		$updateTime = time();
		$postUser = !empty($_POST['postuser']) ? trim($_POST['postuser']) : '管理员';
		$arrUpdate = array( 
							'title'=>$title,
							'isbank'=>$isBank,
							'istop'=>$isTop,
							'bankid'=>$bankID,
							'content'=>$content,
							'updatetime'=>$updateTime,
							'postuser'=>$postUser
		                   );
		$reId = $this->news_model->Updatenews_byid($arrUpdate, $editID);
		if($reId)$this->message->showmessage('更新成功!',$this->input->server('HTTP_REFERER'));
		else $this->message->showmessage('更新失败!',$this->input->server('HTTP_REFERER'));
		
	}
	
	public function deleteby_id() {
		
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
		
			if(!empty($_POST['ids'])){
				foreach($_POST['ids'] as $id){
					$id = intval($id);
					$result = $this->news_model->delnews_byID($id);
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
					$result = $this->news_model->delnews_byID($id);
					if($result){
						$this->message->showmessage('删除成功!',$this->input->server('HTTP_REFERER'));exit();
					}
					else{$this->message->showmessage('删除失败!',$this->input->server('HTTP_REFERER'));exit();}
			}
		}
	}
	
	public function Upload()
	{
		header('Content-Type: text/html; charset=UTF-8');

		$inputName='filedata';//表单文件域name
		$attachDir=$this->config->item('SITEROOT') . '/uploads/news';//上传文件保存路径，结尾不要带/
		$dirType=1;//1:按天存入目录 2:按月存入目录 3:按扩展名存目录  建议使用按天存
		$maxAttachSize=2097152;//最大上传大小，默认是2M
		$upExt='txt,rar,zip,jpg,jpeg,gif,png,swf,wmv,avi,wma,mp3,mid';//上传扩展名
		$msgType=2;//返回上传参数的格式：1，只返回url，2，返回参数数组
		$immediate=isset($_GET['immediate'])?$_GET['immediate']:0;//立即上传模式，仅为演示用
		ini_set('date.timezone','Asia/Shanghai');//时区

		$err = "";
		$msg = "''";
		$tempPath=$attachDir.'/'.date("YmdHis").mt_rand(10000,99999).'.tmp';
		$localName='';

		if(isset($_SERVER['HTTP_CONTENT_DISPOSITION'])&&preg_match('/attachment;\s+name="(.+?)";\s+filename="(.+?)"/i',$_SERVER['HTTP_CONTENT_DISPOSITION'],$info)){//HTML5上传
			file_put_contents($tempPath,file_get_contents("php://input"));
			$localName=urldecode($info[2]);
		}
		else{//标准表单式上传
			$upfile=@$_FILES[$inputName];
			if(!isset($upfile))$err='文件域的name错误';
			elseif(!empty($upfile['error'])){
				switch($upfile['error'])
				{
					case '1':
						$err = '文件大小超过了php.ini定义的upload_max_filesize值';
						break;
					case '2':
						$err = '文件大小超过了HTML定义的MAX_FILE_SIZE值';
						break;
					case '3':
						$err = '文件上传不完全';
						break;
					case '4':
						$err = '无文件上传';
						break;
					case '6':
						$err = '缺少临时文件夹';
						break;
					case '7':
						$err = '写文件失败';
						break;
					case '8':
						$err = '上传被其它扩展中断';
						break;
					case '999':
					default:
						$err = '无有效错误代码';
				}
			}
			elseif(empty($upfile['tmp_name']) || $upfile['tmp_name'] == 'none')$err = '无文件上传';
			else{
				move_uploaded_file($upfile['tmp_name'],$tempPath);
				$localName=$upfile['name'];
			}
		}

		if($err==''){
			$fileInfo=pathinfo($localName);
			$extension=$fileInfo['extension'];
			if(preg_match('/^('.str_replace(',','|',$upExt).')$/i',$extension))
			{
				$bytes=filesize($tempPath);
				if($bytes > $maxAttachSize)$err='请不要上传大小超过'.$this->formatBytes($maxAttachSize).'的文件';
				else
				{
					switch($dirType)
					{
						case 1: $attachSubDir = 'day_'.date('ymd'); break;
						case 2: $attachSubDir = 'month_'.date('ym'); break;
						case 3: $attachSubDir = 'ext_'.$extension; break;
					}
					$attachDir = $attachDir.'/'.$attachSubDir;
					if(!is_dir($attachDir))
					{
						@mkdir($attachDir, 0777);
						@fclose(fopen($attachDir.'/index.htm', 'w'));
					}
					PHP_VERSION < '4.2.0' && mt_srand((double)microtime() * 1000000);
					$newFilename=date("YmdHis").mt_rand(1000,9999).'.'.$extension;
					$targetPath = $attachDir.'/'.$newFilename;
					
					rename($tempPath,$targetPath);
					@chmod($targetPath,0755);
					
					//$targetPath=$this->jsonString($targetPath);
					$targetPath=explode('uploads', $targetPath);
					$targetPath = $this->config->item('Domain') . 'uploads' . $targetPath[1];
					if($immediate=='1')$targetPath='!'.$targetPath;
					if($msgType==1)$msg="'$targetPath'";
					else $msg="{'url':'".$targetPath."','localname':'".$this->jsonString($localName)."','id':'1'}";//id参数固定不变，仅供演示，实际项目中可以是数据库ID
				}
			}
			else $err='上传文件扩展名必需为：'.$upExt;

			@unlink($tempPath);
		}

		echo "{'err':'".$this->jsonString($err)."','msg':".$msg."}";
	}
	
	function jsonString($str)
	{
		return preg_replace("/([\\\\\/'])/",'\\\$1',$str);
	}
	
	function formatBytes($bytes) {
		if($bytes >= 1073741824) {
			$bytes = round($bytes / 1073741824 * 100) / 100 . 'GB';
		} elseif($bytes >= 1048576) {
			$bytes = round($bytes / 1048576 * 100) / 100 . 'MB';
		} elseif($bytes >= 1024) {
			$bytes = round($bytes / 1024 * 100) / 100 . 'KB';
		} else {
			$bytes = $bytes . 'Bytes';
		}
		return $bytes;
	}
	
	
}