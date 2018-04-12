<?php
include_once 'include.php';
checklogin();
$do_status = 1;
$tipMsg = '';

if (isset($_POST['imgid']) && intval($_POST['imgid']) > 0) {
    // 提交修改
    $id = intval($_POST['imgid']);
    $new_expire_time = strtotime($_POST['expire_time']);
    $edittime = time();
    
    $up_sql = "UPDATE ls_imgs SET `expire_time`='{$new_expire_time}',`edittime`='{$edittime}' WHERE `id`=" . $id;
    
    $rows_affected = $db->query($up_sql);
    if ($rows_affected > 0) {
        $tipMsg = '编辑成功!';
    } else {
        $tipMsg = '编辑失败!';
    }
} else {
    // 显示修改
    $id = intval($_GET['id']);
    if ($id > 0) {
        $item = $db->get_row('select * from ls_imgs WHERE id=' . $id, ARRAY_A);
    } else {
        $tipMsg = '请求参数不正确!';
    }
    if (empty($item)) {
        $tipMsg = '请求地址不存在!';
    }
}
if (! empty($tipMsg)) {
    $do_status = 2;
}

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>正在编辑<?php echo isset($item['id'])?$item['id']:'-'?></title>
<!-- add styles -->
<link href="css/main.css" rel="stylesheet" type="text/css" />
<!-- add scripts -->
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="My97DatePicker/WdatePicker.js"></script>
<script>
 function checkForm(theForm){
	 if($('#ipt_username').val()==''){
		 $('.error').html('请输入用户名!').show();
		 return false;
	 }
	 if($('#ipt_password').val()==''){
		 $('.error').html('请输入密码!').show();
		 return false;
	 }
	 return true;
 }
</script>
</head>
<body>
<?php include 'nav.php';?>
	<div class="demo" style="margin-top: 60px;">
		<div class="bheader">
			<h2>正在编辑<?php echo isset($item['id'])?' 编号'.$item['id']:'-'?></h2>
		</div>
		<div class="bbody">
<?php if (1 == $do_status){?>
			<!-- upload form -->
			<form id="login_form" method="post" action="edit.php"
				onsubmit="return checkForm(this)">
				<div class="error"></div>
				<div class="info">
					<table class="table" width="100%">
						<tr>
							<td>编号:</td>
							<td><input type="text" name="imgid" style="width: 160px;"
								value="<?php echo $item['id']?>" /></td>
						</tr>
						<tr>
							<td>图片:</td>
							<td><a href="add.php?id=<?php echo $id;?>&ret=edit">修改图片</a><img alt="1" src="<?php echo $item['img']?>" width="20%" /></td>
						</tr>
						<tr>
							<td>过期时间:</td>
							<td><input type="text" name="expire_time" readonly style="width: 160px;"
								value="<?php echo date("Y-m-d H:i:s",$item['expire_time']) ?>"
								onClick="WdatePicker({startDate:'<?php echo date("Y-m-d H:i:s",$item['expire_time']) ?>',dateFmt:'yyyy-MM-dd HH:mm:ss'})" /></td>
						</tr>
						<tr>
							<td>添加时间:</td>
							<td><?php echo date("Y-m-d H:i",$item['addtime']) ?></td>
						</tr>
						<tr>
							<td colspan="2"><input type="submit" value="提交" />&nbsp;&nbsp;<input
								type="reset" value="重置" /></td>
						</tr>
					</table>
			
			</form>
			<?php }else if (2 == $do_status){?>
			<div class="info">
				<div>
					<?php echo $tipMsg ?>
				</div>
				<div><a href="edit.php?id=<?php echo $id;?>">继续编辑</a>&nbsp;&nbsp;|<a href="list.php">查看列表</a></div>
			</div>

			<?php }?>
		</div>
	</div>
</body>
</html>
<?php if (isset($errorMsg)){?>
<script>
$('.error').html('<?php echo $errorMsg ?>').show();
</script>
<?php }?>