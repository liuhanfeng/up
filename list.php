<?php 
include_once 'include.php';
checklogin();
$list = $db->get_results('select * from ls_imgs ORDER BY addtime DESC, id DESC',ARRAY_A);
?>
<!DOCTYPE html>
<html >
    <head>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <title>图片管理</title>
        <!-- add styles -->
        <link href="css/main.css" rel="stylesheet" type="text/css" />
        <!-- add scripts -->
        <script src="js/jquery.min.js"></script>
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
<?php include 'nav.php';?>
        <div class="demo" style=" margin-top:60px;">
            <div class="bheader"><h2>图片列表</h2></div>
            <div class="bbody list">

                <!-- upload form -->
                <form id="list_form" method="post" action="list.php"">
                    <table class="table" width="100%">
                        <tr>
                        <th width="5%">编号</th>
                        <th>图片</th>
                        <th width="20%">生成时间</th>
                        <th width="20%">过期时间</th>
                        <th width="20%">操作</th>
                        </tr>
                        <?php if (isset($list) && !empty($list)){?>
                        <?php foreach ($list as $item){?>
                        <tr>
                        <td><?php echo $item['id'] ?></td>
                        <td><img src="cache/<?php echo $item['imgname'] ?>_min.jpg?t=<?php echo time() ?>" /></td>
                        <td><?php echo date("Y-m-d H:i",$item['addtime']) ?></td>
                        <td><?php echo date("Y-m-d H:i:s",$item['expire_time']) ?></td>
                        <td><a class="btn_a" href="s<?php echo $item['t']==1?'two':'' ?>.php?i=<?php echo $item['id'] ?>" >查看</a>&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn_a" href="add<?php echo $item['t']==1?'two':'' ?>.php?id=<?php echo $item['id'] ?>&ret=list" >修改图片</a>
                        <br/><a class="btn_a" href="edit.php?id=<?php echo $item['id'] ?>" >编辑</a>&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn_a" href="del.php?id=<?php echo $item['id'] ?>"  onclick="return del()" >完全删除</a></td>
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