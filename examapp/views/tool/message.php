<div id="message" >
	<div style="width:auto;">
		<p style="margin-top:40px; text-indent:3em;">
			<?php echo $message; ?>
		</p>
	</div>
		<p>
	<?php if( isset($location) ){ ?>
		<span id="location-time" style="color:#6684FC;" >5</span>&nbsp;&nbsp;秒后跳转到&nbsp;<a href="<?php echo base_url(); echo 'index.php/'; echo $location; ?>"><?php echo base_url(); echo 'index.php/'; echo $location; ?></a></p>
		<script type="text/javascript">
		(function(){
			var t=document.getElementById('location-time'), i= parseInt(t.innerHTML);
			
			setInterval((function(){
				if(--i===0){
					window.location.href = '<?php echo base_url(); echo 'index.php/'; echo $location; ?>'; 
				}else if(i >= 0){
					t.innerHTML=i;
				}
			}), 1000);
		})();
		</script>
	<?php } ?>
</div>
<div style="margin-top:30px; padding-top:20px; text-align:center; ">
	<p style="font-size:13px;">如有疑问，请<a href="<?php echo base_url(); ?>index.php/faq/" >访问帮助页面</a></p>
</div>
