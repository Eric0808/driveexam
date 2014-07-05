<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Ads_model extends CI_Model { 

	private $tname = 'ads_info';
   
    function __construct()
     {
         parent::__construct();
     }
	
	
	
	//增加广告位展示
	function Addads($sqlstr){
		$sqlstr=str_replace('table_info', $this->tname, $sqlstr);
		$this->db->query($sqlstr);
		$result = $this->db->insert_id();//返回插入时的ID
		return $result;
		
	}
	
	//根据所有广告列表
	public function Getallads($page = 1, $pageSize = 20, $setPages = 10, $where='', $order=''){
		
		$sqlStr = "SELECT * FROM {$this->tname} ";
		$sqlStr1 = "SELECT COUNT(*) FROM {$this->tname} {$where} ";
		$allnum=$this->getads_num($sqlStr1);
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
	//根据条件广告位数量
	public function getads_num($sqlStr){
	
		$num = $this->db->query($sqlStr)->row_array();
		return $num['COUNT(*)'];
	}
	//根据ID删除广告展示
	public function delads_byID($adsID){
		$status = $this->db->delete($this->tname, array('adsid' => $adsID)); 
	    return $status;
	}
	
	//根据ID获取广告信息
	public function demail_byID($adsID){
		if(is_numeric($adsID)){
		
			$query = $this->db->get_where($this->tname, array('adsid' => $adsID))->row_array(); 
			return $query;
		}
		else
		return FALSE;
	}
	
	//根据ID获取广告信息
	public function edit_byID($data, $adsID){
		if($adsID!=0){
			$this->db->where('adsid', $adsID);
			$result=$this->db->update($this->tname, $data); 
			return $result;
		}
		else
		return false;
	}
	
	
	
}
