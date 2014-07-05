<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Link_model extends CI_Model { 

	private $table = 'link_info';
   
    function __construct()
     {
         parent::__construct();
     }
	
	
	
	//增加新的友情链接
	function Addlink($sqlstr){
		$sqlstr=str_replace('table_info',$this->table,$sqlstr);
		$this->db->query($sqlstr);
		$result = $this->db->insert_id();//返回插入时的ID
		return $result;
		
	}
	
	//获取所有友情链接信息
	function Getlinks(){
		$sqlStr = "SELECT * FROM `$this->table` ORDER BY `displayorder` ASC, `linkid` DESC";
		$query = $this->db->query($sqlStr)->result();
		return $query;
	}
	
	//更新友链显示顺序
	function Updateorder($data, $linkid) {
		if($linkid!=0){
			$this->db->where('linkid', $linkid);
			$result=$this->db->update($this->table, $data); 
			return $result;
		}
		else
		return false;
	}
	
	//根据ID删除友链
	function Delete_bylinkid($linkid){
		$query = $this->db->delete($this->table,array('linkid'=>$linkid));
		if($query)
			return true;
		else
		    return false;
	}
	
	
}
