<?php 
class Globalfunc
{
	//@set_time_limit(0);
	public function __construct()
	{
		
	}
	
	/**
	 * 分页函数
	 *
	 * @param $num 信息总数
	 * @param $curr_page 当前分页
	 * @param $perpage 每页显示数
	 * @param $urlrule URL规则
	 * @param $array 需要传递的数组，用于增加额外的方法
	 * @return 分页
	 */
	function pages($num, $curr_page, $perpage = 20, $setpages = 10) {
		
			$urlrule = $this->url_par('page={$page}');
		
		$multipage = '';
		if($num > $perpage) {
			$page = $setpages+1;
			$offset = ceil($setpages/2-1);
			$pages = ceil($num / $perpage);
			if (!defined('PAGES')) define('PAGES', $pages);
			$from = $curr_page - $offset;
			$to = $curr_page + $offset;
			$more = 0;
			if($page >= $pages) {
				$from = 2;
				$to = $pages-1;
			} else {
				if($from <= 1) {
					$to = $page-1;
					$from = 2;
				}  elseif($to >= $pages) {
					$from = $pages-($page-2);
					$to = $pages-1;
				}
				$more = 1;
			}
			$multipage .= '<a class="a1">'.$num.'条'.'</a>';
			if($curr_page>0) {
				$multipage .= ' <a href="'.$this->pageurl($urlrule, $curr_page-1).'" class="a1">'.'上一页'.'</a>';
				if($curr_page==1) {
					$multipage .= ' <span>1</span>';
				} elseif($curr_page>6 && $more) {
					$multipage .= ' <a href="'.$this->pageurl($urlrule, 1).'">1</a>..';
				} else {
					$multipage .= ' <a href="'.$this->pageurl($urlrule, 1).'">1</a>';
				}
			}
			for($i = $from; $i <= $to; $i++) {
				if($i != $curr_page) {
					$multipage .= ' <a href="'.$this->pageurl($urlrule, $i).'">'.$i.'</a>';
				} else {
					$multipage .= ' <span>'.$i.'</span>';
				}
			}
			if($curr_page<$pages) {
				if($curr_page<$pages-5 && $more) {
					$multipage .= ' ..<a href="'.$this->pageurl($urlrule, $pages).'">'.$pages.'</a> <a href="'.$this->pageurl($urlrule, $curr_page+1).'" class="a1">'.'下一页'.'</a>';
				} else {
					$multipage .= ' <a href="'.$this->pageurl($urlrule, $pages).'">'.$pages.'</a> <a href="'.$this->pageurl($urlrule, $curr_page+1).'" class="a1">'.'下一页'.'</a>';
				}
			} elseif($curr_page==$pages) {
				$multipage .= ' <span>'.$pages.'</span> <a href="'.$this->pageurl($urlrule, $curr_page).'" class="a1">'.'下一页'.'</a>';
			} else {
				$multipage .= ' <a href="'.$this->pageurl($urlrule, $pages).'">'.$pages.'</a> <a href="'.$this->pageurl($urlrule, $curr_page+1).'" class="a1">'.'下一页'.'</a>';
			}
		}
		return $multipage;
	}
	/**
	 * 返回分页路径
	 *
	 * @param $urlrule 分页规则
	 * @param $page 当前页
	 * @param $array 需要传递的数组，用于增加额外的方法
	 * @return 完整的URL路径
	 */
	function pageurl($urlrule, $page, $array = array()) {
		if(strpos($urlrule, '~')) {
			$urlrules = explode('~', $urlrule);
			$urlrule = $page < 2 ? $urlrules[0] : $urlrules[1];
		}
		$findme = array('{$page}');
		$replaceme = array($page);
		if (is_array($array)) foreach ($array as $k=>$v) {
			$findme[] = '{$'.$k.'}';
			$replaceme[] = $v;
		}
		$url = str_replace($findme, $replaceme, $urlrule);
		$url = str_replace(array('http://','//','~'), array('~','/','http://'), $url);
		return $url;
	}

