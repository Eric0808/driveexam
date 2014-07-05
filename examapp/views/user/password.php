<div class="title" >修改密码</div>
<div class="txt" style="height:530px;">
	<table width="100%" border="0" cellpadding="2" cellspacing="0">
		<form action="<?php echo base_url(); ?>user/password/" method="post" name="password" id="password">
			<input name="act" type="hidden" value="edit">
			<tbody>
			<tr>
				<td align="right">&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td width="150" align="right">旧密码：</td>
				<td><input type="password" name="old" id="oldpass"></td>
			</tr>
			<tr>
				<td align="right">新密码：</td>
				<td><input name="new" type="password" id="newpass"></td>
			</tr>
			<tr>
				<td align="right">确认新密码：</td>
				<td><input name="renew" type="password" id="repass"></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>
					<input type="submit" name="submit" class="button" value="提交修改"/>
				</td>
			</tr>
			</tbody>
		</form>
	</table>
</div>