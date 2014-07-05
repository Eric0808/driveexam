<?php

final class wrong_model extends CI_Model
{
	private $table = 'wrong_info';
	private $topictable = 'topic_info';
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function add($uid, $id, $answer)
	{
		$id = (int)$id; 
		$answer = (int)$answer;
		$insert = array(
			'userid' => $uid,
			'topicid'=> $id,
			'addtime'=> date('Y-m-d H:i:s')
		);
		if( !empty($answer) ){
			$insert['answer'] = $answer;
		}
		return $this->db->insert($this->table, $insert);
	}
	
	public function getWrongTopicList($uid, $page, $limit)
	{
		$offest = ($page-1)*$limit;
		$sql = "SELECT SQL_CALC_FOUND_ROWS `t`.*, count(`a`.`topicid`) as `errcount`, `a`.`addtime`, `a`.`answer` as `useranswer`";
		$sql .= " FROM `{$this->topictable}` as `t`";
		$sql .= " LEFT JOIN `{$this->table}` as `a` ON `a`.`topicid`= `t`.`id`";
		$sql .= " WHERE `a`.`userid`='{$uid}'";
		$sql .= " GROUP BY `a`.`topicid` ORDER BY count(`a`.`topicid`) DESC";
		$sql .= " LIMIT {$offest}, {$limit}";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function getWrongTopicIds($uid)
	{
		$sql = "SELECT GROUP_CONCAT(DISTINCT `topicid`) AS `ids` FROM {$this->table}";
		$sql .= " WHERE `userid`='{$uid}'";

		$query = $this->db->query($sql);
		$result = $query->row_array();
		return $result;
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
