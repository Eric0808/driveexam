<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Topic_model extends CI_Model { 

	private $table = 'topic_info';
	private $table1 = 'explain_info';
	private $table2 = 'test_bank';
	private $table3 = 'cate_info';
	private $table4 = 'chapter_info';
   
    function __construct()
     {
         parent::__construct();
		 
		 $this->db->query('SET group_concat_max_len = 99999');
     }
	
	
	
	//增加新的试题
	function Addtopic($sqlstr){
		$sqlstr=str_replace('table_info',$this->table,$sqlstr);
		$this->db->query($sqlstr);
		$result = $this->db->insert_id();//返回插入时的ID
		return $result;
		
	}
	
	//增加题解
	function Addexplain($sqlstr){
		$sqlstr=str_replace('table_info',$this->table1,$sqlstr);
		$this->db->query($sqlstr);
		$result = $this->db->insert_id();//返回插入时的ID
		return $result;
		
	}
	
	//获取所有试题列表
	function Getalltopics($page = 1, $pageSize = 20, $setPages = 10, $where='', $order=''){
		$sqlStr = "SELECT * FROM {$this->table} AS t   LEFT JOIN {$this->table3} as c ON t.catalog=c.cateid  ";
		$sqlStr1 = "SELECT COUNT(*) FROM {$this->table} {$where} ";
		$allnum=$this->gettopic_num($sqlStr1);
		$page = max(intval($page), 1);
		$offset = $pageSize*($page-1);
		$query[0] =$this->globalfunc->pages($allnum, $page, $pageSize,$setPages);
		if($allnum >0){
			$sqlStr .= " $where $order LIMIT $offset, $pageSize";
			
			$query[1] = $this->db->query($sqlStr)->result();
			return $query;
		}		
		else
		return null;
	}
	
	/*根据ID更新章节*/
	function Updatechapter_byid($data, $topicID){
		if($topicID!=0){
			$this->db->where('id', $topicID);
			$result=$this->db->update($this->table, $data); 
			return $result;
		}
		else
		return false;
	
	}
	
	//根据条件获取所有试题的数量
	public function gettopic_num($sqlStr){
		
		$num = $this->db->query($sqlStr)->row_array();
		return $num['COUNT(*)'];
	}
	
	//获取试题详情根据ID 
	//修改0324
	function Detail($id) {
		if(is_numeric($id)){
		
			$sqlStr = "SELECT * FROM {$this->table} AS t  LEFT JOIN (SELECT id as bank, name as bankname FROM {$this->table2}) AS b ON t.bankid = b.bank LEFT JOIN {$this->table3} as c ON t.catalog=c.cateid  LEFT JOIN  {$this->table1} as e ON e.topicid=t.id  where t.id = $id LIMIT 1";
			$query = $this->db->query($sqlStr)->row_array();
			return $query;
		}
		if(is_string($id) && $id=="ALL"){
		
			$sqlStr = "SELECT * FROM {$this->table} AS t  LEFT JOIN (SELECT id as bank, name as bankname FROM {$this->table2}) AS b ON t.bankid = b.bank LEFT JOIN {$this->table3} as c ON t.catalog=c.cateid  LEFT JOIN  {$this->table1} as e ON e.topicid=t.id ";
			$query = $this->db->query($sqlStr)->result_array();
			return $query;
		}
		
	}
	
	//根据ID删除试题
	function Delete_bytid($id){
		$query = $this->db->delete($this->table,array('id'=>$id));
		if($query){
			$query1 = $this->db->delete($this->table1,array('topicid'=>$id));
			if($query1)
			return true;
			else
			return false;
			}
		else
		    return false;
	}
	/*根据ID更新试题*/
	function Updatetopic_byid($data, $topicID){
		if($topicID!=0){
			$this->db->where('id', $topicID);
			$result=$this->db->update($this->table, $data); 
			return $result;
		}
		else
		return false;
	
	}
	/*根据ID更新题解*/
	function Updateexplain_byid($data, $explainID){
		if($explainID!=0){
			$this->db->where('id', $explainID);
			$result=$this->db->update($this->table1, $data); 
			return $result;
		}
		else
		return false;
	
	}
	/*根据试题ID获取题解ID*/
	function GetexplainID_bytid($tID){
		$sqlStr = "SELECT `id` FROM {$this->table1} WHERE `topicid`=$tID";
		$query = $this->db->query($sqlStr)->row_array();
		if($query){
			return $query['id'];
		}
		else
		return false;
		
	}
	
	//获取当前题解的上一条下一条
	function Getnextup($currentID){
		$sqlStr1 = "SELECT `id`,`question` FROM  `topic_info` WHERE  `id` >$currentID LIMIT 0 , 1"; 
		$sqlStr2 = "SELECT `id`,`question` FROM  `topic_info` WHERE  `id` <$currentID  ORDER BY `id` DESC LIMIT 0 , 1"; 
		$arrReturn = array();
		$arrReturn[] = $this->db->query($sqlStr2)->row_array();
		$arrReturn[] = $this->db->query($sqlStr1)->row_array();
		
		return $arrReturn;
		
	}
	
	function getTopicIDLengthByType($type, $answer)
	{
		$type = (int)$type;
		$where = "`type`= '{$type}'";
		if( !is_null($answer) ){
			$where .= " AND `answer` = {$answer}";
		}
		$and = $this->getWhere();
		if($and)	$where .= " AND {$and}";
		
		$this->db->select('GROUP_CONCAT(`id`) as `ids`');
		$this->db->where($where, null, false);
		$query = $this->db->get($this->table);
		$this->db->order_by("id", "desc"); 
		$result = $query->row_array();
		
		return trim($result['ids'], ',');
	}
	
	function getTopicIDLengthByCatid($catid)
	{
		if( is_array($catid) ){
			$catid = implode(',', $catid);
		}
		$where = "`catalog` IN ({$catid})";
		$and = $this->getWhere();
		if($and)	$where .= " AND {$and}";
		
		$this->db->select('GROUP_CONCAT(`id`) as `ids`');
		$this->db->where($where, null, false);
		$query = $this->db->get($this->table);
		$this->db->order_by("id", "desc"); 
		$result = $query->row_array();

		return trim($result['ids'], ',');
	}
	
	
	public function getTopicsByBankid($bankid, $page){

		$where = "WHERE `bankid` LIKE '%{$bankid},%'";
		
		$sqlStr = "SELECT * FROM {$this->table} AS t";
		$sqlStr1 = "SELECT COUNT(*) FROM {$this->table} {$where} ";
		$allnum=$this->gettopic_num($sqlStr1);
		
		$page = max(intval($page), 1);
		$offset = 20*($page-1);
		$query['pages'] =$this->globalfunc->pages($allnum, $page, 20, 7);
		if($allnum >0){
			$sqlStr .= " $where LIMIT $offset, 20";
			$query['lists'] = $this->db->query($sqlStr)->result_array();
		}
		return $query;
	}
	
	
	public function getTopicID($rand=false)
	{
		$where = $this->setCateWhere();
		$where2 = $this->setChapterWhere();
		$where3 = $this->getWhere();
		
		$this->db->select('GROUP_CONCAT(`id`) as `ids`', false);
		$this->db->where($where, null, false);
		// 关联章节
	
		$where2 && $this->db->where($where2, null, false);
		$where3 && $this->db->where($where3, null, false);
		
        $result = $this->db->get($this->table)->row_array();

		if( empty($result) ){
			return '';
		}
		$ids = $result['ids'];
		unset($result);
		if( $rand ){
			$ids = explode(',', $ids);
			shuffle($ids);
			$ids = implode(',', $ids);
		}

		return $ids;
	}
	
	public function getTopicIdsByType($type, $limit)
	{
		$where2 = $this->getWhere();
		$where = $this->setCateWhere();
		
		$this->db->select('`id`', false);
		$this->db->where('type', $type);
		$where2 && $this->db->where($where2, null, false);
		$this->db->where($where, null, false);
		$this->db->order_by('RAND()');
        $results = $this->db->get($this->table, $limit)->result_array();
		$ids = '';
		foreach($results as $result){
			$ids .= ','. $result['id'];
		}
		
		return trim($ids, ',');
	}
	
	
	public function getAnswerByIds($ids)
	{
		$ids = trim($ids, ',');
		if( empty($ids)){
			return array();
		}
		
		$sql = "SELECT `id`, `answer` FROM {$this->table}";
		$sql .= " WHERE `id` IN ({$ids})";
		
		$data = $this->db->query($sql)->result_array();
		$result = array();
		
		foreach($data as $row){
			$id = (int)$row['id'];
			$answer = (int)$row['answer'];
			$result[$id] = $answer;
		}
		
		return $result;
	}
	
	
	public function setCateWhere()
	{
		$ci = get_instance();
		$ci->load->model('cate_model', 'cate');
		$idin = $ci->cate->getWherein(@$_COOKIE['subjectid']);
		if( $idin === '' ){
			$idin = 0;
		}
		return "catalog IN ($idin) ";
	}
	
	public function setChapterWhere()
	{
		if( isset($_GET['chapter']) && is_numeric($_GET['chapter']) ){
			return "chapid = '{$_GET['chapter']}'";
		}
	}
	
	
	public function getWhere()
	{	
		$id = isset($_COOKIE['subjectid']) ? $_COOKIE['subjectid'] : 1;
		$name = 'id';
	
		$this->load->driver('cache', array('adapter' => 'file'));
		$key = 'bankwhere_'.$id;
		if( $bankwhere = $this->cache->get($key) ){
			return $bankwhere;
		}
	
		if( strpos($id, '-') !==false ){
			list($id1, $id2) = explode('-', $id);
			$id1 = (int)$id1;
			$id2 = (int)$id2;
			$s = trim("{$id1}, {$id2}", ',');
			$where = "`{$name}` IN ({$s})";
		}else{
			$id = (int)$id;
			$where = "`{$name}` = '{$id}'";
		}
		
		$sql = "SELECT `bankid` FROM `subject_info` WHERE {$where}";
		$rows = $this->db->query($sql)->result_array();
		
		$where = array();
		if( ! empty($rows) ){
			foreach($rows as $row){
				$where[] = "`bankid` LIKE '%{$row['bankid']},%'";
			}
		}
		
		if( count($where) >1 ){
			$where = ' ( '. implode(' OR ', $where) .' ) ';
		}elseif( count($where) === 1 ){
			$where = $where[0];
		}else{
			$where = false;
		}
		
		// 缓存结果5分钟
		$this->cache->save($key, $where, 300);
		return $where;
	}
}
