<?php

final class remove_model extends CI_Model
{
	private $table = 'remove_info';
	private $topictable = 'topic_info';
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function add($uid, $id)
	{
		$id = (int)$id;
		$where = array(
			'userid' => $uid, 'topicid'=>$id
		);
		$data = $this->db->get_where($this->table, $where)->row();
		if( ! empty($data) ){
			return false;
		}
		$where['addtime'] = date('Y-m-d');
		return $this->db->insert($this->table, $where);
	}
	
	public function getRemoveTopicList($uid, $page, $limit)
	{
		$offest = ($page-1)*$limit;
		$sql = "SELECT SQL_CALC_FOUND_ROWS `t`.*, `a`.`addtime`";
		$sql .= " FROM `{$this->topictable}` as `t`";
		$sql .= " LEFT JOIN `{$this->table}` as `a` ON `a`.`topicid`= `t`.`id`";
		$sql .= " WHERE `a`.`userid`='{$uid}'";
		$sql .= " ORDER BY `id` DESC";
		$sql .= " LIMIT {$offest}, {$limit}";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getRemoveTopicIds($uid)
	{
		$sql = "SELECT GROUP_CONCAT(`topicid`) AS `ids` FROM {$this->table}";
		$sql .= " WHERE `userid`='{$uid}'";

		$query = $this->db->query($sql);
		$result = $query->row_array();
		return $result['ids'];
	}

	public function clear($uid, $id=null)
	{
		$sql = "DELETE FROM {$this->table}";
		$sql .= " WHERE `userid`={$uid}";
		if( is_numeric($id) && $id>0 ){
			$sql .= " AND `topicid`='{$id}'";
		}
		
		$this->db->query($sql);
		return $this->db->affected_rows();
	}

	
	public function getCount()
	{
		$sql = "SELECT FOUND_ROWS() as `count`";
		$result = $this->db->query($sql)->row_array();
		
		return (int)$result['count'];
	}
}
