<div class="mainw">
	<div class="left_t" style="width:164px">
            <fieldset>
                <legend>驾考考试试场</legend>
                <div class="kc cblue">
                    <SPAN id="lbltiku"></SPAN>
					<?php if( isset($examid) ){ ?>
	                   全国第 <?php echo (int)$examid; ?> 考场
						<?php } ?>
					</div>
            </fieldset>
            <fieldset class="t10">
                <legend>考生信息</legend>
                <div class="kaoshenginfo">
                    <img src="<?php echo STATIC_IMG_PATH;?>kaosheng.png">
                    <ul>
                        <li>考生姓名：<span id=turename><?php echo $uname;?></span></li>
                        <li>性    别：<SPAN id="xingbie"><?php echo $sex;?></SPAN></li>
                        <li>考试车型：<SPAN id="lbldrivetype">
						<?php if(isset($sbjname)){
						echo htmlspecialchars($sbjname);
						}?>	
						</SPAN></li>
                        <li>申请原因：初次申请</li>
                    </ul>
                </div>
            </fieldset>
            <fieldset class="t10">
                <legend>剩余时间</legend>
                <div class="times" id="div_times"><font color="red" id="lasttime"></font></div>
            </fieldset>
        </div>
		
	 <div class="midd" style="width:826px">
            <fieldset>
                <legend>考试题目</legend>
		
		<span id="count" style="visibility:hidden;"></span>
	
	<div class="txt" style="height:266px;">
		<div class="study">
			<div class="s1">
				<div id="image">
				</div>
				<div id="question">
			
				</div>
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
			
			<DIV id="ErrTipAreaHtml">
<DIV class="ConfirmArea ErrTipArea" style="width:700px;"><B>信息提示</B>
<P>亲爱的驾考学员：</P><I>很遗憾！您已经做错了<STRONG><?php echo $wrong_max;?></STRONG>题！您本次考试成绩不合格！祝您下次考试成功！
</I><EM>正式考试时，错误超过<?php echo $wrong_max;?>题本次考试就被判为不合格。无论你下面怎么答题，都不会超过分的。由于我们这是模拟考试，您可以选择继续考试。</EM><SPAN><INPUT id="lookresult" onclick="lookresult();" type="button" value="查看分数"><INPUT type=button value='继续考试' onclick="javascript:EV_closeAlert();"></SPAN></DIV></DIV>
 <DIV id=ResultAreaHtml>
<DIV class="ConfirmArea ErrTipArea" style="width:700px;"><B>信息提示</B>
<P>亲爱的驾考学员：</P><I>恭喜您，您本次考试得<STRONG>90</STRONG>分，合格。请准备下一科目的训练和考试。你也可以点击“查看详情”跟你的好友分享下哦！
</I><SPAN><INPUT id="lookresult" onclick="lookresult();" type="button" value="查看详情"><INPUT type=button value='关闭' onclick="javascript:EV_closeAlert();"></SPAN></DIV></DIV>
			
			<div class="s2" style="height: 80px;">
				<div class="choose">
					您的选择:
					<span id="result"></span><span id="trueresult"></span><br>
					<span id="useranswer"></span>
				</div>
				<div class="control">
				<table border="0" cellpadding="0" cellspacing="0" width="280">
				<tbody><tr>
				<td width="66">选择：</td>
				<td><div id="button"></div></td>
				</tr></tbody></table>
				</div>
				<div class="clear"></div>
			</div>
			
			
			
		</div>
	</div>
	</fieldset>
	
	<div class="tsxx">
	
                <div  class="nfjbtn">
				
<input class="oldbutton" id="flag" type="hidden" style="margin:auto 10px;"title="" />
				
                   <input value="暂 停" onClick="javascript:EV_modeAlert('envon')" id="btn_fzst_stop" type="button"/>
				   <input value="上一题" onClick="" id="prev" type="button"/>
				   <input value="下一题" onClick="" id="next" type="button"/>
				   <input value="交 卷"  id="submit" type="button">
				   </div>
                <div class="dtishis">
                    <fieldset>
                        <legend class="cblue">提示信息</legend>
                        <div class="tishis" id="tip"></div>
                    </fieldset>
                </div>
            </div>
</div>	

<div class="clear"></div>
        <div class="full">
            <fieldset>
                <legend>答题信息</legend>
                <div class="bgg" style="padding:15px 10px;">
                <div class="a10_t">
				<div id="topiclist"></div>
			</div>
			<?php } ?>
			<div class="clear"></div>
               
                </div>
 
           

            <fieldset>
			<!-- Baidu Button BEGIN -->
			<div id="bdshare" class="bdshare_t bds_tools_32 get-codes-bdshare">
			<a class="bds_tfh"></a>
			<a class="bds_hi"></a>
			<a class="bds_thx"></a>
			<a class="bds_qy"></a>
			<a class="bds_mogujie"></a>
			<a class="bds_tsohu"></a>
			<a class="bds_t163"></a>
			<a class="bds_kaixin001"></a>
			<a class="bds_sqq"></a>
			<a class="bds_diandian"></a>
			<a class="bds_taobao"></a>
			<a class="bds_tqf"></a>
			<a class="bds_msn"></a>
			<a class="bds_qq"></a>
			<a class="bds_douban"></a>
			<a class="bds_ty"></a>
			<a class="bds_baidu"></a>
			<a class="bds_tqq"></a>
			<a class="bds_renren"></a>
			<a class="bds_qzone"></a>
			<a class="bds_mshare"></a>
			<a class="bds_tsina"></a>
			<span class="bds_more"></span>
			<a class="shareCount"></a>
			</div>
			<script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=0" ></script>
					<script type="text/javascript" id="bdshell_js" data=""></script>
					<script type="text/javascript">
					var bds_config = {
						'url': "<?php echo base_url(); ?>",
						'bdText': "我正在“<?php echo $this->config->config['site_name'] ?>（<?php echo trim(str_replace('http://', '', base_url()), '/'); ?>）”参加交通法规仿真考试，哥哥姐姐弟弟妹妹快来试试吧："
					};
					document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000)

					</script>
<!-- Baidu Button END -->
            </fieldset>           </fieldset>



        </div>

</div>	
<script type="text/javascript">
// do.js

var topic, show, starttime;
<?php if(defined('EXAM') && EXAM) :?>
var ISEXAM = true;
<?php endif; ?>

var PASSNUM = 0;

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
	jp.src = '<?php echo STATIC_JS_PATH;?>trueexam/exam.js';
	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(jp, s);
	})();
	<?php }else{ ?>
	topic.start();
	<?php } ?>
}
function lookresult(){
var submit = new _submit;
	var data = submit.getValue();
	message.show("正在向服务器传送数据，请稍等 ...");
	submit.send(data);
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
