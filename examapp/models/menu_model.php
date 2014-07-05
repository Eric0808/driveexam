<?php

final class Menu_model extends CI_Model
{
	public function __construct()
	{
	
	}
	
	public function getMenu()
	{
		return array(
			'chapter' => '章节练习',
			'orderly' => '顺序练习',
			'random' => '随机练习',
			'select' => '筛选练习',
			'exam' => '模拟考试',
			'trueexam' => '仿真考场',
			'scores' => '历史成绩',
			'wrong' => '我的错题',
			'remove' => '排除的题'
		);
	}

	public function getUserCenter()
	{
		return array(
			'user' => '会员中心',
			'scores' => '历史成绩',
            'wrong' => '我的错题',
            'remove' => '排除的题',
			'user/change' => '修改信息',
            'user/password' => '修改密码',
			'user/logout' => '退出登录'
		);
	}
}
