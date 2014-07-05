<div id="login" style="margin-top:30px;">
	<?php if( !empty($error) ): ?>
	<div id="errorbox" >
		<?php foreach($error as $msg): ?>
		<p class="error" ><?php echo $msg; ?></p>
		<?php endforeach; ?>
	</div>
	<?php endif; ?>
	<form action="<?php echo base_url(); ?>user/login" method="post" autocomplete="off">
		<div class="row">
			<label>邮箱</label><input type="text" name="email" value="<?php 
			if( isset($email) ){
				echo $email;
			}
			?>"/>
			<div class="clear"></div>
		</div>
		<div class="row">
			<label>密码</label><input type="password" name="password" />
			<div class="clear"></div>
		</div>
		<div class="row">
			<div style="float:left;">
				<a href="<?php echo base_url();?>user/signup/" style="line-height:24px;">还没有帐号?立即注册</a>
			</div>
			<div style="text-align:center;" class="row">
				<input type="submit" class="oldbutton" value="登录" />
			</div>
			<div class="clear"></div>
		</div>
	</form>
</div>