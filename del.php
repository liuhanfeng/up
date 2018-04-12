<?php
include_once 'include.php';
checklogin();

$tipMsg = '';
$id = intval($_GET['id']);
$list = $db->get_row('select * from ls_imgs WHERE id=' . $id, ARRAY_A);
if (empty($list)) {
    $tipMsg = '请求地址不存在!';
} else {
    @unlink($list['img']);
    $db->query('DELETE FROM ls_imgs WHERE `id`=' . $id);
    header('Location: /list.php?i=' . $id);
}
?>


<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>删除</title>
<link href="css/main.css" rel="stylesheet" type="text/css" />
</head>
<body>
	<div class="demo" style="margin-top: 60px;">
		<div class="bheader">
			<h2>删除</h2>
		</div>
		<div class="bbody">
			<div class="info">
				<div>
					<?php echo $tipMsg ?>!&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a
						href="list.php">进入列表</a>
				</div>
			</div>
		</div>
	</div>
</body>
</html>