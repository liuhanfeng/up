<?php
include_once 'include.php';

$login_status = 1;
if (isset($_SESSION['uuserid']) && intval($_SESSION['uuserid']) > 0) {
    $login_status = 3;
} else 
    if (isset($_POST['username'])) {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        $list = $db->get_row('select * from ls_admin WHERE username=\'' . $username . '\'', ARRAY_A);
        if (! empty($list)) {
            if ($list['password'] == md5($password)) {
                $_SESSION['uuserid'] = $list['id'];
                $_SESSION['username'] = $list['username'];
                $_SESSION['userstate'] = $list['state'];
                $login_status = 2;
            } else {
                $errorMsg = '密码不正确!' . md5($password);
            }
        } else {
            $errorMsg = '用户不存在!';
        }
    }

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>登录</title>
<!-- add styles -->
<link href="css/main.css" rel="stylesheet" type="text/css" />
<!-- add scripts -->
<script src="js/jquery.min.js"></script>
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
	<div class="demo" style="margin-top: 60px;">
		<div class="bheader">
			<h2>登录</h2>
		</div>
		<div class="bbody">
<?php if (1 == $login_status){?>
			<!-- upload form -->
			<form id="login_form" method="post" action="login.php"
				onsubmit="return checkForm(this)">
				<div class="error"></div>
				<div class="info">
					<div>
						<label for="ipt_username">用户名:</label> <input type="text"
							id="ipt_username" name="username" style="width: 160px;" />
					</div>
					<div>
						<label for="ipt_password">密&nbsp;&nbsp;码:</label> <input
							type="password" id="ipt_password" name="password"
							style="width: 160px;" />
					</div>
				</div>
				<div>
					<input type="submit" value="登录" /><input type="reset" value="重置" />
				</div>
			</form>
			<?php }else if (2 == $login_status){?>
			<div class="info">
				<div>
					登录成功!
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="list.php">图片方式</a>
					<!--&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="tx/list.php">文字方式</a>-->
				</div>
			</div>
			<?php }else if (3 == $login_status){?>
			<div class="info">
				<div>
					您当前已经是登录状态!
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="list.php">图片方式</a>
					<!--&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="tx/list.php">文字方式</a>-->
				</div>
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