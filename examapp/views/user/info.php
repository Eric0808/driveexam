<div class="txt" style="height:530px;">
	<div class="title">会员中心</div>
	<table width="100%" border="0" cellpadding="2" cellspacing="0" style="background:none;" >
		<tbody><tr>
			<td width="166"  align="right">&nbsp;</td>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td align="right" style="text-align:right;">用 户 名：</td>
			<td width="272"><?php echo $username; ?></td>
		</tr>
		<tr>
			<td align="right">电子邮箱：</td>
			<td><?php echo $email; ?></td>
		</tr>
		<tr>
			<td align="right">登录地址：</td>
			<td><?php echo $regip; ?></td>
		</tr>
		<tr>
			<td align="right">登录时间：</td>
			<td><?php echo date('Y-m-d H:i:s', $regdate); ?></td>
		</tr>
		<tr>
			<td align="right">登录次数：</td>
			<td><?php echo $loginnum?> 次</td>
		</tr>

		</tbody>
	</table>
</div>