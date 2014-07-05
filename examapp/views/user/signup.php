<div id="signup"  style="margin-top:30px;">
	<div id="errorbox">
	<?php if( !empty($error) ): ?>
		<?php foreach($error as $msg): ?>
		<p class="error" ><?php echo $msg; ?></p>
		<?php endforeach; ?>
	<?php endif; ?>
	</div>
	<form action="<?php echo base_url(); ?>user/signup" id="signupform" method="post" autocomplete="off">
		<div class="row">
			<label>邮箱</label><input type="text" name="email" value="<?php 
			if( isset($email) ){
				echo $email;
			}
			?>"/>
			<div class="clear"></div>
		</div>
		<div class="row">
			<label>用户名</label><input type="text" name="username" value="<?php 
			if( isset($username) ){
				echo $username;
			}
			?>"/>
			<div class="clear"></div>
		</div>
		<div class="row">
			<label>密码</label><input type="password" name="password" />
			<div class="clear"></div>
		</div>
		<div class="row">
			<label>确认密码</label><input type="password" name="password_enter" />
			<div class="clear"></div>
		</div>
		<div class="row">
			<div style="float:left;">
				<a href="<?php echo base_url();?>user/login/" style="line-height:24px;">已经有帐号啦?立即登录</a>
			</div>
			<div style="text-align:center;">
				<input type="submit" class="oldbutton" value="立即注册" />
			</div>
			<div class="clear"></div>
		</div>
	</form>
	<script type="text/javascript">
	(function(f, errbox){
		f.email.onkeypress = function(){
			var t = f.email.value, u = f.username.value;
			if( u.length > 0 ){
				return ;
			}
			if( t.indexOf('@') !==-1 ){
				f.username.value = t.substr(0, t.indexOf('@'));
			}
		}
		f.password_enter.onkeyup = function(){
			var p = f.password.value, e = f.password_enter.value;
			if( p !== e ){
				f.password_enter.style.borderColor = 'rgb(250, 133, 133)';
			}else{
				f.password_enter.style.borderColor = 'rgb(35, 196, 35)';
			}
		}

		var logmsg = function(msg){
			var p = document.createElement('p');
			p.innerHTML = msg;
			p.className = 'error';
			p.setAttribute('class', 'error');
			errcount++;
			errbox.appendChild(p);
		}
		
		var errcount;
		
		
		f.onsubmit = function(e){
			errcount = 0;
			while (errbox.firstChild) {
				errbox.removeChild(errbox.firstChild);
			}
			var e = e || window.event;
			var email = f.email.value, u = f.username.value,
				passwd = f.password.value, 
				passwd_enter = f.password_enter.value;
				
			if( email.length === 0 ){
				logmsg("请填写邮箱地址");
			}
			if( u.length === 0 ){
				logmsg("请填写用户名");
			}
			if( passwd.length === 0 ){
				logmsg("请填写密码");
			}else{
				if( passwd !== passwd_enter ){
					logmsg("两次输入的密码不一致");
				}
			}
			if( errcount > 0 ){
				e.returnValue = false;
			}
		}
	})(document.getElementById('signupform'), document.getElementById('errorbox'));
	</script>
</div>