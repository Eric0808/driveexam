<?php

final class exam_model extends CI_Model
{
	private $table = 'record_info';

	public function __construct()
	{
	
	}
	
	public function start($uid)
	{
		$data = array(
			'userid' => $uid,
			'begintime' => time()
			);
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}
	
	public function get($uid=null, $id=null)
	{
		$where = array();
		if( ! empty($uid) )
			$where['userid'] = $uid;
		if( ! empty($id) ){
			$where['id'] = $id;
		}
		
		return $this->db->get_where($this->table, $where)->result_array();
	}
	
	public function end($id, $scores)
	{
		$data = $this->get(null, $id);

		if( !isset($data[0]) ){
			return array('code'=>1, 'msg'=>'未能发现本次测试的记录，这很可能是您答题时间远远超过了限制');
		}
		
		if( ! $this->notend($data[0]) ){
			return array('code'=>2, 'msg'=>'该测试已经完成，不能重复提交');
		}
		$scores = (int)$scores;
		$usetime = time() - $data[0]['begintime'];
		if($usetime <= 0 ){
			$usetime = 1;
		}
		
		$sql = "UPDATE `{$this->table}` SET `score`={$scores}, `usetime`={$usetime}";
		$sql .= " WHERE `id`='{$id}'";
		$this->db->query($sql);
		
		if( $this->db->affected_rows() ){
			$msg = array('code'=>0, 'msg'=>'Ok');
		}
		return $msg;
	}

	
	public function notend($data)
	{
		if( isset($data['usetime']) && $data['usetime']>0 ){
			return false;
		}
		return true;
	}
}