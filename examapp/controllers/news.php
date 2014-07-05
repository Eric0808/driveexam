<?php

final class News extends J_Controller
{
	public function show($id=null)
	{
		if( ! is_null($id) ){
			$this->load->model('news_model', 'news');
			$info = $this->news->get($id);
			if( !empty($info) ){
				if( $info['isbank'] && is_numeric($info['bankid']) ){
					$this->load->helper('showitem_helper');
					$this->load->model('topic_model', 'topic');
					
					$info['page'] = isset($_GET['page']) ? (int)$_GET['page'] : 1;
					$data = $this->topic->getTopicsByBankid($info['bankid'], $info['page']);
					
					$info = array_merge($info, $data);
				}
			
				$prevnext = $this->news->getprevnext($id);
				if( isset($prevnext[0]) && !empty($prevnext[0]) ){
					$setting['prev'] = $info['prev'] = $prevnext[0];
				}
				if( isset($prevnext[1]) && !empty($prevnext[1]) ){
					$setting['next'] = $info['next'] = $prevnext[1];
				}
				$content = $this->load->view('news/content', $info, true);
			
				$setting['description'] = $info['title'];
				$this->layout($info['title'], $content, $setting);
				return ;
			}
		}
		
		$this->layout('文章未找到', 404);
	}
	
	public function top()
	{
		$this->load->model('news_model', 'news');
		$top = $this->news->getTopNews();
		if( $top ){
			$date = date('m-d', $top['inputtime']);
			$response = "<a style=\"margin-left:30px;\" href=\"".base_url()."news/{$top['id']}.html\" >{$date}  &nbsp; {$top['title']}</a>";
			echo $response;
		}
	}
	
}