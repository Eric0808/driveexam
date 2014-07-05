<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
<link rel="stylesheet" type="text/css" href="<?php echo STATIC_CSS_PATH; ?>table_form.css" charset="UTF-8"/>
<script type="text/javascript" src="<?php echo STATIC_JS_PATH; ?>jquery.min.js" charset="UTF-8"></script>
<script type="text/javascript" src="<?php echo STATIC_JS_PATH; ?>formvalidator.js" charset="UTF-8"></script>
<script type="text/javascript" src="<?php echo STATIC_JS_PATH; ?>formvalidatorregex.js" charset="UTF-8"></script>
<script type="text/javascript">
  $(document).ready(function() {
	$.formValidator.initConfig({autotip:true,formid:"myform",onerror:function(msg){}});
	$("#drivetype").formValidator({empty:false,onshow:"请填写车型名称 如：A1、B2、C1。",onfocus:"车型不能为空！",oncorrect:"OK"}).inputValidator({min:1,max:5,onerror:"应该为1-5位字符之间"});
	$("#subject1").formValidator({empty:false,onshow:"请填写科目",onfocus:"科目不能为空！",oncorrect:"OK"}).inputValidator({min:1,max:30,onerror:"应该为1-20位字符之间"});
	$("#remark").formValidator({empty:false,onshow:"备注信息将显示在首页车型切换处",onfocus:"备注不能为空！",oncorrect:"OK"}).inputValidator({min:1,max:30,onerror:"应该为1-30位字符之间"});
	$("#bankid").formValidator({empty:true,onshow:"请填写绑定题库的ID",onfocus:"只能绑定一个题库！",oncorrect:"OK"}).inputValidator({min:0,max:8,onerror:"应该为0-8位字符之间"});
	$("#chapterid").formValidator({empty:false,onshow:"请以英文逗号隔开填写章节ID",onfocus:"例如：1,2,3,4",oncorrect:"OK"}).inputValidator({min:1,max:30,onerror:"应该为1-50位字符之间"});
  })
</script>
</head>

<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="30"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="24" bgcolor="#353c44"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="6%" height="19" valign="bottom"><div align="center"><img src="<?php echo STATIC_IMG_PATH; ?>admin_img/tb.gif" width="14" height="14" /></div></td>
                <td width="94%" valign="bottom"><span class="STYLE1"> 编辑车型/科目</span></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>
	<?php echo form_open('admin/drive_type/editby_id',array('target'=>'rightFrame','name'=>'myform','id'=>'myform'));?>
	<table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#a8c7ce">
     <input  type="hidden" name="edit_id" value="<?php echo $editid;?>"/>
      <tr>
        <td height="30" width="10%" bgcolor="#FFFFFF" class="STYLE6">
		<div class="input-div1"><span class="STYLE19">车型：</span></div>
		</td>
        <td height="20" bgcolor="#FFFFFF" class="STYLE19">
		<div  class="input-div2"><input type="text" value="<?php echo $typeinfo['drivetype'] ?>" id="drivetype" class="input-text" name="drivetype"></div>
		</td>
      </tr>
      <tr>
        <td height="30" width="10%" bgcolor="#FFFFFF" class="STYLE6">
		<div class="input-div1"><span class="STYLE19">科目：</span></div>
		</td>
        <td height="20" bgcolor="#FFFFFF" class="STYLE19">
		<div  class="input-div2"><input type="text" value="<?php echo $typeinfo['subject1'] ?>" id="subject1" class="input-text" name="subject1"></div>
		</td>
      </tr>
       <tr>
        <td height="30" width="10%" bgcolor="#FFFFFF" class="STYLE6">
		<div class="input-div1"><span class="STYLE19">备注：</span></div>
		</td>
        <td height="20" bgcolor="#FFFFFF" class="STYLE19">
		<div  class="input-div2"><input type="text" value="<?php echo $typeinfo['remark'] ?>" id="remark" class="input-text" name="remark"></div>
		</td>
      </tr>
	  <tr>
        <td height="30" width="10%" bgcolor="#FFFFFF" class="STYLE6">
		<div class="input-div1"><span class="STYLE19">绑定题库ID：</span></div>
		</td>
        <td height="20" bgcolor="#FFFFFF" class="STYLE19">
		<div  class="input-div2"><input type="text" value="<?php echo $typeinfo['bankid'] ?>" size="3" id="bankid" class="input-text" name="bankid"></div>
		</td>
      </tr>
	  <tr>
        <td height="30" width="10%" bgcolor="#FFFFFF" class="STYLE6">
		<div class="input-div1"><span class="STYLE19">绑定章节ID：</span></div>
		</td>
        <td height="20" bgcolor="#FFFFFF" class="STYLE19">
		<div  class="input-div2"><input type="text" value="<?php echo $typeinfo['chaperid'] ?>" id="chapterid" class="input-text" name="chapterid"></div>
		</td>
      </tr>
	  <tr>
        <td height="30" width="10%" bgcolor="#FFFFFF" colspan="2" class="STYLE6">
		<div class="input-div2" style="padding-left: 400px;"><input type="submit" value="提交" id="dosubmit"/></div>
		</td>
        
      </tr>
    </table>
	</form>
	</td>
  </tr>
  
</table>
</body>
</html>