	/**
	 * URL路径解析，pages 函数的辅助函数
	 *
	 * @param $par 传入需要解析的变量 默认为，page={$page}
	 * @param $url URL地址
	 * @return URL
	 */
	function url_par($par, $url = '') {
		if($url == '') $url =$this->get_url();
		$pos = strpos($url, '?');
		if($pos === false) {
			$url .= '?'.$par;
		} else {
			$querystring = substr(strstr($url, '?'), 1);
			parse_str($querystring, $pars);
			$query_array = array();
			foreach($pars as $k=>$v) {
				if($k != 'page') $query_array[$k] = $v;
			}
			$querystring = http_build_query($query_array).'&'.$par;
			$url = substr($url, 0, $pos).'?'.$querystring;
		}
		return $url;
	}
	
		/**
	 * 获取当前页面完整URL地址
	 */
	function get_url() {
		$sys_protocal = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
		$php_self = $_SERVER['PHP_SELF'] ? $this->safe_replace($_SERVER['PHP_SELF']) : $this->safe_replace($_SERVER['SCRIPT_NAME']);
		$path_info = isset($_SERVER['PATH_INFO']) ? $this->safe_replace($_SERVER['PATH_INFO']) : '';
		$relate_url = isset($_SERVER['REQUEST_URI']) ? $this->safe_replace($_SERVER['REQUEST_URI']) : $php_self.(isset($_SERVER['QUERY_STRING']) ? '?'.$this->safe_replace($_SERVER['QUERY_STRING']) : $path_info);
		return $sys_protocal.(isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '').$relate_url;
	}
		/**
	 * 安全过滤函数
	 *
	 * @param $string
	 * @return string
	 */
	function safe_replace($string) {
		$string = str_replace('%20','',$string);
		$string = str_replace('%27','',$string);
		$string = str_replace('%2527','',$string);
		$string = str_replace('*','',$string);
		$string = str_replace('"','&quot;',$string);
		$string = str_replace("'",'',$string);
		$string = str_replace('"','',$string);
		$string = str_replace(';','',$string);
		$string = str_replace('<','&lt;',$string);
		$string = str_replace('>','&gt;',$string);
		$string = str_replace("{",'',$string);
		$string = str_replace('}','',$string);
		$string = str_replace('\\','',$string);
		return $string;
	}
	
	/**
	 * 生成试题txt文件
	 *
	 * @param $string
	 * @return bool
	 */
	 
	 function Createtxt($dir, $name, $data){
		if(!file_exists($dir)){
			mkdir($dir, 0777) or die("创建目录".$dir."失败");
		}
		$fileName = $dir . '/' . $name . '.txt';
		if(!file_exists($fileName)){
			@fopen($fileName, "w");
			if(is_writable($fileName)){
				if(!$handle = fopen($fileName, "a")){echo "文件不可打开";exit;}
				if(!fwrite($handle, $data)){echo "文件不可写";exit;}
				fclose($handle);
			}
		}
	 }
	 /**
	 * 生成试题txt文件
	 *
	 * @param $string
	 * @return bool
	 */
	 function Delete_File($filePath){
		if(file_exists($filePath)){
			if(!unlink($filePath)){
			   echo '文件或目录没有权限删除';EXIT();
			}
		}
		
	 }
	 
	 
	 
	 
	public static function utf_substr($str, $len)
	{
		for($i=0;$i<$len;$i++)
		{
			$temp_str=substr($str,0,1);
			if(ord($temp_str) > 127){
				$i++;
				if($i<$len){
					$new_str[]=substr($str,0,3);
					$str=substr($str,3);
				}
			}else{
				$new_str[]=substr($str,0,1);
				$str=substr($str,1);
			}
		}
		return join($new_str);
	}
	
