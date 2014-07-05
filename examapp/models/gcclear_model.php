<?php

final class gcclear_model extends CI_Model
{
	private $user = 'member_info';
	private $answer = 'answer_info';
	private $remove = 'remove_info';
	private $wrong  = 'wrong_info';
	private $record = 'record_info';
	
	private $rows = 0;
	
	public function __construct()
	{
		$this->load->database();
		defined('TIME') || define('TIME', time()-(3600*24*7));
		$this->date = date('Y-m-d', TIME);
		
		echo '['. date('Y-m-d H:i:s', TIME). '] 启动', PHP_EOL;
	}

	public function clear()
	{
		$sql = "SELECT GROUP_CONCAT(`userid`) as `ids` FROM {$this->user}";
		$sql .= " WHERE `username`='' AND `regdate` < '".TIME."'";
		
		$data = $this->db->query($sql)->row_array();
		$this->ids = trim($data['ids'], ',');
		
		if( empty($this->ids) ){
			echo "未匹配到符合条件的记录";
			return ;
		}
		
		$this->wrong();
		$this->remove();
		
		$this->answer();
		
		$this->user();
		echo "完成，共删除 {$this->rows} 条记录";
	}
	
	
	private function query($sql)
	{
		$this->db->query($sql);
		$rows = $this->db->affected_rows();
		$this->rows += $rows;
		
		$msg = "{$rows} 行 {$sql} ";
		echo $msg, PHP_EOL;
	}
	
	public function user()
	{
		$sql = "DELETE FROM `{$this->user}`";
		$sql .= " WHERE `userid` IN ({$this->ids}) ";
		$this->query($sql);
	}
	
	public function wrong()
	{
		$sql = "DELETE FROM `{$this->wrong}`";
		$sql .= " WHERE `userid` IN ({$this->ids}) AND `addtime`<'{$this->date}'";
		$this->query($sql);
	}
	
	public function remove()
	{
		$sql = "DELETE  FROM `{$this->remove}`";
		$sql .= " WHERE `userid` IN ({$this->ids}) AND `addtime`<'{$this->date}'";
		$this->query($sql);
	}
	
	public function answer()
	{
		$ids = $this->record();
		if( empty($ids) ){
			return ;
		}
		$sql = "DELETE  FROM `{$this->answer}`";
		$sql .= " WHERE `examid` IN ({$ids})";
		$this->query($sql);
	}
	
	public function record()
	{
		$sql = "SELECT GROUP_CONCAT(`id`) as `ids` FROM {$this->record}";
		$sql .= " WHERE `userid` IN ({$this->ids})";
		
		$data = $this->db->query($sql)->row_array();
		$ids = trim($data['ids'], ',');
		
		$sql = "DELETE  FROM `{$this->record}`";
		$sql .= " WHERE `userid` IN ({$this->ids}) AND `usetime`='0' AND `begintime`<'{$this->date}'";
		
		$this->query($sql);
		return $ids;
	}
}

