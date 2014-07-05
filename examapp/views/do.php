﻿
	<div class="title">
		<span id="runtime"></span>
		<?php echo isset($title) ? $title : '练习'; ?> (<span id="target"></span>/<span id="count"></span>)
	</div>
	<div class="txt" style="height:550px;">
		<div class="study">
			<div class="s1">
				<div id="image">
				</div>
				<div id="question"></div>
				<ul>
					<input id="choose" name="_choose" type="hidden">
					<li id="item1" data-id="1" ></li>
					<li id="item2" data-id="2" ></li>
					<li id="item3" data-id="3" ></li>
					<li id="item4" data-id="4" ></li>
					<li id="submit_checkbox" ></li>
					<li style="clear:both"></li>
				</ul>
			</div>
			<?php if( ! defined('EXAM') || ! EXAM ){ ?>
			<div class="s2">
				<div class="choose">
					<span id="result"></span><span id="trueresult"></span><br>
					<span id="useranswer"></span>
				</div>
				<div class="control">
					<div id="button"></div>
					<div id="prenext">
						<button class="button" id="prev" onclick="" style="float: left;margin:auto 10px;" >上一题</button>
						<button class="button" id="next" onclick="" style="float: left;margin:auto 10px;" >下一题</button>
						<div class="clear"></div>
					</div>
					<div class="clear"></div>
				</div>
			</div>
			<div class="s3" style="margin:10px auto;">
				<div id="barnum" style="padding-left: 0px; background-position: 0px 0px;">1</div>
				<div style="padding:0 0 0 12px;">
					<div id="bar" class="bar">
						<img src="<?php echo STATIC_IMG_PATH; ?>bar_on.png" id="baron" style="width: 0px;">
					</div>
				</div>
			</div>
			<div class="s4">
				<a id="ajaxadderror" class="oldbutton" href="javascript:;">记为错题</a>
				<a id="ajaxaddremove" class="oldbutton" href="javascript:;">排除此题</a>
				<a id="showexplain" class="oldbutton" href="javascript:;" style="width:98px;" title="点击显示" >本题最佳解析</a>
				<label>
					<input type="checkbox" name="autonext" id="autonext">
					正确后自动下一题
				</label>
				<label>
					<strong style="font-size:14px;">转到
						<input name="listid" type="text" title="在文本框中填上题号，即可跳到这道题" id="listid" maxlength="4" style="width:28px;font-size:12px;padding:0;text-align:center;font-weight:bold;">
					</strong> &nbsp; 
				</label>
				<div class="clear"></div>
			</div>
			<div style="background:#f3f8fc;margin:25px -10px -5px;padding:20px 0 0 12px;height:60px;color:#444;">
				<!-- Baidu Button BEGIN -->
				<div id="bdshare" class="bdshare_t bds_tools_32 get-codes-bdshare">
					<span style="float:left; font-size:16px; padding-top:8px;">分享到：</span>
					<a class="bds_qzone"></a> <a class="bds_tsina"></a> <a class="bds_tqq"></a> <a class="bds_renren"></a> <a class="bds_kaixin001"></a> <a class="bds_baidu"></a> <a class="bds_t163"></a> <a class="bds_tsohu"></a> <a class="bds_tqf"></a> <a class="bds_douban"></a> <a class="bds_taobao"></a> <a class="bds_ty"></a> <a class="bds_copy"></a> <span class="bds_more">更多</span> <a class="shareCount"></a> </div>
					<script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=0" ></script>
					<script type="text/javascript" id="bdshell_js"></script>
					<script type="text/javascript">
					var bds_config = {
						'url': "<?php echo base_url(); ?>",
						'bdText': "我正在“<?php echo $this->config->config['site_name'] ?>（<?php echo trim(str_replace('http://', '', base_url()), '/'); ?>）”参加交通法规模拟练习，哥哥姐姐弟弟妹妹快来试试吧："
					};
					document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000)
					</script>
				<!-- Baidu Button END -->
			</div>

			<?php }else{ ?>
			
<div id="envon" style=" width:300px; background-color:#FFFFFF; border:1px solid rgb(243, 242, 242); padding:20px; overflow:hidden; display:none; text-align:center;"><br><br>
<script type="text/javascript"><!--
google_ad_client = "ca-pub-8821433142047294";
/* jxkst300x250 */
google_ad_slot = "1530932321";
google_ad_width = 300;
google_ad_height = 250;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
	<a href="javascript:EV_closeAlert()" class="oldbutton">继续考试</a>
</div>
			
			<div class="s2" style="height: 80px;">
				<div class="choose">
					您的选择:
					<span id="result"></span><span id="trueresult"></span><br>
					<span id="useranswer"></span>
				</div>
				<div class="control">
					<div id="button"></div>
					<div id="prenext">
						<button class="button" id="prev" onclick="" style="float: left;margin:auto 4px;" >上一题</button>
						<button class="button" id="next" onclick="" style="float: left;margin:auto 4px;">下一题</button>
						<button class="button" id="submit" style="float: left;margin:auto 10px;" >交卷</button>
						<div class="clear"></div>
					</div>
					<div class="clear"></div>
				</div>
				<div class="clear"></div>
			</div>
			
			<div class="s4" style="margin-bottom:15px;">
				<a class="oldbutton" href="javascript:EV_modeAlert('envon')">暂停</a>
				<a>剩余时间：<font color="red" id="lasttime"></font></a>				
				<div style="float:left;" class="sharediv">
					<style type="text/css">
						.sharediv a{margin:auto; }
					</style>
					<!-- JiaThis Button BEGIN -->
					<!-- Baidu Button BEGIN -->
					<div id="bdshare" class="bdshare_t bds_tools get-codes-bdshare">
					<span class="bds_more" style="line-height:14px;">分享到：</span>
					<a class="bds_sqq"></a>
					<a class="bds_tsina"></a>
					<a class="bds_qzone"></a>
					<a class="bds_tqq"></a>
					<a class="bds_renren"></a>
					<a class="shareCount"></a>
					</div>
					<script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=0" ></script>
					<script type="text/javascript" id="bdshell_js" data=""></script>
					<script type="text/javascript">
					var bds_config = {
						'url': "<?php echo base_url(); ?>",
						'bdText': "我正在“<?php echo $this->config->config['site_name'] ?>（<?php echo trim(str_replace('http://', '', base_url()), '/'); ?>）”参加交通法规模拟考试，哥哥姐姐弟弟妹妹快来试试吧："
					};
					document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000)

					</script>
			
				</div>
				<button class="oldbutton" id="flag" style="float: right;margin:auto 10px;"title="如果此题没把握就做个记号吧" >标记为难题</button>
				<label id="autonextstate" style=""><input name="autonext" type="checkbox" id="autonext" checked="checked"> 自动下一题</label>
				<div class="clear"></div>
			</div>
			<div class="a10">
				<div id="topiclist"></div>
			</div>
			<?php } ?>
			<div class="clear"></div>
		</div>
	</div>
	
	
