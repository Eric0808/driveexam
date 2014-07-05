<?php

final class showItem
{
	private $useranswer;

	public static function show($type, &$data, $useranswer=null)
	{
		$type = (int)$type;
		switch($type)
		{
			case 0:
				$list = self::createSelected($data);
				if( isset($data['useranswer']) && $data['useranswer'] > 2 ){
					$data['useranswer'] = 1;
				}
			break;
			case 1:
				$list = self::createRadio($data);
			break;
			case 2:
				$list = self::createCheckbox($data);
			break;
		}
		if( isset($data['useranswer']) && $data['useranswer'] == '0' ){
			$data['type'] = '2';
			$data['useranswer'] = '5';
		}
		
		$fileinfo = explode('.', $data['image']);
		if(isset($fileinfo[1]) && $fileinfo[1] === 'swf'){
			$upload = STATIC_UPLOAD_PATH;
			$data['falsh'] = <<<html
	<object codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab" id="imgsrc">
		<param name="movie" value="{$upload}{$data['image']}">
		<param name="quality" value="high">
		<param name="bgcolor" value="snow">
		<embed src="{$upload}{$data['image']}" quality="high" bgcolor="#869ca7" width="220" height="175" align="middle" name="movie" play="true" loop="true" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer">
	</object>	
html;
		}else{
			if( empty($data['thumb']) )
				$data['thumb'] = $data['image'];
		}
		
		return $list;
	}

	// 判断
	private static function createSelected(array $list)
	{
		if( empty($list['item1']) ){
			$list['item1'] = '√、正确';
		}
		if( empty($list['item2']) ){
			$list['item2'] = '×、错误';
		}
		$str = "<li>{$list['item1']}</li>";
		$str .= "<li>{$list['item2']}</li>";
		return $str;
	}
	// 单选
	private static function createRadio(array $list)
	{
		$str = "<li>A、{$list['item1']}</li>";
		$str .= "<li>B、{$list['item2']}</li>";
		$str .= "<li>C、{$list['item3']}</li>";
		$str .= "<li>D、{$list['item4']}</li>";
		return $str;
	}
	
	// 多选
	private static function createCheckbox(array $list)
	{
		return self::createRadio($list);
	}
	
	
}