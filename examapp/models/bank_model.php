<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Bank_model extends CI_Model { 

	private $table = 'test_bank';
   
    function __construct()
     {
         parent::__construct();
     }
	
	
	
	//增加新的题库
	function Addbank($sqlstr){
		$sqlstr=str_replace('table_info',$this->table,$sqlstr);
		$this->db->query($sqlstr);
		$result = $this->db->insert_id();//返回插入时的ID
		return $result;
		
	}
	
	//获取所有试题分类信息
	function Getbanks(){
		$sqlStr = "SELECT * FROM `$this->table` ORDER BY `id` DESC";
		$query = $this->db->query($sqlStr)->result();
		return $query;
	}
	
	//获取所有试题分类信息
	function Getbank_bypage($page = 1, $pageSize = 20, $setPages = 10, $where='', $order=''){
		$sqlStr = "SELECT * FROM {$this->table} AS b ";
		$sqlStr1 = "SELECT COUNT(*) FROM {$this->table} {$where} ";
		$allnum=$this->getbank_num($sqlStr1);
		$page = max(intval($page), 1);
		$offset = $pageSize*($page-1);
		$query[0] =$this->globalfunc->pages($allnum, $page, $pageSize,$setPages);
		if($allnum >0){
			$sqlStr .= " $where $order LIMIT $offset, $pageSize";
			
			$query[1] = $this->db->query($sqlStr)->result_array();
			
			foreach($query[1] as $key=>$value){
				$arrnum = $this->getbank_num(" SELECT COUNT(*) FROM  `topic_info` WHERE `bankid` LIKE '%" .$value['id'].",%' ");
				
				$query[1][$key]['allnum'] = $arrnum;
			}

			return $query;
		}		
		else
		return null;
	}
	
	//根据条件获取所有试题的数量
	public function getbank_num($sqlStr){
		
		$num = $this->db->query($sqlStr)->row_array();
		return $num['COUNT(*)'];
	}
	
	
	
	//根据ID删除题库和该题库下的所有试题
	function Delete_byid($bankid){
		$query = $this->db->delete($this->table,array('id'=>$bankid));
		if($query){
			$query1 = $this->db->delete('topic_info',array('bankid'=>$bankid));
			if($query1)
			return true;
			else
			return false;
		}
		else
		    return false;
	}
	
	public function Detail_byID($bankid){
		$query = $this->db->get_where($this->table, array('id' => $bankid),1)->row_array(); 
	    return $query;
	}
	
	/*根据ID更新题库*/
	function Updatebank_byid($data, $bankid){
		if($bankid!=0){
			$this->db->where('id', $bankid);
			$result=$this->db->update($this->table, $data); 
			return $result;
		}
		else
		return false;
	
	}
	
	public function getCaties($bankid)
	{
		$where = array('id'=>$bankid);
		$query = $this->db->get_where('test_bank', $where);
		$result = $query->row_array();
		
		$categorys = @unserialize(trim($result['cateids']));
		$categorys = implode(',', $categorys);
		
		return $categorys;
	}
	
}
