<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cate_model extends CI_Model { 

	private $table = 'cate_info';
   
    function __construct()
     {
         parent::__construct();
     }
	
	
	
	//增加新的试题分类信息
	function Addcategory($sqlstr){
		$sqlstr=str_replace('table_info',$this->table,$sqlstr);
		$this->db->query($sqlstr);
		$result = $this->db->insert_id();//返回插入时的ID
		return $result;
		
	}
	
	//获取所有试题分类信息
	function Getcategory($where=null){
		$where = empty($where) ? '' : "where `cateid` IN ({$where})";
		$sqlStr = "SELECT * FROM `$this->table` {$where} ORDER BY `displayorder` ASC, `cateid` DESC";
		$query = $this->db->query($sqlStr)->result();
		return $query;
	}
	
	//更新类别显示顺序
	function Updateorder($data, $cateid) {
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
	
	public function getWherein($id, $arr=false)
	{
		$ci = get_instance();
		$ci->load->model('subject_model', 'subject');
		$data = $ci->subject->getNameById($id, true);
		$ids = $ci->subject->getWhere($data['bankid'], 'id');
		$where = "$ids";
		$query = $this->db->get_where('test_bank', $where);
		$data = $query->row_array();
		if( !empty($data) && isset($data['cateids']) ){
			$categorys = @unserialize(trim($data['cateids']));
		}else{
			$categorys = array();
		}
		
		if( $arr ===false){
			$categorys = implode(',', $categorys);
		}
		return $categorys;
	}
	
}
