<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class City_model extends CI_Model { 

	private $table = 'city_info';
   
    function __construct()
     {
         parent::__construct();
     }
	
	
	
	//增加新的城市
	function Addcity($sqlstr){
		$sqlstr=str_replace('table_info',$this->table,$sqlstr);
		$this->db->query($sqlstr);
		$result = $this->db->insert_id();//返回插入时的ID
		return $result;
		
	}
	
	//获取所有城市
	function Getcitys(){
		$sqlStr = "SELECT * FROM `$this->table` ORDER BY `key` ASC, `displayorder` ASC";
		$query = $this->db->query($sqlStr)->result();
		return $query;
	}
	
	
	function Updateorder($data, $id) {
		if($id!=0){
			$this->db->where('id', $id);
			$result=$this->db->update($this->table, $data); 
			return $result;
		}
		else
		return false;
	}
	
	
	function Delete_byid($id){
		$query = $this->db->delete($this->table,array('id'=>$id));
		if($query)
			return true;
		else
		    return false;
	}
	
	
	public function getCity($id)
	{
		$sqlStr = "SELECT `name` FROM `{$this->table}` WHERE";
		if( is_numeric($id) ){
			$sqlStr .= " `id`='{$id}'";
		}elseif( is_string($id) ){
			$id = urldecode($id);
			$id = $this->db->escape($id);
			$sqlStr .= " `name` = {$id}";
		}
		$query = $this->db->query($sqlStr)->row_array();
		return empty($query) ? '' : $query['name'];
	}
	
	
}
