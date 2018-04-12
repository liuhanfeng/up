<?php
include_once '../include.php';
checklogin();
$txid = isset($_GET['id'])?intval($_GET['id']):0;
$pdata = array(
    'tx_id'=>$txid,
    'tx_title'=>'',
    'tx_content'=>''    
);

if ($_POST && isset($_POST['pp'])){
    $pdata['tx_id'] = isset($_POST['txid']) ? intval($_POST['txid']):0;
    $pdata['tx_title'] = trim($_POST['tx_title']);
    $pdata['tx_content'] = trim($_POST['tx_content']);
    $edittime = time();
    
    
    if ($pdata['tx_id'] > 0) {
        // 提交修改    
        $up_sql = "UPDATE ls_ma SET `title`='{$pdata['tx_title']}',`ma`='{$pdata['tx_content']}',`edittime`='{$edittime}' WHERE `id`=" . $pdata['tx_id'];
    
        $rows_affected = $db->query($up_sql);
        if ($rows_affected > 0) {
            $tipMsg = '编辑成功!';
        } else {
            $tipMsg = '编辑失败!';
        }
    }else {
        // 提交添加       
        $up_sql = "INSERT INTO `ls_ma` ( `title`, `ma`, `addtime`, `edittime`) VALUES ('{$pdata['tx_title']}', '{$pdata['tx_content']}', '{$edittime}', '{$edittime}')";
        
        $rows_affected = $db->query($up_sql);
        if ($rows_affected > 0) {
            $tipMsg = '添加成功!';
        } else {
            $tipMsg = '添加失败!';
        }
    }
    
    var_dump($tipMsg);
    exit();
}elseif ($pdata['tx_id']>0){
    $item = $db->get_row('select * from ls_ma WHERE id=' . $pdata['tx_id'], ARRAY_A);
    $pdata['tx_title'] = $item['title'];
    $pdata['tx_content'] = $item['ma'];
    $pdata['tx_id'] = $item['id'];
}
?>
<!DOCTYPE html>
<html >
    <head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>期数编辑</title>
        <!-- add styles -->
        <link href="../css/main.css" rel="stylesheet" type="text/css" />

        <!-- add scripts -->
        <script src="../js/jquery.min.js"></script>
       <style type="text/css">
        .img-preview {padding:10px 0; } 
        img { 
            height: auto; 
            width: auto\9; 
            width:98%;
        	border: 1px solid #CCCCCC; 
        } 
        </style>
        <script type="text/javascript">
        function checkForm(){
        	var tle = $('#tx_title').val();
        	var cnt = $('#tx_content').val();
        	var tip_msg = '';
        	if (tle == ''){ tip_msg = tip_msg+ '码标题不能为空!<br/>'}
        	if (cnt == ''){ tip_msg = tip_msg+ '码信息不能为空!<br/>'}
        
        	if (''==tip_msg){
        		return true;
        	}else{
        		$('#tip_error').html(tip_msg).show();
        		return false;
        	}
        }
        </script>
    </head>
    <body>
<?php include '../nav.php';?>
        <div class="demo" style=" margin-top:60px;">
            <div class="bheader"><h2>添加/编辑</h2></div>
            <div class="bbody">
                <form id="tx_form" method="post" action="" onsubmit="return checkForm()">
                    <input type="hidden" id="txid" name="txid" value="<?php echo $pdata['tx_id'] ?>" />
                    <div id="tip_error" class="error"></div>
                    <div class="info">
                    <label for="tx_title">码标题:</label> <input type="text" id="tx_title" name="tx_title" style="width:80%;" value="<?php echo $pdata['tx_title'] ?>" />
                    </div>
                    <div class="info">
                    <label for="tx_content">码信息:</label>
                    <textarea id="tx_content" name="tx_content" rows="10" style="width:80%;"><?php echo $pdata['tx_content'] ?></textarea>
                    </div>
                    <div class="info" style="display:none;">
                        <label for="filesize">文件大小</label> <input type="text" id="filesize" name="filesize" />
                        <label for="filetype">类型</label> <input type="text" id="filetype" name="filetype" />
                        <label for="filedim">图像尺寸</label> <input type="text" id="filedim" name="filedim" />
                    </div>
                    <div><input name="pp" type="submit" value="提交" /></div>
                </form>
            </div>
        </div>
</body>
</html>