	/**
	* 转化 \ 为 /
	* 
	* @param	string	$path	路径
	* @return	string	路径
	*/
	function dir_path($path) {
		$path = str_replace('\\', '/', $path);
		if(substr($path, -1) != '/') $path = $path.'/';
		return $path;
	}
	/**
	* 创建目录
	* 
	* @param	string	$path	路径
	* @param	string	$mode	属性
	* @return	string	如果已经存在则返回true，否则为flase
	*/
	function dir_create($path, $mode = 0777) {
		if(is_dir($path)) return TRUE;
		$ftp_enable = 0;
		$path = dir_path($path);
		$temp = explode('/', $path);
		$cur_dir = '';
		$max = count($temp) - 1;
		for($i=0; $i<$max; $i++) {
			$cur_dir .= $temp[$i].'/';
			if (@is_dir($cur_dir)) continue;
			@mkdir($cur_dir, 0777,true);
			@chmod($cur_dir, 0777);
		}
		return is_dir($path);
	}
	/**
	* 拷贝目录及下面所有文件
	* 
	* @param	string	$fromdir	原路径
	* @param	string	$todir		目标路径
	* @return	string	如果目标路径不存在则返回false，否则为true
	*/
	function dir_copy($fromdir, $todir) {
		$fromdir = dir_path($fromdir);
		$todir = dir_path($todir);
		if (!is_dir($fromdir)) return FALSE;
		if (!is_dir($todir)) dir_create($todir);
		$list = glob($fromdir.'*');
		if (!empty($list)) {
			foreach($list as $v) {
				$path = $todir.basename($v);
				if(is_dir($v)) {
					dir_copy($v, $path);
				} else {
					copy($v, $path);
					@chmod($path, 0777);
				}
			}
		}
		return TRUE;
	}
	/**
	* 转换目录下面的所有文件编码格式
	* 
	* @param	string	$in_charset		原字符集
	* @param	string	$out_charset	目标字符集
	* @param	string	$dir			目录地址
	* @param	string	$fileexts		转换的文件格式
	* @return	string	如果原字符集和目标字符集相同则返回false，否则为true
	*/
	function dir_iconv($in_charset, $out_charset, $dir, $fileexts = 'php|html|htm|shtml|shtm|js|txt|xml') {
		if($in_charset == $out_charset) return false;
		$list = dir_list($dir);
		foreach($list as $v) {
			if (pathinfo($v, PATHINFO_EXTENSION) == $fileexts && is_file($v)){
				file_put_contents($v, iconv($in_charset, $out_charset, file_get_contents($v)));
			}
		}
		return true;
	}
	/**
	* 列出目录下所有文件
	* 
	* @param	string	$path		路径
	* @param	string	$exts		扩展名
	* @param	array	$list		增加的文件列表
	* @return	array	所有满足条件的文件
	*/
	function dir_list($path, $exts = '', $list= array()) {
		$path = dir_path($path);
		$files = glob($path.'*');
		foreach($files as $v) {
			if (!$exts || pathinfo($v, PATHINFO_EXTENSION) == $exts) {
				$list[] = $v;
				if (is_dir($v)) {
					$list = dir_list($v, $exts, $list);
				}
			}
		}
		return $list;
	}
	/**
	* 设置目录下面的所有文件的访问和修改时间
	* 
	* @param	string	$path		路径
	* @param	int		$mtime		修改时间
	* @param	int		$atime		访问时间
	* @return	array	不是目录时返回false，否则返回 true
	*/
	function dir_touch($path, $mtime = TIME, $atime = TIME) {
		if (!is_dir($path)) return false;
		$path = dir_path($path);
		if (!is_dir($path)) touch($path, $mtime, $atime);
		$files = glob($path.'*');
		foreach($files as $v) {
			is_dir($v) ? dir_touch($v, $mtime, $atime) : touch($v, $mtime, $atime);
		}
		return true;
	}
	/**
	* 目录列表
	* 
	* @param	string	$dir		路径
	* @param	int		$parentid	父id
	* @param	array	$dirs		传入的目录
	* @return	array	返回目录列表
	*/
	function dir_tree($dir, $parentid = 0, $dirs = array()) {
		global $id;
		if ($parentid == 0) $id = 0;
		$list = glob($dir.'*');
		foreach($list as $v) {
			if (is_dir($v)) {
				$id++;
				$dirs[$id] = array('id'=>$id,'parentid'=>$parentid, 'name'=>basename($v), 'dir'=>$v.'/');
				$dirs = dir_tree($v.'/', $id, $dirs);
			}
		}
		return $dirs;
	}

	/**
	* 删除目录及目录下面的所有文件
	* 
	* @param	string	$dir		路径
	* @return	bool	如果成功则返回 TRUE，失败则返回 FALSE
	*/
	function dir_delete($dir) {
		$dir = dir_path($dir);
		if (!is_dir($dir)) return FALSE;
		$list = glob($dir.'*');
		foreach($list as $v) {
			is_dir($v) ? dir_delete($v) : @unlink($v);
		}
		return @rmdir($dir);
	}
}
?>