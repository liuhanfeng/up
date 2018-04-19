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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head lang="zh-cmn-Hans">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
<title>管理登录</title>		
<link rel="stylesheet" type="text/css" href="css/v2/aui.2.0.css"/>
<link rel="stylesheet" type="text/css" href="css/v2/public.css"/>
<link type="text/css" rel="stylesheet" href="css/style.css"/>
<link type="text/css" rel="stylesheet" href="css/v2/style.css"/>
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
<!--头部-->
<header class="aui-bar aui-bar-nav">
    <a class="aui-pull-left aui-btn">
        <span class="aui-iconfont"><img src="img/icon－password.png"><span div class="head-txt">管理登录</span></span>
    </a>
    <a class="aui-pull-right aui-btn">
        <span class="aui-iconfont">&nbsp;</span>
    </a>
</header>

    <div class="content">
    	<div class="content-tilte"><center>管理登录</center></div>
        <div class="lins"></div>
        <div class="form-box">
			<?php if (1 == $login_status){?>
<?php if (isset($errorMsg)){?>
<div class="aui-tips aui-margin-b-15" id="tips-1">
    <i class="aui-iconfont aui-icon-info"></i>
    <div class="aui-tips-title"><?php echo $errorMsg ?></div>
    <i class="aui-iconfont aui-icon-close"></i>
</div>
<?php }?>

			<form id="login_form" method="post" action="loginv2.php"
				onsubmit="return checkForm(this)">
				<div class="input-form">
					<span><img src="img/icon-cellphone.png"></span>
					<input name="username" class="inputstyle" type="text" id="ipt_username" placeholder="请输入用户名">
				</div>
				<div class="lins"></div>
				<div class="input-form">
					<span><img src="img/icon－password.png"></span>
					<input name="password" class="inputstyle" type="password" id="ipt_password" placeholder="请输入密码">
				</div>
				<div class="lins"></div>
				<div class="sub">
					<input type="submit" name="submit" id="" value="登录">
				</div>
		   </form>
			<?php }else if (2 == $login_status){?>
<div class="aui-tips aui-margin-b-15" id="tips-1">
    <i class="aui-iconfont aui-icon-info"></i>
    <div class="aui-tips-title">登录成功!</div>
    <i class="aui-iconfont aui-icon-close"></i>
</div>
			<div class="aui-text-center">
				<span>
					<a href="list.php">图片方式</a>
					<!--&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="tx/list.php">文字方式</a>-->
				</span>
			</div>
			<?php }else if (3 == $login_status){?>
<div class="aui-tips aui-margin-b-15" id="tips-1">
    <i class="aui-iconfont aui-icon-info"></i>
    <div class="aui-tips-title">您当前已经是登录状态!</div>
    <i class="aui-iconfont aui-icon-close"></i>
</div>
			<div class="aui-text-center">
				<span>
					<a href="list.php">图片方式</a>
					<!--&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="tx/list.php">文字方式</a>-->
				</span>
			</div>
			<?php }?>
	   </div>
 	</div>
</body>
</html>