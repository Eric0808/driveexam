<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Record_model extends CI_Model { 

	private $table = 'record_info';
	
   
    function __construct()
     {
         parent::__construct();
     }
	
	
	
	//根据UID获取其考试记录的数量
	function gettestNum($UID){
		$num = $this->db->count_all_results($this->table, array('userid'=>$UID));
		return $num;
	}
	
	//增加题解
	function Addexplain($sqlstr){
		$sqlstr=str_replace('table_info',$this->table1,$sqlstr);
		$this->db->query($sqlstr);
		$result = $this->db->insert_id();//返回插入时的ID
		return $result;
		
	}
	
	//获取所有试题分类信息
	function Gettopics(){
		$sqlStr = "SELECT * FROM `$this->table` ORDER BY `displayorder` ASC, `cateid` DESC";
		$query = $this->db->query($sqlStr)->result();
		return $query;
	}
	
	//更新类别显示顺序
	function Updatetopic($data, $cateid) {
		if($cateid!=0){
			$this->db->where('cateid', $cateid);
			$result=$this->db->update($this->table, $data); 
			return $result;
		}
		else
		return false;
	}
	
	//根据ID删除试题类型
	function Delete_bycatid($cateid){
		$query = $this->db->delete($this->table,array('cateid'=>$cateid));
		if($query)
			return true;
		else
		    return false;
	}
	
	function getTopicIDLengthByCatid($catid)
	{
		if( is_array($catid) ){
			$catid = implode(',', $catid);
		}
		$where = "`catalog` IN ({$catid})";
		
		$this->db->select('GROUP_CONCAT(`id`) as `ids`, COUNT(`id`) as `count`');
		$query = $this->db->get_where($this->table, $where);
		$result = $query->row_array();
		return $result;
	}
	
}