<script type="text/javascript">
// do.js

var topic, show, starttime;
<?php if(defined('EXAM') && EXAM) :?>
var ISEXAM = true;
<?php endif; ?>



window.onload = function(){

	topic = new _topic();
	show  = new _show();		

	topic.url = '<?php echo base_url(); ?>data/question/{$id}.txt';
	<?php if(isset($remove)):?>
	topic.remove = <?php echo $remove; ?>;
	<?php endif; ?>
	topic.ids = <?php echo $ids; ?>;
	
	var newtopicids = [];
	(function(){
		if(typeof topic.remove === 'object'){
		for( var k in topic.ids ){
			var n = topic.remove.indexOf(topic.ids[k]);
			if( n === -1 ){
				newtopicids.push(topic.ids[k]);
			}
		}
		topic.ids = newtopicids;
		}
	})();

	topic.count = <?php echo isset($count) ? $count : 'topic.ids.length'; ?>;
	<?php if(isset($time)){?>
	topic.time = <?php echo $time; ?>;
	<?php } ?>
	topic.errorUrl = '<?php echo base_url(); ?>wrong/add/{$id}/?answer={$answer}';
	topic.removeUrl = '<?php echo base_url(); ?>remove/add/{$id}/';
	topic.callback = function(data, id){
		show.create(data, id);
		if( show.render.bar !== null ){
			show.setBar();
		}
	};
	
	show.nextcase = '<?php echo (defined('EXAM') && EXAM) ? 'all' : 'true'; ?>'
	show.img_path = '<?php echo STATIC_UPLOAD_PATH; ?>';
	show.eventfunc = 'topic.Q({$id});';
	show.msg_true = '恭喜您，答对了！';
	show.msg_false = '答错了，正确答案：{$answer}';

	
	if( show.render.bar !== null ){
		show.barLeft=0;
		var offsetParent = show.render.bar;
		while (offsetParent!=null && offsetParent!=document.body) 
		{
			show.barLeft+=offsetParent.offsetLeft;
			offsetParent=offsetParent.offsetParent;
		}

		show.barWidth = 704;
		show.render.bar.onmousemove = function(e) {
			var e = e || window.event;
			show.showBar(e);
		};
		show.render.bar.onmouseout = function() {
			show.setBar();
		};
		show.render.bar.onclick = function(e) {
			var e = e || window.event;
			show.clickBar(e);
		};

		show.render.baron.onmouseout = function() {
            show.setBar();
        };
		show.render.baron.onclick = function(e) {
            var e = e || window.event;
            show.clickBar(e);
        };

		show.render.listid.onkeyup = function(){
			setTimeout(function(){
				var num = parseInt(show.render.listid.value);
				if(isNaN(num)) return ;
				num -= 1;
				if( typeof topic.ids[num] === 'number' ){
					topic.Q(topic.ids[num]);
				}else{
					message.show('没有找到序号为<b>'+ (num+1) +'</b>的题', 1000);
				}
			}, 200);
		}
	}
	
	if( document.getElementById('ajaxadderror') !== null ){
		document.getElementById('ajaxadderror').onclick = function(){
			if( typeof topic.currentid === 'number' ){
				message.setMousePoint(document.getElementById('ajaxadderror'));
				topic.addError(topic.currentid, true);
			}
		};
	}
	if( document.getElementById('ajaxaddremove') !== null ){
		document.getElementById('ajaxaddremove').onclick = function(){
			if( typeof topic.currentid === 'number' ){
				message.setMousePoint(document.getElementById('ajaxaddremove'));
				topic.addRemove(topic.currentid);
				if( typeof topic.next === 'number' ){
					topic.Q(topic.next);
				}
			}
		};
	}
	if( document.getElementById('showexplain') !== null ){
		document.getElementById('showexplain').onclick = function(){
			if( typeof topic.currentid === 'number' ){
				message.setMousePoint(document.getElementById('showexplain'));
				message.pointData.y -= (show.data.explain.length+70);
				message.show(show.data.explain);
			}
		};
		document.getElementById('showexplain').onmouseout = function(){
			message.hide(500);
		};
	}
	
	show.setText(show.render.count, topic.count);	

	
	<?php if( isset($examid) ){ ?>
	
	examid = '<?php echo (int)$examid; ?>';
	
	(function(){
	var jp = document.createElement('script');
	jp.type = "text/javascript";
	jp.async = true;
	jp.src = '<?php echo STATIC_JS_PATH;?>exam.js';
	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(jp, s);
	})();
	<?php }else{ ?>
	topic.start();
	<?php } ?>
}

</script>

<div class="ad2">
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
