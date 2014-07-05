<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class News_model extends CI_Model { 

	private $tname = 'news_info';
	private $tname1 = 'test_bank';
   
    function __construct()
     {
         parent::__construct();
     }
	
	
	
	//增加内容
	function Addnews($sqlstr){
		$sqlstr=str_replace('table_info', $this->tname, $sqlstr);
		$this->db->query($sqlstr);
		$result = $this->db->insert_id();//返回插入时的ID
		return $result;
		
	}
	
	//根据条件获取所有文章列表
	public function Getallnews($page = 1, $pageSize = 20, $setPages = 10, $where='', $order=''){
		
		$sqlStr = "SELECT * FROM {$this->tname} AS n  LEFT JOIN  (SELECT id as bank, name as bankname FROM {$this->tname1}) AS t ON n.bankid = t.bank ";
		$sqlStr1 = "SELECT COUNT(*) FROM {$this->tname} {$where} ";
		$allnum=$this->getnews_num($sqlStr1);
		$page = max(intval($page), 1);
		$offset = $pageSize*($page-1);
		$query[0] =$this->globalfunc->pages($allnum, $page, $pageSize,$setPages);
		if($allnum >0){
			$sqlStr .= " $where $order LIMIT $offset, $pageSize";
			$query[1] = $this->db->query($sqlStr)->result();
			return $query;
		}		
		else
		return null;
		
	}
	//根据条件获取所有文章数量
	public function getnews_num($sqlStr){
	
		$num = $this->db->query($sqlStr)->row_array();
		return $num['COUNT(*)'];
	}
	//根据ID删除文章
	public function delnews_byID($articleID){
		$status = $this->db->delete($this->tname, array('id' => $articleID)); 
	    return $status;
	}
	
	public function Detail_byID($articleID){
		$query = $this->db->get_where($this->tname, array('id' => $articleID),1)->row_array(); 
	    return $query;
	}
	
	/*根据ID更新文章*/
	function Updatenews_byid($data, $articleID){
		if($articleID!=0){
			$this->db->where('id', $articleID);
			$result=$this->db->update($this->tname, $data); 
			return $result;
		}
		else
		return false;
	
	}
	
	// add by PXK
	public function getTopNews()
	{
		$sql = "SELECT `id`, `title`, `inputtime`";
		$sql.= " FROM {$this->tname}";
		$sql.= " WHERE `istop`=1";
		$sql.= " ORDER BY `istop` DESC, `inputtime` DESC, `id` DESC";
		$query = $this->db->query($sql);

		return $query->row_array();
	}
	
	public function getBankList($limit)
	{
		$sql = "SELECT `id`, `title`, `inputtime`";
		$sql.= " FROM {$this->tname}";
		$sql.= " WHERE `isbank`=1";
		$sql.= " ORDER BY `istop` DESC, `inputtime` DESC, `id` DESC";
		$sql.= " LIMIT $limit";
		
		$query = $this->db->query($sql);

		return $query->result_array();
	}
	
	
	public function get($id)
	{
		return $this->db->get_where($this->tname, array('id'=>$id) )->row_array();
	}
	
	
	public function getprevnext($id)
	{
		if( !is_numeric($id) )	return array();
		$sql = "select `id`,`title`,`inputtime` from `{$this->tname}` where `id` < '{$id}' order by `id` desc limit 1";
		$data[0] = $this->db->query($sql)->row_array();
		$sql = "select `id`,`title`,`inputtime` from `{$this->tname}` where `id` > '{$id}' order by `id` desc limit 1";
		$data[1] = $this->db->query($sql)->row_array();

		return $data;
	}
	
}
