	<script type="text/javascript">
	var topic, show, starttime;
	
	if( ! Array.prototype.indexOf ){
		Array.prototype.indexOf = function(find){
			for(var k in this){
				if(this.k === find){
					return k;
				}
			}
			return -1;
		}
	}
	

	window.onload = function(){
		topic = new _topic();
		show  = new _show();
		
		topic.url = '<?php echo base_url(); ?>data/question/{$id}.txt';
		topic.ids = <?php echo $ids; ?>;
		topic.count = <?php echo $count; ?>;
		topic.errorUrl = '<?php echo base_url(); ?>wrong/add/?id={$id}&answer={$answer}';
		topic.callback = function(data, id){ 
			show.create(data, id);
			show.setBar();
		};
		
		
		show.img_path = '<?php echo STATIC_UPLOAD_PATH; ?>';
		show.eventfunc = 'topic.Q({$id});';
		show.msg_true = '恭喜您，答对了！';
		show.msg_false = '答错了，正确答案：{$answer}';
		for( var k in topic.ids ){
			topic.Q(topic.ids[k]);
			break;
		}
		
		
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
		show.render.listid.onkeyup = function(){
			setTimeout(function(){
				var num = parseInt(show.render.listid.value);
				isNaN(num) || topic.Q(num);
			}, 200);
		}
		
	}
	</script>
	<div class="title">
		<span id="runtime"></span>
		筛选练习 (<span id="target"></span>/<span id="count"><?php echo $count; ?></span>)
	</div>
	<div class="txt" style="height:630px;">
		<div class="study">
			<div class="s1">
				<div id="image"></div>
				<div id="question"></div>
				<ul>
					<input id="choose" name="_choose" type="hidden">
					<li id="item1" data-id="1" ></li>
					<li id="item2" data-id="2" ></li>
					<li id="item3" data-id="3" ></li>
					<li id="item4" data-id="4" ></li>
					<li style="clear:both"></li>
				</ul>
			</div>
			<div class="s2">
				<div class="choose">
					<span id="result"></span><span id="trueresult"></span><br>
					<span id="useranswer"></span>
				</div>
				<div class="control">
					<div id="button">
					</div>
					<div id="prenext">
						<button class="button" id="prev" onclick="" >上一题</button>
						<button class="button" id="next" onclick="" >下一题</button>
					</div>
					<div class="clear"></div>
				</div>
			</div>
			<div class="s3">
				<div id="barnum" style="padding-left: 0px; background-position: 0px 0px;">1</div>
				<div style="padding:0 0 0 12px;">
					<div id="bar" class="bar">
						<img src="<?php echo STATIC_IMG_PATH; ?>bar_on.png" id="baron" style="width: 0px;">
					</div>
				</div>
			</div>
			<div class="s4"><a id="ajaxerror" href="javascript:;">记为错题</a> <a id="ajaxremove" href="javascript:;">排除此题</a><a id="showexplain" href="javascript:;" style="width:98px;">本题最佳解析</a>
				<label>
					<input type="checkbox" name="autonext" id="autonext">
					正确后自动下一题
				</label>
				<label>
					<strong style="font-size:14px;">转到第 
						<input name="listid" type="text" id="listid" maxlength="4" style="width:28px;font-size:12px;padding:0;text-align:center;font-weight:bold;">
					题</strong> &nbsp; 
				</label>
				<div class="clear"></div>
			</div>

			<div style="background:#f3f8fc;margin:25px -10px -5px;padding:20px 0 0 12px;height:60px;color:#444;">
				<!-- Baidu Button BEGIN -->
				<div id="bdshare" class="bdshare_t bds_tools_32 get-codes-bdshare"><span style="float:left; font-size:16px; padding-top:8px;">分享到：</span> <a class="bds_qzone" title="分享到QQ空间" href="#"></a> <a class="bds_tsina" title="分享到新浪微博" href="#"></a> <a class="bds_tqq" title="分享到腾讯微博" href="#"></a> <a class="bds_renren" title="分享到人人网" href="#"></a> <a class="bds_kaixin001" title="分享到开心网" href="#"></a> <a class="bds_baidu" title="分享到百度搜藏" href="#"></a> <a class="bds_t163" title="分享到网易微博" href="#"></a> <a class="bds_tsohu" title="分享到搜狐微博" href="#"></a> <a class="bds_tqf" title="分享到腾讯朋友" href="#"></a> <a class="bds_douban" title="分享到豆瓣网" href="#"></a> <a class="bds_taobao" title="分享到我的淘宝" href="#"></a> <a class="bds_ty" title="分享到天涯社区" href="#"></a> <a class="bds_copy" title="分享到复制网址" href="#"></a> <span class="bds_more">更多</span> <a class="shareCount" href="#" title="累计分享2346次">2346</a> </div>
				<!-- Baidu Button END -->
			</div>
		</div>
	</div>