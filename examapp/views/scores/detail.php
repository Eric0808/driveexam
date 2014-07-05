<?php if( !isset($list) ) exit; ?>

<div class="title">
	考试详情
</div>
<div class="txt">
	<div class="artview">
	<?php if( isset($data) && is_array($data) ): ?>
	<?php $case = $data['score'] >= 90 ? 'good' : 'bad'?>
	<div class="score s<?php echo $case; ?>">
		<div class="s1"><img src="<?php echo STATIC_IMG_PATH; ?>exam_<?php echo $case; ?>.gif" height="95"></div>
		<div class="s2">得分：<?php echo $data['score']; ?> </div>
		<div class="s3" style="margin-top:60px;">
			<div style="text-align:right;">
				答对 <em><?php echo $right; ?></em>道题 &nbsp;&nbsp;|&nbsp;&nbsp;
				答错 <em><?php echo $wrong; ?></em>道题 &nbsp;&nbsp;
			</div>
			您从 <em><?php echo date('m-d H:i:s', $data['begintime']); ?></em>开始答题 &nbsp;&nbsp;
			用时<em><?php echo ceil($data['usetime']/60); ?></em>分钟 &nbsp;&nbsp;&nbsp;&nbsp;
		</div>
		<div class="clear"></div>
	</div>
	<?php endif; ?>
	<div style="margin: 10px 20px 10px 20px;">
		<!-- Baidu Button BEGIN -->
		<div id="bdshare" class="bdshare_t bds_tools_32 get-codes-bdshare">
			<span style="float:left; font-size:16px; padding-top:8px;">分享到：</span>
			<a class="bds_qzone"></a> <a class="bds_tsina"></a> <a class="bds_tqq"></a> <a class="bds_renren"></a> <a class="bds_kaixin001"></a> <a class="bds_baidu"></a> <a class="bds_t163"></a> <a class="bds_tsohu"></a> <a class="bds_tqf"></a> <a class="bds_douban"></a> <a class="bds_taobao"></a> <a class="bds_ty"></a> <a class="bds_copy"></a> <span class="bds_more">更多</span> <a class="shareCount"></a> </div>
			<script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=0" ></script>
			<script type="text/javascript" id="bdshell_js"></script>
			<script type="text/javascript">
			var bds_config = {
				'url': "<?php echo base_url(); ?>",
				'bdText': "哈哈！我果然是天才，在“<?php echo $this->config->config['site_name'] ?>（<?php echo trim(str_replace('http://', '', base_url()), '/'); ?>）”随便一考交通法规就得了<?php echo $data['score']; ?>分，哥哥姐姐弟弟妹妹千万不要因为我的才华爱上我哦！快，你也来试试吧："
			};
			document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000)
			</script>
		</div>
		<!-- Baidu Button END -->

		<div class="clear"></div>
	</div>
	<div class="controls" style="margin-left: 20px;">
		<a href="?select=right" class="c5<?php if($_GET['select']==='right') echo ' current';?>">答对的题(<?php echo $right; ?>)</a>
		<a href="?select=error" class="c5<?php if($_GET['select']==='error') echo ' current';?>">答错的题(<?php echo $wrong; ?>)</a>
		<a href="?select=none" class="c5<?php if($_GET['select']==='none') echo ' current';?>">未答的题(<?php echo $none; ?>)</a>
		<a href="<?php echo base_url(); ?>scores/redo/<?php echo $examid; ?>/" target="_blank" class="c4">错题重做</a>
		<a href="<?php echo base_url(); ?>scores/addwrong/<?php echo $examid; ?>/" target="_blank" class="c4">加入错题库</a>
		<a href="<?php echo base_url(); ?>exam/" class=" c1">重新出卷</a>


<br><br>
<div class="ad728">
<!-- ad -->
<script type="text/javascript"><!--
google_ad_client = "ca-pub-8821433142047294";
/* 仿真考试 */
google_ad_slot = "1832630322";
google_ad_width = 728;
google_ad_height = 90;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
<!-- ad-->
</div>
	</div>
		<div class="clear"></div>
		<div class="content">
		<iframe name="none" style="display:none; width:0px; height:0px;"></iframe>
<?php if( is_array($list) && !empty($list) ){ ?>
<?php foreach($list as $n=>$li): ?>
<div class="q qc<?php echo ($n)%2; ?><?php echo ($li['useranswer']==$li['answer']) ? ' rightrow' : ' wrongrow';?>">
	<div class="q1"><?php echo ++$n; ?>、<?php echo $li['question'];?></div>
	<ul class="q2">
		<?php $answer = $li['useranswer']; echo showItem::show($li['type'], $li, $li['useranswer']); ?>
	</ul>
	<div class="q3">
		<?php if( isset($li['falsh']) ){ ?>
			<?php echo $li['falsh']; ?>
		<?php }elseif(!empty($li['thumb'])){ ?>
			<img src="<?php echo STATIC_UPLOAD_PATH;?><?php echo $li['thumb']; ?>" />
		<?php } ?>
	</div>
	<div class="clear"></div>
	<div class="q4" style="color:red;padding-bottom:10px;">
		您的答案：<img src="<?php echo STATIC_IMG_PATH; ?>choose/<?php echo $li['type']; ?>_<?php echo $li['useranswer']; ?>.jpg">
		正确答案：<img src="<?php echo STATIC_IMG_PATH; ?>choose/<?php echo $li['type']; ?>_<?php echo $li['answer']; ?>.jpg">
		<span class="q5">
			<a href="<?php echo base_url(); ?>jieshi/<?php echo $li['id']?>.html" target="_blank">查看题解</a>
			&nbsp; &nbsp;
			<a onclick="message.show('已加入错题库', 3000);" href="<?php echo base_url(); ?>wrong/add/<?php echo $li['id']?>?answer=<?php echo $answer; ?>" target="none">记为错题</a>
		</span>
	</div>
</div>

<?php endforeach; ?>

	<div class="controls" style="margin-left: 20px;">

		<a href="<?php echo base_url(); ?>scores/redo/<?php echo $examid; ?>/" target="_blank" class="c4">错题重做</a>
		<a href="<?php echo base_url(); ?>scores/addwrong/<?php echo $examid; ?>/" target="_blank" class="c4">加入错题库</a>
		<a href="<?php echo base_url(); ?>exam/" class=" c1">重新出卷</a>

</div>

<?php }else{ ?>
<p>非常抱歉，为了能维持网站持续稳定的运行，所以如果您是未登录访客，那么您的答题详细数据只会保留30天。</p><p>您可以<a href="<?php echo base_url(), 'user/signup'?>">免费注册</a>成为我们的会员，这样您的模拟考试记录，错题记录都会持久保留</p>
<?php } ?>
		</div>
	</div>
	<div class="clear"></div>
</div>
