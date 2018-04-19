<?php
include_once 'include.php';
//checklogin();

$id = intval($_GET['i']);

$list = $db->get_row('select * from ls_imgs WHERE id='.$id,ARRAY_A);
if (empty($list)){
    echo '请求地址不存在!';
    exit();
}elseif ($list['expire_time']<time()){
    echo '请求地址不存在!';
    exit();
}


require_once "jssdk.php";
$jssdk = new JSSDK($config['wx']['appId'], $config['wx']['appSecret']);
$signPackage = $jssdk->GetSignPackage();

$imagespath = $list['img'];

$t=time();

$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

$url = $config['sys']['siteurl'].'/s.php?i='.$_GET['i'];
$img = $config['sys']['siteurl'].'/'.$imagespath.'?'.$t;
$shareimg = $config['sys']['siteurl'].'/cache/'.$list['imgname'].'_min.jpg?i='.$signPackage["timestamp"];;
// echo $imagespath;
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="baidu-tc-verification" content="000000" />
<meta name="viewport"
	content="height=device-height,initial-scale=1.0,  maximum-scale=1.0" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<link href="/css/style.css?a=111" rel="stylesheet" type="text/css" />
<script src="/js/jquery.min.js" type="text/javascript"></script>
<style type="text/css">
img { 
    height: 100%; 
    width: auto\9; 
    width:100%;
    pointer-events: none;
} 
</style>
<script type="text/javascript">

</script>
</head>
<body>
	<div class="conddtent">
		<div class="cdddd">
			<img style="display:none;" src="<?php echo $shareimg?>" alt="" ondragstart="return false" />
			<img src="<?php echo $img?>" alt="" ondragstart="return false" />
		</div>
	</div>
</body>
<script type='text/javascript'>
document.querySelector('body').addEventListener('touchstart', function (ev) {
    event.preventDefault();
});
</script>
<script type="text/javascript"
	src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript">
/*
 * 注意：
 * 1. 所有的JS接口只能在公众号绑定的域名下调用，公众号开发者需要先登录微信公众平台进入“公众号设置”的“功能设置”里填写“JS接口安全域名”。
 * 2. 如果发现在 Android 不能分享自定义内容，请到官网下载最新的包覆盖安装，Android 自定义分享接口需升级至 6.0.2.58 版本及以上。
 * 3. 常见问题及完整 JS-SDK 文档地址：http://mp.weixin.qq.com/wiki/7/aaa137b55fb2e0456bf8dd9148dd613f.html
 *
 * 开发中遇到问题详见文档“附录5-常见错误及解决办法”解决，如仍未能解决可通过以下渠道反馈：
 * 邮箱地址：weixin-open@qq.com
 * 邮件主题：【微信JS-SDK反馈】具体问题
 * 邮件内容说明：用简明的语言描述问题所在，并交代清楚遇到该问题的场景，可附上截屏图片，微信团队会尽快处理你的反馈。
 */
wx.config({
		debug: false,
	    appId: '<?php echo $signPackage["appId"];?>',
	    timestamp: <?php echo $signPackage["timestamp"];?>,
	    nonceStr: '<?php echo $signPackage["nonceStr"];?>',
	    signature: '<?php echo $signPackage["signature"];?>',
		jsApiList: [
		  'onMenuShareTimeline',
		  'onMenuShareAppMessage',
		  'onMenuShareQQ',
		]
	});
	
		 var shareTitle="　　";
	 	 
		 var desc="　　";
	 
	wx.ready(function(){
		wx.onMenuShareTimeline({
			title: shareTitle, // 分享标题
			link: '<?php echo $url ?>', // 分享链接
			imgUrl: '<?php echo $shareimg ?>', // 分享图标
		});

		wx.onMenuShareAppMessage({
		title: " ",
		link: "",
		desc: '　', //分享描述
			imgUrl: '<?php echo $shareimg ?>', // 分享图标
			type: '', // 分享类型,music、video或link，不填默认为link
			dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
			success: function (res) {
				alert('已分享');
			},
			fail: function (res) {
				alert(JSON.stringify(res));
			}
		});
		
		wx.onMenuShareQQ({
			title: shareTitle, // 分享标题
			//desc: '', // 分享描述
			desc: desc, // 分享描述
			link: '<?php echo $url ?>', // 分享链接
			imgUrl: '<?php echo $shareimg ?>', // 分享图标
		});
	});	

	wx.error(function (res) {
	  alert(res.errMsg+'');
	});
	
</script>
<script type="text/javascript">
//setInterval('getart()',10000);
function getart(){
	$.ajax({
		type: 'POST',
		data:{flag:'diff'},
		dataType: 'html',
		async:false,
		timeout: 3000,
		success: function(result){
			if(result!='0'){
				$(".content").html(result);
				document.title=$("#title").html();
			}
		}
	})
}
</script>
</html>
