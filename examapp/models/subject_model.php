<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Subject_model extends CI_Model { 

	private $table = 'subject_info';
   
	// 满分
	private $full = 100;
   
    function __construct()
     {
         parent::__construct();
     }
	
	
	
	//增加新的车型/科目
	function Adddrivetype($sqlstr){
		$sqlstr=str_replace('table_info',$this->table,$sqlstr);
		$this->db->query($sqlstr);
		$result = $this->db->insert_id();//返回插入时的ID
		return $result;
		
	}
	
	//根据ID删除车型
	public function deltype_byID($typeID){
		$status = $this->db->delete($this->table, array('id' => $typeID)); 
	    return $status;
	}
	
	public function Detail_byID($typeID){
		$query = $this->db->get_where($this->table, array('id' => $typeID),1)->row_array(); 
	    return $query;
	}
	
	/*根据ID更新车型科目*/
	function Updatetype_byid($data, $typeID){
		if($typeID!=0){
			$this->db->where('id', $typeID);
			$result=$this->db->update($this->table, $data); 
			return $result;
		}
		else
		return false;
	
	}
	
	//获取所有车型/科目信息
	function Getalltype(){
	
		$result = $this->db->get($this->table)->result();
		return $result;
	}
	
	
	public function getAll()
	{
		$result = $this->Getalltype();
		$data = array();
		foreach($result as $row){
			$row = get_object_vars($row);
			if( !isset($data[$row['drivetype']]) ){
				$data[$row['drivetype']] = $row;
				$data[$row['drivetype']]['subjects'] = array(
					$data[$row['drivetype']]['id'] => $data[$row['drivetype']]['subject1']
				);
				unset($data[$row['drivetype']]['subject1'], $data[$row['drivetype']]['id']);
			}else{
				$data[$row['drivetype']]['subjects'][$row['id']] = $row['subject1'];
			}
		}

		return $data;
	}
	
	
	public function getNameById($id, $all=false)
	{
		$sql = "SELECT * FROM {$this->table}";
		$sql .= " WHERE ". $this->getWhere($id);

		$query =  $this->db->query($sql);
		$sqlresult = $query->result_array();
		$result = @$sqlresult[0];
		if( isset($sqlresult[1]) ){
			$result['subject1'] = '';
			$result['id'] = $result['id'].'-'.$sqlresult[1]['id'];
			$result['bankid'] = $result['bankid'].'-'.$sqlresult[1]['bankid'];
		}

		if( empty($result) ){
			$sql = "SELECT * FROM {$this->table} LIMIT 1";
			$result = $this->db->query($sql)->row_array();
		}
		if( $all === false ){
			$sub = explode('/', $result['subject1']);
			$name = $result['drivetype'].$sub[0];
			return array('name'=>$name, 'id'=>$result['id']);
		}else{
			return $result;
		}
	}
	
	public function getRule($id)
	{
		$where = $this->getWhere($id);
		$sql = "SELECT `number` FROM {$this->table} WHERE {$where}";
		$result = $this->db->query($sql)->row_array();
		if( empty($result) ){
			$sql = "SELECT `number` FROM {$this->table} LIMIT 1";
			$result = $this->db->query($sql)->row_array();
		}
		$score = (int)($this->full/$result['number']);
		$data = array(
			'num' => (int)$result['number'],
			'score' => $score
			);
			
		return $data;
	}

	public function getWhere($id, $name='id')
	{
		if( strpos($id, '-') !==false ){
			list($id1, $id2) = explode('-', $id);
			$id1 = (int)$id1;
			$id2 = (int)$id2;
			$where = "`{$name}` IN ($id1, $id2)";
		}else{
			$id = (int)$id;
			$where = "`{$name}` = '$id'";
		}
		return $where;
	}
	
}
