<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Chapter_model extends CI_Model { 

	private $table = 'chapter_info';
   
    function __construct()
     {
         parent::__construct();
     }
	
	
	
	//增加新的试题章节
	function Addchapter($sqlstr){
		$sqlstr=str_replace('table_info',$this->table,$sqlstr);
		$this->db->query($sqlstr);
		$result = $this->db->insert_id();//返回插入时的ID
		return $result;
		
	}
	
	//获取所有章节信息
	function Getchapter(){
		$sqlStr = "SELECT * FROM `$this->table` ORDER BY `displayorder` ASC, `chaptid` DESC";
		$query = $this->db->query($sqlStr)->result();
		return $query;
	}
	
	//更新显示顺序
	function Updateorder($data, $chapterid) {
		if($chapterid!=0){
			$this->db->where('chaptid', $chapterid);
			$result=$this->db->update($this->table, $data); 
			return $result;
		}
		else
		return false;
	}
	
	//根据ID删除章节
	function Delete_bychapterid($chapterid){
		$query = $this->db->delete($this->table,array('chaptid'=>$chapterid));
		if($query)
			return true;
		else
		    return false;
	}

	public function getListById($id)
	{
		if( is_array($id) ){
			$ids = trim(implode(',', $id), ',');
			if( empty($ids) ){
				return array();
			}
			$where = ' WHERE chaptid IN ('.$ids.')';
			$sql = "SELECT * FROM {$this->table} {$where}";
			return $this->db->query($sql)->result_array();
		}else{
			$sql = "SELECT * FROM {$this->table} {$where}";
			$where = " WHERE chaptid = '{$id}'";
			return $this->db->query($sql)->row_array();
		}
	}	
	
}
