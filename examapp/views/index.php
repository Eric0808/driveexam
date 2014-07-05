<?php // index.php ?>

<div class="cars"> 
	<a id="p1" href="javascript:;" onmouseover="replaceflag('C1', this)" carpass="C1" class="chgcars item current">
		<strong>C1</strong> 小型汽车
	</a>
	<a id="p2" href="javascript:;" onmouseover="replaceflag('B2', this)" carpass="B2" class="chgcars item rline">
		<strong>B2</strong> 大型货车
	</a>
	<a id="p3" href="javascript:;" onmouseover="replaceflag('A1', this)" carpass="A1" class="chgcars item rline" style="border-right:1px solid #A4C9EE;">
		<strong>A1</strong> 大型客车
	</a><a class="item space"></a>
	<div class="clear"></div>
</div>
<div class="hguide">
	<div class="htop">
		<div class="htit"><span id="flagname1">C1</span> 科目一
		</div>
		<div class="hintro">2013年驾驶员理论考试最新模拟题库<br />
			<span>基础知识理论考试</span>
		</div>
		<div class="hicon"><img src="<?php echo STATIC_IMG_PATH; ?>icon_km1.gif" width="90" /></div>
		<div class="clear"></div>
	</div>
	<div class="hdesc"><strong>阶段目标：</strong>根握道路交通安全法律、法规及道路交通信号的规定。
	</div>
	<div class="hfunc">
		<a href="<?php echo base_url(); ?>orderly/" data-num="0">
			<img src="<?php echo STATIC_IMG_PATH; ?>icon_list.gif" border="0">
		</a>
		<a href="<?php echo base_url(); ?>random/"  data-num="0">
			<img src="<?php echo STATIC_IMG_PATH; ?>icon_random.gif" border="0">
		</a>
		<a href="<?php echo base_url(); ?>exam/" data-num="0">
			<img src="<?php echo STATIC_IMG_PATH; ?>icon_exam.gif" border="0">
		</a>
	</div>
</div>
<div class="hguide" style="margin-top:40px;">
	<div class="htop">
		<div class="htit"><span id="flagname2">C1</span> 科目三/科目四
		</div>
		<div class="hintro">路考后的安全文明驾驶模拟考试<br />
			<span>安全文明驾驶常识考试</span>
		</div>
		<div class="hicon"><img src="<?php echo STATIC_IMG_PATH;?>icon_km3.gif" width="90" /></div>
		<div class="clear"></div>
	</div>
	<div class="hdesc"><strong>阶段目标：</strong>学员需要掌握安全文明驾驶知识，具备对车辆综合控制能力；了解行人、非机动车的动态特点及险情的预测和分析方法；熟练掌握一般道路和夜间驾驶方法，能够根据不同的道路交通状况安全驾驶；形成自觉遵守交通法规、有效处置随机交通状况、无意识合理操纵车辆的能力。
	</div>
	<div class="hfunc">
		<a href="<?php echo base_url(); ?>orderly/" data-num="1">
			<img src="<?php echo STATIC_IMG_PATH; ?>icon_list.gif" border="0">
		</a>
		<a href="<?php echo base_url(); ?>random/"  data-num="1">
			<img src="<?php echo STATIC_IMG_PATH; ?>icon_random.gif" border="0">
		</a>
		<a href="<?php echo base_url(); ?>exam/" data-num="1">
			<img src="<?php echo STATIC_IMG_PATH; ?>icon_exam.gif" border="0">
		</a>
	</div>
</div>
<script type="text/javascript">
<?php if(isset($subjectinfo)): ?>
var subjectinfodata = <?php echo $subjectinfo;?>;
<?php endif; ?>
var subjectnametag = 'C1';
function replaceflag(replace, obj){
document.getElementById('flagname1').innerHTML = replace;
document.getElementById('flagname2').innerHTML = replace;
for(i=1;i<4;i++){
var p = document.getElementById('p'+i);
p.className = p.className.replace('current', '');
}
subjectnametag = replace;
obj.className += ' current';
}

var listenfunction = function(obj){
	return function(e){
		var subnum = obj.getAttribute('data-num');
		subnum = parseInt(subnum)
		if( isNaN(subnum) ) return ;
        if( typeof subjectinfodata === 'object' ){
            var subid = subjectinfodata[subjectnametag][subnum];
        }
        var date=new Date();
        date.setTime(date.getTime()+30*24*3600*1000);
        document.cookie = "subjectid="+subid+";expire="+date.toGMTString()+";path=/";
    }
};

(function(){
var main = document.getElementById('main'),
	urls = main.getElementsByTagName('a');
for(var k in urls){
	if(	typeof urls[k] === 'object' && 
		typeof urls[k].getAttribute('data-num') === 'string' ){
		urls[k].onclick = listenfunction(urls[k]);
	}
}
})();
</script>



</div>

<div class="box mtop">
	<div class="title">模拟试题</div>
	<div class="txt homelist" style="margin-left: 10px;">
		<ul>
			<?php foreach($newslist as $li) :?>
			<li>
				<a href="<?php echo base_url(), 'news/', $li['id'], '.html'; ?>" target="_blank" title="<?php echo $li['title'];?>" >
					<?php echo strlen($li['title'])>26 ? globalfunc::utf_substr($li['title'], 28).' ...' : $li['title']; ?>
				</a>
			</li>
			<?php endforeach; ?>
		</ul>
		<div class="clear"></div>
	</div>
</div>


<div class="box mtop">
	<div class="title">友情链接</div>
	<div class="txt homelist" style="margin-left: 10px;">
		<ul>
			<?php foreach($links as $link) :?>
			<li>
				<a href="<?php echo $link->url; ?>" target="_blank" title="<?php echo $link->name;?>" >
					<?php echo strlen($link->name)>26 ? globalfunc::utf_substr($link->name, 28).' ...' : $link->name; ?>
				</a>
			</li>
			<?php endforeach; ?>
		</ul>
		<div class="clear"></div>
	</div>