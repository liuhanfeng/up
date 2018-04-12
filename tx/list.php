<?php 
include_once '../include.php';
checklogin();
$list = $db->get_results('select * from ls_ma ORDER BY addtime DESC, id DESC',ARRAY_A);
?>
<!DOCTYPE html>
<html >
    <head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <title>码表管理</title>
        <!-- add styles -->
        <link href="../css/main.css" rel="stylesheet" type="text/css" />
        <!-- add scripts -->
        <script src="../js/jquery.min.js"></script>
        <script type="text/javascript"> 
        function del(){ 
            if(!confirm("确认要删除？")){ 
            	window.event.returnValue = false;
            	return false;
            } 
        } 
        </script> 
       <style type="text/css">
        .img-preview {padding:10px 0; } 
        img { 
            height: auto; 
            width: auto\9; 
            width:98%;
        	border: 1px solid #CCCCCC; 
        } 
        </style>
    </head>
    <body>
<?php include '../nav.php';?>
        <div class="demo" style=" margin-top:60px;">
            <div class="bheader"><h2>码表</h2></div>
            <div class="bbody list">

                <!-- upload form -->
                <form id="list_form" method="post" action="list.php"">
                    <table class="table" width="100%">
                        <tr>
                        <th width="5%">编号</th>
                        <th width="20%">码标题</th>
                        <th>码内容</th>
                        <th width="10%">操作</th>
                        <th width="20%">生成时间</th>
                        </tr>
                        <?php if (isset($list) && !empty($list)){?>
                        <?php foreach ($list as $item){?>
                        <tr>
                        <td><?php echo $item['id'] ?></td>
                        <td><?php echo $item['title'] ?></td>
                        <td style="text-align: left;word-wrap:break-word;word-break:break-all; overflow:hidden;"><?php echo rn2br($item['ma']) ?></td>
                        <td><a class="btn_a" href="/s.php?i=<?php echo $item['id'] ?>" >看</a>
                        <br/><a class="btn_a" href="add.php?id=<?php echo $item['id'] ?>" >改</a></td>
                        <td><?php echo date("Y-m-d H:i",$item['addtime']) ?></td>
                        </tr>
                        <?php }?>
                        <?php }?>
                        <tr><td colspan="5">-</td></tr>
                    </table>
                </form>
            </div>
        </div>
</body>
</html>