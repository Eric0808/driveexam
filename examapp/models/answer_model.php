<?php


final class answer_model extends CI_Model
{
	private $table = 'answer_info';
	public $topictable = 'topic_info';
	
	public $examid;
	
	public function add($topicid, $answer)
	{
		$data = array(
			'examid'=>$this->examid,
			'topicid'=>$topicid, 
			'answer'=>$answer
		);
		return $this->db->insert($this->table, $data);
	}
	
	public function getAllTopic($where, $select='t.*', $orderby=null)
	{
		$sql = "SELECT {$select} FROM `{$this->topictable}` as `t`";
		$sql .= " LEFT JOIN {$this->table} as `a` ON t.id = a.topicid ";
	
		if( $where ){
			$sql .= " WHERE {$where}";
		}
		is_null($orderby) || $sql.=" ORDER BY `a`.`id` {$orderby}";
		
		return $this->db->query($sql)->result_array();
	}
	
	
	public function getByWhere($examid, $wrong=false, $justnum=false)
	{
		$select = $justnum ? 'count(`*`)' : '`t`.*, `a`.`answer` as `useranswer`';
		if( $wrong ===true ){ // get the false
			$wrong = "`t`.`answer` != `a`.`answer` AND";
		}elseif( $wrong ===false){ // get all
			$wrong = '';
		}elseif( $wrong === 1){ // get the true
			$wrong = "`t`.`answer` = `a`.`answer` AND";
		}
		$where = "{$wrong} `a`.`examid`={$examid}";
		return $this->getAllTopic($where, $select, 'ASC');
	}
	
}